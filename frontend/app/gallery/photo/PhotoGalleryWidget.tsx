"use client";

import ImageGallery, { type GalleryItem } from "react-image-gallery";

type PhotoGalleryWidgetProps = {
  photos: GalleryItem[];
  title: string;
};

export default function PhotoGalleryWidget({ photos, title }: PhotoGalleryWidgetProps) {
  return (
    <section className="PhotoGalleryWidget" aria-label={title}>
      <ImageGallery items={photos} showPlayButton={false} showFullscreenButton={true} showBullets={false} lazyLoad={true} thumbnailPosition="bottom" />
    </section>
  );
}
