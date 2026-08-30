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


@pytest.mark.parametrize(
    ("role", "sentence", "rule", "role_key", "win_key", "points"),
    [
        (2, 1, RatingRule(win_sheriff=2.5), "Sheriff", "Sheriff_Win", 2.5),
        (3, 2, RatingRule(win_mafia=3), "Mafia", "WB", 3),
        (4, 2, RatingRule(win_don=4), "Don", "Don_Win", 4),
        (1, 2, RatingRule(fail_citizen=-1), "Citizen", "Fail", -1),
        (2, 2, RatingRule(fail_sheriff=-2), "Sheriff", "Fail", -2),
        (4, 1, RatingRule(fail_don=-4), "Don", "Fail", -4),
    ],
)
def test_role_outcomes_use_their_configured_points(
    role: int,
    sentence: int,
    rule: RatingRule,
    role_key: str,
    win_key: str,
    points: float,
) -> None:
    game = GameResult(game_id=20, sentence=sentence, players=(GamePlayer(player=1, role=role),))

    result = score_player(game, game.players[0], rule)

    assert result[role_key] == 1
    assert result[win_key] == 1
    assert result["Balls"] == pytest.approx(points)


def test_prima_nota_three_and_second_best_move_are_counted() -> None:
    game = GameResult(
        game_id=21,
        sentence=1,
        players=(GamePlayer(player=2, role=1),),
        best_move2=2,
        prima_nota=2,
        select_prima=3,
    )
    rule = RatingRule(best_step=0.5, prima_nota3=1.25)

    result = score_player(game, game.players[0], rule)

    assert result["BM"] == 1
    assert result["Balls"] == pytest.approx(1.75)


def test_player_without_role_has_zero_games_and_score() -> None:
    game = GameResult(game_id=22, sentence=1, players=(GamePlayer(player=3, role=0),))

    result = score_player(game, game.players[0], RatingRule(best_player=10))

    assert result["Game"] == 0
    assert result["Win"] == 0
    assert result["Fail"] == 0
    assert result["Score"] == 0
