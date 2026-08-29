import { notFound } from "next/navigation";
import { assetUrl, getNewsItem } from "../../../lib/api";

export default async function NewsDetailPage({ params }: { params: Promise<{ locale?: string; slug: string }> }) {
  const { locale = "en", slug } = await params;
  let item;
  try { item = await getNewsItem(slug); } catch { notFound(); }
  return <main className="SinleNewsPage"><div className="container">
    <div className="archive-title"><div className="left_line lineDef" /><h1 className="title_name">{item.title}</h1><div className="right_line lineDef" /></div>
    <div className="news-detail-content"><div className="news-detail-meta">{item.created_at ? new Date(item.created_at).toLocaleDateString(locale === "ru" ? "ru-RU" : "en-GB") : ""}<p>{item.description}</p></div>
      {item.image && <div className="news-detail-image" style={{ backgroundImage: `url(${assetUrl(item.image)})` }} />}
      <div className="MainCont" dangerouslySetInnerHTML={{ __html: item.text ?? item.description ?? "" }} />
    </div>
  </div></main>;
}
