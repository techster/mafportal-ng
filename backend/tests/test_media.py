from pathlib import Path

from app.media import MediaStorage
from app.settings import Settings


def test_local_storage_uses_configured_asset_root(tmp_path: Path) -> None:
    settings = Settings(media_local_root=tmp_path / "canonical-assets")
    storage = MediaStorage(settings)

    storage.put("images/example.jpg", b"image-data")

    assert (tmp_path / "canonical-assets" / "images" / "example.jpg").read_bytes() == b"image-data"
    assert storage.url("images/example.jpg") == "/assets/images/example.jpg"
    assert storage.url("tournaments/example.jpg") == "/assets/tournaments/example.jpg"


def test_legacy_compatibility_setting_controls_url_shape(tmp_path: Path) -> None:
    compatible = MediaStorage(
        Settings(media_local_root=tmp_path / "assets", media_legacy_compatibility=True)
    )
    canonical_only = MediaStorage(
        Settings(media_local_root=tmp_path / "assets", media_legacy_compatibility=False)
    )

    assert compatible.url("uploads/example.jpg") == "/uploads/example.jpg"
    assert canonical_only.url("uploads/example.jpg") == "/assets/images/example.jpg"


def test_legacy_admin_and_avatar_paths_use_reorganized_locations(tmp_path: Path) -> None:
    storage = MediaStorage(Settings(media_local_root=tmp_path / "assets"))

    storage.put("admin/photos/example.jpg", b"admin-image")
    storage.put("avatars/example.jpg", b"avatar-image")

    assert (tmp_path / "assets" / "images" / "admin" / "photos" / "example.jpg").read_bytes() == b"admin-image"
    assert (tmp_path / "assets" / "avatar" / "example.jpg").read_bytes() == b"avatar-image"
    assert storage.url("avatars/example.jpg") == "/assets/avatar/example.jpg"
    assert storage.url("images/avatars/example.jpg") == "/assets/avatar/example.jpg"
    assert storage.url("images/users/avatar/example.jpg") == "/assets/avatar/example.jpg"
    assert storage.url("http://127.0.0.1:8001/assets/images/users/avatar/example.jpg") == "/assets/avatar/example.jpg"
    assert storage.url("/uploads/users/avatar/example.jpg") == "/assets/avatar/example.jpg"
    assert storage.url("avatar/example.jpg") == "/assets/avatar/example.jpg"


def test_configured_legacy_root_is_independent_from_asset_root(tmp_path: Path) -> None:
    settings = Settings(
        media_local_root=tmp_path / "canonical-assets",
        media_legacy_root=tmp_path / "legacy-public",
    )

    assert settings.media_local_root == tmp_path / "canonical-assets"
    assert settings.media_legacy_root == tmp_path / "legacy-public"