import { getNews, type News } from "../../lib/api";

export default async function NewsPage({ locale = "en" }: { locale?: string }) {
  let news: News[] = [];
  let unavailable = false;
  try { news = await getNews(); } catch { unavailable = true; }

  const russian = locale === "ru";
  const prefix = locale ? `/${locale}` : "";
  const labels = russian ? { title: "Новости", error: "Сервис данных временно недоступен." } : { title: "News", error: "The Python API is unavailable. Start the backend on port 8011." };
  return <main className="NewsPage"><div className="container">
    <div className="archive-title"><div className="left_line lineDef" /><h1 className="title_name">{labels.title}</h1><div className="right_line lineDef" /></div>
    {unavailable ? <div className="empty">{labels.error}</div> : <section className="NewsList">
      {news.map((item) => <article className="News_item" key={item.id}><a href={`${prefix}/news/${item.slug}`}>
        <h2 className="news-item-title">{item.title}</h2><div className="news-content"><div className="news-date">{item.created_at ? new Date(item.created_at).toLocaleDateString(russian ? "ru-RU" : "en-GB") : ""}</div><div className="news-desc">{item.description}</div></div>
      </a></article>)}
    </section>}
  </div></main>;
}
