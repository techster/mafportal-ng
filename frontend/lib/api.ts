const API_URL = process.env.MAFPORTAL_API_URL ?? "http://127.0.0.1:8001";
export const LEGACY_URL = process.env.MAFPORTAL_LEGACY_URL ?? "http://127.0.0.1:8001";
const MEDIA_URL = process.env.NEXT_PUBLIC_MEDIA_PUBLIC_BASE_URL ?? `${LEGACY_URL}/assets`;

const WORLD_CUP_IMAGE_MAP: Record<string, string> = {
  "_hero_background_worldcup.jpg": "tournaments/bd3b01bff56c259a1017ece953709e90.jpg",
  "8th_mwc.jpg": "tournaments/2b88bac505979dc0783d84b38ce92a07.jpg",
  "vegas-maf-7th.jpeg": "tournaments/c024dd500ab62471b6e11ec484bf499d.jpg",
  "6th_mwc.png": "tournaments/bec0ae638374386c9c62796b13044d18.jpg",
  "6th_mwc_winner.JPG": "tournaments/bec0ae638374386c9c62796b13044d18.jpg",
  "5th_mwc.jpg": "galleries/wmc2014/aa00d2a0477634f1e3c9866d917e8e19.jpg",
  "mwc2016winners.jpg": "galleries/wmc2014/aa00d2a0477634f1e3c9866d917e8e19.jpg",
  "4th_mwc.jpg": "galleries/wmc2014/5b515580bf405a96c19d84d7c58bf5bd.jpg",
  "3rd_mwc.jpg": "galleries/wmc2014/aa00d2a0477634f1e3c9866d917e8e19.jpg",
  "2nd_mwc.jpg": "galleries/mwc2012/7d11a7003f4204176eee90fe30fa6597.jpg",
  "1st_mwc.jpg": "galleries/mwc2012/20324e6382669d0f9b40714bf9b32011.jpg",
};

export function assetUrl(value: string | null | undefined): string | undefined {
  if (!value) return undefined;
  if (value.startsWith("http://") || value.startsWith("https://")) return value;
  const path = value.replace(/^\/(?:en|ru)(?=\/uploads\/)/i, "").replace(/^\//, "");
  const worldCupFile = path.match(/^uploads\/maf-world-cup-history\/img\/(?:history\/)?([^/]+)$/i)?.[1];
  if (worldCupFile && WORLD_CUP_IMAGE_MAP[worldCupFile]) return `${MEDIA_URL.replace(/\/$/, "")}/${WORLD_CUP_IMAGE_MAP[worldCupFile]}`;
  if (path.startsWith("images/uploads/")) return `${MEDIA_URL.replace(/\/$/, "")}/images/${path.slice(15)}`;
  if (path.startsWith("images/avatars/")) return `${MEDIA_URL.replace(/\/$/, "")}/avatar/${path.slice(15)}`;
  if (path.startsWith("images/system/")) return `${MEDIA_URL.replace(/\/$/, "")}/system/${path.slice(14)}`;
  if (path.startsWith("images/") || path.startsWith("system/") || path.startsWith("videos/")) return `${MEDIA_URL.replace(/\/$/, "")}/${path}`;
  if (path.startsWith("logo/")) return `${MEDIA_URL.replace(/\/$/, "")}/${path}`;
  if (path.startsWith("uploads/")) return `${MEDIA_URL.replace(/\/$/, "")}/images/${path.slice(8)}`;
  if (path.startsWith("avatars/")) return `${MEDIA_URL.replace(/\/$/, "")}/avatar/${path.slice(8)}`;
  if (path.startsWith("avatar/")) return `${MEDIA_URL.replace(/\/$/, "")}/${path}`;
  if (path.startsWith("build/")) return `${MEDIA_URL.replace(/\/$/, "")}/images/build/${path.slice(6)}`;
  if (path.startsWith("galleries/")) return `${MEDIA_URL.replace(/\/$/, "")}/${path}`;
  if (path.startsWith("tournaments/")) return `${MEDIA_URL.replace(/\/$/, "")}/${path}`;
  if (path.startsWith("admin/")) return `${MEDIA_URL.replace(/\/$/, "")}/images/admin/${path}`;
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
