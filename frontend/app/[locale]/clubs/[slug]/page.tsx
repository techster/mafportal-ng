import ClubPage from "../../../clubs/[slug]/page";

export default function LocalizedClubPage({ params }: { params: Promise<{ locale: string; slug: string }> }) {
  return <ClubPage params={params} />;
}
