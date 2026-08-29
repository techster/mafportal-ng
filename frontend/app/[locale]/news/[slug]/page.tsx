import NewsDetailPage from "../../../news/[slug]/page";

export default async function LocalizedNewsDetailPage({ params }: { params: Promise<{ locale: string; slug: string }> }) {
  return <NewsDetailPage params={params} />;
}