import GenericPage from "../[locale]/[...slug]/page";
export default function TheGamePage() { return <GenericPage params={Promise.resolve({ locale: "en", slug: ["the-game"] })} />; }
