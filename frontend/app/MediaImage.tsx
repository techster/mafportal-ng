"use client";

import { useEffect, useState } from "react";
import { assetUrl } from "../lib/api";

type MediaImageProps = {
  src: string | undefined;
  fallback?: string;
  alt: string;
  className?: string;
};

export default function MediaImage({ src, fallback, alt, className }: MediaImageProps) {
  const fallbackSrc = assetUrl(fallback);
  const [currentSrc, setCurrentSrc] = useState(src ?? fallbackSrc);
  useEffect(() => {
    if (src) setCurrentSrc(src);
  }, [src]);
  return <img src={currentSrc} alt={alt} className={className} onError={() => fallbackSrc && currentSrc !== fallbackSrc && setCurrentSrc(fallbackSrc)} />;
}
