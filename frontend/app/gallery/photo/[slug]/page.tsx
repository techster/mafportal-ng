import { notFound } from "next/navigation";
import { assetUrl, getPhotoGallery } from "../../../../lib/api";
import PhotoGalleryWidget from "../PhotoGalleryWidget";

export default async function PhotoGalleryPage({ params }: { params: Promise<{ locale?: string; slug: string }> }) {
  const { slug } = await params;
  let gallery;
  try { gallery = await getPhotoGallery(slug); } catch { notFound(); }
  return <main className="SinlgePhoto"><div className="container">
    <div className="archive-title"><div className="left_line lineDef" /><h1 className="title_name">{gallery.title}</h1><div className="right_line lineDef" /></div>
    <PhotoGalleryWidget photos={gallery.photos.map((photo) => {
      const fallback = assetUrl(gallery.preview) ?? "/build/img/not_img.jpg";
      return {
        original: assetUrl(`uploads/${photo}`) ?? fallback,
        thumbnail: assetUrl(`uploads/thumb/${photo}`) ?? fallback,
        originalAlt: `${gallery.title} photo`,
        thumbnailAlt: `${gallery.title} thumbnail`,
      };
    })} title={gallery.title} />
  </div></main>;
}
