import { test, expect } from '@playwright/test';

async function login(page, username) {
    await page.goto('/login');
    await page.getByLabel('Username').fill(username);
    await page.getByLabel('Kata Sandi', { exact: true }).fill('Password123!');
    await page.getByRole('button', { name: 'Masuk' }).click();
}

test('admin dashboard and inventory search work', async ({ page }) => {
    const errors = [];
    page.on('pageerror', error => errors.push(error.message));
    await login(page, 'admin');
    await expect(page).toHaveURL(/dashboard$/);
    await expect(page.getByRole('heading', { name: 'Tren penjualan' })).toBeVisible();
    await page.getByRole('link', { name: 'Inventori barang' }).click();
    await expect(page.locator('#inventory-table tbody tr')).toHaveCount(10);
    await page.getByRole('searchbox').fill('BRG-001');
    await expect(page.locator('#inventory-table tbody tr')).toHaveCount(1);
    await expect(page.getByRole('cell', { name: 'Air Mineral 600ml', exact: true })).toBeVisible();
    await page.screenshot({ path: 'test-results/inventory.png', fullPage: true });
    expect(errors).toEqual([]);
});

test('cashier cart calculates totals and blocks underpayment', async ({ page }) => {
    const errors = [];
    page.on('pageerror', error => errors.push(error.message));
    await login(page, 'kasir');
    await expect(page).toHaveURL(/pos$/);
    await page.getByRole('textbox', { name: 'Cari barang' }).fill('BRG-001');
    const product = page.locator('.product').filter({ hasText: 'Air Mineral 600ml' });
    await product.click();
    await page.getByRole('button', { name: 'Tambah jumlah' }).click();
    await expect(page.getByRole('spinbutton', { name: 'Jumlah Air Mineral 600ml' })).toHaveValue('2');
    const checkout = page.getByRole('button', { name: 'Proses pembayaran' });
    await expect(checkout).toBeDisabled();
    await page.getByRole('button', { name: 'Uang pas' }).click();
    await expect(page.getByLabel('Uang diterima (Rp)')).toHaveValue('8000');
    await expect(checkout).toBeEnabled();
    await page.getByLabel('Uang diterima (Rp)').fill('10000');
    await expect(page.getByText('Rp. 2.000', { exact: true })).toBeVisible();
    await page.screenshot({ path: 'test-results/pos-desktop.png', fullPage: true });
    await page.setViewportSize({ width: 390, height: 844 });
    await expect.poll(async () => (await page.locator('#sidebar').boundingBox()).x).toBeLessThanOrEqual(-200);
    await expect(checkout).toBeVisible();
    expect(await page.evaluate(() => document.documentElement.scrollWidth <= innerWidth)).toBe(true);
    await page.screenshot({ path: 'test-results/pos-mobile.png', fullPage: true });
    await page.getByRole('button', { name: 'Buka menu' }).click();
    await expect(page.getByRole('link', { name: 'Penjualan hari ini' })).toBeVisible();
    await expect(page.getByRole('link', { name: 'Inventori barang' })).toHaveCount(0);
    await page.getByRole('button', { name: 'Tutup menu' }).click();
    await expect.poll(async () => (await page.locator('#sidebar').boundingBox()).x).toBeLessThanOrEqual(-200);
    expect(errors).toEqual([]);
});
