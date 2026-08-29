from fastapi import FastAPI
from fastapi.staticfiles import StaticFiles

from app.admin import router as admin_router
from app.api import clubs, content, countries, ratings, tournaments
from app.settings import get_settings


settings = get_settings()
app = FastAPI(title="MAF Portal API", version="0.1.0")
assets_dir = settings.media_local_root
assets_dir.mkdir(parents=True, exist_ok=True)
app.mount("/assets", StaticFiles(directory=assets_dir), name="assets")
app.include_router(admin_router)
app.include_router(clubs.router, prefix=settings.api_prefix)
app.include_router(countries.router, prefix=settings.api_prefix)
app.include_router(content.router, prefix=settings.api_prefix)
app.include_router(tournaments.router, prefix=settings.api_prefix)
app.include_router(ratings.router, prefix=settings.api_prefix)


@app.get("/", tags=["system"])
def root() -> dict[str, str]:
    return {
        "name": "MAF Portal API",
        "docs": "/docs",
        "health": "/health",
        "clubs": f"{settings.api_prefix}/clubs",
        "tournaments": f"{settings.api_prefix}/tournaments",
    }


@app.get("/health", tags=["system"])
def health() -> dict[str, str]:
    return {"status": "ok"}
