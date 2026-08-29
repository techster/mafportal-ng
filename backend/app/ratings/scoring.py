from dataclasses import dataclass, field
import ast
import operator
import re
from typing import Any


@dataclass(frozen=True)
class RatingRule:
    best_player: float = 0
    best_step: float = 0
    win_citizen: float = 0
    win_sheriff: float = 0
    win_mafia: float = 0
    win_don: float = 0
    fail_citizen: float = 0
    fail_sheriff: float = 0
    fail_mafia: float = 0
    fail_don: float = 0
    citizen_killed: float = 0
    prima_nota3: float = 0
    prima_nota2: float = 0
    formula: str | None = None


@dataclass(frozen=True)
class GamePlayer:
    player: int
    role: int


@dataclass(frozen=True)
class GameResult:
    game_id: int
    sentence: int
    players: tuple[GamePlayer, ...]
    best_move: int | None = None
    best_move2: int | None = None
    best_player: int | None = None
    cool_citizen: int | None = None
    prima_nota: int | None = None
    select_prima: int | None = None
    extra_fields: dict[str, Any] = field(default_factory=dict)


DEFAULT_FORMULA = " + ".join(f"#{index}#" for index in range(1, 14))
_TOKEN_PATTERN = re.compile(r"#(?:[1-9]|1[0-3])#")
_ALLOWED_OPERATORS = {
    ast.Add: operator.add,
    ast.Sub: operator.sub,
    ast.Mult: operator.mul,
    ast.Div: operator.truediv,
    ast.Pow: operator.pow,
}


def _evaluate_formula(formula: str, values: dict[str, float]) -> float:
    expression = _TOKEN_PATTERN.sub(lambda match: str(values[match.group(0)]), formula)
    tree = ast.parse(expression, mode="eval")

    def evaluate(node: ast.AST) -> float:
        if isinstance(node, ast.Expression):
            return evaluate(node.body)
        if isinstance(node, ast.Constant) and isinstance(node.value, (int, float)):
            return float(node.value)
        if isinstance(node, ast.UnaryOp) and isinstance(node.op, (ast.UAdd, ast.USub)):
            value = evaluate(node.operand)
            return value if isinstance(node.op, ast.UAdd) else -value
        if isinstance(node, ast.BinOp) and type(node.op) in _ALLOWED_OPERATORS:
            return _ALLOWED_OPERATORS[type(node.op)](evaluate(node.left), evaluate(node.right))
        raise ValueError("Formula contains an unsupported expression")

    return evaluate(tree)


def score_player(game: GameResult, player: GamePlayer, rule: RatingRule) -> dict[str, float | int]:
    role = player.role
    player_id = player.player
    citizen_win = role in (1, 2) and game.sentence == 1
    sheriff_win = role == 2 and game.sentence == 1
    don_win = role == 4 and game.sentence == 2
    mafia_win = role in (3, 4) and game.sentence == 2
    win = citizen_win or mafia_win
    fail = not win and bool(game.sentence) and bool(role)

    values = {
        "#1#": rule.win_citizen if role == 1 and game.sentence == 1 else 0,
        "#2#": rule.win_sheriff if sheriff_win else 0,
        "#3#": rule.win_mafia if role == 3 and game.sentence == 2 else 0,
        "#4#": rule.win_don if don_win else 0,
        "#5#": rule.fail_citizen if role == 1 and game.sentence == 2 else 0,
        "#6#": rule.fail_sheriff if role == 2 and game.sentence == 2 else 0,
        "#7#": rule.fail_mafia if role == 3 and game.sentence == 1 else 0,
        "#8#": rule.fail_don if role == 4 and game.sentence == 1 else 0,
        "#9#": rule.best_player if game.best_player == player_id else 0,
        "#10#": rule.best_step if player_id in (game.best_move, game.best_move2) else 0,
        "#11#": rule.citizen_killed if game.cool_citizen == player_id else 0,
        "#12#": rule.prima_nota3 if game.prima_nota == player_id and game.select_prima == 3 else 0,
        "#13#": rule.prima_nota2 if game.prima_nota == player_id and game.select_prima == 2 else 0,
    }
    points = _evaluate_formula(rule.formula or DEFAULT_FORMULA, values)

    return {
        "Game": int(role > 0),
        "Win": int(win),
        "WR": int(citizen_win),
        "WB": int(mafia_win),
        "Fail": int(fail),
        "Citizen": int(role == 1),
        "Mafia": int(role == 3),
        "Sheriff": int(role == 2),
        "Sheriff_Win": int(sheriff_win),
        "Don": int(role == 4),
        "Don_Win": int(don_win),
        "BM": int(player_id in (game.best_move, game.best_move2)),
        "BP": int(game.best_player == player_id),
        "Balls": points,
        "Score": points / int(role > 0) if role > 0 else 0,
    }
