import json
from collections import defaultdict

from sqlalchemy import select
from sqlalchemy.orm import Session

from app.models.domain import GameRating, TableRating, Tournament
from app.ratings.scoring import GamePlayer, GameResult, RatingRule, score_player


def _number(value: str | int | None) -> int | None:
    try:
        return int(value) if value is not None else None
    except (TypeError, ValueError):
        return None


def _rating_rule(rule: TableRating) -> RatingRule:
    return RatingRule(
        best_player=rule.best_player or 0,
        best_step=rule.best_step or 0,
        win_citizen=rule.win_citizen or 0,
        win_sheriff=rule.win_sheriff or 0,
        win_mafia=rule.win_mafia or 0,
        win_don=rule.win_don or 0,
        fail_citizen=rule.fail_citizen or 0,
        fail_sheriff=rule.fail_sheriff or 0,
        fail_mafia=rule.fail_mafia or 0,
        fail_don=rule.fail_don or 0,
        citizen_killed=rule.citizen_killed or 0,
        prima_nota3=rule.prima_nota3 or 0,
        formula=rule.formula,
    )


def calculate_game_scores(db: Session, tournament_id: int) -> dict[int, dict[int, dict[str, int | float]]]:
    tournament = db.get(Tournament, tournament_id)
    rule = db.get(TableRating, tournament.table_ratings_id) if tournament and tournament.table_ratings_id else None
    if rule is None:
        return {}

    rating_rule = _rating_rule(rule)
    scores: dict[int, dict[int, dict[str, int | float]]] = {}
    games = db.scalars(select(GameRating).where(GameRating.tournament_id == tournament_id)).all()
    for game in games:
        if not game.results or not game.sentence:
            continue
        try:
            raw_players = json.loads(game.results)
            players = tuple(
                GamePlayer(player=int(item["player"]), role=int(item["role"]))
                for item in raw_players
                if item.get("player") and int(item["player"]) != 239
            )
        except (TypeError, ValueError, KeyError, json.JSONDecodeError):
            continue
        game_result = GameResult(
            game_id=game.id,
            sentence=game.sentence,
            players=players,
            best_move=_number(game.best_move),
            best_move2=_number(game.best_move2),
            best_player=_number(game.best_player),
            cool_citizen=_number(game.cool_citizen),
            prima_nota=_number(game.prima_nota),
            select_prima=game.select_prima,
        )
        raw_by_player = {int(item["player"]): item for item in raw_players if item.get("player")}
        scores[game.id] = {}
        for player in players:
            result = score_player(game_result, player, rating_rule)
            scores[game.id][player.player] = {
                "result": "Win" if result["Win"] else "Fail",
                "points": result["Balls"],
                "add_points": raw_by_player[player.player].get("penalty") or 0,
            }
    return scores


def calculate_tournament_rating(db: Session, tournament_id: int) -> list[dict[str, int | float]] | None:
    tournament = db.get(Tournament, tournament_id)
    if tournament is None:
        return None

    rule = db.get(TableRating, tournament.table_ratings_id) if tournament.table_ratings_id else None
    if rule is None:
        return []

    rating_rule = _rating_rule(rule)
    totals: dict[int, dict[str, int | float]] = defaultdict(lambda: {"player_id": 0, "Game": 0, "Win": 0, "WR": 0, "WB": 0, "Fail": 0, "Citizen": 0, "Mafia": 0, "Sheriff": 0, "Sheriff_Win": 0, "Don": 0, "Don_Win": 0, "BM": 0, "BP": 0, "Balls": 0.0, "Score": 0.0})

    games = db.scalars(select(GameRating).where(GameRating.tournament_id == tournament_id)).all()
    for game in games:
        if not game.results or not game.sentence:
            continue
        try:
            players = tuple(
                GamePlayer(player=int(item["player"]), role=int(item["role"]))
                for item in json.loads(game.results)
                if item.get("player") and int(item["player"]) != 239
            )
        except (TypeError, ValueError, KeyError, json.JSONDecodeError):
            continue
        game_result = GameResult(
            game_id=game.id,
            sentence=game.sentence,
            players=players,
            best_move=_number(game.best_move),
            best_move2=_number(game.best_move2),
            best_player=_number(game.best_player),
            cool_citizen=_number(game.cool_citizen),
            prima_nota=_number(game.prima_nota),
            select_prima=game.select_prima,
        )
        for player in players:
            result = score_player(game_result, player, rating_rule)
            total = totals[player.player]
            total["player_id"] = player.player
            for key, value in result.items():
                total[key] = (total[key] or 0) + value

    for total in totals.values():
        total["Score"] = (total["Balls"] or 0) / (total["Game"] or 1)
    return sorted(totals.values(), key=lambda item: (-(item["Balls"] or 0), item["player_id"]))
