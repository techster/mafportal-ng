import GalleryPage from "../../gallery/page";

export default async function LocalizedGalleryPage({ params }: { params: Promise<{ locale: string }> }) {
  const { locale } = await params;
  return <GalleryPage locale={locale} />;
}