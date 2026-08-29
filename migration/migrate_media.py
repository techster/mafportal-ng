"""Build and optionally copy the canonical media asset tree."""

from __future__ import annotations

import argparse
import hashlib
import json
import mimetypes
import shutil
from pathlib import Path

try:
    from PIL import Image
except ImportError:
    Image = None

ROOT = Path(__file__).resolve().parents[1]
ASSET_ROOT = ROOT / "assets"
MEDIA_ROOTS = {
    "uploads": ROOT / "public" / "uploads",
    "images": ROOT / "public" / "images",
    "avatars": ROOT / "public" / "avatars",
}
IMAGE_EXTENSIONS = {".avif", ".gif", ".jpeg", ".jpg", ".png", ".svg", ".webp"}
VIDEO_EXTENSIONS = {".avi", ".m4v", ".mkv", ".mov", ".mp4", ".ogv", ".webm"}
FILE_EXTENSIONS = {".ca-bundle"}
MANIFEST_PATH = ASSET_ROOT / "asset-manifest.json"


def media_kind(path: Path) -> str | None:
    suffix = path.suffix.lower()
    if suffix in IMAGE_EXTENSIONS or suffix == ".ico":
        return "images"
    if suffix in VIDEO_EXTENSIONS:
        return "videos"
    if path.name.lower().endswith(tuple(FILE_EXTENSIONS)):
        return "files"
    return None


def destination_for(source_root_name: str, source: Path, kind: str) -> Path:
    relative = source.relative_to(MEDIA_ROOTS[source_root_name])
    category = "avatars" if source_root_name == "avatars" else "system" if source_root_name == "images" else "uploads"
    return ASSET_ROOT / kind / category / relative


def sha256(path: Path) -> str:
    digest = hashlib.sha256()
    with path.open("rb") as handle:
        for chunk in iter(lambda: handle.read(1024 * 1024), b""):
            digest.update(chunk)
    return digest.hexdigest()


def image_metadata(path: Path) -> dict[str, int] | None:
    if Image is None or path.suffix.lower() == ".svg":
        return None
    try:
        with Image.open(path) as image:
            return {"width": image.width, "height": image.height}
    except Exception:
        return None


def collect_entries() -> list[dict[str, object]]:
    if not any(source_root.is_dir() for source_root in MEDIA_ROOTS.values()):
        raise RuntimeError(
            "No legacy media roots found. Refusing to replace the canonical manifest with zero entries."
        )
    entries: list[dict[str, object]] = []
    for source_root_name, source_root in MEDIA_ROOTS.items():
        if not source_root.exists():
            continue
        for source in sorted(source_root.rglob("*")):
            if not source.is_file():
                continue
            kind = media_kind(source)
            if kind is None:
                continue
            destination = destination_for(source_root_name, source, kind)
            entry: dict[str, object] = {
                "source": source.relative_to(ROOT).as_posix(),
                "key": destination.relative_to(ASSET_ROOT).as_posix(),
                "media_type": kind[:-1],
                "mime_type": mimetypes.guess_type(source.name)[0] or "application/octet-stream",
                "bytes": source.stat().st_size,
                "sha256": sha256(source),
                "status": "pending",
            }
            dimensions = image_metadata(source)
            if dimensions:
                entry["dimensions"] = dimensions
            entries.append(entry)
    return entries


def collect_canonical_entries() -> list[dict[str, object]]:
    entries: list[dict[str, object]] = []
    for path in sorted(ASSET_ROOT.rglob("*")):
        if not path.is_file() or path == MANIFEST_PATH:
            continue
        kind = media_kind(path)
        if kind is None:
            continue
        key = path.relative_to(ASSET_ROOT).as_posix()
        entry: dict[str, object] = {
            "source": f"assets/{key}",
            "key": key,
            "media_type": kind[:-1],
            "mime_type": mimetypes.guess_type(path.name)[0] or "application/octet-stream",
            "bytes": path.stat().st_size,
            "sha256": sha256(path),
            "status": "verified",
        }
        dimensions = image_metadata(path)
        if dimensions:
            entry["dimensions"] = dimensions
        entries.append(entry)
    return entries


def copy_entries(entries: list[dict[str, object]]) -> None:
    for entry in entries:
        source = ROOT / str(entry["source"])
        destination = ASSET_ROOT / str(entry["key"])
        destination.parent.mkdir(parents=True, exist_ok=True)
        if destination.exists() and sha256(destination) == entry["sha256"]:
            entry["status"] = "verified"
            continue
        shutil.copy2(source, destination)
        if sha256(destination) != entry["sha256"]:
            raise RuntimeError(f"Checksum mismatch after copying {source}")
        entry["status"] = "verified"


def upload_entries(entries: list[dict[str, object]]) -> None:
    import sys
    sys.path.insert(0, str(ROOT / "backend"))
    from app.media import MediaStorage
    from app.settings import get_settings

    storage = MediaStorage(get_settings())
    if storage.backend == "local":
        raise RuntimeError("Set MAFPORTAL_MEDIA_BACKEND=spaces before using --upload")
    for entry in entries:
        source = ROOT / str(entry["source"])
        with source.open("rb") as handle:
            storage.put(str(entry["key"]), handle, str(entry["mime_type"]))
        entry["remote_status"] = "verified" if storage.verify(str(entry["key"])) else "failed"
        if entry["remote_status"] != "verified":
            raise RuntimeError(f"Remote verification failed for {source}")


def main() -> None:
    parser = argparse.ArgumentParser()
    parser.add_argument("--copy", action="store_true", help="Copy media into assets/ after hashing")
    parser.add_argument("--upload", action="store_true", help="Upload source media to configured Spaces storage")
    parser.add_argument("--refresh", action="store_true", help="Rebuild the manifest from the current canonical assets tree")
    args = parser.parse_args()
    ASSET_ROOT.mkdir(parents=True, exist_ok=True)
    entries = collect_canonical_entries() if args.refresh else collect_entries()
    if args.copy:
        copy_entries(entries)
    if args.upload:
        upload_entries(entries)
    MANIFEST_PATH.write_text(json.dumps({"version": 1, "entries": entries}, indent=2) + "\n", encoding="utf-8")
    print(f"media entries: {len(entries)}")
    print(f"manifest: {MANIFEST_PATH}")
    if args.copy:
        pending = sum(entry["status"] != "verified" for entry in entries)
        print(f"unverified entries: {pending}")


if __name__ == "__main__":
    main()
