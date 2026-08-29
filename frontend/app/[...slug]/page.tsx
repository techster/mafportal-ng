import { notFound } from "next/navigation";
import { assetUrl, getPage } from "../../lib/api";

function normalizeInternalLinks(content: string): string {
  return content
    .replace(/https?:\/\/(?:www\.)?mafportal\.com(?=\/)/gi, "")
    .replace(/(src=["'])\/(?:en|ru)\/?(uploads\/[^"']+)/gi, (_, prefix: string, path: string) => `${prefix}${assetUrl(`/${path}`)}`)
    .replace(/(src=["'])\/(uploads\/[^"']+)/gi, (_, prefix: string, path: string) => `${prefix}${assetUrl(`/${path}`)}`);
}

function normalizeWorldCupContent(content: string): string {
  return normalizeInternalLinks(content)
    .replace(/(<div>\s*)<div>\s*<h2\b[^>]*>\s*(?:История|History)\s*<\/h2>[\s\S]*?<\/div>(\s*<div>)/i, "$1$2")
    .replace(/(<h2\b[^>]*>\s*(?:Лучшие 10 игроков турнира|Top 10 players)\s*<\/h2>)([\s\S]*?)(?=<\/div>)/i, (_, heading, playerContent) => {
      const players = [...playerContent.matchAll(/<h3\b[^>]*>([\s\S]*?)<\/h3>/gi)].map((match) => match[1].trim());
      return `${heading}<table><thead><tr><th>Rank</th><th>Name</th></tr></thead><tbody>${players.map((player, index) => `<tr><td>${String(index + 1).padStart(2, "0")}</td><td>${player}</td></tr>`).join("")}</tbody></table>`;
    });
}

export default async function GenericPage({ params }: { params: Promise<{ slug: string[] }> }) {
  const { slug } = await params;
  const pageSlug = slug.join("/");
  let page;
  try { page = await getPage(slug.join("/")); } catch { notFound(); }
  const isNinthWorldCup = pageSlug === "mafworldcup-history/the-9th-annual-maf-world-cup";
  const pageClass = isNinthWorldCup ? "GenericPage WorldCupHistoryChild" : "GenericPage";
  const content = isNinthWorldCup ? normalizeWorldCupContent(page.content ?? "") : normalizeInternalLinks(page.content ?? "");
  return <main className={pageClass}><div className="container"><div className="archive-title"><div className="left_line lineDef" /><h1 className="title_name">{page.title}</h1>{isNinthWorldCup && <p className="archive-subtitle">August 6-9, 2020</p>}<div className="right_line lineDef" /></div><article className="MainCont" dangerouslySetInnerHTML={{ __html: content }} /></div></main>;
}