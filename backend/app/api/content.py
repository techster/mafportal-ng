import json

from fastapi import APIRouter, Depends, HTTPException
from sqlalchemy import select
from sqlalchemy.orm import Session

from app.db import get_db
from app.models.domain import News, Page, PhotoGallery, Testimonial, VideoGallery
from app.schemas import NewsRead, PageRead, PhotoGalleryRead, TestimonialRead, VideoGalleryRead


router = APIRouter(tags=["content"])


@router.get("/news", response_model=list[NewsRead])
def list_news(db: Session = Depends(get_db)) -> list[News]:
    return list(db.scalars(select(News).order_by(News.created_at.desc())).all())


@router.get("/news/{slug}", response_model=NewsRead)
def get_news(slug: str, db: Session = Depends(get_db)) -> News:
    item = db.scalar(select(News).where(News.slug == slug))
    if item is None:
        raise HTTPException(status_code=404, detail="News article not found")
    return item


@router.get("/galleries/photos", response_model=list[PhotoGalleryRead])
def list_photo_galleries(db: Session = Depends(get_db)) -> list[PhotoGalleryRead]:
    galleries = db.scalars(select(PhotoGallery).order_by(PhotoGallery.created_at.desc())).all()
    return [PhotoGalleryRead.model_validate({**gallery.__dict__, "photos": _photos(gallery.photos)}) for gallery in galleries]


@router.get("/galleries/photos/{slug}", response_model=PhotoGalleryRead)
def get_photo_gallery(slug: str, db: Session = Depends(get_db)) -> PhotoGalleryRead:
    gallery = db.scalar(select(PhotoGallery).where(PhotoGallery.slug == slug))
    if gallery is None:
        raise HTTPException(status_code=404, detail="Photo gallery not found")
    return PhotoGalleryRead.model_validate({**gallery.__dict__, "photos": _photos(gallery.photos)})


@router.get("/galleries/videos", response_model=list[VideoGalleryRead])
def list_video_galleries(db: Session = Depends(get_db)) -> list[VideoGallery]:
    return list(db.scalars(select(VideoGallery).order_by(VideoGallery.created_at.desc())).all())


@router.get("/testimonials", response_model=list[TestimonialRead])
def list_testimonials(db: Session = Depends(get_db)) -> list[Testimonial]:
    return list(db.scalars(select(Testimonial).order_by(Testimonial.id.desc())).all())


@router.get("/pages/{slug}", response_model=PageRead)
def get_page(slug: str, db: Session = Depends(get_db)) -> Page:
    page = db.scalar(select(Page).where(Page.slug == slug))
    if page is None:
        raise HTTPException(status_code=404, detail="Page not found")
    return page


def _photos(value: str | None) -> list[str]:
    if not value:
        return []
    try:
        parsed = json.loads(value)
    except json.JSONDecodeError:
        return []
    return parsed if isinstance(parsed, list) else []