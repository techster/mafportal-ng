# mafportal-ng

Version: 0.1.0  
Release date: 2026-08-23

This is an isolated local copy of the Mafportal Laravel 5.4 application. The
public routes, Blade templates, CSS, JavaScript, images, uploads, and the
World Cup archive are served from the same Laravel application. The local copy
uses SQLite and includes a private PHP 7.4.33 runtime. Docker and MySQL are
not required to run the application.

## Local setup

From PowerShell in this directory:

```powershell
.\setup-local.ps1
.\start-local.ps1
```

The startup script runs PHPUnit and the UI smoke suite before opening the PHP
server. To run the checks independently:

```powershell
.\runtime\php-7.4.33\php.exe vendor\phpunit\phpunit\phpunit --configuration phpunit.xml
npm run test:ui
```

Open http://127.0.0.1:8000 after both checks pass. `start-local.ps1` runs the
PHPUnit suite and the same-origin UI/link crawl before starting PHP's built-in
web server with `server.php`. Set `MAFPORTAL_PORT` to use another port.

`setup-local.ps1` recreates `database/database.sqlite`, runs the Laravel
migrations, and imports data from an existing MariaDB database. The import
defaults to `127.0.0.1:3308`, database `mafportal`, and credentials `root/root`.
Override `SOURCE_DB_HOST`, `SOURCE_DB_PORT`, `SOURCE_DB_DATABASE`,
`SOURCE_DB_USERNAME`, or `SOURCE_DB_PASSWORD` when necessary. Running the app
itself still requires only the generated SQLite database.

The local admin is available under `/admin`. The clone keeps content and
catalog management while omitting legacy exports, specialist rating tools,
direct role/permission CRUD, and the stale diagnostic endpoint.

## AWS EC2 deployment

The application is a legacy Laravel 5.4 application. Deploy it on an Ubuntu
EC2 instance with a supported PHP 7.4 environment, Nginx, and PHP-FPM. PHP 7.4
is end-of-life, so use a private VPC, restrict inbound access, and plan an
upgrade before exposing the application to untrusted traffic.

### 1. Prepare the instance

Launch an Ubuntu EC2 instance and configure its security group with SSH (22)
only from your administration IP, HTTP (80), and HTTPS (443). Connect over SSH
and install the web stack and required PHP extensions:

```bash
sudo apt update
sudo apt install -y nginx git unzip curl ca-certificates \
  php7.4-fpm php7.4-cli php7.4-curl php7.4-gd php7.4-mbstring \
  php7.4-mysql php7.4-sqlite3 php7.4-xml php7.4-zip
```

On Ubuntu releases where PHP 7.4 is not in the default repositories, use a
maintained PHP package source appropriate for that release or build the
runtime in a pinned container image. Do not copy the Windows runtime under
`runtime/` to EC2.

### 2. Install the application

Replace the repository URL and deployment user as appropriate:

```bash
sudo mkdir -p /var/www
sudo chown "$USER":"$USER" /var/www
cd /var/www
git clone <repository-url> mafportal-ng
cd mafportal-ng
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader
cp .env.example .env
php artisan key:generate --force
```

Edit `.env` before starting the service. At minimum set `APP_ENV=production`,
`APP_DEBUG=false`, `APP_URL`, the locale, and the database connection. Never
commit `.env` or production credentials.

For the simplest single-instance deployment, configure SQLite and create the
database file:

```bash
touch database/database.sqlite
php artisan migrate --force
```

For a production database, use Amazon RDS for MariaDB/MySQL instead. Set
`DB_CONNECTION=mysql`, `DB_HOST` to the RDS endpoint, `DB_PORT`,
`DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD`, then run
`php artisan migrate --force`. The optional `scripts/import-database.php`
expects the source variables documented above and should be run only during a
controlled data migration.

### 3. Configure writable directories

Laravel needs to write to `storage` and `bootstrap/cache`; uploaded and public
assets under `public/` must also be present in the release:

```bash
mkdir -p storage/app storage/framework/cache storage/framework/sessions storage/framework/views storage/logs
sudo chown -R www-data:www-data storage bootstrap/cache
sudo find storage bootstrap/cache -type d -exec chmod 775 {} \;
sudo find storage bootstrap/cache -type f -exec chmod 664 {} \;
php artisan storage:link || true
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 4. Configure Nginx and PHP-FPM

Create `/etc/nginx/sites-available/mafportal-ng` with the repository’s
`public/` directory as the document root. Replace the PHP-FPM socket if the
installed minor version differs:

```nginx
server {
  listen 80;
  server_name example.com;
  root /var/www/mafportal-ng/public;
  index index.php;

  location / {
    try_files $uri $uri/ /index.php?$query_string;
  }

  location ~ \.php$ {
    try_files $uri =404;
    include snippets/fastcgi-php.conf;
    fastcgi_pass unix:/run/php/php7.4-fpm.sock;
  }

  location ~ /\.ht {
    deny all;
  }
}
```

Enable the site and remove the default site if it is unused:

```bash
sudo ln -s /etc/nginx/sites-available/mafportal-ng /etc/nginx/sites-enabled/mafportal-ng
sudo rm -f /etc/nginx/sites-enabled/default
sudo nginx -t
sudo systemctl enable --now php7.4-fpm nginx
sudo systemctl reload nginx
```

### 5. Enable HTTPS and operate the service

After DNS points the hostname to the EC2 Elastic IP, install a certificate and
redirect HTTP to HTTPS:

```bash
sudo apt install -y certbot python3-certbot-nginx
sudo certbot --nginx -d example.com
sudo certbot renew --dry-run
```

Run the PHPUnit and UI checks before each release where the test environment
is available. Back up the SQLite file and `storage/` regularly, or use RDS
backups and an external object-storage strategy for a multi-instance setup.
Monitor Nginx, PHP-FPM, and Laravel logs with `journalctl` and the files under
`storage/logs`. Do not use `php artisan serve` as the production service.

## Architecture

- **Application:** Laravel 5.4, with Blade views, Eloquent models, Backpack
  administration, and legacy Vue 2 frontend components.
- **Web entry point:** `server.php` handles requests for PHP's built-in
  development server. `public/` contains the web assets and `public/index.php`
  remains the Laravel front controller.
- **Local runtime:** `runtime/php-7.4.33/php.exe` and its bundled `php.ini` are
  used by the setup, test, and startup scripts. No system PHP installation is
  needed for the supported local workflow.
- **Database:** SQLite at `database/database.sqlite`, configured through
  `.env` with `DB_CONNECTION=sqlite`. MariaDB is used only as an optional
  source for `scripts/import-database.php`.
- **Frontend assets:** the application serves the checked-in files under
  `public/build`, `public/css`, `public/js`, and related asset directories.
  The repository retains a legacy Gulp 3 build configuration, but rebuilding
  assets is not part of the normal startup path.
- **Tests:** PHPUnit 5.7 covers application checks, while
  `tests/run-ui-tests.ps1` starts an isolated server and checks rendered pages,
  discovered same-origin links, error signatures, and new-tab behavior.

## Manual commands

Run the checks without starting the application server:

```powershell
.\runtime\php-7.4.33\php.exe vendor\phpunit\phpunit\phpunit --configuration phpunit.xml
npm run test:ui
```

The optional frontend commands are `npm run dev` and `npm run prod`; they use
the legacy Gulp toolchain and may require the historical Node/Bower
dependencies to be installed.