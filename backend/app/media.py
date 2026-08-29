from __future__ import annotations

import mimetypes
from pathlib import Path, PurePosixPath
from typing import BinaryIO
from urllib.parse import urlparse

from app.settings import Settings, get_settings


class MediaStorage:
    """Resolve stable media keys to local or DigitalOcean Spaces objects."""

    def __init__(self, settings: Settings | None = None) -> None:
        self.settings = settings or get_settings()
        self.backend = self.settings.media_backend.lower().strip()
        if self.backend not in {"local", "spaces", "s3"}:
            raise ValueError("MAFPORTAL_MEDIA_BACKEND must be local or spaces")
        if self.backend in {"spaces", "s3"}:
            required = {
                "MAFPORTAL_MEDIA_SPACES_ENDPOINT": self.settings.media_spaces_endpoint,
                "MAFPORTAL_MEDIA_SPACES_BUCKET": self.settings.media_spaces_bucket,
                "MAFPORTAL_MEDIA_SPACES_REGION": self.settings.media_spaces_region,
                "MAFPORTAL_MEDIA_SPACES_ACCESS_KEY": self.settings.media_spaces_access_key,
                "MAFPORTAL_MEDIA_SPACES_SECRET_KEY": self.settings.media_spaces_secret_key,
            }
            missing = [name for name, value in required.items() if not value]
            if missing:
                raise ValueError(f"Spaces storage is missing settings: {', '.join(missing)}")
            try:
                import boto3
            except ImportError as exc:
                raise ValueError("Install boto3 to use Spaces storage") from exc
            self._client = boto3.client(
                "s3",
                endpoint_url=self.settings.media_spaces_endpoint.rstrip("/"),
                region_name=self.settings.media_spaces_region,
                aws_access_key_id=self.settings.media_spaces_access_key,
                aws_secret_access_key=self.settings.media_spaces_secret_key,
            )
        else:
            self._client = None

    @property
    def public_base_url(self) -> str:
        configured = self.settings.media_public_base_url.strip().rstrip("/")
        if configured:
            return configured
        return "/assets" if self.backend == "local" else (
            f"{self.settings.media_spaces_endpoint.rstrip('/')}/"
            f"{self.settings.media_spaces_bucket}"
        )

    def key_for(self, value: str | None) -> str | None:
        if not value:
            return None
        raw = str(value).strip().replace("\\/", "/").replace("\\", "/")
        parsed = urlparse(raw)
        path = parsed.path if parsed.scheme or parsed.netloc else raw
        path = path.lstrip("/")
        if path.startswith("assets/"):
            path = path[7:]
        if path.startswith("uploads/users/avatar/"):
            return self._safe_key("avatar/" + path[21:])
        if path.startswith("uploads/"):
            return self._safe_key("images/" + path[8:])
        if path.startswith("avatars/"):
            return self._safe_key("avatar/" + path[8:])
        if path.startswith("avatar/"):
            return self._safe_key(path)
        if path.startswith("images/uploads/"):
            return self._safe_key("images/" + path[15:])
        if path.startswith("images/avatars/"):
            return self._safe_key("avatar/" + path[15:])
        if path.startswith("images/users/avatar/"):
            return self._safe_key("avatar/" + path[20:])
        if path.startswith("images/system/"):
            return self._safe_key("system/" + path[14:])
        if path.startswith(("galleries/", "tournaments/")):
            return self._safe_key(path)
        if path.startswith(("images/", "system/", "images/build/", "videos/")):
            return self._safe_key(path)
        if path.startswith("build/"):
            return self._safe_key("images/build/" + path[6:])
        if path.startswith("admin/"):
            return self._safe_key("images/" + path)
        if parsed.scheme or parsed.netloc:
            return None
        return None

    def url(self, value: str | None, local_legacy: bool | None = None) -> str | None:
        if not value:
            return None
        raw = str(value).strip().replace("\\/", "/").replace("\\", "/")
        key = self.key_for(raw)
        if raw.startswith(("http://", "https://")) and self.backend == "local" and not key:
            return raw
        if not key:
            return raw if raw.startswith(("http://", "https://")) else None
        if local_legacy is None:
            local_legacy = self.settings.media_legacy_compatibility
        canonical_input = raw.lstrip("/").startswith(("images/", "system/", "videos/", "assets/"))
        if self.backend == "local" and local_legacy and not canonical_input:
            if key.startswith("avatar/"):
                return "/avatars/" + key.removeprefix("avatar/")
            if key.startswith("images/"):
                return "/uploads/" + key.removeprefix("images/")
            if key.startswith("system/"):
                return "/images/" + key.removeprefix("system/")
            if key.startswith("images/build/"):
                return "/build/" + key.removeprefix("images/build/")
        public_key = self._object_key(key) if self.backend in {"spaces", "s3"} else key
        return f"{self.public_base_url}/{public_key}"

    def _safe_key(self, key: str) -> str:
        normalized = str(PurePosixPath(key))
        if normalized in {"", "."} or normalized.startswith("../") or "/../" in f"/{normalized}/":
            raise ValueError("Invalid media key")
        return normalized

    def _object_key(self, key: str) -> str:
        prefix = self.settings.media_spaces_key_prefix.strip("/")
        return f"{prefix}/{key}" if prefix else key

    def local_path(self, value: str) -> Path:
        key = self.key_for(value)
        if not key:
            raise ValueError("Media value is not a managed key")
        path = (self.settings.media_local_root / key).resolve()
        root = self.settings.media_local_root.resolve()
        if root not in path.parents and path != root:
            raise ValueError("Media path escapes local asset root")
        return path

    def put(self, key: str, data: bytes | BinaryIO, content_type: str | None = None) -> None:
        key = self._safe_key(key)
        content_type = content_type or mimetypes.guess_type(key)[0] or "application/octet-stream"
        if self.backend == "local":
            path = self.local_path(key)
            path.parent.mkdir(parents=True, exist_ok=True)
            if hasattr(data, "seek"):
                data.seek(0)
                path.write_bytes(data.read())
            else:
                path.write_bytes(data)
            return
        body = data.read() if hasattr(data, "read") else data
        self._client.put_object(Bucket=self.settings.media_spaces_bucket, Key=self._object_key(key), Body=body, ContentType=content_type, CacheControl="public, max-age=31536000, immutable")

    def delete(self, value: str | None) -> None:
        key = self.key_for(value)
        if not key:
            return
        if self.backend == "local":
            self.local_path(key).unlink(missing_ok=True)
        else:
            self._client.delete_object(Bucket=self.settings.media_spaces_bucket, Key=self._object_key(key))

    def verify(self, value: str) -> bool:
        key = self.key_for(value) or self._safe_key(value)
        if self.backend == "local":
            return self.local_path(key).is_file()
        try:
            self._client.head_object(Bucket=self.settings.media_spaces_bucket, Key=self._object_key(key))
        except Exception:
            return False
        return True


media_storage = MediaStorage()