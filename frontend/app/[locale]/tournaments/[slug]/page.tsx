import TournamentPage from "../../../tournaments/[slug]/page";

export default function LocalizedTournamentPage({ params }: { params: Promise<{ locale: string; slug: string }> }) {
  return <TournamentPage params={params} />;
}
