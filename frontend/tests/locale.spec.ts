import { expect, test } from "@playwright/test";

const russianNavigation = ["Клубы", "Игра", "Статьи", "Музыка", "История", "Турниры", "Галереи", "Кубок мира"];
const englishNavigation = ["Clubs", "The Game", "Articles", "Music", "History", "Tournaments", "Galleries", "World Cup"];
const publicRoutes = ["", "/clubs", "/tournaments", "/gallery", "/news", "/articles", "/history", "/the-game", "/music-for-games", "/mafworldcup-history"];

test.describe("localized public pages", () => {
  for (const route of publicRoutes) {
    test(`Russian navigation is localized on /ru${route || "/"}`, async ({ page }) => {
      await page.goto(`/ru${route}`);
      await expect(page.locator(".nav-links a")).toHaveText(russianNavigation);
      await expect(page.locator(".game-submenu a")).toHaveText(russianNavigation.slice(2, 5));
      await expect(page.locator(".site-footer")).toContainText("Все права защищены");
    });

    test(`English navigation is localized on /en${route || "/"}`, async ({ page }) => {
      await page.goto(`/en${route}`);
      await expect(page.locator(".nav-links a")).toHaveText(englishNavigation);
      await expect(page.locator(".game-submenu a")).toHaveText(englishNavigation.slice(2, 5));
      await expect(page.locator(".site-footer")).toContainText("All Rights Reserved");
    });
  }

  test("Russian archive labels and mobile filter are localized", async ({ page }) => {
    await page.goto("/ru/tournaments");
    await expect(page.getByRole("heading", { name: "Турниры" })).toBeVisible();
    await expect(page.locator(".TournamentYearSelect option").first()).toHaveText("Все годы");
    await page.goto("/ru/gallery");
    await expect(page.getByRole("heading", { name: "Галерея" })).toBeVisible();
    await expect(page.locator(".gallery-heading")).toHaveText(["Фото альбом", "Видео альбом"]);
    await page.goto("/ru/news");
    await expect(page.getByRole("heading", { name: "Новости" })).toBeVisible();
  });

  test("English archive labels remain English", async ({ page }) => {
    await page.goto("/en/tournaments");
    await expect(page.getByRole("heading", { name: "Tournaments" })).toBeVisible();
    await expect(page.locator(".TournamentYearSelect option").first()).toHaveText("All years");
    await page.goto("/en/gallery");
    await expect(page.getByRole("heading", { name: "Gallery" })).toBeVisible();
    await expect(page.locator(".gallery-heading")).toHaveText(["Photo Albums", "Video Albums"]);
    await page.goto("/en/news");
    await expect(page.getByRole("heading", { name: "News" })).toBeVisible();
  });
});
