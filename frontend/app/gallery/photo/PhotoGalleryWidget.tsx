"use client";

import { useEffect, useState } from "react";
import ImageGallery, { type GalleryItem } from "react-image-gallery";
import { assetUrl } from "../../../lib/api";

type PhotoGalleryWidgetProps = {
  photos: GalleryItem[];
  title: string;
};

function GalleryImage({ src, fallback, alt, className }: { src: string; fallback: string; alt: string; className?: string }) {
  const [currentSrc, setCurrentSrc] = useState(fallback);
  useEffect(() => setCurrentSrc(src), [src]);
  return <img className={className} src={currentSrc} alt={alt} onError={() => setCurrentSrc(fallback)} />;
}

export default function PhotoGalleryWidget({ photos, title }: PhotoGalleryWidgetProps) {
  const fallback = assetUrl("logo/logo_bigger.png") ?? "/assets/logo/logo_bigger.png";
  const galleryItems = photos.map((item) => ({
    ...item,
    renderItem: () => <GalleryImage className="image-gallery-image" src={item.original} fallback={fallback} alt={item.originalAlt ?? ""} />,
    renderThumbInner: () => <span className="image-gallery-thumbnail-inner"><GalleryImage src={item.thumbnail ?? item.original} fallback={fallback} alt={item.thumbnailAlt ?? ""} /></span>,
  }));

  return (
    <section className="PhotoGalleryWidget" aria-label={title}>
      <ImageGallery items={galleryItems} onErrorImageURL={fallback} showPlayButton={false} showFullscreenButton={true} showBullets={false} lazyLoad={true} thumbnailPosition="bottom" />
    </section>
  );
}
