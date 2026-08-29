import { assetUrl, getPhotoGalleries, getVideoGalleries, type PhotoGallery, type VideoGallery, youtubeThumbnail } from "../../lib/api";
import MediaImage from "../MediaImage";

export default async function GalleryPage({ locale = "" }: { locale?: string }) {
  let photos: PhotoGallery[] = [];
  let videos: VideoGallery[] = [];
  let unavailable = false;
  try { [photos, videos] = await Promise.all([getPhotoGalleries(), getVideoGalleries()]); } catch { unavailable = true; }
  const publishedPhotos = photos.filter((gallery) => gallery.check_glob === 1);
  const publishedVideos = videos.filter((gallery) => gallery.check_glob === 1);
  const prefix = locale ? `/${locale}` : "";
  const labels = locale === "ru" ? { title: "Галерея", photos: "Фото альбом", videos: "Видео альбом" } : { title: "Gallery", photos: "Photo Albums", videos: "Video Albums" };
  return <main className="GalleryPage"><div className="container">
    <div className="archive-title"><div className="left_line lineDef" /><h1 className="title_name">{labels.title}</h1><div className="right_line lineDef" /></div>
    {unavailable ? <div className="empty">The Python API is unavailable. Start the backend on port 8011.</div> : <>
      <div className="gallery-heading">{labels.photos}</div><section className="GalleryList">{publishedPhotos.map((gallery) => <a className="gallery-card" href={`${prefix}/gallery/photo/${gallery.slug}`} key={gallery.id}><div className="gallery-card-pic"><MediaImage src={assetUrl(gallery.preview)} fallback="/build/img/not_img.jpg" alt={gallery.title} /></div><div className="gallery-card-title">{gallery.title}</div></a>)}</section>
      <div className="gallery-heading">{labels.videos}</div><section className="GalleryList">{publishedVideos.map((gallery) => <a className="gallery-card" href={`https://www.youtube.com/watch?v=${gallery.id_youtube}`} key={gallery.id}><div className="gallery-card-pic"><MediaImage src={assetUrl(gallery.preview) ?? youtubeThumbnail(gallery.id_youtube)} fallback="/build/img/not_img.jpg" alt={gallery.title} /></div><div className="gallery-card-title">{gallery.title}</div></a>)}</section>
    </>}
  </div></main>;
}
