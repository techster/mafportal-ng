from fastapi import APIRouter, Depends
from sqlalchemy import select
from sqlalchemy.orm import Session

from app.db import get_db
from app.models.domain import Country
from app.schemas import CountryRead


router = APIRouter(prefix="/countries", tags=["countries"])


@router.get("", response_model=list[CountryRead])
def list_countries(db: Session = Depends(get_db)) -> list[Country]:
    return list(db.scalars(select(Country).order_by(Country.title)).all())
