from datetime import datetime

from pydantic import BaseModel, ConfigDict


class ClubRead(BaseModel):
    model_config = ConfigDict(from_attributes=True)

    id: int
    title: str
    slug: str | None = None
    country_id: int | None = None
    city: str | None = None
    image: str | None = None
    description: str | None = None
    text: str | None = None


class EventRead(BaseModel):
    model_config = ConfigDict(from_attributes=True)

    id: int
    title: str
    slug: str | None = None
    description: str | None = None
    text: str | None = None
    image: str | None = None
    created_at: datetime | None = None


class ClubDetailRead(ClubRead):
    events: list[EventRead] = []
    photo_galleries: list["PhotoGalleryRead"] = []
    video_galleries: list["VideoGalleryRead"] = []


class CountryRead(BaseModel):
    model_config = ConfigDict(from_attributes=True)

    id: int
    title: str
    description: str | None = None
    image: str | None = None


class NewsRead(BaseModel):
    model_config = ConfigDict(from_attributes=True)

    id: int
    slug: str
    title: str
    description: str | None = None
    text: str | None = None
    image: str | None = None
    created_at: datetime | None = None


class PhotoGalleryRead(BaseModel):
    model_config = ConfigDict(from_attributes=True)

    id: int
    title: str
    slug: str
    preview: str | None = None
    check_glob: int | None = None
    photos: list[str] = []


class VideoGalleryRead(BaseModel):
    model_config = ConfigDict(from_attributes=True)

    id: int
    title: str
    preview: str | None = None
    check_glob: int | None = None
    id_youtube: str


class TestimonialRead(BaseModel):
    model_config = ConfigDict(from_attributes=True)

    id: int
    name: str
    text: str | None = None
    image: str | None = None


class PageRead(BaseModel):
    model_config = ConfigDict(from_attributes=True)

    id: int
    template: str | None = None
    title: str
    slug: str
    content: str | None = None
    extras: str | None = None


class TournamentRead(BaseModel):
    model_config = ConfigDict(from_attributes=True)

    id: int
    title: str
    slug: str | None = None
    preview: str | None = None
    description: str | None = None
    image: str | None = None
    text: str | None = None
    created_at: datetime | None = None
