# MAF Portal Python Backend

Parallel replacement for the Laravel application. The public API uses the existing
`../database/database.sqlite` file as its source of truth.

## Run

```powershell
cd backend
python -m venv .venv
.\.venv\Scripts\Activate.ps1
python -m pip install -e ".[test]"
uvicorn app.main:app --reload
```

Run backend tests with `pytest`. The test configuration always enables pytest-xdist
with automatic worker selection, so parallel execution is mandatory for every
pytest invocation.

The public endpoints are:

- `GET /health`
- `GET /api/v1/clubs`
- `GET /api/v1/tournaments`
- `GET /api/v1/ratings/tournaments/{tournament_id}`

## Admin

The Python service includes a parallel admin UI at `http://localhost:8000/admin`.
It mirrors the legacy Laravel resource menu and provides list, create, edit, and
delete operations for the resources present in the shared database. The temporary
local credentials are `mafportaladmin@gmail.com` / `admin`.

Set these environment variables before starting the service when the defaults must
be changed:

```powershell
$env:MAFPORTAL_ADMIN_USERNAME = "mafportaladmin@gmail.com"
$env:MAFPORTAL_ADMIN_PASSWORD = "replace-me"
$env:MAFPORTAL_ADMIN_SESSION_SECRET = "replace-with-a-random-secret"
```

The admin is served by the same FastAPI process as the API, so it runs in parallel
with the main service and does not alter the existing public routes.

The ratings endpoint is read-only and calculates player aggregates from the
existing `game_ratings`, `table_ratings`, and `tournaments` tables. Its formula
evaluator accepts arithmetic expressions only; Python execution is not allowed.

The existing Laravel application remains the production application until feature parity and rating-result comparisons are complete. Do not run destructive migrations against the shared SQLite file.
