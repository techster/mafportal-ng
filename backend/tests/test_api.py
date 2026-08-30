from fastapi.testclient import TestClient
from sqlalchemy import event, text

from app.api.content import _gallery_preview
from app.db import engine
from app.main import app


client = TestClient(app)


def test_public_collection_endpoints_return_expected_contracts() -> None:
    contracts = {
        "/api/v1/countries": {"id", "title", "description", "image"},
        "/api/v1/news": {"id", "slug", "title", "description", "text", "image", "created_at"},
        "/api/v1/galleries/photos": {"id", "slug", "title", "preview", "photos"},
        "/api/v1/galleries/videos": {"id", "title", "preview", "id_youtube"},
        "/api/v1/testimonials": {"id", "name", "text", "image"},
    }

    for path, expected_keys in contracts.items():
        response = client.get(path)
        assert response.status_code == 200
        payload = response.json()
        assert isinstance(payload, list)
        if payload:
            assert expected_keys <= payload[0].keys()


def test_public_detail_endpoints_return_not_found() -> None:
    missing_slug = "missing-record-that-does-not-exist"

    for path in (
        f"/api/v1/clubs/{missing_slug}",
        f"/api/v1/news/{missing_slug}",
        f"/api/v1/galleries/photos/{missing_slug}",
        f"/api/v1/pages/{missing_slug}",
        f"/api/v1/tournaments/{missing_slug}",
    ):
        response = client.get(path)
        assert response.status_code == 404
        assert response.json()["detail"]


def test_photo_gallery_detail_matches_collection_item() -> None:
    galleries = client.get("/api/v1/galleries/photos").json()
    assert galleries

    expected = galleries[0]
    response = client.get(f"/api/v1/galleries/photos/{expected['slug']}")

    assert response.status_code == 200
    assert response.json() == expected
    assert isinstance(response.json()["photos"], list)


def test_gallery_preview_falls_back_from_legacy_upload_path() -> None:
    photos = ["galleries/wmc_armenia_history/cover.jpg"]

    assert _gallery_preview("/uploads/gallery/wmc_armenia_history/old-cover.jpg", photos, "wmc_armenia_history") == photos[0]


def test_clubs_are_read_from_sqlite() -> None:
    response = client.get("/api/v1/clubs")

    assert response.status_code == 200
    clubs = response.json()
    assert clubs
    assert all({"id", "title", "slug", "country_id"} <= club.keys() for club in clubs)
    assert [club["title"] for club in clubs] == sorted(club["title"] for club in clubs)


def test_tournaments_are_read_from_sqlite() -> None:
    response = client.get("/api/v1/tournaments")

    assert response.status_code == 200
    tournaments = response.json()
    assert tournaments
    assert all({"id", "title", "slug", "created_at"} <= tournament.keys() for tournament in tournaments)
    dates = [tournament["created_at"] for tournament in tournaments]
    assert dates == sorted(dates, reverse=True)


def test_tournament_detail_loads_player_clubs_without_n_plus_one() -> None:
    with engine.connect() as connection:
        slug = connection.execute(
            text(
                """
                SELECT tournaments.slug
                FROM tournaments
                JOIN game_ratings ON game_ratings.tournament_id = tournaments.id
                WHERE tournaments.slug IS NOT NULL AND game_ratings.results IS NOT NULL
                LIMIT 1
                """
            )
        ).scalar_one()

    statements: list[str] = []

    def capture_statement(_connection, _cursor, statement, _parameters, _context, _executemany):
        statements.append(statement.lower())

    event.listen(engine, "before_cursor_execute", capture_statement)
    try:
        response = client.get(f"/api/v1/tournaments/{slug}")
    finally:
        event.remove(engine, "before_cursor_execute", capture_statement)

    assert response.status_code == 200
    assert response.json()["schedule"]
    assert any("join clubs on clubs.id = club_user.club_id" in statement for statement in statements)
    assert not any("from clubs" in statement and "clubs.id = ?" in statement for statement in statements)
