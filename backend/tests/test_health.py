from fastapi.testclient import TestClient

from app.main import app


def test_root_lists_api_links() -> None:
    response = TestClient(app).get("/")

    assert response.status_code == 200
    assert response.json()["docs"] == "/docs"
    assert response.json()["clubs"] == "/api/v1/clubs"


def test_health() -> None:
    response = TestClient(app).get("/health")

    assert response.status_code == 200
    assert response.json() == {"status": "ok"}
