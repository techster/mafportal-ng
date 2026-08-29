import { assetUrl } from "../../../lib/api";

type GamePlayer = {
  name?: string;
  club?: string;
  avatar?: string;
  role?: string;
  result?: string;
  points?: string | number;
  add_points?: string | number;
};

type Game = {
  id: number;
  sentence: number | null;
  players: GamePlayer[];
};

function winnerLabel(sentence: number | null) {
  if (sentence === 1) return "Citizens win";
  if (sentence === 2) return "Mafia wins";
  return "Result not recorded";
}

export default function GameSchedule({ games }: { games: Game[] }) {
  if (!games.length) return <p>No games are recorded.</p>;

  return (
    <div className="game-accordion">
      {games.map((game, index) => {
        const panelId = `game-${game.id}`;
        return (
          <details className={`game-accordion-item ${game.sentence === 1 ? "citizens-win" : game.sentence === 2 ? "mafia-win" : "unknown-result"}`} name="tournament-games" key={game.id}>
            <summary className="game-accordion-title">
              <span className="game-accordion-icon" aria-hidden="true" />
              <span>Game {index + 1}</span>
              <span className="game-accordion-result">{winnerLabel(game.sentence)}</span>
            </summary>
            <div className="game-accordion-panel" id={panelId}>
                <div className="schedule-table">
                  <table>
                    <thead>
                      <tr><th>#</th><th>Player</th><th>Role</th><th>Result</th><th>Points</th><th>Add. Points</th></tr>
                    </thead>
                    <tbody>
                      {game.players.map((player, playerIndex) => (
                        <tr key={`${game.id}-${playerIndex}`}>
                          <th>{playerIndex + 1}</th>
                          <th><span className="player-cell"><img className="player-avatar" src={assetUrl(player.avatar ?? "/images/avatar-silhouette.svg")} alt="" /><span className="player-details">{player.name ?? "Player"}{player.club && <small>{player.club}</small>}</span></span></th>
                          <td>{player.role ?? ""}</td>
                          <td>{player.result ?? ""}</td>
                          <td>{player.points ?? ""}</td>
                          <td>{player.add_points ?? ""}</td>
                        </tr>
                      ))}
                    </tbody>
                  </table>
                </div>
            </div>
          </details>
        );
      })}
    </div>
  );
}
