import GenericPage from "../[locale]/[...slug]/page";
export default function HistoryPage() { return <GenericPage params={Promise.resolve({ locale: "en", slug: ["history"] })} />; }
