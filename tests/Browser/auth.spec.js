import { test, expect } from '@playwright/test';

test('login and registration share a centered responsive card', async ({ page }) => {
    for (const viewport of [{ width: 1440, height: 1000 }, { width: 390, height: 844 }]) {
        await page.setViewportSize(viewport);
        await page.goto('/login');
        await expect(page.getByLabel('Username')).toBeVisible();
        await expect(page.getByLabel('Ingat saya')).toBeVisible();
        await expect(page.locator('.login-story')).toHaveCount(0);
        const loginCard = await page.locator('.auth-card').boundingBox();
        expect(Math.abs(loginCard.x + loginCard.width / 2 - viewport.width / 2)).toBeLessThan(2);
        await page.getByRole('link', { name: 'Daftar sekarang' }).click();
        await expect(page).toHaveURL(/register$/);
        for (const label of ['Nama Lengkap', 'Username', 'Kata Sandi', 'Konfirmasi Kata Sandi']) {
            await expect(page.getByLabel(label, { exact: true })).toBeVisible();
        }
        const registrationCard = await page.locator('.auth-card').boundingBox();
        expect(Math.abs(registrationCard.x + registrationCard.width / 2 - viewport.width / 2)).toBeLessThan(2);
        expect(await page.evaluate(() => document.documentElement.scrollWidth <= innerWidth)).toBe(true);
        await page.screenshot({ path: `test-results/register-${viewport.width}.png`, fullPage: true });
        await page.getByRole('link', { name: 'Masuk di sini' }).click();
        await expect(page).toHaveURL(/login$/);
    }
});
