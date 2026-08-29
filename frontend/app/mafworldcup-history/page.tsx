import { notFound } from "next/navigation";
import { assetUrl, getPage } from "../../lib/api";

function normalizeContent(content: string, locale: string): string {
  const normalized = content
    .replace(/<h2\b[^>]*>[\s\S]*?<\/h2>/i, "")
    .replace(/<div>\s*<p>[\s\S]*?<\/p>\s*<\/div>/i, "")
    .replace(/<blockquote\b[^>]*>[\s\S]*?<\/blockquote>/i, "")
    .replace(/https?:\/\/(?:www\.)?mafportal\.com(?=\/)/gi, "")
    .replace(/(\b(?:src|href)=["'])\/(?:en|ru)\/?(uploads\/[^"']+)/gi, (_, prefix: string, path: string) => `${prefix}${assetUrl(`/${path}`)}`)
    .replace(/(\bsrc=["'])\/(uploads\/[^"']+)/gi, (_, prefix: string, path: string) => `${prefix}${assetUrl(`/${path}`)}`)
    .replace(/href="\.\//gi, `href="/${locale}/mafworldcup-history/`);
  return locale === "ru"
    ? normalized.replace(/(август|июль)\s+(\d{1,2}-\d{1,2}),\s*(\d{4})/gi, (_, month, days, year) => `${days} ${month.toLowerCase() === "август" ? "Августа" : "Июля"}, ${year}`)
    : normalized;
}

  export default async function MafWorldCupHistoryPage({ locale = "en" }: { locale?: string }) {
  let page;
  try {
    page = await getPage("mafworldcup-history");
  } catch {
    notFound();
  }

  let localized = { title: page.title, content: page.content };
  if (locale === "ru" && page.extras) {
    try {
      const extras = JSON.parse(page.extras) as { title_rus?: string; content_rus?: string };
      localized = { title: extras.title_rus || page.title, content: extras.content_rus || page.content };
    } catch { }
  }

  return (
    <main className="GenericPage WorldCupHistory">
      <div className="container">
        <div className="archive-title">
          <div className="left_line lineDef" />
          <h1 className="title_name">{locale === "ru" ? "История кубков мира" : localized.title}</h1>
          <div className="right_line lineDef" />
        </div>
        <article
          className="MainCont"
          dangerouslySetInnerHTML={{ __html: normalizeContent(localized.content ?? "", locale) }}
        />
      </div>
    </main>
  );
}
