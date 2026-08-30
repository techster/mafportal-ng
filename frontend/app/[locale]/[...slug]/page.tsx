import { notFound } from "next/navigation";
import { assetUrl, getPage, getPhotoGallery } from "../../../lib/api";
import PhotoGalleryWidget from "../../gallery/photo/PhotoGalleryWidget";

function normalizeInternalLinks(content: string, pageSlug: string, locale: string): string {
  let normalized = content
    .replace(/https?:\/\/(?:www\.)?mafportal\.com(?=\/)/gi, "")
    .replace(/https?:\/\/127\.0\.0\.1:8000\/([^"']+)/gi, (_, path: string) => assetUrl(`/${path}`) || _)
    .replace(/(\bsrc=["'])\/(?:en|ru)\/?(uploads\/[^"']+)/gi, (_, prefix: string, path: string) => `${prefix}${assetUrl(`/${path}`)}`)
    .replace(/(\bsrc=["'])\/(uploads\/[^"']+)/gi, (_, prefix: string, path: string) => `${prefix}${assetUrl(`/${path}`)}`)
    .replace(/(\bsrc=["'])\.\.\/img\/history\/([^"']+)(["'])/gi, (_, prefix: string, file: string, suffix: string) => `${prefix}${assetUrl(`/uploads/maf-world-cup-history/img/history/${file}`)}${suffix}`)
    .replace(/(\bsrc=["'])(?:\.\.\/)?img\/(?:history\/)?([^"']+)(["'])/gi, (_, prefix: string, file: string, suffix: string) => `${prefix}${assetUrl(`/uploads/maf-world-cup-history/img/${file.split("/").at(-1) ?? file}`)}${suffix}`)
    .replace(/(\bsrc=["'])\/assets\/images\/maf-world-cup-history\/img\/(?:history\/)?([^"']+)(["'])/gi, (_, prefix: string, file: string, suffix: string) => `${prefix}${assetUrl(`/uploads/maf-world-cup-history/img/${file.split("/").at(-1) ?? file}`)}${suffix}`)
    .replace(/(\bsrc=["'])\/images\/missing-media\.svg(["'])/gi, `$1${assetUrl("images/53438d2a1105a08374e43dbbc9f8211c.jpg")}$2`);
  const isRussianRulesPage = locale === "ru" && pageSlug === "the-game";
  normalized = normalized.replace(/<img\b[^>]*src=["']http:\/\/127\.0\.0\.1:8000\/uploads\/maf-world-cup-history\/img\/_hero_background_worldcup\.jpg["'][^>]*>/gi, "");
  if (pageSlug === "mafworldcup-history/the-9th-annual-maf-world-cup") {
    normalized = normalized.replace(/(<h2\b[^>]*>(?:Video|Видео)<\/h2>)/i, `$1<div class="world-cup-playlist"><iframe width="560" height="315" src="https://www.youtube-nocookie.com/embed/CNnwvLueTKo?si=--fk6f9hJ_sjGQb3" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe></div>`);
  }
  if (pageSlug.startsWith("mafworldcup-history/")) {
    normalized = normalized.replace(/<p>\s*(Award Ceremony|The Final Game|FINAL Game|Day One|Day Two|Церемония Награждения|Финальная Игра|День Первый|День Второй)\s*<\/p>/gi, (_, title) => {
      const query = encodeURIComponent(`MAF World Cup ${pageSlug.replace("mafworldcup-history/", "")} ${title}`);
      return `<p><a href="https://www.youtube.com/results?search_query=${query}" target="_blank" rel="noreferrer">${title}</a></p>`;
    });
  }
  if (pageSlug === "the-game") {
    normalized = normalized
      .replace(/<h2\b[^>]*>[\s\S]*?<\/h2>[\s\S]*?<div>\s*&nbsp;\s*<\/div>/i, "")
      .replace(/<h1\b[^>]*>\s*<\/h1>/gi, "");
  }
  if (pageSlug === "history") {
    normalized = normalized.replace(/<p>\s*(?:&nbsp;|\s)*<\/p>/gi, "");
    if (locale === "ru") {
      normalized = normalized.replace(/\s*<strong\b[^>]*>\s*<a\b[^>]*href=["']https?:\/\/mafworldcup\.com["'][^>]*>\s*10-й ежегодный Кубок мира по игре МАФИЯ\s*<\/a>\s*<\/strong>\s*пройдет с 5 по 8 августа 2021 года\.?/iu, "");
    } else if (locale === "en") {
      normalized = normalized.replace(/\s*The\s*<a\b[^>]*href=["']https?:\/\/mafworldcup\.com["'][^>]*>\s*<strong\b[^>]*>\s*10th Annual MAF World Cup\s*<\/strong>\s*<\/a>\s*will take place from August 5 to 8, 2021\.?/iu, "");
    }
  }
  if (isRussianRulesPage) {
    normalized = normalized.replace(/<p>\s*Председатель Орг Комитета[\s\S]*?Павел Лагутин\s*<\/p>/i, "");
  }
  if (locale === "en" && pageSlug === "the-game") {
    normalized = normalized
      .replace(/<p>\s*Chairman of the Organizing Committee[\s\S]*?Pavel Lagutin\s*<\/p>/i, "")
      .replace(/<h1(\b[^>]*)>(\s*<img\b[\s\S]*?)<\/h1>\s*<h1\b[^>]*>(1\.\s*General Provision)<\/h1>/i, "<h1$1>$2$3</h1>");
  }
  const ruleNumbers = new Set<string>();
  normalized = normalized.replace(/<(p|h[1-3])(?![^>]*\bid=)([^>]*)>\s*(\d+(?:\.\d+)*)(?=\.|\s|&nbsp;|<)/gi, (_, tag, attributes, number) => {
    ruleNumbers.add(number);
    return `<${tag}${attributes} id="rule-${number.replace(/\./g, "-")}">${number}`;
  });
  normalized = normalized.replace(/<(h[1-3])(?![^>]*\bid=)([^>]*)>((?:(?:<[^>]+>)|\s|&nbsp;)*)(\d+(?:\.\d+)*)(?=\.|\s|&nbsp;|<)/gi, (_, tag, attributes, prefix, number) => {
    ruleNumbers.add(number);
    return `<${tag}${attributes} id="rule-${number.replace(/\./g, "-")}">${prefix}${number}`;
  });
  normalized = normalized.replace(/<a\b([^>]*?)href=["']https:\/\/www\.notion\.so\/[^"']+["']([^>]*)>\s*(\d+(?:\.\d+)*)\s*<\/a>/gi, (match, beforeHref, afterHref, number) => ruleNumbers.has(number) ? `<a${beforeHref}href="#rule-${number.replace(/\./g, "-")}"${afterHref}>${number}</a>` : match);
  if (isRussianRulesPage) {
    normalized = normalized.replace(/(^|[^А-Яа-яЁёA-Za-z0-9_>])(пункт(?:а|е|ом|у|ы|ов|ам|ами|ах)?|п\.)((?:(?:&nbsp;|\s)+|<[^>]+>)+)(?:правил((?:(?:&nbsp;|\s)+|<[^>]+>)+))?(\d+(?:\.\d+)*)(?![А-Яа-яЁёA-Za-z0-9_])/giu, (match, prefix, label, whitespace, rulesWhitespace, number) => ruleNumbers.has(number) ? `${prefix}${label}${whitespace}${rulesWhitespace || ""}<a href="#rule-${number.replace(/\./g, "-")}">${number}</a>` : match);
  }
  let anchorDepth = 0;
  let linked = normalized.split(/(<[^>]+>)/g).map((part) => {
    if (part.startsWith("<")) {
      if (/^<a\b/i.test(part)) anchorDepth += 1;
      if (/^<\/a>/i.test(part)) anchorDepth = Math.max(0, anchorDepth - 1);
      return part;
    }
    if (anchorDepth > 0) return part;
    if (!isRussianRulesPage) return part;
    return part.replace(/(^|[^А-Яа-яЁёA-Za-z0-9_])(пункт(?:а|е|ом|у|ы|ов|ам|ами|ах)?|п\.)(&nbsp;|\s+)(\d+(?:\.\d+)*)(?![А-Яа-яЁёA-Za-z0-9_])/giu, (match, prefix, label, whitespace, number) => ruleNumbers.has(number) ? `${prefix}${label}${whitespace}<a href="#rule-${number.replace(/\./g, "-")}">${number}</a>` : match);
  }).join("");
  let previous = "";
  while (isRussianRulesPage && linked !== previous) {
    previous = linked;
    linked = linked.replace(/(<\/a>\s*(?:и|,|-|–)\s*)(\d+(?:\.\d+)*)(?![А-Яа-яЁёA-Za-z0-9_])/giu, (match, separator, number) => `${separator}<a href="#rule-${number.replace(/\./g, "-")}">${number}</a>`);
  }
  return linked;
}

function localizedPage(page: { title: string; content: string | null; extras: string | null }, locale: string) {
  if (locale !== "ru" || !page.extras) return { title: page.title, content: page.content };
  try {
    const extras = JSON.parse(page.extras) as { title_rus?: string; content_rus?: string };
    return {
      title: extras.title_rus || page.title,
      content: extras.content_rus || page.content,
    };
  } catch {
    return { title: page.title, content: page.content };
  }
}

const articleTiles = [
  { slug: "mafiya-kak-stil-zhizni", en: "Mafia is a way of life", ru: "«Мафия - это стиль жизни»", authorRu: "Армен Акопджанян" },
  { slug: "mafia-for-beginners", en: "Mafia for beginners", ru: "«Мафия» для новичков" },
  { slug: "balance-and-counterweight-in-the-game", en: "Balance and counterweight in the game", ru: "Баланс и противовес" },
  { slug: "how-to-play-Mafia-if-you-are-Citizen-Strategy", en: "How to play Mafia as a citizen", ru: "Как играть в «Мафию», если вы Мирный житель" },
  { slug: "guessing-in-Mafia", en: "Guessing in Mafia", ru: "Угадайка в «Мафии»" },
  { slug: "starting-point-in-Mafia", en: "The starting point in Mafia", ru: "Точка отсчета в «Мафии»" },
  { slug: "types-of-players-in-Mafia", en: "Types of Mafia players", ru: "Типы игроков в «Мафию»" },
  { slug: "the-zero-round-in-Mafia", en: "The zero round in Mafia", ru: "Нулевой круг в «Мафии»" },
  { slug: "conflicts-in-Mafia", en: "Conflicts in the game of Mafia", ru: "Конфликты в игре «Мафия»" },
  { slug: "evaluation-and-other-nuances-of-the-game", en: "Table evaluation and game nuances", ru: "Оценка стола и нюансы игры" },
  { slug: "tilt-in-Mafia", en: "Tilt in Mafia", ru: "Тильт в «Мафии»" },
  { slug: "mafia-for-5-players", en: "Mafia for five players", ru: "Мафия на 5 игроков" },
  { slug: "life-is-like-a-game", en: "Life is like a game", ru: "Жизнь как игра" },
  { slug: "Poker-terms-for-players-in-the-Mafia", en: "Poker terms for Mafia players", ru: "Покерные термины для игроков в «Мафию»" },
  { slug: "Nine-sins-of-players-in-the-Mafia", en: "Nine sins of Mafia players", ru: "Девять грехов игроков в «Мафию»" },
];

const articleSections = [
  { en: "Interview", ru: "Интервью", slugs: ["mafiya-kak-stil-zhizni"] },
  { en: "Game basics", ru: "Основы игры", slugs: ["mafia-for-beginners", "balance-and-counterweight-in-the-game", "how-to-play-Mafia-if-you-are-Citizen-Strategy", "guessing-in-Mafia", "starting-point-in-Mafia", "types-of-players-in-Mafia", "the-zero-round-in-Mafia", "conflicts-in-Mafia", "evaluation-and-other-nuances-of-the-game"] },
  { en: "Advanced", ru: "Продвинутый уровень", slugs: ["tilt-in-Mafia"] },
  { en: "Featured articles", ru: "Развлекательные статьи", slugs: ["mafia-for-5-players", "life-is-like-a-game", "Poker-terms-for-players-in-the-Mafia", "Nine-sins-of-players-in-the-Mafia"] },
];

export default async function LocalizedGenericPage({ params }: { params: Promise<{ locale: string; slug: string[] }> }) {
  const { locale, slug } = await params;
  const pageSlug = slug.join("/");
  let page;
  try {
    page = await getPage(pageSlug);
  } catch {
    if (slug[0] !== "mafworldcup-history" || slug.length < 2) notFound();
    try { page = await getPage(slug[slug.length - 1]); } catch { notFound(); }
  }
  const localized = localizedPage(page, locale);
  if (pageSlug === "articles") {
    return <main className="GenericPage ArticlesPage"><div className="container"><div className="archive-title"><div className="left_line lineDef" /><h1 className="title_name">{localized.title}</h1><div className="right_line lineDef" /></div><article className="MainCont"><div className="article-sections">{articleSections.map((section) => <section className="article-section" key={section.en}><h2 className="article-section-title">{locale === "ru" ? section.ru : section.en}</h2><div className="article-grid">{section.slugs.map((slug) => { const article = articleTiles.find((item) => item.slug === slug)!; return <a className="article-tile" href={`/${locale}/${article.slug}`} key={article.slug}>{locale === "ru" && article.authorRu && <span className="article-author">{article.authorRu}</span>}<span className="article-title">{locale === "ru" ? article.ru : article.en}</span></a>; })}</div></section>)}</div></article></div></main>;
  }
  const pageClass = pageSlug.startsWith("mafworldcup-history/")
    ? "GenericPage WorldCupHistoryChild"
    : pageSlug === "the-game" ? "GenericPage GameRulesPage" : pageSlug === "history" ? "GenericPage GameRulesPage HistoryPage" : pageSlug === "articles" ? "GenericPage ArticlesPage" : "GenericPage";
  const articleClass = articleTiles.some((article) => article.slug === pageSlug) ? " ArticlePage" : "";
  const isNinthWorldCup = pageSlug === "mafworldcup-history/the-9th-annual-maf-world-cup";
  const normalizedContent = normalizeInternalLinks(localized.content ?? "", pageSlug, locale);
  const content = (isNinthWorldCup
    ? normalizedContent
      .replace(/(<div>\s*)<div>\s*<h2\b[^>]*>\s*(?:История|History)\s*<\/h2>[\s\S]*?<\/div>(\s*<div>)/i, "$1$2")
      .replace(/(<h2\b[^>]*>\s*(?:Лучшие 10 игроков турнира|Top 10 players)\s*<\/h2>)([\s\S]*?)(?=<\/div>)/i, (_, heading, playerContent) => {
        const players = [...playerContent.matchAll(/<h3\b[^>]*>([\s\S]*?)<\/h3>/gi)].map((match) => match[1].trim());
        return `${heading}<table><thead><tr><th>Rank</th><th>Name</th></tr></thead><tbody>${players.map((player, index) => `<tr><td>${String(index + 1).padStart(2, "0")}</td><td>${player}</td></tr>`).join("")}</tbody></table>`;
      })
    : normalizedContent
  ).replace(isNinthWorldCup ? /<h3>\s*August 6-9, (?:2019|2020)\s*<\/h3>/i : /$^/, "");
  let photoGallery = null;
  if (isNinthWorldCup) {
    try { photoGallery = await getPhotoGallery("9th-annual-maf-world-cup"); } catch { photoGallery = null; }
  }
  const videoStart = content.search(/<h2\b[^>]*>\s*(?:Видео|Video)\s*<\/h2>/i);
  const contentBeforeVideo = videoStart >= 0 ? content.slice(0, videoStart) : content;
  const contentFromVideo = videoStart >= 0 ? content.slice(videoStart) : "";
  const photoFallback = assetUrl(photoGallery?.preview) ?? "/build/img/not_img.jpg";
  const photoItems = photoGallery?.photos.map((photo) => ({
    original: assetUrl(photo) ?? photoFallback,
    thumbnail: assetUrl(photo) ?? photoFallback,
    originalAlt: `${localized.title} photo`,
    thumbnailAlt: `${localized.title} thumbnail`,
  })) ?? [];
  return <main className={`${pageClass}${articleClass}`}><div className="container"><div className="archive-title"><div className="left_line lineDef" /><h1 className="title_name">{localized.title}</h1>{isNinthWorldCup && <p className="archive-subtitle">August 6-9, 2020</p>}<div className="right_line lineDef" /></div><article className="MainCont"><div suppressHydrationWarning dangerouslySetInnerHTML={{ __html: contentBeforeVideo }} />{photoItems.length > 0 && <section className="world-cup-photos"><h2>{locale === "ru" ? "Фото" : "Photos"}</h2><PhotoGalleryWidget photos={photoItems} title={localized.title} /></section>}{contentFromVideo && <div className="world-cup-video-section" suppressHydrationWarning dangerouslySetInnerHTML={{ __html: contentFromVideo }} />}</article></div></main>;
}
