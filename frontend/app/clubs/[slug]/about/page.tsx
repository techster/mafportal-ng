import ClubPage from "../page";

export default function ClubAboutPage({ params }: { params: Promise<{ slug: string }> }) {
  return <ClubPage params={params} />;
}