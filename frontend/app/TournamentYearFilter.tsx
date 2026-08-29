"use client";

export default function TournamentYearFilter({ prefix, selectedYear, years, allYears = "All years" }: { prefix: string; selectedYear: string; years: string[]; allYears?: string }) {
  return (
    <select
      className="TournamentYearSelect"
      aria-label="Tournament years"
      defaultValue={selectedYear}
      onChange={(event) => { window.location.href = `${prefix}/tournaments?page=1&year=${event.target.value}`; }}
    >
      <option value="all">{allYears}</option>
      {years.map((year) => <option value={year} key={year}>{year}</option>)}
    </select>
  );
}