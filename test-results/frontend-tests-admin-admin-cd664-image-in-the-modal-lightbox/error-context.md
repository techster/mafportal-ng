# Instructions

- Following Playwright test failed.
- Explain why, be concise, respect Playwright best practices.
- Provide a snippet of code with the fix, if possible.

# Test info

- Name: frontend\tests\admin.spec.ts >> admin gallery previews >> opens and closes an image in the modal lightbox
- Location: frontend\tests\admin.spec.ts:14:7

# Error details

```
Error: expect(locator).toBeVisible() failed

Locator: locator('.gslide.current .gslide-media > img')
Expected: visible
Timeout: 5000ms
Error: element(s) not found

Call log:
  - Expect "toBeVisible" with timeout 5000ms
  - waiting for locator('.gslide.current .gslide-media > img')

```

```yaml
- dialog:
  - heading [level=4]
  - heading [level=4]
  - heading [level=4]
  - heading [level=4]
  - heading [level=4]
  - heading [level=4]
  - heading [level=4]
  - heading [level=4]
  - heading [level=4]
  - heading [level=4]
  - button "Close":
    - img
  - button "Previous":
    - img
  - button "Next":
    - img
```

# Test source

```ts
  1  | import { expect, test, type Page } from "@playwright/test";
  2  | 
  3  | const adminURL = "http://127.0.0.1:8001";
  4  | 
  5  | async function signIn(page: Page) {
  6  |   await page.goto(`${adminURL}/admin/`);
  7  |   await page.getByLabel("Username").fill("mafportaladmin@gmail.com");
  8  |   await page.getByLabel("Password").fill("admin");
  9  |   await page.getByRole("button", { name: "Sign in" }).click();
  10 |   await expect(page).toHaveURL(`${adminURL}/admin/`);
  11 | }
  12 | 
  13 | test.describe("admin gallery previews", () => {
  14 |   test("opens and closes an image in the modal lightbox", async ({ page }) => {
  15 |     await signIn(page);
  16 |     await page.goto(`${adminURL}/admin/photo_gallery/36/edit`);
  17 | 
  18 |     const thumbnails = page.locator(".gallery-tile.glightbox");
  19 |     await expect(thumbnails).toHaveCount(12);
  20 |     await expect(page.locator(".page-link").first()).toBeVisible();
  21 | 
  22 |     await thumbnails.first().click();
  23 |     await expect(page.locator(".glightbox-container")).toBeVisible();
> 24 |     await expect(page.locator(".gslide.current .gslide-media > img")).toBeVisible();
     |                                                                       ^ Error: expect(locator).toBeVisible() failed
  25 | 
  26 |     await page.locator(".gclose").click();
  27 |     await expect(page.locator(".glightbox-container")).toBeHidden();
  28 |   });
  29 | });
  30 | 
```