import GenericPage from "../[locale]/[...slug]/page";
export default function MusicPage() { return <GenericPage params={Promise.resolve({ locale: "en", slug: ["music-for-games"] })} />; }
