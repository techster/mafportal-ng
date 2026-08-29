"use client";

import { usePathname } from "next/navigation";

export default function Footer() {
  const russian = usePathname().split("/").filter(Boolean)[0] === "ru";
  const copyright = russian
    ? `MAF является зарегистрированным товарным знаком MAF CLUB, INC., единственной корпорации, сертифицированной для проведения мероприятий, связанных с МАФ. © 1992 - ${new Date().getFullYear()} Maf Club, Inc. Все права защищены.`
    : `MAF is a registered trademark of MAF CLUB, INC., The only corporation certified to conduct business of MAF related events. © 1992 - ${new Date().getFullYear()} Maf Club, Inc. All Rights Reserved.`;
  return <footer className="site-footer"><div className="container footer-inner"><div className="footer-brand">MafClub</div><div>{copyright}</div></div></footer>;
}