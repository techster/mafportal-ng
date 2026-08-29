const API_URL = process.env.MAFPORTAL_API_URL ?? "http://127.0.0.1:8001";
export const LEGACY_URL = process.env.MAFPORTAL_LEGACY_URL ?? "http://127.0.0.1:8001";
const MEDIA_URL = process.env.NEXT_PUBLIC_MEDIA_PUBLIC_BASE_URL ?? `${LEGACY_URL}/assets`;

export function assetUrl(value: string | null | undefined): string | undefined {
  if (!value) return undefined;
  if (value.startsWith("http://") || value.startsWith("https://")) return value;
  const path = value.replace(/^\/(?:en|ru)(?=\/uploads\/)/i, "").replace(/^\//, "");
  if (path.startsWith("images/uploads/") || path.startsWith("images/avatars/") || path.startsWith("images/system/") || path.startsWith("images/build/") || path.startsWith("videos/")) return `${MEDIA_URL.replace(/\/$/, "")}/${path}`;
  if (path.startsWith("uploads/")) return `${MEDIA_URL.replace(/\/$/, "")}/images/uploads/${path.slice(8)}`;
  if (path.startsWith("avatars/")) return `${MEDIA_URL.replace(/\/$/, "")}/images/avatars/${path.slice(8)}`;
  if (path.startsWith("images/")) return `${MEDIA_URL.replace(/\/$/, "")}/images/system/${path.slice(7)}`;
  if (path.startsWith("build/")) return `${MEDIA_URL.replace(/\/$/, "")}/images/build/${path.slice(6)}`;
  if (path.startsWith("admin/")) return `${MEDIA_URL.replace(/\/$/, "")}/images/uploads/${path}`;
  return `${LEGACY_URL}/${path}`;
}

export function youtubeId(value: string): string {
  return value.split(/[?&]/, 1)[0].trim();
}

export function youtubeThumbnail(value: string): string {
  return `https://img.youtube.com/vi/${youtubeId(value)}/mqdefault.jpg`;
}

export type Club = {
  id: number;
  title: string;
  slug: string | null;
  country_id: number | null;
  city: string | null;
  image: string | null;
  description: string | null;
  text: string | null;
  events?: Event[];
  photo_galleries?: PhotoGallery[];
  video_galleries?: VideoGallery[];
};

export type Event = { id: number; title: string; slug: string | null; description: string | null; text: string | null; image: string | null; created_at: string | null };

export type Country = {
  id: number;
  title: string;
  description: string | null;
  image: string | null;
};

export type Tournament = {
  id: number;
  title: string;
  slug: string | null;
  preview: string | null;
  description: string | null;
  image: string | null;
  text: string | null;
  created_at: string | null;
  live?: string | null;
  rating?: Record<string, string | number>[];
  schedule?: { id: number; sentence: number | null; players: { player?: number; name?: string; club?: string; avatar?: string; role?: string; result?: string; points?: string | number; add_points?: string | number }[] }[];
  photo_galleries?: PhotoGallery[];
  video_galleries?: VideoGallery[];
};

export type News = {
  id: number;
  slug: string;
  title: string;
  description: string | null;
  text: string | null;
  image: string | null;
  created_at: string | null;
};

export type PhotoGallery = {
  id: number;
  title: string;
  slug: string;
  preview: string | null;
  check_glob: number | null;
  photos: string[];
};

export type VideoGallery = {
  id: number;
  title: string;
  preview: string | null;
  check_glob: number | null;
  id_youtube: string;
};

export type Testimonial = {
  id: number;
  name: string;
  text: string | null;
  image: string | null;
};

export type Page = {
  id: number;
  template: string | null;
  title: string;
  slug: string;
  content: string | null;
  extras: string | null;
};

async function getJson<T>(path: string): Promise<T> {
  const response = await fetch(`${API_URL}${path}`, { cache: "no-store" });
  if (!response.ok) {
    throw new Error(`API request failed: ${response.status}`);
  }
  return response.json() as Promise<T>;
}

export async function getClubs(): Promise<Club[]> {
  return getJson<Club[]>("/api/v1/clubs");
}

export async function getClub(slug: string): Promise<Club> {
  return getJson<Club>(`/api/v1/clubs/${slug}`);
}

export async function getCountries(): Promise<Country[]> {
  return getJson<Country[]>("/api/v1/countries");
}

export async function getTournaments(): Promise<Tournament[]> {
  return getJson<Tournament[]>("/api/v1/tournaments");
}

export async function getTournament(slug: string): Promise<Tournament> {
  return getJson<Tournament>(`/api/v1/tournaments/${slug}`);
}

export async function getNews(): Promise<News[]> {
  return getJson<News[]>("/api/v1/news");
}

export async function getNewsItem(slug: string): Promise<News> {
  return getJson<News>(`/api/v1/news/${slug}`);
}

export async function getPhotoGalleries(): Promise<PhotoGallery[]> {
  return getJson<PhotoGallery[]>("/api/v1/galleries/photos");
}

export async function getPhotoGallery(slug: string): Promise<PhotoGallery> {
  return getJson<PhotoGallery>(`/api/v1/galleries/photos/${slug}`);
}

export async function getVideoGalleries(): Promise<VideoGallery[]> {
  return getJson<VideoGallery[]>("/api/v1/galleries/videos");
}

export async function getTestimonials(): Promise<Testimonial[]> {
  return getJson<Testimonial[]>("/api/v1/testimonials");
}

export async function getPage(slug: string): Promise<Page> {
  return getJson<Page>(`/api/v1/pages/${slug}`);
}
