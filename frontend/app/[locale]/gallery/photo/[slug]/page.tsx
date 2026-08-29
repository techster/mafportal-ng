import PhotoGalleryPage from "../../../../gallery/photo/[slug]/page";

export default async function LocalizedPhotoGalleryPage({ params }: { params: Promise<{ locale: string; slug: string }> }) {
  const { locale, slug } = await params;
  return <PhotoGalleryPage params={Promise.resolve({ locale, slug })} />;
}