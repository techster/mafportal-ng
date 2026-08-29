import { expect, test, type Page } from "@playwright/test";

const adminURL = "http://127.0.0.1:8001";

async function signIn(page: Page) {
  await page.goto(`${adminURL}/admin/`);
  await page.getByLabel("Username").fill("mafportaladmin@gmail.com");
  await page.getByLabel("Password").fill("admin");
  await page.getByRole("button", { name: "Sign in" }).click();
  await expect(page).toHaveURL(`${adminURL}/admin/`);
}

test.describe("admin gallery previews", () => {
  test("opens and closes an image in the modal lightbox", async ({ page }) => {
    await signIn(page);
    await page.goto(`${adminURL}/admin/photo_gallery/36/edit`);

    const thumbnails = page.locator(".gallery-tile.glightbox");
    await expect(thumbnails).toHaveCount(12);
    await expect(page.locator(".page-link").first()).toBeVisible();

    await thumbnails.first().click();
    await expect(page.locator(".glightbox-container")).toBeVisible();
    await expect(page.locator(".gslide.current .gslide-media > img")).toBeVisible();

    await page.locator(".gclose").click();
    await expect(page.locator(".glightbox-container")).toBeHidden();
  });
});
