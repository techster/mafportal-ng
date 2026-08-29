import { notFound } from "next/navigation";
import { assetUrl, getTournament, getTournaments } from "../../../lib/api";
import MediaImage from "../../MediaImage";
import GameSchedule from "./GameSchedule";

export default async function TournamentPage({ params }: { params: Promise<{ slug: string }> }) {
  const { slug } = await params;
  let tournament;
  try { tournament = await getTournament(slug); } catch { notFound(); }
  const ordered = await getTournaments();
  const index = ordered.findIndex((item) => item.slug === tournament.slug);
  const previous = index >= 0 ? ordered[index + 1] : undefined;
  const next = index > 0 ? ordered[index - 1] : undefined;

  return <main className="TournamentDetail">
    <section className="detail-hero" style={tournament.image ? { backgroundImage: `url(${assetUrl(tournament.image)})` } : undefined}>
      <div className="container"><h1>{tournament.title}</h1>{tournament.created_at && <p>{new Date(tournament.created_at).toLocaleDateString("en-GB")}</p>}<nav className="detail-pager" aria-label="Tournament navigation">{previous?.slug && <a href={`/tournaments/${previous.slug}`}>Previous tournament</a>}{next?.slug && <a href={`/tournaments/${next.slug}`}>Next tournament</a>}</nav></div>
    </section>
    <div className="container">
      <section id="about" className="detail-section"><h2>About</h2><p>{tournament.description}</p><div dangerouslySetInnerHTML={{ __html: tournament.text ?? "" }} /></section>
      <section id="rating" className="detail-section tournament-rating"><h2>Rating</h2>{tournament.rating?.length ? <div className="rating-panel"><div className="rating-toolbar">Number of members: {tournament.rating.length}</div><div className="rating-table"><table><thead><tr><th>#</th><th>Player</th><th>Games (Won)</th><th title="Citizen (Win)">Citizen</th><th title="Mafia (Win)">Mafia</th><th title="Sheriff (Win)">Sheriff</th><th title="Don (Win)">Don</th><th>BM</th><th>BP</th><th>PN</th><th>Points</th><th>Score</th></tr></thead><tbody>{tournament.rating.map((row, index) => <tr key={String(row.player_id ?? index)}><th>{index + 1}</th><th><span className="player-cell"><img className="player-avatar" src={assetUrl(String(row.avatar ?? "/images/avatar-silhouette.svg"))} alt="" /><span className="player-details">{row.player}<small>{row.club}</small></span></span></th><th>{row.Game} ({row.Win})</th><th>{row.Citizen} ({row.WR})</th><th>{row.Mafia} ({row.WB})</th><th>{row.Sheriff} ({row.Sheriff_Win})</th><th>{row.Don} ({row.Don_Win})</th><th>{row.BM}</th><th>{row.BP}</th><th>{row.PN ?? 0}</th><th>{row.Balls}</th><th>{Number(row.Score).toFixed(2)}</th></tr>)}</tbody></table></div></div> : <p>No rating results are recorded.</p>}</section>
      <section id="gallery" className="detail-section"><h2>Gallery</h2>{tournament.photo_galleries?.length ? <div className="GalleryList">{tournament.photo_galleries.map((gallery) => <a className="gallery-card" href={`/gallery/photo/${gallery.slug}`} key={gallery.id}><div className="gallery-card-pic" style={gallery.preview ? { backgroundImage: `url(${assetUrl(gallery.preview)})` } : undefined} /><div className="gallery-card-title">{gallery.title}</div></a>)}</div> : <p>No photos are recorded for this tournament.</p>}</section>
      <section id="schedule" className="detail-section"><h2>Games</h2><GameSchedule games={tournament.schedule ?? []} /></section>
      <section id="video" className="detail-section"><h2>Live</h2>{tournament.live ? <div dangerouslySetInnerHTML={{ __html: tournament.live }} /> : tournament.video_galleries?.length ? <div className="GalleryList">{tournament.video_galleries.map((gallery) => <a className="gallery-card" href={`https://www.youtube.com/watch?v=${gallery.id_youtube}`} key={gallery.id}><div className="gallery-card-pic" style={gallery.preview ? { backgroundImage: `url(${assetUrl(gallery.preview)})` } : undefined} /><div className="gallery-card-title">{gallery.title}</div></a>)}</div> : <p>No live stream is currently available.</p>}</section>
    </div>
  </main>;
}
