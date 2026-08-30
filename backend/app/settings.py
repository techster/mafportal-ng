from functools import lru_cache
from pathlib import Path

from pydantic_settings import BaseSettings, SettingsConfigDict


PROJECT_ROOT = Path(__file__).resolve().parents[2]


class Settings(BaseSettings):
    database_url: str = f"sqlite:///{PROJECT_ROOT / 'database' / 'database.sqlite'}"
    api_prefix: str = "/api/v1"
    admin_username: str = "mafportaladmin@gmail.com"
    admin_password: str = "admin"
    admin_session_secret: str = "change-this-admin-session-secret"
    admin_session_ttl_seconds: int = 28800
    admin_cookie_secure: bool = False
    media_backend: str = "local"
    media_local_root: Path = PROJECT_ROOT / "assets"
    media_legacy_root: Path = PROJECT_ROOT / "public"
    media_legacy_compatibility: bool = False
    media_public_base_url: str = ""
    media_spaces_endpoint: str = ""
    media_spaces_bucket: str = ""
    media_spaces_region: str = ""
    media_spaces_key_prefix: str = ""
    media_spaces_access_key: str = ""
    media_spaces_secret_key: str = ""
    model_config = SettingsConfigDict(env_prefix="MAFPORTAL_", env_file=".env", extra="ignore")


@lru_cache
def get_settings() -> Settings:
    return Settings()
