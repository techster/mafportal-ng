import { assetUrl, getTournaments, type Tournament } from "../../lib/api";
import MediaImage from "../MediaImage";
import TournamentYearFilter from "../TournamentYearFilter";

export default async function TournamentsPage({ searchParams, locale = "" }: { searchParams?: Promise<{ page?: string; year?: string }>; locale?: string }) {
  let tournaments: Tournament[] = [];
  let unavailable = false;

  try {
    tournaments = await getTournaments();
  } catch {
    unavailable = true;
  }

  const query = searchParams ? await searchParams : {};
  const selectedYear = query.year && query.year !== "all" ? query.year : "all";
  const filtered = selectedYear === "all" ? tournaments : tournaments.filter((item) => item.created_at?.slice(0, 4) === selectedYear);
  const pageSize = 12;
  const page = Math.max(1, Number(query.page) || 1);
  const pageCount = Math.max(1, Math.ceil(filtered.length / pageSize));
  const currentPage = Math.min(page, pageCount);
  const visible = filtered.slice((currentPage - 1) * pageSize, currentPage * pageSize);
  const years = [...new Set(tournaments.map((item) => item.created_at?.slice(0, 4)).filter(Boolean))].sort().reverse();
  const prefix = locale ? `/${locale}` : "";
  const archiveUrl = (nextPage: number, year = selectedYear) => `${prefix}/tournaments?page=${nextPage}&year=${year}`;
  const russian = locale === "ru";
  const labels = russian ? { title: "Турниры", allYears: "Все годы", error: "Сервис данных временно недоступен.", unavailableDate: "Дата не указана", previous: "Предыдущая", next: "Следующая", page: "Страница" } : { title: "Tournaments", allYears: "All years", error: "The Python API is unavailable. Start the backend on port 8011.", unavailableDate: "Date unavailable", previous: "Previous", next: "Next", page: "Page" };

  return (
    <main className="TournamentsPage"><div className="container">
      <div className="archive-title"><div className="left_line lineDef" /><h1 className="title_name">{labels.title}</h1><div className="right_line lineDef" /></div>
      <div className="TournamentFilters"><nav className="TournamentYearButtons" aria-label={labels.allYears}><a href={archiveUrl(1, "all")} className={selectedYear === "all" ? "active" : ""}>{labels.allYears}</a>{years.map((year) => <a href={archiveUrl(1, year!)} className={selectedYear === year ? "active" : ""} key={year}>{year}</a>)}</nav><TournamentYearFilter prefix={prefix} selectedYear={selectedYear} years={years as string[]} allYears={labels.allYears} /></div>
      {unavailable ? (
        <div className="empty">{labels.error}</div>
      ) : (
        <div className="TournamentList">
          {visible.map((tournament) => (
            <article className="tournament-item" key={tournament.id}>
              <a href={`${prefix}/tournaments/${tournament.slug ?? tournament.id}`} className="tournament-media" aria-label={tournament.title}><MediaImage src={assetUrl(tournament.preview)} fallback="/build/img/Mafia.jpg" alt={tournament.title} /></a>
              <div className="tournament-info"><h3><a href={`${prefix}/tournaments/${tournament.slug ?? tournament.id}`}>{tournament.title}</a></h3><div className="tournament-desc"><div className="date">{tournament.created_at ? new Date(tournament.created_at).toLocaleDateString(russian ? "ru-RU" : "en-GB") : labels.unavailableDate}</div>{tournament.description && <div className="desc" dangerouslySetInnerHTML={{ __html: tournament.description }} />}</div></div>
            </article>
          ))}
        </div>
      )}
      {pageCount > 1 && <nav className="Pagination" aria-label={labels.page}>{currentPage > 1 && <a href={archiveUrl(currentPage - 1)}>{labels.previous}</a>}<span>{labels.page} {currentPage} {russian ? "из" : "of"} {pageCount}</span>{currentPage < pageCount && <a href={archiveUrl(currentPage + 1)}>{labels.next}</a>}</nav>}
    </div></main>
  );
}
