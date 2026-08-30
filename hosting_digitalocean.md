# DigitalOcean minimal production deployment

This runbook deploys MAF Portal on:

- one Ubuntu 24.04 LTS Droplet;
- optional DigitalOcean Spaces bucket for media;
- Nginx for HTTPS and reverse proxying;
- systemd for the FastAPI and Next.js processes;
- the existing SQLite database on the Droplet.

This is a small single-server deployment, not high availability. The database must be backed up before every data-changing release. Do not delete or recreate `database/database.sqlite`.

The commands below assume you are logged in as `mafportal`. Commands beginning
with `sudo` run with administrator privileges. Keep one working SSH session
open while changing SSH or firewall settings.

## 0. Choose values

Replace these placeholders consistently:

```text
DOMAIN=portal.example.com
DROPLET_IP=<Droplet public IPv4>
SPACES_REGION=nyc3
SPACES_BUCKET=mafportal-production
APP_DIR=/opt/mafportal-ng
```

Recommended starting Droplet: Ubuntu 24.04 LTS, 2 vCPU, 4 GB RAM, SSD. A 1 GB Droplet is likely too small for a Next.js build and should only be used for a low-traffic trial.

Use a non-root SSH key. Keep the Spaces access key and secret key out of Git, shell history, and support tickets.

## 1. Create the Droplet

In DigitalOcean:

1. Create a Droplet with Ubuntu 24.04 LTS.
2. Add an SSH key.
3. Enable automated backups if the budget allows.
4. Add a cloud firewall allowing only SSH (from your office/VPN IP), HTTP, and HTTPS.
5. Record the Droplet IPv4 as `DROPLET_IP`.

From Windows PowerShell, verify SSH access:

```powershell
ssh root@DROPLET_IP
```

On the Droplet, confirm the OS and public address:

```bash
. /etc/os-release && printf '%s\n' "$PRETTY_NAME"
hostname -I
```

**Checkpoint:** Continue only when the host reports Ubuntu 24.04 and the public IP is the Droplet IP you recorded.

## 2. Create a restricted application user

Run as root on the Droplet:

```bash
adduser --disabled-password --gecos "" mafportal
usermod -aG sudo mafportal
apt update
apt full-upgrade -y
apt install -y git nginx ufw sqlite3 curl unzip ca-certificates build-essential python3 python3-venv python3-pip
```

Configure the host firewall. Replace `YOUR_ADMIN_IP/32` with your fixed admin IP; if you do not have one yet, omit that rule temporarily and use the DigitalOcean cloud firewall for SSH restriction.

```bash
ufw default deny incoming
ufw default allow outgoing
ufw allow from YOUR_ADMIN_IP/32 to any port 22 proto tcp
ufw allow 80/tcp
ufw allow 443/tcp
ufw --force enable
ufw status verbose
```

**Checkpoint:** `ufw status` must show SSH, HTTP, and HTTPS only. Do not close your current SSH session until a second SSH session as `mafportal` succeeds:

```bash
ssh mafportal@DROPLET_IP
```

## 3. Point DNS to the Droplet

At the DNS provider, create:

```text
A    portal.example.com    DROPLET_IP
```

Verify from your workstation. DNS may take time to propagate:

```powershell
Resolve-DnsName portal.example.com -Type A
```

The returned address must be `DROPLET_IP`.

## 4. Install Node.js and obtain the application

Log in as `mafportal` and install Node.js 22 from NodeSource:

```bash
curl -fsSL https://deb.nodesource.com/setup_22.x | sudo -E bash -
sudo apt install -y nodejs
node --version
npm --version
```

Clone the repository. Use your real Git remote or copy a reviewed release archive:

```bash
sudo mkdir -p /opt
sudo chown mafportal:mafportal /opt
cd /opt
git clone YOUR_GIT_REMOTE mafportal-ng
cd /opt/mafportal-ng
```

If the database is not in Git, securely copy it from the release source before starting the app:

```bash
mkdir -p database
# From a trusted workstation, run separately:
# scp database/database.sqlite mafportal@DROPLET_IP:/opt/mafportal-ng/database/database.sqlite
```

**Checkpoint:** Confirm the release and database exist:

```bash
test -f backend/pyproject.toml && test -f database/database.sqlite && echo "release and database present"
git rev-parse --short HEAD
sqlite3 database/database.sqlite 'PRAGMA integrity_check;'
```

The SQLite check must return `ok`.

## 5. Optional: create the Spaces bucket and access key

For this deployment, Spaces is optional. With approximately 3 GB of fixed
assets and enough Droplet disk space, keep media local and skip sections 5 and
6. The application already serves `/opt/mafportal-ng/assets` through FastAPI.
Use these sections only when you want independent media storage or plan to
move media off the Droplet.

In DigitalOcean:

1. Create the bucket `SPACES_BUCKET` in `SPACES_REGION`.
2. Leave the bucket private initially.
3. Create a Spaces access key restricted to this bucket if the DigitalOcean control panel offers that scope.
4. Record the access key and secret once. The secret cannot be recovered later.

The application currently returns direct media URLs. For images to load in visitors' browsers, objects need a public delivery endpoint. The simplest supported setup is a bucket configured for public read, while write/delete remains restricted to the application key. If public media is unacceptable, stop here: the application needs a server-side media proxy or signed-URL implementation before using a private bucket.

After the bucket exists, identify:

```text
SPACES_ENDPOINT=https://nyc3.digitaloceanspaces.com
SPACES_PUBLIC_BASE=https://mafportal-production.nyc3.digitaloceanspaces.com
```

Use the endpoint for the SDK and the bucket hostname (or Spaces CDN hostname) for public URLs. Do not put the secret key in a browser or `NEXT_PUBLIC_*` variable.

## 6. Upload canonical media to Spaces

On the Droplet, install the AWS CLI in the application user's home:

```bash
python3 -m venv ~/.venvs/awscli
~/.venvs/awscli/bin/pip install --upgrade awscli
~/.venvs/awscli/bin/aws --version
```

Create a temporary credentials file with restrictive permissions:

```bash
cat > /tmp/spaces.env <<'EOF'
export AWS_ACCESS_KEY_ID='<SPACES_ACCESS_KEY>'
export AWS_SECRET_ACCESS_KEY='<SPACES_SECRET_KEY>'
export AWS_DEFAULT_REGION='SPACES_REGION'
export SPACES_ENDPOINT='https://SPACES_REGION.digitaloceanspaces.com'
EOF
chmod 600 /tmp/spaces.env
. /tmp/spaces.env
```

Upload the canonical `assets/` tree. This preserves keys such as `images/admin/...` expected by `app.media.MediaStorage`:

```bash
cd /opt/mafportal-ng
~/.venvs/awscli/bin/aws s3 sync assets/ s3://SPACES_BUCKET/ --endpoint-url "$SPACES_ENDPOINT" --no-progress
~/.venvs/awscli/bin/aws s3 ls s3://SPACES_BUCKET/images/ --endpoint-url "$SPACES_ENDPOINT" | head
```

If the bucket is public-read, verify one known object using its public hostname:

```bash
curl -I https://SPACES_BUCKET.SPACES_REGION.digitaloceanspaces.com/images/logo/<KNOWN_FILE>
```

A successful object response should be `200`; use an actual key from `find assets -type f | head` if the example path does not exist.

**Checkpoint:** Confirm at least one existing media object returns `200` before configuring the app. Delete `/tmp/spaces.env` after the check:

```bash
rm -f /tmp/spaces.env
```

## 7. Configure and install the backend

Create the production environment file. The directory must be root-owned before
using `sudoedit`; otherwise `sudoedit` may reject the file or fail to save it.
The file is readable only by root and the service user:

```bash
sudo install -d -o mafportal -g mafportal -m 750 /etc/mafportal
sudo chown root:root /etc/mafportal
sudo chmod 755 /etc/mafportal
sudo touch /etc/mafportal/backend.env
sudo chown root:mafportal /etc/mafportal/backend.env
sudo chmod 640 /etc/mafportal/backend.env
sudoedit /etc/mafportal/backend.env
```

If `sudoedit` reports `editing files in a writable directory is not
permitted` or `Permission denied`, run `sudo nano` instead:

```bash
sudo nano /etc/mafportal/backend.env
```

Use this content, replacing every placeholder. Do not paste the angle brackets
literally: `<LONG_RANDOM_ADMIN_PASSWORD>` would be invalid shell syntax when
the file is loaded.

```dotenv
MAFPORTAL_DATABASE_URL=sqlite:////opt/mafportal-ng/database/database.sqlite
MAFPORTAL_ADMIN_USERNAME=admin@example.com
MAFPORTAL_ADMIN_PASSWORD=<LONG_RANDOM_ADMIN_PASSWORD>
MAFPORTAL_ADMIN_SESSION_SECRET=<LONG_RANDOM_SECRET>
MAFPORTAL_MEDIA_BACKEND=local
MAFPORTAL_MEDIA_LOCAL_ROOT=/opt/mafportal-ng/assets
```

If you completed the optional Spaces setup, replace the two media lines above
with the Spaces settings from section 5. For local media, do not set
`NEXT_PUBLIC_MEDIA_PUBLIC_BASE_URL` to a Spaces hostname.

Generate secrets without putting them in shell history:

```bash
openssl rand -base64 36
openssl rand -base64 36
```

Install Python dependencies and verify the settings can initialize the Spaces client:

```bash
cd /opt/mafportal-ng/backend
python3 -m venv .venv
.venv/bin/python -m pip install --upgrade pip
.venv/bin/pip install -e .
set -a; . /etc/mafportal/backend.env; set +a
.venv/bin/python -c 'from app.media import media_storage; print(media_storage.public_base_url)'
```

The command must print the configured public base URL without a traceback.

Validate the environment file before starting the service. This catches pasted
placeholders and malformed values:

```bash
bash -n /etc/mafportal/backend.env
set -a; . /etc/mafportal/backend.env; set +a
```

Create `/etc/systemd/system/mafportal-backend.service`:

```ini
[Unit]
Description=MAF Portal FastAPI backend
After=network.target

[Service]
User=mafportal
Group=mafportal
WorkingDirectory=/opt/mafportal-ng/backend
EnvironmentFile=/etc/mafportal/backend.env
ExecStart=/opt/mafportal-ng/backend/.venv/bin/uvicorn app.main:app --host 127.0.0.1 --port 8001
Restart=on-failure
RestartSec=5

[Install]
WantedBy=multi-user.target
```

Start and verify:

```bash
sudo systemctl daemon-reload
sudo systemctl enable --now mafportal-backend
systemctl --no-pager --full status mafportal-backend
curl --fail http://127.0.0.1:8001/health
curl --fail http://127.0.0.1:8001/api/v1/clubs | head -c 300
```

The health response must contain `{"status":"ok"}` and the API must return JSON.

Useful lifecycle commands:

```bash
sudo systemctl stop mafportal-backend
sudo systemctl start mafportal-backend
sudo systemctl restart mafportal-backend
sudo systemctl is-active mafportal-backend
sudo journalctl -u mafportal-backend -n 100 --no-pager
```

Use `stop` before copying or replacing the SQLite database. Use `restart`
after changing backend code or `/etc/mafportal/backend.env`. If the service
fails, inspect the journal before retrying:

```bash
sudo systemctl status mafportal-backend --no-pager --full
sudo journalctl -u mafportal-backend -n 100 --no-pager
```

## 8. Build and run the frontend

Create `/etc/mafportal/frontend.env`:

```bash
sudo touch /etc/mafportal/frontend.env
sudo chown root:mafportal /etc/mafportal/frontend.env
sudo chmod 640 /etc/mafportal/frontend.env
sudo nano /etc/mafportal/frontend.env
```

Use `sudo nano` for this file if `sudoedit` gives a writable-directory or
permission error. Save in Nano with `Ctrl+O`, press `Enter`, then exit with
`Ctrl+X`.

Use internal URLs because Next.js server-side rendering calls the backend
locally. With no DNS record, use the Droplet IP for browser-visible media:

```dotenv
MAFPORTAL_API_URL=http://127.0.0.1:8001
MAFPORTAL_LEGACY_URL=http://127.0.0.1:8001
NEXT_PUBLIC_MEDIA_PUBLIC_BASE_URL=http://DROPLET_IP/assets
```

`NEXT_PUBLIC_MEDIA_PUBLIC_BASE_URL` is embedded during `npm run build`. Changing
the environment file requires a clean frontend rebuild, not only a service
restart.

Build the frontend:

```bash
cd /opt/mafportal-ng/frontend
npm ci
set -a; . /etc/mafportal/frontend.env; set +a
npm run build
```

Create `/etc/systemd/system/mafportal-frontend.service`:

```ini
[Unit]
Description=MAF Portal Next.js frontend
After=network.target mafportal-backend.service
Requires=mafportal-backend.service

[Service]
User=mafportal
Group=mafportal
WorkingDirectory=/opt/mafportal-ng/frontend
EnvironmentFile=/etc/mafportal/frontend.env
Environment=NODE_ENV=production
ExecStart=/usr/bin/npm run start -- --hostname 127.0.0.1 --port 3000
Restart=on-failure
RestartSec=5

[Install]
WantedBy=multi-user.target
```

Start and verify:

```bash
sudo systemctl daemon-reload
sudo systemctl enable --now mafportal-frontend
systemctl --no-pager --full status mafportal-frontend
curl --fail http://127.0.0.1:3000/ru | head -c 500
```

The command must return HTML rather than a connection error.

Useful lifecycle commands:

```bash
sudo systemctl stop mafportal-frontend
sudo systemctl start mafportal-frontend
sudo systemctl restart mafportal-frontend
sudo systemctl is-active mafportal-frontend
sudo journalctl -u mafportal-frontend -n 100 --no-pager
```

After changing frontend environment values or frontend code, use this sequence:

```bash
cd /opt/mafportal-ng/frontend
set -a; . /etc/mafportal/frontend.env; set +a
rm -rf .next
npm ci
npm run build
sudo systemctl restart mafportal-frontend
```

If the old URL still appears in rendered HTML, check the loaded value and
rebuild again:

```bash
grep -E '^(MAFPORTAL_API_URL|MAFPORTAL_LEGACY_URL|NEXT_PUBLIC_MEDIA_PUBLIC_BASE_URL)=' /etc/mafportal/frontend.env
printf '%s\n' "$NEXT_PUBLIC_MEDIA_PUBLIC_BASE_URL"
curl -s http://127.0.0.1:3000/ru -o /tmp/home.html
grep -o 'http://127.0.0.1:8001[^" ]*' /tmp/home.html | head
```

The last command should produce no output when media URLs are configured for
the public IP or a public Spaces URL.

## 9. Configure Nginx

Create `/etc/nginx/sites-available/mafportal`:

```nginx
server {
    listen 80;
    listen [::]:80;
    server_name portal.example.com DROPLET_IP _;

    location /api/ {
        proxy_pass http://127.0.0.1:8001;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
    }

    location /admin/ {
        proxy_pass http://127.0.0.1:8001;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
    }

    location /health {
        proxy_pass http://127.0.0.1:8001;
    }

    location / {
        proxy_pass http://127.0.0.1:3000;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
    }
}
```

Enable it and validate the configuration:

```bash
sudo ln -s /etc/nginx/sites-available/mafportal /etc/nginx/sites-enabled/mafportal
sudo rm -f /etc/nginx/sites-enabled/default
sudo nginx -t
sudo systemctl reload nginx
curl --fail -H 'Host: portal.example.com' http://127.0.0.1/health
```

**Checkpoint:** Continue only when `nginx -t` succeeds and the proxied health endpoint returns `ok`.

## 10. Enable HTTPS

Install Certbot and request a certificate after DNS points to the Droplet:

```bash
sudo apt install -y certbot python3-certbot-nginx
sudo certbot --nginx -d portal.example.com
sudo certbot renew --dry-run
```

Choose the redirect-to-HTTPS option. Verify externally:

```powershell
curl.exe -I https://portal.example.com/health
curl.exe -I https://portal.example.com/ru
```

Expected results are `200` for both, with HTTPS in use. Never expose ports 8001 or 3000 through the firewall; both services should remain bound to `127.0.0.1`.

## 11. Production smoke test

Run all of these from a workstation:

```powershell
curl.exe -fsS https://portal.example.com/health
curl.exe -fsS https://portal.example.com/api/v1/clubs
curl.exe -I https://portal.example.com/ru
```

Then in a browser verify:

1. The home page renders in English and Russian.
2. At least one image loads from Spaces.
3. A tournament and a club page load.
4. `/admin/` redirects to login.
5. The configured admin account can log in.
6. Uploading a test image in admin creates an object in Spaces and the preview loads.
7. Delete the test record/object after verification.

Inspect logs if any check fails:

```bash
sudo journalctl -u mafportal-backend -n 100 --no-pager
sudo journalctl -u mafportal-frontend -n 100 --no-pager
sudo tail -n 100 /var/log/nginx/error.log
```

## 12. Database backup and release procedure

Create a backup directory outside the application tree and test a SQLite backup:

```bash
sudo install -d -o mafportal -g mafportal -m 750 /var/backups/mafportal
sqlite3 /opt/mafportal-ng/database/database.sqlite ".backup '/var/backups/mafportal/database-$(date +%Y%m%d-%H%M%S).sqlite'"
ls -lh /var/backups/mafportal
```

For a release, use this order. It preserves production data when the tracked
SQLite file differs from the Git version:

1. On the Droplet, stop both application services:

    ```bash
    sudo systemctl stop mafportal-backend mafportal-frontend
    ```

2. Take and verify a consistent database backup:

    ```bash
    backup="/var/backups/mafportal/database-before-update-$(date +%Y%m%d-%H%M%S).sqlite"
    sqlite3 /opt/mafportal-ng/database/database.sqlite ".backup '$backup'"
    sqlite3 "$backup" 'PRAGMA integrity_check;'
    ```

    The result must be `ok`. Do not commit or delete the backup.

3. Check the working tree before pulling:

    ```bash
    cd /opt/mafportal-ng
    git status --short
    ```

    If `database/database.sqlite` is modified, temporarily restore only that
    tracked file, then pull. Do not use `git reset --hard`:

    ```bash
    git restore -- database/database.sqlite
    git pull --ff-only origin main
    ```

    If `git pull` still reports local changes, stop and inspect `git status`;
    do not force the pull. Generated files such as `frontend/next-env.d.ts`
    should be inspected with `git diff -- frontend/next-env.d.ts` and restored
    only when they contain no intentional server changes.

4. Restore the production database after the code update:

    ```bash
    cp "$backup" /opt/mafportal-ng/database/database.sqlite
    chown mafportal:mafportal /opt/mafportal-ng/database/database.sqlite
    sqlite3 /opt/mafportal-ng/database/database.sqlite 'PRAGMA integrity_check;'
    ```

5. Install dependencies and rebuild:

    ```bash
    cd /opt/mafportal-ng/backend
    .venv/bin/pip install -e .
    cd /opt/mafportal-ng/frontend
    npm ci
    set -a; . /etc/mafportal/frontend.env; set +a
    rm -rf .next
    npm run build
    ```

6. Start services and verify each one before testing Nginx:

    ```bash
    sudo systemctl start mafportal-backend
    curl --fail http://127.0.0.1:8001/health
    sudo systemctl start mafportal-frontend
    curl --fail http://127.0.0.1:3000/ru -o /tmp/home.html
    ```

    If either service fails, run its `systemctl status` and `journalctl`
    commands above. Fix the local error, then restart only that service.

7. Repeat the HTTPS or IP smoke tests, including API, page, media, and admin
    login checks. Keep several dated database backups and periodically test
    restoring one to a non-production path.

For future releases, remove `database/database.sqlite` from Git tracking in a
planned code change and add it to `.gitignore`. Until that migration is done,
the backup, restore, and pull sequence above is required.

A deployment is complete only after the HTTPS smoke test, Spaces media test, admin login test, and a restorable database backup all pass.
