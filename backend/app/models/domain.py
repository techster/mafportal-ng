from datetime import datetime

from sqlalchemy import DateTime, Float, Integer, String, Text
from sqlalchemy.orm import DeclarativeBase, Mapped, mapped_column


class Base(DeclarativeBase):
    pass


class Club(Base):
    __tablename__ = "clubs"
    __table_args__ = {"extend_existing": True}

    id: Mapped[int] = mapped_column(Integer, primary_key=True)
    title: Mapped[str] = mapped_column(String)
    slug: Mapped[str | None] = mapped_column(String)
    country_id: Mapped[int | None] = mapped_column(Integer)
    city: Mapped[str | None] = mapped_column(String)
    image: Mapped[str | None] = mapped_column(Text)
    description: Mapped[str | None] = mapped_column(Text)
    text: Mapped[str | None] = mapped_column(Text)


class User(Base):
    __tablename__ = "users"
    __table_args__ = {"extend_existing": True}

    id: Mapped[int] = mapped_column(Integer, primary_key=True)
    name: Mapped[str] = mapped_column(String)
    last_name: Mapped[str | None] = mapped_column(String)
    nickname: Mapped[str | None] = mapped_column(String)
    avatar: Mapped[str | None] = mapped_column(Text)


class Event(Base):
    __tablename__ = "events"
    __table_args__ = {"extend_existing": True}

    id: Mapped[int] = mapped_column(Integer, primary_key=True)
    title: Mapped[str] = mapped_column(String)
    slug: Mapped[str | None] = mapped_column(String)
    description: Mapped[str | None] = mapped_column(Text)
    text: Mapped[str | None] = mapped_column(Text)
    image: Mapped[str | None] = mapped_column(Text)
    created_at: Mapped[datetime | None] = mapped_column(DateTime)


class Country(Base):
    __tablename__ = "countries"
    __table_args__ = {"extend_existing": True}

    id: Mapped[int] = mapped_column(Integer, primary_key=True)
    title: Mapped[str] = mapped_column(String)
    description: Mapped[str | None] = mapped_column(Text)
    image: Mapped[str | None] = mapped_column(Text)


class News(Base):
    __tablename__ = "news"
    __table_args__ = {"extend_existing": True}

    id: Mapped[int] = mapped_column(Integer, primary_key=True)
    slug: Mapped[str] = mapped_column(String)
    title: Mapped[str] = mapped_column(String)
    description: Mapped[str | None] = mapped_column(Text)
    text: Mapped[str | None] = mapped_column(Text)
    image: Mapped[str | None] = mapped_column(Text)
    created_at: Mapped[datetime | None] = mapped_column(DateTime)


class PhotoGallery(Base):
    __tablename__ = "photo_galleries"
    __table_args__ = {"extend_existing": True}

    id: Mapped[int] = mapped_column(Integer, primary_key=True)
    title: Mapped[str] = mapped_column(String)
    slug: Mapped[str] = mapped_column(String)
    preview: Mapped[str | None] = mapped_column(Text)
    photos: Mapped[str | None] = mapped_column(Text)
    club_id: Mapped[int | None] = mapped_column(Integer)
    tournament_id: Mapped[int | None] = mapped_column(Integer)
    check_glob: Mapped[int | None] = mapped_column(Integer)
    created_at: Mapped[datetime | None] = mapped_column(DateTime)


class VideoGallery(Base):
    __tablename__ = "video_galleries"
    __table_args__ = {"extend_existing": True}

    id: Mapped[int] = mapped_column(Integer, primary_key=True)
    title: Mapped[str] = mapped_column(String)
    preview: Mapped[str | None] = mapped_column(Text)
    id_youtube: Mapped[str] = mapped_column(String)
    club_id: Mapped[int | None] = mapped_column(Integer)
    tournament_id: Mapped[int | None] = mapped_column(Integer)
    check_glob: Mapped[int | None] = mapped_column(Integer)
    created_at: Mapped[datetime | None] = mapped_column(DateTime)


class Testimonial(Base):
    __tablename__ = "testimonials"
    __table_args__ = {"extend_existing": True}

    id: Mapped[int] = mapped_column(Integer, primary_key=True)
    name: Mapped[str] = mapped_column(String)
    text: Mapped[str | None] = mapped_column(Text)
    image: Mapped[str | None] = mapped_column(Text)


class Page(Base):
    __tablename__ = "pages"
    __table_args__ = {"extend_existing": True}

    id: Mapped[int] = mapped_column(Integer, primary_key=True)
    template: Mapped[str | None] = mapped_column(String)
    title: Mapped[str] = mapped_column(String)
    slug: Mapped[str] = mapped_column(String)
    content: Mapped[str | None] = mapped_column(Text)
    extras: Mapped[str | None] = mapped_column(Text)


class Tournament(Base):
    __tablename__ = "tournaments"
    __table_args__ = {"extend_existing": True}

    id: Mapped[int] = mapped_column(Integer, primary_key=True)
    title: Mapped[str] = mapped_column(String)
    slug: Mapped[str | None] = mapped_column(String)
    preview: Mapped[str | None] = mapped_column(Text)
    description: Mapped[str | None] = mapped_column(Text)
    image: Mapped[str | None] = mapped_column(Text)
    text: Mapped[str | None] = mapped_column(Text)
    table_ratings_id: Mapped[int | None] = mapped_column(Integer)
    created_at: Mapped[datetime | None] = mapped_column(DateTime)
    live: Mapped[str | None] = mapped_column(Text)


class GameRating(Base):
    __tablename__ = "game_ratings"
    __table_args__ = {"extend_existing": True}

    id: Mapped[int] = mapped_column(Integer, primary_key=True)
    tournament_id: Mapped[int | None] = mapped_column(Integer)
    results: Mapped[str | None] = mapped_column(Text)
    sentence: Mapped[int | None] = mapped_column(Integer)
    best_move: Mapped[str | None] = mapped_column(String)
    best_move2: Mapped[str | None] = mapped_column(String)
    best_player: Mapped[str | None] = mapped_column(String)
    cool_citizen: Mapped[str | None] = mapped_column(String)
    prima_nota: Mapped[str | None] = mapped_column(String)
    select_prima: Mapped[int | None] = mapped_column(Integer)
    table_ratings_id: Mapped[str | None] = mapped_column(String)


class TableRating(Base):
    __tablename__ = "table_ratings"
    __table_args__ = {"extend_existing": True}

    id: Mapped[int] = mapped_column(Integer, primary_key=True)
    best_player: Mapped[float] = mapped_column(Float, default=0)
    best_step: Mapped[float] = mapped_column(Float, default=0)
    win_citizen: Mapped[float] = mapped_column(Float, default=0)
    win_sheriff: Mapped[float] = mapped_column(Float, default=0)
    win_mafia: Mapped[float] = mapped_column(Float, default=0)
    win_don: Mapped[float] = mapped_column(Float, default=0)
    fail_citizen: Mapped[float] = mapped_column(Float, default=0)
    fail_sheriff: Mapped[float] = mapped_column(Float, default=0)
    fail_mafia: Mapped[float] = mapped_column(Float, default=0)
    fail_don: Mapped[float] = mapped_column(Float, default=0)
    citizen_killed: Mapped[float] = mapped_column(Float, default=0)
    formula: Mapped[str | None] = mapped_column(String)
    prima_nota3: Mapped[float | None] = mapped_column(Float)
