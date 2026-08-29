from __future__ import annotations

import hashlib
import hmac
import html
import json
import secrets
from datetime import date, datetime
from typing import Any
from urllib.parse import parse_qs, urlencode, urlparse

import bcrypt
from fastapi import APIRouter, Request, UploadFile
from fastapi.responses import HTMLResponse, RedirectResponse
from sqlalchemy import MetaData, Table, inspect, select, text

from app.db import SessionLocal, engine
from app.media import media_storage
from app.settings import get_settings


router = APIRouter(prefix="/admin", tags=["admin"])
settings = get_settings()
IMAGE_FIELDS = {
    "image": "admin/{slug}",
    "preview": "admin/{slug}",
    "logo": "admin/{slug}",
    "value": "admin/thumbnails",
    "photos": "admin/{slug}",
}
IMAGE_RESOURCES = {
    "news": "news", "product": "shop", "tournament": "tournaments", "photo_gallery": "photos",
    "video_gallery": "video", "slide": "slider", "testimonial": "testimonials", "partner": "partners",
    "club": "clubs", "country": "country", "event": "events", "thumb_image": "thumbnails",
    "globalRatings": "globalRating",
}
REQUIRED_FIELDS = {
    "menu-item": ("name", "name_rus"), "news": ("title", "title_ru", "description", "description_ru"),
    "tournament": ("title", "title_ru", "description", "description_ru"), "club": ("title",),
    "country": ("title",), "event": ("title",), "seasons": ("title", "start", "end"),
    "user": ("name", "email"), "role": ("name",), "permission": ("name",), "product": ("title",),
    "photo_gallery": ("title",), "video_gallery": ("title", "id_youtube"), "testimonial": ("name",),
    "partner": ("name",), "create-game-results": ("title", "moderator", "results"),
    "create-table-ratings": ("title", "best_player", "best_step", "win_citizen", "win_sheriff", "win_mafia", "win_don", "fail_citizen", "fail_sheriff", "fail_mafia", "fail_don"),
    "thumb_image": ("value", "title", "description"), "rating-list": ("club", "player", "game"),
}
UNIQUE_FIELDS = {
    "user": "email", "news": "slug", "tournament": "slug", "club": "slug", "country": "title",
    "event": "slug", "seasons": "title", "product": "title", "photo_gallery": "slug",
    "video_gallery": "title", "role": "name", "permission": "name", "create-game-results": "title",
    "create-table-ratings": "title", "page": "slug",
}
PAGE_EXTRA_FIELDS = ("meta_title", "meta_description", "title_rus", "content_rus", "meta_title_ru", "meta_description_ru", "phones", "email", "facebook", "instagram", "twitter")

# These aliases mirror the Laravel Backpack routes. Only real database tables are exposed.
RESOURCES: dict[str, tuple[str, str]] = {
    "menu-item": ("menu_items", "Menu items"),
    "page": ("pages", "Pages"),
    "news": ("news", "News"),
    "product": ("products", "Products"),
    "tournament": ("tournaments", "Tournaments"),
    "photo_gallery": ("photo_galleries", "Photo galleries"),
    "video_gallery": ("video_galleries", "Video galleries"),
    "slide": ("slides", "Slides"),
    "testimonial": ("testimonials", "Testimonials"),
    "partner": ("partners", "Partners"),
    "club": ("clubs", "Clubs"),
    "country": ("countries", "Countries"),
    "event": ("events", "Events"),
    "contact": ("contacts", "Contacts"),
    "seasons": ("seasons", "Seasons"),
    "options": ("options", "Options"),
    "globalRatings": ("global_ratings", "Global ratings"),
    "user": ("users", "Users"),
    "order": ("orders", "Orders"),
    "permission": ("permissions", "Permissions"),
    "role": ("roles", "Roles"),
    "rating-list": ("ratings", "Rating list"),
    "create-game-results": ("game_ratings", "Game results"),
    "create-table-ratings": ("table_ratings", "Rating tables"),
    "thumb_image": ("gen_settings", "General settings"),
}

RESOURCE_GROUPS = (
    ("Content", ("page", "news", "menu-item", "slide", "partner", "testimonial")),
    ("Competition", ("tournament", "club", "country", "event", "seasons")),
    ("Ratings", ("create-game-results", "create-table-ratings", "rating-list", "globalRatings")),
    ("Media and shop", ("photo_gallery", "video_gallery", "product", "order")),
    ("Access and settings", ("user", "role", "permission", "contact", "options", "thumb_image")),
)


def _escape(value: Any) -> str:
    return html.escape("" if value is None else str(value), quote=True)


def _signature(value: str) -> str:
    return hmac.new(settings.admin_session_secret.encode(), value.encode(), hashlib.sha256).hexdigest()


def _session_token() -> str:
    payload = f"{settings.admin_username}:{secrets.token_urlsafe(18)}"
    return f"{payload}.{_signature(payload)}"


def _authenticated(request: Request) -> bool:
    token = request.cookies.get("mafportal_admin")
    if not token or "." not in token:
        return False
    payload, signature = token.rsplit(".", 1)
    return payload.startswith(f"{settings.admin_username}:") and hmac.compare_digest(
        signature, _signature(payload)
    )


def _redirect_login() -> RedirectResponse:
    return RedirectResponse("/admin", status_code=303)


def _table_info(table_name: str) -> list[dict[str, Any]]:
    return inspect(engine).get_columns(table_name)


def _resource(slug: str) -> tuple[str, str] | None:
    resource = RESOURCES.get(slug)
    if resource is None:
        return None
    available = set(inspect(engine).get_table_names())
    return resource if resource[0] in available else None


def _layout(title: str, content: str) -> str:
    nav_groups = "".join(
        f'<div class="nav-group"><span class="nav-label">{_escape(group)}</span>{"".join(f'<a href="/admin/{_escape(slug)}">{_escape(RESOURCES[slug][1])}</a>' for slug in slugs if slug in RESOURCES)}</div>'
        for group, slugs in RESOURCE_GROUPS
    )
    return f"""<!doctype html>
<html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>{_escape(title)} | MAF Portal Admin</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox@3.3.1/dist/css/glightbox.min.css">
<style>
:root {{ color-scheme:light; --ink:#172536; --muted:#6d7a89; --line:#dbe2e8; --accent:#e7654f; --accent-dark:#bd4939; --wash:#f3f6f8; --sidebar:#172536; --sidebar-soft:#213447; --card:#fff; }}
* {{ box-sizing:border-box; }} body {{ margin:0; color:var(--ink); background:var(--wash); font:14px/1.5 "Segoe UI",Arial,sans-serif; }}
a {{ color:inherit; }} .shell {{ display:grid; grid-template-columns:258px 1fr; min-height:100vh; }}
aside {{ background:var(--sidebar); color:#f5f8fa; padding:28px 17px 20px; }} aside h1 {{ margin:0; font-size:20px; letter-spacing:.03em; }} .brand {{ display:flex; align-items:center; gap:11px; padding:0 10px 30px; }} .brand-mark {{ display:grid; place-items:center; width:34px; height:34px; border-radius:10px; background:var(--accent); color:#fff; font-weight:800; }} .brand-copy {{ display:grid; gap:1px; }} .brand-copy small {{ color:#93a6b7; font-size:10px; letter-spacing:.12em; text-transform:uppercase; }}
nav {{ display:grid; gap:22px; }} .nav-group {{ display:grid; gap:3px; }} .nav-label {{ padding:0 10px 7px; color:#8095a8; font-size:10px; font-weight:700; letter-spacing:.12em; text-transform:uppercase; }} nav a {{ color:#cfdae3; text-decoration:none; padding:9px 10px; border-left:2px solid transparent; border-radius:5px; }} nav a:hover {{ background:var(--sidebar-soft); color:#fff; border-left-color:var(--accent); }}
main {{ width:100%; max-width:1500px; padding:0 clamp(20px,4vw,62px) 50px; }} .topbar {{ display:flex; justify-content:space-between; align-items:center; min-height:64px; border-bottom:1px solid var(--line); color:var(--muted); font-size:12px; }} .topbar strong {{ color:var(--ink); font-size:12px; }} .status {{ display:flex; align-items:center; gap:7px; }} .status-dot {{ width:7px; height:7px; border-radius:50%; background:#44b883; }} header {{ display:flex; justify-content:space-between; align-items:flex-end; gap:18px; margin:42px 0 25px; }} h2 {{ margin:0; font-size:32px; letter-spacing:-.02em; line-height:1.1; }} h3 {{ font-size:18px; margin:0 0 12px; }}
.panel {{ background:var(--card); border:1px solid var(--line); box-shadow:0 8px 26px rgba(23,37,54,.04); padding:22px; margin-bottom:20px; border-radius:10px; }}
.image-preview {{ display:flex; align-items:center; gap:10px; width:max-content; max-width:100%; color:var(--accent-dark); font-size:11px; text-decoration:none; }} .image-preview img {{ width:76px; height:54px; object-fit:cover; border:1px solid var(--line); border-radius:6px; background:#eef2f5; }} .gallery-meta {{ display:flex; justify-content:space-between; align-items:center; margin-bottom:12px; }} .gallery-grid {{ display:grid; grid-template-columns:repeat(auto-fill,minmax(115px,1fr)); gap:10px; }} .gallery-tile {{ position:relative; aspect-ratio:4/3; overflow:hidden; border-radius:7px; background:#eef2f5; }} .gallery-tile img {{ width:100%; height:100%; object-fit:cover; transition:transform .15s ease; }} .gallery-tile:hover img {{ transform:scale(1.04); }} .gallery-tile span {{ position:absolute; right:5px; bottom:5px; padding:2px 5px; border-radius:4px; background:rgba(23,37,54,.78); color:#fff; font-size:10px; }} .pagination {{ display:flex; flex-wrap:wrap; gap:6px; margin-top:16px; }} .page-link {{ display:inline-flex; min-width:30px; height:30px; align-items:center; justify-content:center; border:1px solid var(--line); border-radius:5px; color:var(--muted); text-decoration:none; }} .page-link:hover,.page-link.current {{ border-color:var(--accent); background:var(--accent); color:#fff; }}
.grid {{ display:grid; grid-template-columns:repeat(auto-fit,minmax(215px,1fr)); gap:15px; }} .resource {{ position:relative; overflow:hidden; border-top:0; text-decoration:none; transition:transform .15s ease, box-shadow .15s ease; }} .resource:before {{ content:""; position:absolute; inset:0 auto 0 0; width:4px; background:var(--accent); }} .resource:hover {{ transform:translateY(-2px); box-shadow:0 12px 28px rgba(23,37,54,.1); }} .resource strong {{ display:block; margin-bottom:5px; color:var(--ink); font-size:27px; font-weight:700; }} .muted {{ color:var(--muted); }}
.table-wrap {{ overflow:auto; border:1px solid var(--line); border-radius:10px; background:#fff; }} table {{ width:100%; border-collapse:collapse; min-width:680px; }} th,td {{ border-bottom:1px solid var(--line); padding:13px 15px; text-align:left; vertical-align:top; }} th {{ background:#f7f9fb; color:#718092; font-size:11px; font-weight:700; letter-spacing:.06em; text-transform:uppercase; }} tr:last-child td {{ border-bottom:0; }} tr:hover td {{ background:#fcfdfd; }} td {{ max-width:280px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }}
.actions {{ display:flex; gap:8px; align-items:center; }} button,.button {{ display:inline-flex; align-items:center; justify-content:center; border:0; background:var(--accent); color:white; padding:10px 15px; cursor:pointer; text-decoration:none; border-radius:6px; font:600 13px inherit; box-shadow:0 4px 10px rgba(231,101,79,.18); }} button:hover,.button:hover {{ background:var(--accent-dark); }} .quiet {{ background:#e8edf2; color:#46586a; box-shadow:none; }} .quiet:hover {{ background:#dce4eb; }}
form.fields {{ display:grid; grid-template-columns:repeat(auto-fit,minmax(260px,1fr)); gap:19px; }} label {{ display:grid; gap:7px; color:#66778a; font-size:12px; font-weight:600; }} input,textarea,select {{ width:100%; border:1px solid #ccd6df; border-radius:6px; background:#fbfcfd; padding:10px 11px; color:var(--ink); font:14px inherit; outline:0; }} input:focus,textarea:focus,select:focus {{ border-color:var(--accent); box-shadow:0 0 0 3px rgba(231,101,79,.12); }} textarea {{ min-height:110px; resize:vertical; }} select[multiple] {{ min-height:140px; }} .wide {{ grid-column:1/-1; }}
.login {{ max-width:430px; margin:12vh auto; }} .login h2 {{ margin-bottom:8px; }} .login form {{ display:grid; gap:16px; }} .error {{ color:#a42418; background:#fff0ed; border:1px solid #f2c5bc; border-radius:6px; padding:10px 12px; margin:0 0 12px; }}
@media(max-width:760px) {{ .shell {{ display:block; }} aside {{ padding:16px 12px; }} .brand {{ padding-bottom:18px; }} nav {{ display:flex; gap:15px; overflow:auto; }} .nav-group {{ min-width:max-content; }} .nav-label {{ padding-left:7px; }} nav a {{ white-space:nowrap; padding:7px; }} main {{ padding:0 15px 35px; }} .topbar {{ min-height:52px; }} header {{ align-items:flex-start; flex-direction:column; margin-top:30px; }} h2 {{ font-size:27px; }} .panel {{ padding:17px; }} }}
</style></head><body><div class="shell"><aside><div class="brand"><span class="brand-mark">M</span><span class="brand-copy"><h1>MAF Portal</h1><small>Admin workspace</small></span></div><nav>{nav_groups}</nav></aside><main><div class="topbar"><strong>Operations console</strong><span class="status"><span class="status-dot"></span>Local environment</span></div>{content}</main></div><script src="https://cdn.jsdelivr.net/npm/glightbox@3.3.1/dist/js/glightbox.min.js"></script><script>const lightbox=GLightbox({{selector:'.glightbox',touchNavigation:true,loop:false,closeButton:true}});document.addEventListener('click',event=>{{const trigger=event.target.closest('.glightbox');if(!trigger)return;window.setTimeout(()=>{{const media=document.querySelector('.gslide.current .gslide-media');if(media&&!media.querySelector('img')){{const image=document.createElement('img');image.src=trigger.href;image.alt=trigger.querySelector('img')?.alt||'';media.replaceChildren(image);}}}},500);}},true);</script></body></html>"""


def _login_page(error: str = "") -> HTMLResponse:
    message = f'<p class="error">{_escape(error)}</p>' if error else ""
    content = f"""<section class="panel login"><h2>Admin sign in</h2>{message}
<form method="post" action="/admin/login"><label>Username<input name="username" autocomplete="username" required></label>
<label>Password<input name="password" type="password" autocomplete="current-password" required></label>
<button type="submit">Sign in</button></form><p class="muted">Local access is configured for the temporary admin account.</p></section>"""
    return HTMLResponse(_layout("Sign in", content))


@router.get("", response_class=HTMLResponse, response_model=None)
async def admin_login() -> HTMLResponse | RedirectResponse:
    return RedirectResponse("/admin/", status_code=303)


@router.post("/login", response_class=HTMLResponse, response_model=None)
async def admin_sign_in(request: Request) -> HTMLResponse | RedirectResponse:
    form = await request.form()
    if hmac.compare_digest(str(form.get("username", "")), settings.admin_username) and hmac.compare_digest(
        str(form.get("password", "")), settings.admin_password
    ):
        response = RedirectResponse("/admin/", status_code=303)
        response.set_cookie("mafportal_admin", _session_token(), httponly=True, samesite="lax")
        return response
    return _login_page("Invalid username or password")


@router.post("/logout")
async def admin_logout() -> RedirectResponse:
    response = RedirectResponse("/admin", status_code=303)
    response.delete_cookie("mafportal_admin")
    return response


@router.get("/", response_class=HTMLResponse, response_model=None)
async def admin_dashboard(request: Request) -> HTMLResponse | RedirectResponse:
    if not _authenticated(request):
        return _login_page()
    cards = []
    with SessionLocal() as db:
        for slug, label in RESOURCES.items():
            resource = _resource(slug)
            if resource is None:
                continue
            table_name, _ = resource
            count = db.execute(text(f'SELECT COUNT(*) FROM "{table_name}"')).scalar_one()
            cards.append(f'<a class="panel resource" href="/admin/{_escape(slug)}"><strong>{count}</strong>{_escape(label)}</a>')
    content = '<header><h2>Admin dashboard</h2><form method="post" action="/admin/logout"><button class="quiet">Sign out</button></form></header>'
    content += '<p class="muted">Legacy resources are grouped below. Select a resource to manage its records.</p><div class="grid">' + "".join(cards) + "</div>"
    return HTMLResponse(_layout("Dashboard", content))


@router.get("/confirm_user_to_club/{club_id}/{user_id}")
async def confirm_user_to_club(request: Request, club_id: int, user_id: int) -> RedirectResponse:
    if not _authenticated(request):
        return _redirect_login()
    with SessionLocal() as db:
        db.execute(
            text("UPDATE club_user SET confirm = 1 WHERE club_id = :club_id AND user_id = :user_id"),
            {"club_id": club_id, "user_id": user_id},
        )
        db.commit()
    return RedirectResponse("/admin/club", status_code=303)


@router.get("/cancel_user_to_club/{club_id}/{user_id}")
async def cancel_user_to_club(request: Request, club_id: int, user_id: int) -> RedirectResponse:
    if not _authenticated(request):
        return _redirect_login()
    with SessionLocal() as db:
        db.execute(
            text("DELETE FROM club_user WHERE club_id = :club_id AND user_id = :user_id"),
            {"club_id": club_id, "user_id": user_id},
        )
        db.commit()
    return RedirectResponse("/admin/club", status_code=303)


def _value_for_form(value: Any) -> str:
    if isinstance(value, (datetime, date)):
        return value.isoformat(sep=" ") if isinstance(value, datetime) else value.isoformat()
    return "" if value is None else str(value)


def _image_url(value: Any) -> str | None:
    return media_storage.url(value)


def _image_preview(value: Any, label: str = "Preview") -> str:
    image_url = _image_url(value)
    if not image_url:
        return '<span class="muted">No image selected</span>'
    return f'<a class="image-preview glightbox" href="{_escape(image_url)}" data-type="image"><img src="{_escape(image_url)}" alt="{_escape(label)}"><span>Preview image</span></a>'


def _gallery_images(value: Any) -> list[str]:
    if isinstance(value, str):
        try:
            value = json.loads(value)
        except (TypeError, json.JSONDecodeError):
            return []
    if not isinstance(value, list):
        return []
    return [image for image in (_image_url(item) for item in value) if image]


def _gallery_preview(value: Any, page: int = 1, per_page: int = 12) -> str:
    images = _gallery_images(value)
    if not images:
        return '<p class="muted">No gallery images uploaded yet.</p>'
    page_count = max(1, (len(images) + per_page - 1) // per_page)
    page = max(1, min(page, page_count))
    start = (page - 1) * per_page
    tiles = ''.join(
        f'<a class="gallery-tile glightbox" href="{_escape(image)}" data-gallery="admin-gallery" data-type="image"><img src="{_escape(image)}" alt="Gallery image {start + index + 1}"><span>{start + index + 1}</span></a>'
        for index, image in enumerate(images[start:start + per_page])
    )
    links = []
    for number in range(1, page_count + 1):
        current = ' current' if number == page else ''
        links.append(f'<a class="page-link{current}" href="?photo_page={number}">{number}</a>')
    return f'<div class="gallery-meta"><strong>{len(images)} images</strong><span class="muted">Page {page} of {page_count}</span></div><div class="gallery-grid">{tiles}</div><div class="pagination">{"".join(links)}</div>'


def _input(column: dict[str, Any], value: Any = None, slug: str = "", gallery_page: int = 1) -> str:
    name = column["name"]
    label = name.replace("_", " ").title()
    if name in IMAGE_FIELDS and slug in IMAGE_RESOURCES:
        multiple = " multiple" if name == "photos" else ""
        preview = _gallery_preview(value, gallery_page) if name == "photos" else _image_preview(value, label)
        return f'<label class="wide">{_escape(label)}<input type="file" name="{_escape(name)}" accept="image/*"{multiple}><span class="muted">Choose a new image to replace the current one.</span>{preview}</label>'
    relations = {
        "country_id": ("countries", "title"),
        "club_id": ("clubs", "title"),
        "tournament_id": ("tournaments", "title"),
        "table_ratings_id": ("table_ratings", "title"),
        "category": ("categories", "name"),
    }
    if name in relations:
        table_name, display_column = relations[name]
        with SessionLocal() as db:
            options = db.execute(text(f'SELECT id, "{display_column}" FROM "{table_name}" ORDER BY "{display_column}"')).all()
        choices = ['<option value="">None</option>'] + [
            f'<option value="{item[0]}"{" selected" if str(item[0]) == str(value) else ""}>{_escape(item[1])}</option>'
            for item in options
        ]
        return f'<label>{_escape(label)}<select name="{_escape(name)}">{"".join(choices)}</select></label>'
    kind = "number" if "INT" in str(column["type"]).upper() or "REAL" in str(column["type"]).upper() else "text"
    if "TEXT" in str(column["type"]).upper() or name in {"content", "description", "text", "extras", "cart", "payment_data", "results", "photos", "extra_field"}:
        return f'<label class="wide">{_escape(label)}<textarea name="{_escape(name)}">{_escape(_value_for_form(value))}</textarea></label>'
    return f'<label>{_escape(label)}<input type="{kind}" name="{_escape(name)}" value="{_escape(_value_for_form(value))}"></label>'


def _upload_key(slug: str, field_name: str, filename: str) -> str:
    directory = IMAGE_FIELDS[field_name].format(slug=IMAGE_RESOURCES[slug])
    return f"images/uploads/{directory}/{secrets.token_hex(16)}.jpg"


def _delete_media_value(value: Any) -> None:
    if not value:
        return
    media_storage.delete(str(value))


async def _store_upload(slug: str, field_name: str, value: Any, old_value: Any = None) -> str | None:
    if not isinstance(value, UploadFile) or not value.filename:
        return None
    if value.content_type and not value.content_type.startswith("image/"):
        raise ValueError(f"{field_name} must be an image")
    key = _upload_key(slug, field_name, value.filename)
    data = await value.read()
    try:
        from PIL import Image
        from io import BytesIO
        image = Image.open(BytesIO(data))
        image.thumbnail((1920, 1920))
        output = BytesIO()
        image.convert("RGB").save(output, "JPEG", quality=90)
        media_storage.put(key, output, "image/jpeg")
    except Exception as exc:
        media_storage.delete(key)
        raise ValueError(f"Invalid image for {field_name}") from exc
    if old_value:
        _delete_media_value(old_value)
    return key


def _form_value(form: Any, name: str) -> str:
    value = form.get(name, "")
    return "" if isinstance(value, UploadFile) else str(value)


def _relationship_fields(slug: str, current: Any = None) -> str:
    definitions = {
        "user": (("clubs", "clubs", "title"), ("roles", "roles", "name"), ("permissions", "permissions", "name")),
        "club": (("users_admin", "users", "name"),),
        "event": (("clubs", "clubs", "title"),),
        "role": (("permissions", "permissions", "name"),),
        "permission": (("roles", "roles", "name"),),
    }
    if slug not in definitions:
        return ""
    values = current or {}
    blocks = []
    with SessionLocal() as db:
        for field_name, table_name, display_column in definitions[slug]:
            options = db.execute(text(f'SELECT id, "{display_column}" FROM "{table_name}" ORDER BY "{display_column}"')).all()
            selected = set(values.get(field_name, [])) if isinstance(values, dict) else set()
            choices = "".join(
                f'<option value="{item[0]}"{" selected" if str(item[0]) in {str(value) for value in selected} else ""}>{_escape(item[1])}</option>'
                for item in options
            )
            label = field_name.replace("_", " ").title()
            blocks.append(f'<label class="wide">{_escape(label)}<select name="{_escape(field_name)}" multiple size="6">{choices}</select></label>')
    return "".join(blocks)


def _page_extra_fields(current: Any = None) -> str:
    values = current or {}
    blocks = []
    for name in PAGE_EXTRA_FIELDS:
        label = name.replace("_", " ").title()
        value = values.get(name, "")
        if name in {"content_rus", "phones"}:
            blocks.append(f'<label class="wide">{_escape(label)}<textarea name="{_escape(name)}">{_escape(value)}</textarea></label>')
        else:
            blocks.append(f'<label>{_escape(label)}<input name="{_escape(name)}" value="{_escape(value)}"></label>')
    return "".join(blocks)


def _page_extras(current: Any) -> dict[str, Any]:
    if not current:
        return {}
    try:
        value = json.loads(current)
    except (TypeError, json.JSONDecodeError):
        return {}
    return value if isinstance(value, dict) else {}


def _sync_relationships(db: Any, slug: str, item_id: int, form: Any) -> None:
    pivot_definitions = {
        "user": (("clubs", "club_user", "user_id", "club_id"), ("roles", "role_users", "user_id", "role_id"), ("permissions", "permission_users", "user_id", "permission_id")),
        "club": (("users_admin", "club_user", "club_id", "user_id"),),
        "event": (("clubs", "club_event", "event_id", "club_id"),),
        "role": (("permissions", "permission_roles", "role_id", "permission_id"),),
        "permission": (("roles", "permission_roles", "permission_id", "role_id"),),
    }
    for field_name, pivot, owner_column, related_column in pivot_definitions.get(slug, ()):
        selected = {int(value) for value in form.getlist(field_name) if str(value).isdigit()}
        db.execute(text(f'DELETE FROM "{pivot}" WHERE "{owner_column}" = :owner'), {"owner": item_id})
        for related_id in selected:
            if pivot == "club_user":
                db.execute(text(f'INSERT OR IGNORE INTO "{pivot}" ("{owner_column}", "{related_column}", admin, confirm, active) VALUES (:owner, :related, 0, 0, 1)'), {"owner": item_id, "related": related_id})
                if slug == "club":
                    db.execute(text('UPDATE club_user SET admin = 1 WHERE club_id = :owner AND user_id = :related'), {"owner": item_id, "related": related_id})
            else:
                db.execute(text(f'INSERT INTO "{pivot}" ("{owner_column}", "{related_column}") VALUES (:owner, :related)'), {"owner": item_id, "related": related_id})


def _relationship_values(slug: str, item_id: int) -> dict[str, list[int]]:
    definitions = {
        "user": (("clubs", "club_user", "user_id", "club_id"), ("roles", "role_users", "user_id", "role_id"), ("permissions", "permission_users", "user_id", "permission_id")),
        "club": (("users_admin", "club_user", "club_id", "user_id"),),
        "event": (("clubs", "club_event", "event_id", "club_id"),),
        "role": (("permissions", "permission_roles", "role_id", "permission_id"),),
        "permission": (("roles", "permission_roles", "permission_id", "role_id"),),
    }
    result: dict[str, list[int]] = {}
    with SessionLocal() as db:
        for field_name, pivot, owner_column, related_column in definitions.get(slug, ()):
            result[field_name] = list(db.execute(text(f'SELECT "{related_column}" FROM "{pivot}" WHERE "{owner_column}" = :owner'), {"owner": item_id}).scalars())
    return result


def _coerce(value: str, column: dict[str, Any]) -> Any:
    if value == "":
        return None
    type_name = str(column["type"]).upper()
    if "INT" in type_name:
        return int(value)
    if any(kind in type_name for kind in ("REAL", "FLOAT", "DOUBLE", "DECIMAL")):
        return float(value)
    if "DATE" in type_name or "TIME" in type_name:
        try:
            return datetime.fromisoformat(value)
        except ValueError:
            return value
    return value


@router.get("/{slug}", response_class=HTMLResponse, response_model=None)
async def admin_resource(request: Request, slug: str) -> HTMLResponse | RedirectResponse:
    if not _authenticated(request):
        return _redirect_login()
    resource = _resource(slug)
    if resource is None:
        return HTMLResponse("Resource not found", status_code=404)
    table_name, label = resource
    columns = _table_info(table_name)
    visible = [column for column in columns if column["name"] != "deleted_at"]
    try:
        page = max(1, int(request.query_params.get("page", "1")))
    except ValueError:
        page = 1
    per_page = 25
    with SessionLocal() as db:
        total = db.execute(text(f'SELECT COUNT(*) FROM "{table_name}"')).scalar_one()
        page_count = max(1, (total + per_page - 1) // per_page)
        page = min(page, page_count)
        rows = db.execute(text(f'SELECT * FROM "{table_name}" ORDER BY id DESC LIMIT :limit OFFSET :offset'), {"limit": per_page, "offset": (page - 1) * per_page}).mappings().all()
    headers = "".join(f"<th>{_escape(column['name'])}</th>" for column in visible)
    body = []
    for row in rows:
        cells = "".join(
            f'<td title="{_escape(row[column["name"]])}">{_image_preview(row[column["name"]], column["name"]) if column["name"] in IMAGE_FIELDS else _escape(row[column["name"]])}</td>'
            for column in visible
        )
        item_id = row.get("id")
        delete_action = "" if slug == "user" else f'<form method="post" action="/admin/{_escape(slug)}/{item_id}/delete"><button type="submit">Delete</button></form>'
        actions = f'<td class="actions"><a class="button quiet" href="/admin/{_escape(slug)}/{item_id}/edit">Edit</a>{delete_action}</td>' if item_id is not None else ""
        body.append(f"<tr>{cells}{actions}</tr>")
    pagination = "" if page_count == 1 else '<div class="pagination">' + "".join(f'<a class="page-link{" current" if number == page else ""}" href="?page={number}">{number}</a>' for number in range(1, page_count + 1)) + "</div>"
    content = f'<header><h2>{_escape(label)}</h2><a class="button" href="/admin/{_escape(slug)}/create">Add record</a></header><p class="muted">Showing {((page - 1) * per_page) + 1 if total else 0}-{min(page * per_page, total)} of {total} records</p><div class="table-wrap"><table><thead><tr>{headers}<th>Actions</th></tr></thead><tbody>{"".join(body) or "<tr><td colspan=99 class=muted>No records found.</td></tr>"}</tbody></table></div>{pagination}'
    return HTMLResponse(_layout(label, content))


async def _save(request: Request, slug: str, item_id: int | None = None) -> RedirectResponse | HTMLResponse:
    resource = _resource(slug)
    if resource is None:
        return HTMLResponse("Resource not found", status_code=404)
    table_name, label = resource
    columns = [column for column in _table_info(table_name) if column["name"] not in {"id", "created_at", "updated_at", "deleted_at"}]
    form = await request.form()
    table = Table(table_name, MetaData(), autoload_with=engine)
    with SessionLocal() as db:
        current = db.execute(select(table).where(table.c.id == item_id)).mappings().first() if item_id else None
        missing = [name for name in REQUIRED_FIELDS.get(slug, ()) if not _form_value(form, name)]
        if missing:
            return HTMLResponse(_layout("Validation error", f'<section class="panel"><p class="error">Required fields: {_escape(", ".join(missing))}</p><a class="button" href="/admin/{_escape(slug)}">Back</a></section>'), status_code=422)
        unique_name = UNIQUE_FIELDS.get(slug)
        if unique_name and _form_value(form, unique_name) and unique_name in table.c:
            duplicate = db.execute(select(table.c.id).where(table.c[unique_name] == _form_value(form, unique_name), table.c.id != (item_id or -1))).first()
            if duplicate:
                return HTMLResponse(_layout("Validation error", f'<section class="panel"><p class="error">{_escape(unique_name)} must be unique.</p><a class="button" href="/admin/{_escape(slug)}">Back</a></section>'), status_code=422)
    values = {}
    for column in columns:
        name = column["name"]
        try:
            uploaded = await _store_upload(slug, name, form.get(name), current.get(name) if current else None) if name in IMAGE_FIELDS and name != "photos" else None
        except ValueError as exc:
            return HTMLResponse(_layout("Validation error", f'<section class="panel"><p class="error">{_escape(exc)}</p><a class="button" href="/admin/{_escape(slug)}">Back</a></section>'), status_code=422)
        if uploaded:
            values[name] = uploaded
        elif name not in IMAGE_FIELDS or _form_value(form, name):
            values[name] = _coerce(_form_value(form, name), column)
    if slug == "page":
        extras = _page_extras(current.get("extras") if current else None)
        for name in PAGE_EXTRA_FIELDS:
            if _form_value(form, name):
                extras[name] = _form_value(form, name)
        values["extras"] = json.dumps(extras, ensure_ascii=False)
    if slug == "photo_gallery":
        try:
            existing_photos = json.loads(current.get("photos")) if current and current.get("photos") else []
        except (TypeError, json.JSONDecodeError):
            existing_photos = []
        if not isinstance(existing_photos, list):
            existing_photos = []
        uploaded_photos = []
        for upload in form.getlist("photos"):
            stored = await _store_upload(slug, "photos", upload)
            if stored:
                uploaded_photos.append(stored)
        if uploaded_photos:
            existing_photos.extend(uploaded_photos)
        if existing_photos:
            values["photos"] = json.dumps(existing_photos, ensure_ascii=False)
    if slug == "user" and _form_value(form, "password"):
        password = bcrypt.hashpw(_form_value(form, "password").encode(), bcrypt.gensalt()).decode()
        values["password"] = password
    with SessionLocal() as db:
        if item_id is not None:
            for column in columns:
                name = column["name"]
                if name in IMAGE_FIELDS and name not in values and current:
                    values[name] = current[name]
            if slug == "user" and "password" not in values and current:
                values["password"] = current["password"]
        if slug == "user" and item_id is None and "password" not in values:
            values["password"] = bcrypt.hashpw(b"", bcrypt.gensalt()).decode()
        if item_id is None:
            result = db.execute(table.insert().values(**values))
            saved_id = result.inserted_primary_key[0]
        else:
            db.execute(table.update().where(table.c.id == item_id).values(**values))
            saved_id = item_id
        _sync_relationships(db, slug, int(saved_id), form)
        db.commit()
    return RedirectResponse(f"/admin/{slug}", status_code=303)


@router.get("/{slug}/create", response_class=HTMLResponse, response_model=None)
async def admin_create_form(request: Request, slug: str) -> HTMLResponse | RedirectResponse:
    if not _authenticated(request):
        return _redirect_login()
    resource = _resource(slug)
    if resource is None:
        return HTMLResponse("Resource not found", status_code=404)
    fields = [column for column in _table_info(resource[0]) if column["name"] not in {"id", "created_at", "updated_at", "deleted_at"}]
    password = '<label>Password<input type="password" name="password" autocomplete="new-password"></label>' if slug == "user" else ""
    content = f'<header><h2>Add { _escape(resource[1]) }</h2><a class="button quiet" href="/admin/{_escape(slug)}">Back</a></header><section class="panel"><form class="fields" enctype="multipart/form-data" method="post" action="/admin/{_escape(slug)}/create">{"".join(_input(column, slug=slug) for column in fields)}{_page_extra_fields() if slug == "page" else ""}{_relationship_fields(slug)}{password}<div class="wide"><button type="submit">Create record</button></div></form></section>'
    return HTMLResponse(_layout("Add record", content))


@router.post("/{slug}/create", response_model=None)
async def admin_create(request: Request, slug: str) -> RedirectResponse | HTMLResponse:
    if not _authenticated(request):
        return _redirect_login()
    return await _save(request, slug)


@router.get("/{slug}/{item_id}/edit", response_class=HTMLResponse, response_model=None)
async def admin_edit_form(request: Request, slug: str, item_id: int) -> HTMLResponse | RedirectResponse:
    if not _authenticated(request):
        return _redirect_login()
    resource = _resource(slug)
    if resource is None:
        return HTMLResponse("Resource not found", status_code=404)
    table_name, label = resource
    table = Table(table_name, MetaData(), autoload_with=engine)
    with SessionLocal() as db:
        row = db.execute(select(table).where(table.c.id == item_id)).mappings().first()
    if row is None:
        return HTMLResponse("Record not found", status_code=404)
    fields = [column for column in _table_info(table_name) if column["name"] not in {"id", "created_at", "updated_at", "deleted_at"}]
    try:
        gallery_page = max(1, int(request.query_params.get("photo_page", "1")))
    except ValueError:
        gallery_page = 1
    password = '<label>Password<input type="password" name="password" autocomplete="new-password"><span class="muted">Leave blank to keep the current password.</span></label>' if slug == "user" else ""
    relationship_values = _relationship_values(slug, item_id)
    content = f'<header><h2>Edit { _escape(label) }</h2><a class="button quiet" href="/admin/{_escape(slug)}">Back</a></header><section class="panel"><form class="fields" enctype="multipart/form-data" method="post" action="/admin/{_escape(slug)}/{item_id}/edit">{"".join(_input(column, row[column["name"]], slug=slug, gallery_page=gallery_page) for column in fields)}{_page_extra_fields(_page_extras(row.get("extras"))) if slug == "page" else ""}{_relationship_fields(slug, relationship_values)}{password}<div class="wide"><button type="submit">Save changes</button></div></form></section>'
    return HTMLResponse(_layout("Edit record", content))


@router.post("/{slug}/{item_id}/edit", response_model=None)
async def admin_edit(request: Request, slug: str, item_id: int) -> RedirectResponse | HTMLResponse:
    if not _authenticated(request):
        return _redirect_login()
    return await _save(request, slug, item_id)


@router.post("/{slug}/{item_id}/delete", response_model=None)
async def admin_delete(request: Request, slug: str, item_id: int) -> RedirectResponse | HTMLResponse:
    if not _authenticated(request):
        return _redirect_login()
    resource = _resource(slug)
    if resource is None:
        return HTMLResponse("Resource not found", status_code=404)
    table = Table(resource[0], MetaData(), autoload_with=engine)
    with SessionLocal() as db:
        current = db.execute(select(table).where(table.c.id == item_id)).mappings().first()
        db.execute(table.delete().where(table.c.id == item_id))
        db.commit()
    if current:
        for field_name in IMAGE_FIELDS:
            if field_name in current and current[field_name]:
                _delete_media_value(current[field_name])
    return RedirectResponse(f"/admin/{slug}", status_code=303)