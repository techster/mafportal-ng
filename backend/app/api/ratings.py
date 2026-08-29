from fastapi import APIRouter, Depends, HTTPException
from sqlalchemy.orm import Session

from app.db import get_db
from app.ratings.service import calculate_tournament_rating


router = APIRouter(prefix="/ratings", tags=["ratings"])


@router.get("/tournaments/{tournament_id}")
def tournament_rating(tournament_id: int, db: Session = Depends(get_db)) -> list[dict[str, int | float]]:
    result = calculate_tournament_rating(db, tournament_id)
    if result is None:
        raise HTTPException(status_code=404, detail="Tournament not found")
    return result
