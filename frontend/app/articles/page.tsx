import GenericPage from "../[locale]/[...slug]/page";
export default function ArticlesPage() { return <GenericPage params={Promise.resolve({ locale: "en", slug: ["articles"] })} />; }
