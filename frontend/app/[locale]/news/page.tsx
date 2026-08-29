import NewsPage from "../../news/page";

export default async function LocalizedNewsPage({ params }: { params: Promise<{ locale: string }> }) {
  const { locale } = await params;
  return <NewsPage locale={locale} />;
}