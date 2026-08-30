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
  const resolvedSrc = assetUrl(src);
  const fallbackSrc = assetUrl(fallback);
  const [currentSrc, setCurrentSrc] = useState(resolvedSrc ?? fallbackSrc);
  useEffect(() => {
    setCurrentSrc(resolvedSrc ?? fallbackSrc);
  }, [resolvedSrc, fallbackSrc]);
  return <img src={currentSrc} alt={alt} className={className} decoding="async" onError={() => fallbackSrc && currentSrc !== fallbackSrc && setCurrentSrc(fallbackSrc)} />;
}
