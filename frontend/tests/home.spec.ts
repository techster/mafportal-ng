import { expect, test } from "@playwright/test";

test("home page matches the legacy public shell", async ({ page }) => {
  await page.goto("/en/");

  await expect(page).toHaveTitle('MafClub - создатели игры "Мафия" | Play "Mafia" game with us!');
  await expect(page.getByRole("heading", { name: "History of the Legend" })).toBeVisible();
  await expect(page.getByText("Photo Gallery").first()).toBeVisible();
  await expect(page.getByText("Video Gallery").first()).toBeVisible();
});

test("clubs and tournaments pages render their route shells", async ({ page }) => {
  await page.goto("/clubs");
  await expect(page.getByRole("heading", { name: "Clubs" })).toBeVisible();

  await page.goto("/tournaments");
  await expect(page.getByRole("heading", { name: "Tournaments" })).toBeVisible();
});
