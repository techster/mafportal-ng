import json
import re

from fastapi.testclient import TestClient

import app.admin as admin_module
from app.admin import _gallery_images, _gallery_preview, _image_preview, _image_url
from app.main import app


client = TestClient(app)


def test_admin_requires_login() -> None:
    response = client.get("/admin", follow_redirects=False)

    assert response.status_code == 303
    assert response.headers["location"] == "/admin/"


def test_admin_login_and_dashboard() -> None:
    login = client.post(
        "/admin/login",
        data={"username": "mafportaladmin@gmail.com", "password": "admin"},
        follow_redirects=False,
    )

    assert login.status_code == 303
    assert "mafportal_admin" in login.cookies

    dashboard = client.get("/admin/", cookies=login.cookies)
    assert dashboard.status_code == 200
    assert "Admin dashboard" in dashboard.text
    assert "/admin/tournament" in dashboard.text


def test_admin_rejects_invalid_credentials_without_setting_session() -> None:
    response = TestClient(app).post(
        "/admin/login",
        data={"username": "wrong@example.com", "password": "wrong"},
        follow_redirects=False,
    )

    assert response.status_code == 200
    assert "Invalid username or password" in response.text
    assert "mafportal_admin" not in response.cookies


def test_admin_session_cookie_and_logout_csrf() -> None:
    session = TestClient(app)
    login = session.post(
        "/admin/login",
        data={"username": "mafportaladmin@gmail.com", "password": "admin"},
        follow_redirects=False,
    )

    cookie = login.headers["set-cookie"].lower()
    assert "httponly" in cookie
    assert "max-age=28800" in cookie
    assert "path=/admin" in cookie
    assert "samesite=lax" in cookie

    dashboard = session.get("/admin/")
    csrf_match = re.search(r'name="csrf_token" value="([^"]+)"', dashboard.text)
    assert csrf_match is not None
    assert session.post("/admin/logout", data={}, follow_redirects=False).status_code == 403

    logout = session.post(
        "/admin/logout",
        data={"csrf_token": csrf_match.group(1)},
        follow_redirects=False,
    )
    assert logout.status_code == 303
    assert logout.headers["location"] == "/admin"


def test_expired_admin_session_is_rejected(monkeypatch) -> None:
    monkeypatch.setattr(admin_module, "time", lambda: 1_000)
    token = admin_module._session_token()
    monkeypatch.setattr(
        admin_module,
        "time",
        lambda: 1_000 + admin_module.settings.admin_session_ttl_seconds + 1,
    )

    response = TestClient(app).get("/admin/", cookies={"mafportal_admin": token})

    assert response.status_code == 200
    assert "Admin sign in" in response.text


def test_club_membership_mutations_reject_get_requests() -> None:
    session = TestClient(app)

    assert session.get("/admin/confirm_user_to_club/1/1").status_code == 405
    assert session.get("/admin/cancel_user_to_club/1/1").status_code == 405


def test_admin_mutations_reject_missing_or_tampered_csrf() -> None:
    session = TestClient(app)
    session.post(
        "/admin/login",
        data={"username": "mafportaladmin@gmail.com", "password": "admin"},
    )

    assert session.post("/admin/tournament/1/delete", data={}).status_code == 403
    assert session.post(
        "/admin/tournament/create",
        data={"csrf_token": "tampered"},
    ).status_code == 403


def test_admin_lists_legacy_tournament_resource() -> None:
    login = client.post(
        "/admin/login",
        data={"username": "mafportaladmin@gmail.com", "password": "admin"},
        follow_redirects=False,
    )

    response = client.get("/admin/tournament", cookies=login.cookies)

    assert response.status_code == 200
    assert "Tournaments" in response.text
    assert "Add record" in response.text


def test_image_url_normalizes_legacy_upload_paths() -> None:
    assert _image_url("admin\\/photos\\/gallery.jpg") == "/assets/images/admin/photos/gallery.jpg"
    assert _image_url("/uploads/admin/photos/gallery.jpg") == "/assets/images/admin/photos/gallery.jpg"
    assert _image_url("gallery.jpg") is None


def test_gallery_images_parses_legacy_json_paths() -> None:
    value = json.dumps(["admin/photos/one.jpg", "admin/photos/two.jpg"])

    assert _gallery_images(value) == [
        "/assets/images/admin/photos/one.jpg",
        "/assets/images/admin/photos/two.jpg",
    ]
    assert _gallery_images("not json") == []


def test_gallery_preview_paginates_and_uses_lightbox_links() -> None:
    value = json.dumps([f"admin/photos/{index}.jpg" for index in range(25)])

    first_page = _gallery_preview(value)
    second_page = _gallery_preview(value, page=2)

    assert first_page.count('class="gallery-tile glightbox"') == 12
    assert second_page.count('class="gallery-tile glightbox"') == 12
    assert 'href="?photo_page=2"' in first_page
    assert "Page 2 of 3" in second_page
    assert 'target="_blank"' not in first_page


def test_image_preview_uses_closable_lightbox_trigger() -> None:
    preview = _image_preview("/uploads/admin/photos/cover.jpg", "Cover")

    assert 'class="image-preview glightbox"' in preview
    assert 'data-type="image"' in preview
    assert 'target="_blank"' not in preview