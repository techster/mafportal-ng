import json

from fastapi import APIRouter, Depends
from sqlalchemy import select, text
from sqlalchemy.orm import Session

from app.db import get_db
from app.media import media_storage
from app.models.domain import Club, GameRating, PhotoGallery, Tournament, User, VideoGallery
from app.ratings.service import calculate_game_scores, calculate_tournament_rating
from app.schemas import TournamentRead


router = APIRouter(prefix="/tournaments", tags=["tournaments"])
AVATAR_FALLBACK = "images/avatars/avatar-silhouette.svg"
IMAGE_FALLBACK = "images/build/img/not_img.jpg"


def resolve_avatar(stored_avatar: str | None) -> str:
    return media_storage.url(stored_avatar) or media_storage.url(AVATAR_FALLBACK) or "/images/avatar-silhouette.svg"


def resolve_preview(stored_preview: str | None) -> str:
    return media_storage.url(stored_preview) or media_storage.url(IMAGE_FALLBACK) or "/build/img/not_img.jpg"


@router.get("", response_model=list[TournamentRead])
def list_tournaments(db: Session = Depends(get_db)) -> list[Tournament]:
    tournaments = db.scalars(select(Tournament).order_by(Tournament.created_at.desc())).all()
    return [
        TournamentRead.model_validate(tournament).model_copy(update={"preview": resolve_preview(tournament.preview)})
        for tournament in tournaments
    ]


@router.get("/{slug}")
def get_tournament(slug: str, db: Session = Depends(get_db)) -> dict:
    tournament = db.scalar(select(Tournament).where(Tournament.slug == slug))
    if tournament is None:
        from fastapi import HTTPException
        raise HTTPException(status_code=404, detail="Tournament not found")
    games = db.scalars(select(GameRating).where(GameRating.tournament_id == tournament.id).order_by(GameRating.id)).all()
    player_ids = {int(player["player"]) for game in games if game.results for player in json.loads(game.results or "[]") if player.get("player") and str(player["player"]).isdigit()}
    users = {user.id: user for user in db.scalars(select(User).where(User.id.in_(player_ids))).all()} if player_ids else {}
    club_names = {}
    for user_id, club_id in db.execute(text("select user_id, club_id from club_user")).all() if player_ids else []:
        if user_id not in player_ids:
            continue
        club = db.get(Club, club_id)
        if club and user_id not in club_names:
            club_names[user_id] = club.title
    schedule = []
    game_scores = calculate_game_scores(db, tournament.id)
    for game in games:
        try:
            players = json.loads(game.results or "[]")
        except json.JSONDecodeError:
            players = []
        schedule.append({"id": game.id, "sentence": game.sentence, "players": [{"player": item.get("player"), "name": f"{users[int(item['player'])].name} {users[int(item['player'])].last_name or ''}".strip() if str(item.get("player")).isdigit() and int(item["player"]) in users else f"Player {item.get('player')}", "club": club_names.get(int(item["player"]), "") if str(item.get("player")).isdigit() else "", "avatar": resolve_avatar(users[int(item["player"])].avatar) if str(item.get("player")).isdigit() and int(item["player"]) in users else AVATAR_FALLBACK, "role": {"1": "Citizen", "2": "Sheriff", "3": "Mafia", "4": "Don"}.get(str(item.get("role")), ""), "result": game_scores.get(game.id, {}).get(int(item["player"]), {}).get("result") if str(item.get("player")).isdigit() else "", "points": game_scores.get(game.id, {}).get(int(item["player"]), {}).get("points", "") if str(item.get("player")).isdigit() else "", "add_points": game_scores.get(game.id, {}).get(int(item["player"]), {}).get("add_points", "") if str(item.get("player")).isdigit() else ""} for item in players if str(item.get("player")) != "239"]})
    photos = db.scalars(select(PhotoGallery).where(PhotoGallery.tournament_id == tournament.id).order_by(PhotoGallery.id.desc()).limit(24)).all()
    videos = db.scalars(select(VideoGallery).where(VideoGallery.tournament_id == tournament.id).order_by(VideoGallery.id.desc()).limit(24)).all()
    rating = calculate_tournament_rating(db, tournament.id) or []
    for row in rating:
        user = users.get(int(row["player_id"]))
        row["player"] = f"{user.name} {user.last_name or ''}".strip() if user else f"Player {row['player_id']}"
        row["club"] = club_names.get(int(row["player_id"]), "")
        row["avatar"] = resolve_avatar(user.avatar) if user else AVATAR_FALLBACK
    return {"id": tournament.id, "title": tournament.title, "slug": tournament.slug, "preview": resolve_preview(tournament.preview), "description": tournament.description, "image": tournament.image, "text": tournament.text, "created_at": tournament.created_at, "live": tournament.live, "rating": rating, "schedule": schedule, "photo_galleries": [{"id": item.id, "title": item.title, "slug": item.slug, "preview": item.preview, "check_glob": item.check_glob, "photos": []} for item in photos], "video_galleries": [{"id": item.id, "title": item.title, "preview": item.preview, "check_glob": item.check_glob, "id_youtube": item.id_youtube} for item in videos]}
