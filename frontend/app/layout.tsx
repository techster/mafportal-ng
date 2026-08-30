import type { Metadata } from "next";
import "./globals.css";
import "react-image-gallery/styles/image-gallery.css";
import Header from "./Header";
import Footer from "./Footer";

export const metadata: Metadata = {
  title: 'MafClub - создатели игры "Мафия" | Play "Mafia" game with us!',
  description: "Play Mafia with MafClub.",
};

export default function RootLayout({
  children,
}: Readonly<{
  children: React.ReactNode;
}>) {
  const mediaBase = process.env.NEXT_PUBLIC_MEDIA_PUBLIC_BASE_URL ?? "/assets";
  const mediaBackground = `url("${mediaBase.replace(/\/$/, "")}/images/_MG_7550.jpg")`;
  return (
    <html lang="en">
      <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" />
      </head>
      <body style={{ "--media-background": mediaBackground } as React.CSSProperties}>
        <Header />
        {children}
        <Footer />
      </body>
    </html>
  );
}
