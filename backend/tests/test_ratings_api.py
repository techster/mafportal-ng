from fastapi.testclient import TestClient

from app.main import app


client = TestClient(app)


def test_tournament_rating_returns_player_rows() -> None:
    tournaments = client.get("/api/v1/tournaments").json()
    assert tournaments

    response = client.get(f"/api/v1/ratings/tournaments/{tournaments[0]['id']}")

    assert response.status_code == 200
    assert isinstance(response.json(), list)
    for row in response.json():
        assert {"player_id", "Game", "Win", "Balls", "Score"} <= row.keys()


def test_unknown_tournament_rating_returns_not_found() -> None:
    response = client.get("/api/v1/ratings/tournaments/2147483647")

    assert response.status_code == 404
    assert response.json() == {"detail": "Tournament not found"}
