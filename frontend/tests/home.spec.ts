import { expect, test, type Page } from "@playwright/test";

async function expectLoadedImages(page: Page) {
  const failedImageUrls: string[] = [];
  page.on("response", (response) => {
    if (response.request().resourceType() === "image" && !response.ok()) {
      failedImageUrls.push(`${response.status()} ${response.url()}`);
    }
  });

  await page.waitForLoadState("networkidle");
  const images = page.locator("img");
  const count = await images.count();
  expect(count).toBeGreaterThan(0);
  for (let index = 0; index < count; index += 1) {
    const imageSrc = await images.nth(index).getAttribute("src");
    await expect.poll(() => images.nth(index).evaluate((image: HTMLImageElement) => image.naturalWidth), { message: `Image did not decode: ${imageSrc}` }).toBeGreaterThan(0);
  }
  expect(failedImageUrls).toEqual([]);
  expect(await images.evaluateAll((items) => items.map((item) => (item as HTMLImageElement).currentSrc))).not.toContainEqual(
    expect.stringMatching(/^http:\/\/127\.0\.0\.1:8001\/assets\//),
  );
}

test("home page matches the legacy public shell", async ({ page }) => {
  await page.goto("/en/");

  await expect(page).toHaveTitle('MafClub - создатели игры "Мафия" | Play "Mafia" game with us!');
  await expect(page.getByRole("heading", { name: "History of the Legend" })).toBeVisible();
  await expect(page.getByText("Photo Gallery").first()).toBeVisible();
  await expect(page.getByText("Video Gallery").first()).toBeVisible();
  await expectLoadedImages(page);
});

test("homepage feature backgrounds load from canonical assets", async ({ page }) => {
  await page.goto("/ru");

  await expect.poll(() => page.locator(".Carusel").evaluate((element) => getComputedStyle(element).backgroundSize)).toContain("cover");
  await expect.poll(() => page.locator(".Carusel").evaluate((element) => getComputedStyle(element).backgroundRepeat.split(",").at(-1)?.trim())).toBe("no-repeat");
  await expect.poll(() => page.locator(".HomeArticles .article-tile").first().evaluate((element) => getComputedStyle(element).backgroundSize)).toContain("cover");
  await expect.poll(() => page.locator(".HomeArticles .article-tile").first().evaluate((element) => getComputedStyle(element).backgroundRepeat.split(",").at(-1)?.trim())).toBe("no-repeat");

  for (const selector of [".Carusel", ".AboutBox .image", ".HomeArticles .article-tile"]) {
    const backgroundUrl = await page.locator(selector).first().evaluate((element) => {
      const matches = [...getComputedStyle(element).backgroundImage.matchAll(/url\(["']?(.*?)["']?\)/g)];
      return matches.length ? new URL(matches.at(-1)?.[1] ?? "", window.location.href).href : undefined;
    });
    expect(backgroundUrl).toMatch(/^https?:\/\/127\.0\.0\.1:3000\/assets\/images\//);
    expect(await page.evaluate((src) => new Promise<number>((resolve) => {
      const image = new Image();
      image.onload = () => resolve(image.naturalWidth);
      image.onerror = () => resolve(0);
      image.src = src;
    }), backgroundUrl as string)).toBeGreaterThan(0);
  }
});

test("articles archive cards use the canonical article background", async ({ page }) => {
  await page.goto("/ru/articles");

  const card = page.locator(".ArticlesPage .article-tile").first();
  await expect(card).toBeVisible();
  await expect.poll(() => card.evaluate((element) => getComputedStyle(element).backgroundSize)).toContain("cover");
  await expect.poll(() => card.evaluate((element) => getComputedStyle(element).backgroundRepeat.split(",").at(-1)?.trim())).toBe("no-repeat");
  const backgroundUrl = await card.evaluate((element) => {
    const matches = [...getComputedStyle(element).backgroundImage.matchAll(/url\(["']?(.*?)["']?\)/g)];
    return matches.length ? new URL(matches.at(-1)?.[1] ?? "", window.location.href).href : undefined;
  });
  expect(backgroundUrl).toBe("http://127.0.0.1:3000/assets/images/53438d2a1105a08374e43dbbc9f8211c.jpg");
  await expect.poll(() => page.evaluate((src) => new Promise<number>((resolve) => {
    const image = new Image();
    image.onload = () => resolve(image.naturalWidth);
    image.onerror = () => resolve(0);
    image.src = src;
  }), backgroundUrl as string)).toBeGreaterThan(0);
});

test("every Russian article archive link opens with loaded images", async ({ page }) => {
  await page.goto("/ru/articles");

  const articleLinks = await page.locator(".ArticlesPage .article-tile").evaluateAll((links) =>
    [...new Set(links.map((link) => (link as HTMLAnchorElement).href))],
  );
  expect(articleLinks).toHaveLength(15);

  for (const articleLink of articleLinks) {
    await test.step(articleLink, async () => {
      await page.goto(articleLink);
      await expectLoadedImages(page);
      const imageLayouts = await page.locator(".ArticlePage .MainCont img").evaluateAll((images) => images.map((image) => {
        const element = image as HTMLImageElement;
        const style = getComputedStyle(element);
        const rect = element.getBoundingClientRect();
        return {
          naturalRatio: element.naturalWidth / element.naturalHeight,
          renderedRatio: rect.width / rect.height,
          margins: [style.marginTop, style.marginRight, style.marginBottom, style.marginLeft].map(parseFloat),
        };
      }));
      for (const imageLayout of imageLayouts) {
        expect(Math.abs(imageLayout.renderedRatio - imageLayout.naturalRatio)).toBeLessThan(0.03);
        expect(imageLayout.margins.every((margin) => margin >= 20)).toBe(true);
      }
    });
  }
});

test("every Russian World Cup history link opens with loaded images", async ({ page }) => {
  await page.goto("/ru/mafworldcup-history");

  const historyLinks = await page.locator("main.WorldCupHistory a[href]").evaluateAll((links) =>
    [...new Set(links.map((link) => (link as HTMLAnchorElement).href).filter((href) => href.includes("/ru/mafworldcup-history/")))],
  );
  expect(historyLinks.length).toBeGreaterThan(0);

  for (const historyLink of historyLinks) {
    await test.step(historyLink, async () => {
      await page.goto(historyLink);
      await expectLoadedImages(page);
    });
  }
});

test("clubs and tournaments pages render their route shells", async ({ page }) => {
  await page.goto("/clubs");
  await expect(page.getByRole("heading", { name: "Clubs" })).toBeVisible();

  await page.goto("/tournaments");
  await expect(page.getByRole("heading", { name: "Tournaments" })).toBeVisible();
  await expectLoadedImages(page);
});
