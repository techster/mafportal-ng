from fastapi.testclient import TestClient

from app.main import app


client = TestClient(app)


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
