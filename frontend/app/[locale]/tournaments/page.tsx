import TournamentsPage from "../../tournaments/page";

export default async function LocalizedTournamentsPage({ params, searchParams }: { params: Promise<{ locale: string }>; searchParams: Promise<{ page?: string; year?: string }> }) {
  const { locale } = await params;
  return <TournamentsPage locale={locale} searchParams={searchParams} />;
}
