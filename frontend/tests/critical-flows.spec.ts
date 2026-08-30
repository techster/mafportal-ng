import { expect, test, type APIRequestContext, type Page } from "@playwright/test";

const backendURL = "http://127.0.0.1:8001";

type TournamentSummary = { slug: string | null; title: string };
type TournamentDetail = TournamentSummary & {
  rating?: unknown[];
  schedule?: { players: unknown[] }[];
};
type ClubSummary = { slug: string | null; title: string };
type ClubDetail = ClubSummary & {
  image?: string | null;
  events?: unknown[];
  photo_galleries?: unknown[];
  video_galleries?: unknown[];
};
type PhotoGallery = { slug: string; title: string; photos: string[] };

async function getJson<T>(request: APIRequestContext, path: string): Promise<T> {
  const response = await request.get(`${backendURL}${path}`);
  expect(response.ok()).toBeTruthy();
  return response.json() as Promise<T>;
}

async function findTournamentWithGames(request: APIRequestContext): Promise<TournamentDetail> {
  const tournaments = await getJson<TournamentSummary[]>(request, "/api/v1/tournaments");
  for (const tournament of tournaments) {
    if (!tournament.slug) continue;
    const detail = await getJson<TournamentDetail>(request, `/api/v1/tournaments/${tournament.slug}`);
    if (detail.schedule?.length) return detail;
  }
  throw new Error("Expected at least one tournament with scheduled games");
}

async function expectImageLoaded(image: ReturnType<Page["locator"]>) {
  await expect(image).toBeVisible();
  await expect.poll(
    () => image.evaluate((element: HTMLImageElement) => element.complete ? element.naturalWidth : 0),
  ).toBeGreaterThan(0);
  expect(await image.getAttribute("src")).not.toMatch(/^http:\/\/127\.0\.0\.1:8001\/assets\//);
}

test("tournament detail renders ratings and expandable game schedule", async ({ page, request }) => {
  const tournament = await findTournamentWithGames(request);

  await page.goto(`/tournaments/${tournament.slug}`);

  await expect(page.getByRole("heading", { level: 1, name: tournament.title })).toBeVisible();
  await expect(page.locator(".game-accordion-item")).toHaveCount(tournament.schedule?.length ?? 0);
  await page.locator(".game-accordion-item summary").first().click();
  await expect(page.locator(".game-accordion-item").first()).toHaveAttribute("open", "");
  await expect(page.locator(".game-accordion-panel").first()).toBeVisible();

  if (tournament.rating?.length) {
    await expect(page.locator(".rating-table tbody tr")).toHaveCount(tournament.rating.length);
    await expectImageLoaded(page.locator(".rating-table .player-avatar").first());
  }

  await page.locator(".language").click();
  await expect(page).toHaveURL(new RegExp(`/ru/tournaments/${tournament.slug}$`));
});

test("club detail renders API-backed optional sections", async ({ page, request }) => {
  const clubs = await getJson<ClubSummary[]>(request, "/api/v1/clubs");
  const clubSummary = clubs.find((club) => club.slug);
  expect(clubSummary).toBeTruthy();
  const club = await getJson<ClubDetail>(request, `/api/v1/clubs/${clubSummary?.slug}`);

  await page.goto(`/clubs/${club.slug}`);

  await expect(page.locator(".club-nav")).toHaveCount(0);
  await expect(page.locator(".breadcrumb.container")).toHaveCount(0);
  await expect(page.getByRole("heading", { level: 2, name: "About" })).toBeVisible();
  if (club.image) {
    const hero = page.locator(".club-hero");
    await expect(hero).toHaveCSS("background-image", /assets\/clubs\//);
    const imageUrl = await hero.evaluate((element) => getComputedStyle(element).backgroundImage.match(/^url\(["']?(.*?)["']?\)$/)?.[1]);
    expect(imageUrl).toBeTruthy();
    expect(await page.evaluate((src) => new Promise<number>((resolve) => {
      const image = new Image();
      image.onload = () => resolve(image.naturalWidth);
      image.onerror = () => resolve(0);
      image.src = src;
    }), imageUrl as string)).toBeGreaterThan(0);
  }
  if (club.events?.length) {
    await expect(page.locator("#events article")).toHaveCount(club.events.length);
  }
  const galleryCount = (club.photo_galleries?.length ?? 0) + (club.video_galleries?.length ?? 0);
  if (galleryCount) {
    await expect(page.locator("#gallery .gallery-card")).toHaveCount(galleryCount);
  }
});

test("club country images load from canonical assets", async ({ page }) => {
  await page.goto("/ru/clubs");

  const imageUrls = await page.locator(".country-pic").evaluateAll((elements) => elements
    .map((element) => getComputedStyle(element).backgroundImage.match(/^url\(["']?(.*?)["']?\)$/)?.[1])
    .filter((url): url is string => Boolean(url)));
  expect(imageUrls.length).toBeGreaterThan(0);
  for (const url of imageUrls) {
    expect(new URL(url).pathname).toMatch(/^\/assets\/(?:country|clubs|images)\//);
    expect(await page.evaluate((src) => new Promise<number>((resolve) => {
      const image = new Image();
      image.onload = () => resolve(image.naturalWidth);
      image.onerror = () => resolve(0);
      image.src = src;
    }), url)).toBeGreaterThan(0);
  }
});

test("photo gallery displays thumbnails and advances slides", async ({ page, request }) => {
  const galleries = await getJson<PhotoGallery[]>(request, "/api/v1/galleries/photos");
  const gallery = galleries.find((item) => item.photos.length >= 2);
  expect(gallery).toBeTruthy();

  await page.goto(`/gallery/photo/${gallery?.slug}`);

  await expect(page.getByRole("heading", { level: 1, name: gallery?.title })).toBeVisible();
  await expect(page.locator(".image-gallery-thumbnail")).toHaveCount(gallery?.photos.length ?? 0);
  const thumbnailNavigation = page.getByRole("navigation", { name: "Thumbnail Navigation" });
  const firstThumbnail = thumbnailNavigation.getByRole("button", { name: "Go to Slide 1", exact: true });
  const secondThumbnail = thumbnailNavigation.getByRole("button", { name: "Go to Slide 2", exact: true });
  await expect(firstThumbnail).toHaveAttribute("aria-pressed", "true");
  const currentImage = page.locator(".image-gallery-slide.image-gallery-center .image-gallery-image").first();
  await expectImageLoaded(currentImage);
  await secondThumbnail.click();
  await expect(secondThumbnail).toHaveAttribute("aria-pressed", "true");
  await expectImageLoaded(currentImage);
});

test("mobile navigation opens, closes, and follows localized links", async ({ page }) => {
  await page.setViewportSize({ width: 375, height: 667 });
  await page.goto("/en/");

  const menuButton = page.getByRole("button", { name: "Open menu" });
  await expect(menuButton).toHaveAttribute("aria-expanded", "false");
  await menuButton.click();
  await expect(page.getByRole("button", { name: "Close menu" })).toHaveAttribute("aria-expanded", "true");
  await expect(page.locator(".nav-links")).toHaveClass(/is-open/);
  await page.locator(".nav-links").getByRole("link", { name: "Clubs", exact: true }).click();
  await expect(page).toHaveURL(/\/en\/clubs$/);
});

test("Russian game rules images load from canonical assets", async ({ page }) => {
  await page.goto("/ru/the-game");

  const images = page.locator(".GameRulesPage .MainCont img");
  await expect(images).toHaveCount(5);
  for (let index = 0; index < await images.count(); index += 1) {
    const image = images.nth(index);
    await expect(image).toHaveAttribute("src", /^\/assets\/images\//);
    await expect.poll(
      () => image.evaluate((element: HTMLImageElement) => element.complete ? element.naturalWidth : 0),
    ).toBeGreaterThan(0);
  }
});

test("unknown public detail slugs return a real 404", async ({ page }) => {
  for (const path of [
    "/clubs/missing-record-that-does-not-exist",
    "/tournaments/missing-record-that-does-not-exist",
    "/gallery/photo/missing-record-that-does-not-exist",
  ]) {
    const response = await page.goto(path);
    expect(response?.status()).toBe(404);
    await expect(page.getByText(/not found|could not be found/i)).toBeVisible();
  }
});