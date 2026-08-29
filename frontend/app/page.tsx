import { redirect } from "next/navigation";
import { assetUrl, getPhotoGalleries, getVideoGalleries, youtubeThumbnail } from "../lib/api";
import MediaImage from "./MediaImage";
import type { CSSProperties } from "react";

const articleSections = [
  { id: "interview", title: "Interview", articles: [{ slug: "mafiya-kak-stil-zhizni", title: "Mafia is a way of life", category: "Interview" }] },
  { id: "basics", title: "Game basics", articles: [{ slug: "evaluation-and-other-nuances-of-the-game", title: "Table evaluation and game nuances", category: "Basics" }, { slug: "starting-point-in-Mafia", title: "The starting point in Mafia", category: "Basics" }] },
  { id: "features", title: "Featured articles", articles: [{ slug: "Nine-sins-of-players-in-the-Mafia", title: "Nine sins of Mafia players", category: "Features" }, { slug: "Poker-terms-for-players-in-the-Mafia", title: "Poker terms for Mafia players", category: "Features" }] },
];

export async function HomePage({ locale = "en" }: { locale?: string }) {
  const russian = locale === "ru";
  const routePrefix = russian ? "/ru" : "";
  const localizedArticleSections = russian ? [
    { id: "interview", title: "Интервью", articles: [{ slug: "mafiya-kak-stil-zhizni", title: "Мафия как образ жизни", category: "Интервью" }] },
    { id: "basics", title: "Основы игры", articles: [{ slug: "evaluation-and-other-nuances-of-the-game", title: "Оценка стола и нюансы игры", category: "Основы" }, { slug: "starting-point-in-Mafia", title: "Отправная точка в Мафии", category: "Основы" }] },
    { id: "features", title: "Избранные статьи", articles: [{ slug: "Nine-sins-of-players-in-the-Mafia", title: "Девять грехов игроков в Мафии", category: "Избранное" }, { slug: "Poker-terms-for-players-in-the-Mafia", title: "Покерные термины для игроков в Мафию", category: "Избранное" }] },
  ] : articleSections;
  const labels = russian ? {
    history: "История легенды",
    about: "Психологическая игра Мафия проводится в клубах Мафии по всему миру. В массовой культуре она также известна как «Убийца», «Оборотень» и «Охота на ведьм». Эта увлекательная ролевая игра быстро завоевывает популярность среди молодых и зрелых мужчин и женщин всех национальностей. Истоки игры можно проследить до масонов более 150 лет назад. Позже она вошла в методы подготовки сотрудников КГБ в Советской России.",
    learnMore: "Узнать больше",
    photos: "Фотогалерея",
    videos: "Видеогалерея",
  } : {
    history: "History of the Legend",
    about: "The psychological game of Mafia is played in Maf clubs all around the world. It is also known in mainstream culture as “Assassin,” “Werewolf” and “Witch Hunt.” This entertaining role playing game is rapidly gaining popularity among the young and mature men and women of all nationalities. The game’s origins can be traced to the Masons over 150 years ago. It later found its way into the training methods of KGB security agents in Soviet Russia.",
    learnMore: "Learn More",
    photos: "Photo Gallery",
    videos: "Video Gallery",
  };
  const [allPhotos, allVideos] = await Promise.all([getPhotoGalleries(), getVideoGalleries()]);
  const photoGalleries = allPhotos.filter((gallery) => gallery.check_glob === 1);
  const videoGalleries = allVideos.filter((gallery) => gallery.check_glob === 1);
  return <main>
    <section className="Carusel"><div className="titleWr"><h1 className="title">{labels.history}</h1></div></section>
    <section className="AboutBox"><div className="container"><div className="aboutWr"><div className="contWr"><div className="image" /><div className="desc">{labels.about} <a className="about-learn-more" href={`/${locale}/history`}>{labels.learnMore}</a></div></div></div></div></section>
    <GallerySection title={labels.photos} className="HomeGallery" items={photoGalleries.map((gallery) => ({ title: gallery.title, href: `${routePrefix}/gallery/photo/${gallery.slug}`, image: assetUrl(gallery.preview) }))} />
    <GallerySection title={labels.videos} className="HomeVideoGallery" items={videoGalleries.map((gallery) => ({ title: gallery.title, href: `https://www.youtube.com/watch?v=${gallery.id_youtube}`, image: assetUrl(gallery.preview) ?? youtubeThumbnail(gallery.id_youtube), video: true }))} />
    <SectionTitle title={russian ? "Статьи" : "Articles"} />
    <section className="HomeArticles"><div className="container"><div className="article-sections">{localizedArticleSections.map((section) => <div className="article-section" id={`home-${section.id}`} key={section.id}><h2 className="article-section-title">{section.title}</h2><div className="article-grid">{section.articles.map((article) => <a className="article-tile" href={`/${locale}/${article.slug}`} key={article.slug}><span className="article-title">{article.title}</span></a>)}</div><a className="article-more" href={`/${locale}/articles/#${section.id}`}>{russian ? "Больше" : "More"} →</a></div>)}</div></div></section>
  </main>;
}

export default function RootPage() {
  redirect("/ru");
}

function SectionTitle({ title }: { title: string }) { return <section className="Title"><div className="container"><div className="titleWr"><div className="left_line lineDef" /><h1 className="title_name">{title}</h1><div className="right_line lineDef" /></div></div></section>; }

function GallerySection({ title, className, items }: { title: string; className: string; items: { title: string; href: string; image?: string; video?: boolean }[] }) { const video = className === "HomeVideoGallery"; const trackStyle = { "--gallery-count": items.length, "--visible-count": 3 } as CSSProperties; return <><SectionTitle title={title} /><section className={className}><div className="container"><div className={video ? "video-carousel" : "gallery-carousel"}><div className={video ? "video-track" : "gallery-track"} style={trackStyle}>{items.map((item) => <div className={video ? "video-item" : "gallery-item"} key={item.title}><a className={item.video ? "video-slide" : "gallery-slide"} href={item.href}><MediaImage src={item.image} fallback="/build/img/not_img.jpg" alt={item.title} /><span className={item.video ? "video-slide-title" : "gallery-slide-title"}>{item.title}</span></a></div>)}</div></div></div></section></>; }
