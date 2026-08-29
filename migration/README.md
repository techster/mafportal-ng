# Migration Tracking

The registry in `legacy-file-registry.json` tracks legacy files that may become removable after the Python implementation reaches parity.

Statuses:

- `replace-later`: functionality is being rebuilt in Python/Next.js.
- `excluded-feature`: functionality is intentionally outside the reduced scope.
- `retain-source-of-truth`: keep permanently or until an explicit data strategy exists.

No registry entry authorizes deletion. Before cleanup, require passing rating comparison tests, public URL checks, and a verified backup of `database/database.sqlite`.

## Media storage

The canonical media tree is `assets/`. The original `public/` media trees have
already been migrated and removed. The migration utility refuses to overwrite
the manifest when no legacy source roots remain.

```powershell
python migration\migrate_media.py --copy
```

Legacy URL compatibility is disabled. Existing database paths are normalized to
canonical `/assets` URLs by the backend.

DigitalOcean Spaces uses the S3-compatible backend. Configure the
`MAFPORTAL_MEDIA_*` variables in the local environment, then upload and
verify the inventory explicitly:

```powershell
$env:MAFPORTAL_MEDIA_BACKEND = "spaces"
python migration\migrate_media.py --upload
```

The upload operation does not rewrite database references. It is safe to run
before the application switch because the manifest keys are provider-neutral;
database and frontend cutover remain separate, auditable steps.
