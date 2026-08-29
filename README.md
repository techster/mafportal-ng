# MAF Portal

MAF Portal is a FastAPI backend and Next.js frontend backed by the retained
SQLite database at `database/database.sqlite`.

## Backend

From the repository root:

```powershell
cd backend
..\.venv\Scripts\python.exe -m pip install -e ".[test]"
..\.venv\Scripts\python.exe -m uvicorn app.main:app --reload --host 127.0.0.1 --port 8001
```

The API is available at `http://127.0.0.1:8001`.

Run the backend tests:

```powershell
..\.venv\Scripts\python.exe -m pytest -n auto
```

## Frontend

In a second terminal:

```powershell
cd frontend
npm ci
npm run dev -- --hostname 127.0.0.1
```

The frontend is available at `http://127.0.0.1:3000`.

Run the production build and browser tests:

```powershell
npm run build
npm run test:ui
```

The Playwright suite expects the backend to be running on port `8001`.

## Media

Canonical media is stored under `assets/` and served by FastAPI at `/assets`.
Database media paths are normalized to canonical URLs. Legacy `public/` media
compatibility is disabled.

The `archive/` directory contains retained Laravel deployment, runtime, and
PHP dependency material for historical reference only. It is not used by the
FastAPI or Next.js applications.

## Data safety

Do not delete or recreate `database/database.sqlite`. Do not run destructive
migrations against it. Back up the database before changing application data.
