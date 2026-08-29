"use client";

import { usePathname } from "next/navigation";
import { useState } from "react";
import { assetUrl } from "../lib/api";

export default function Header() {
  const [menuOpen, setMenuOpen] = useState(false);
  const pathname = usePathname();
  const parts = pathname.split("/").filter(Boolean);
  const locale = parts[0] === "ru" || parts[0] === "en" ? parts[0] : "en";
  const prefix = parts[0] === "ru" || parts[0] === "en" ? `/${locale}` : "";
  const switchLocale = locale === "en" ? "ru" : "en";
  const localized = (path: string) => `${prefix}${path}` || "/";
  const languagePath = `/${switchLocale}${parts[0] === "ru" || parts[0] === "en" ? `/${parts.slice(1).join("/")}` : pathname}`.replace(/\/$/, "") || `/${switchLocale}`;
  const labels = locale === "ru" ? { clubs: "Клубы", game: "Игра", articles: "Статьи", music: "Музыка", history: "История", tournaments: "Турниры", galleries: "Галереи", worldCup: "Кубок мира", openMenu: "Открыть меню", closeMenu: "Закрыть меню" } : { clubs: "Clubs", game: "The Game", articles: "Articles", music: "Music", history: "History", tournaments: "Tournaments", galleries: "Galleries", worldCup: "World Cup", openMenu: "Open menu", closeMenu: "Close menu" };
  return <header className="site-header"><nav className="site-nav container"><a className="brand" href={localized("/")}><img src={assetUrl("images/build/img/logo.svg")} alt="Maf club" /><span className="brand-copy"><span className="brand-name">MafClub</span><span className="brand-tagline">{locale === "ru" ? 'Создатели Игры "Мафия"' : "The Creators of the Game"}</span></span></a><div className={`nav-links${menuOpen ? " is-open" : ""}`}><a href={localized("/clubs")} onClick={() => setMenuOpen(false)}>{labels.clubs}</a><div className="game-menu"><a href={localized("/the-game")} onClick={() => setMenuOpen(false)}>{labels.game}</a><div className="game-submenu"><a href={localized("/articles")}>{labels.articles}</a><a href={localized("/music-for-games")}>{labels.music}</a><a href={localized("/history")}>{labels.history}</a></div></div><div className="tournaments-menu"><a href={localized("/tournaments")} onClick={() => setMenuOpen(false)}>{labels.tournaments}</a><div className="tournaments-submenu"><a href={localized("/gallery")} onClick={() => setMenuOpen(false)}>{labels.galleries}</a></div></div><a href={`/${locale}/mafworldcup-history`} onClick={() => setMenuOpen(false)}>{labels.worldCup}</a></div><div className="header-actions"><a className="language" href={languagePath}>{switchLocale.toUpperCase()}</a><button className="menu-toggle" type="button" aria-expanded={menuOpen} aria-label={menuOpen ? labels.closeMenu : labels.openMenu} onClick={() => setMenuOpen((open) => !open)}>{menuOpen ? "×" : "☰"}</button></div></nav></header>;
}
