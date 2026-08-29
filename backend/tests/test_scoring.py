import pytest

from app.ratings.scoring import GamePlayer, GameResult, RatingRule, score_player


def test_citizen_win_uses_role_points_and_statistics() -> None:
    game = GameResult(
        game_id=10,
        sentence=1,
        players=(GamePlayer(player=7, role=1),),
        best_player=7,
        best_move=7,
    )
    rule = RatingRule(win_citizen=2, best_player=1, best_step=0.5)

    result = score_player(game, game.players[0], rule)

    assert result["Game"] == 1
    assert result["Win"] == 1
    assert result["WR"] == 1
    assert result["Citizen"] == 1
    assert result["BP"] == 1
    assert result["BM"] == 1
    assert result["Balls"] == pytest.approx(3.5)
    assert result["Score"] == pytest.approx(3.5)


def test_mafia_loss_uses_fail_points_and_awards() -> None:
    game = GameResult(
        game_id=11,
        sentence=1,
        players=(GamePlayer(player=8, role=3),),
        cool_citizen=8,
        prima_nota=8,
        select_prima=2,
    )
    rule = RatingRule(fail_mafia=-1, citizen_killed=0.25, prima_nota2=0.75)

    result = score_player(game, game.players[0], rule)

    assert result["Win"] == 0
    assert result["Fail"] == 1
    assert result["Mafia"] == 1
    assert result["Balls"] == pytest.approx(0)


def test_custom_formula_is_evaluated_without_python_execution() -> None:
    game = GameResult(
        game_id=12,
        sentence=2,
        players=(GamePlayer(player=9, role=4),),
    )
    rule = RatingRule(win_don=4, formula="#4# * 2")

    result = score_player(game, game.players[0], rule)

    assert result["Balls"] == pytest.approx(8)


def test_unsupported_formula_is_rejected() -> None:
    game = GameResult(game_id=13, sentence=1, players=(GamePlayer(player=9, role=1),))

    with pytest.raises(ValueError):
        score_player(game, game.players[0], RatingRule(formula="__import__('os')"))
