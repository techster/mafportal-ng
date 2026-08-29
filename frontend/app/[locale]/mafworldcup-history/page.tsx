import MafWorldCupHistoryPage from "../../mafworldcup-history/page";

export default async function LocalizedMafWorldCupHistoryPage({ params }: { params: Promise<{ locale: string }> }) {
  const { locale } = await params;
  return <MafWorldCupHistoryPage locale={locale} />;
}