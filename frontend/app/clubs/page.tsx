import { assetUrl, getClubs, getCountries, type Club, type Country } from "../../lib/api";

export default async function ClubsPage({ locale = "en" }: { locale?: string }) {
  let clubs: Club[] = [];
  let countries: Country[] = [];
  let unavailable = false;

  try {
    [clubs, countries] = await Promise.all([getClubs(), getCountries()]);
  } catch {
    unavailable = true;
  }

  const russian = locale === "ru";
  const prefix = locale ? `/${locale}` : "";
  const labels = russian ? { title: "Клубы", error: "Сервис данных временно недоступен." } : { title: "Clubs", error: "The Python API is unavailable. Start the backend on port 8011." };
  return (
    <main className="ClubsPage"><div className="container">
      <div className="archive-title"><div className="left_line lineDef" /><h1 className="title_name">{labels.title}</h1><div className="right_line lineDef" /></div>
      <div className="page-line" />
      {unavailable ? (
        <div className="empty">{labels.error}</div>
      ) : (
        <div className="clubList">
          {countries.map((country) => {
            const countryClubs = clubs.filter((club) => club.country_id === country.id);
            if (!countryClubs.length) return null;
            return (
              <section className="club-item" key={country.id}>
                <div className="country">{country.title}</div>
                <div className="country-pic" style={country.image ? { backgroundImage: `url(${assetUrl(country.image)})` } : country.title === "Legendary Clubs" ? { backgroundImage: `url(${assetUrl("/uploads/clubs/USA/black-cat/image1.jpeg")})` } : undefined} />
                <div className="cityList">
                  {countryClubs.map((club) => <a href={`${prefix}/clubs/${club.slug ?? club.id}`} key={club.id}>{club.title}</a>)}
                </div>
                {country.description && <div className="country-desc" dangerouslySetInnerHTML={{ __html: country.description }} />}
              </section>
            );
          })}
        </div>
      )}
    </div></main>
  );
}
