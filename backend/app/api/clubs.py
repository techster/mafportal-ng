import json
from datetime import datetime

from fastapi import APIRouter, Depends
from sqlalchemy import select, text
from sqlalchemy.orm import Session

from app.db import get_db
from app.models.domain import Club, Event, PhotoGallery, VideoGallery
from app.schemas import ClubDetailRead, ClubRead


router = APIRouter(prefix="/clubs", tags=["clubs"])


@router.get("", response_model=list[ClubRead])
def list_clubs(db: Session = Depends(get_db)) -> list[Club]:
    return list(db.scalars(select(Club).order_by(Club.title)).all())


@router.get("/{slug}", response_model=ClubDetailRead)
def get_club(slug: str, db: Session = Depends(get_db)) -> dict:
    club = db.scalar(select(Club).where(Club.slug == slug))
    if club is None:
        from fastapi import HTTPException
        raise HTTPException(status_code=404, detail="Club not found")
    event_ids = db.execute(text("select event_id from club_event where club_id = :club_id"), {"club_id": club.id}).scalars().all()
    event_rows = db.scalars(select(Event).where(Event.id.in_(event_ids), Event.created_at >= datetime.now()).order_by(Event.id)).all() if event_ids else []
    photos = db.scalars(select(PhotoGallery).where(PhotoGallery.club_id == club.id).order_by(PhotoGallery.id.desc()).limit(24)).all()
    videos = db.scalars(select(VideoGallery).where(VideoGallery.club_id == club.id).order_by(VideoGallery.id.desc()).limit(24)).all()
    photo_rows = []
    for gallery in photos:
        try:
            parsed_photos = json.loads(gallery.photos) if gallery.photos else []
        except (TypeError, json.JSONDecodeError):
            parsed_photos = []
        gallery_photos = list(parsed_photos.values()) if isinstance(parsed_photos, dict) else parsed_photos if isinstance(parsed_photos, list) else []
        photo_rows.append({"id": gallery.id, "title": gallery.title, "slug": gallery.slug, "preview": gallery.preview, "check_glob": gallery.check_glob, "photos": gallery_photos})
    video_rows = [{"id": gallery.id, "title": gallery.title, "preview": gallery.preview, "check_glob": gallery.check_glob, "id_youtube": gallery.id_youtube} for gallery in videos]
    return {"id": club.id, "title": club.title, "slug": club.slug, "country_id": club.country_id, "city": club.city, "image": club.image, "description": club.description, "text": club.text, "events": event_rows, "photo_galleries": photo_rows, "video_galleries": video_rows}
