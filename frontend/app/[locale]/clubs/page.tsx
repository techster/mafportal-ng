import ClubsPage from "../../clubs/page";

export default async function LocalizedClubsPage({ params }: { params: Promise<{ locale: string }> }) {
  const { locale } = await params;
  return <ClubsPage locale={locale} />;
}
