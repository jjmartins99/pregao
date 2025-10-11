# PREGÃO - Vue SPA (Tailwind) scaffold

This archive contains a minimal Vue 3 SPA scaffold with TailwindCSS ready to drop into a Laravel project.

## Quick setup (inside your project)

1. Copy the `resources/` directory into your Laravel project root.
2. Copy `package.json`, `vite.config.js`, `postcss.config.js`, `tailwind.config.js` into your project root.
3. Run (you may need --legacy-peer-deps depending on npm version):
   - `npm install`
   - `npx tailwindcss -i ./resources/css/app.css -o ./public/css/app.css --watch` or use Vite dev: `npm run dev`
4. Add a route in `routes/web.php` to serve the SPA:
```php
Route::view('/app', 'app');
```
5. Visit `/app` in your browser.

This is intentionally minimal and designed to be a working starting point. Customize components, styles and build pipeline to match your production requirements.
