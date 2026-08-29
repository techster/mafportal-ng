import json

from fastapi.testclient import TestClient

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
    assert _image_url("admin\\/photos\\/gallery.jpg") == "/assets/images/uploads/admin/photos/gallery.jpg"
    assert _image_url("/uploads/admin/photos/gallery.jpg") == "/assets/images/uploads/admin/photos/gallery.jpg"
    assert _image_url("gallery.jpg") is None


def test_gallery_images_parses_legacy_json_paths() -> None:
    value = json.dumps(["admin/photos/one.jpg", "admin/photos/two.jpg"])

    assert _gallery_images(value) == [
        "/assets/images/uploads/admin/photos/one.jpg",
        "/assets/images/uploads/admin/photos/two.jpg",
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