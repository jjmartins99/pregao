// vite.config.js
import { defineConfig } from "file:///C:/laragon/www/pregao/node_modules/vite/dist/node/index.js";
import laravel from "file:///C:/laragon/www/pregao/node_modules/laravel-vite-plugin/dist/index.js";
import vue from "file:///C:/laragon/www/pregao/node_modules/@vitejs/plugin-vue/dist/index.mjs";
import fs from "fs";
var vite_config_default = defineConfig({
  server: {
    host: "pregao.test",
    port: 5173,
    https: {
      key: fs.readFileSync("./certs/pregao.test.key"),
      cert: fs.readFileSync("./certs/pregao.test.crt")
    }
  },
  plugins: [
    laravel({
      //      input: 'resources/js/app.js',
      input: ["resources/js/main.js"],
      refresh: true
    }),
    vue()
  ]
});
export {
  vite_config_default as default
};
//# sourceMappingURL=data:application/json;base64,ewogICJ2ZXJzaW9uIjogMywKICAic291cmNlcyI6IFsidml0ZS5jb25maWcuanMiXSwKICAic291cmNlc0NvbnRlbnQiOiBbImNvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9kaXJuYW1lID0gXCJDOlxcXFxsYXJhZ29uXFxcXHd3d1xcXFxwcmVnYW9cIjtjb25zdCBfX3ZpdGVfaW5qZWN0ZWRfb3JpZ2luYWxfZmlsZW5hbWUgPSBcIkM6XFxcXGxhcmFnb25cXFxcd3d3XFxcXHByZWdhb1xcXFx2aXRlLmNvbmZpZy5qc1wiO2NvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9pbXBvcnRfbWV0YV91cmwgPSBcImZpbGU6Ly8vQzovbGFyYWdvbi93d3cvcHJlZ2FvL3ZpdGUuY29uZmlnLmpzXCI7aW1wb3J0IHsgZGVmaW5lQ29uZmlnIH0gZnJvbSAndml0ZSc7XG5pbXBvcnQgbGFyYXZlbCBmcm9tICdsYXJhdmVsLXZpdGUtcGx1Z2luJztcbmltcG9ydCB2dWUgZnJvbSAnQHZpdGVqcy9wbHVnaW4tdnVlJztcbmltcG9ydCBmcyBmcm9tICdmcydcblxuZXhwb3J0IGRlZmF1bHQgZGVmaW5lQ29uZmlnKHtcbiAgICBzZXJ2ZXI6e1xuICAgICAgICBob3N0OiAncHJlZ2FvLnRlc3QnLFxuICAgICAgICBwb3J0OiA1MTczLFxuICAgICAgICBodHRwczp7XG4gICAgICAgICAgICBrZXk6ZnMucmVhZEZpbGVTeW5jKCcuL2NlcnRzL3ByZWdhby50ZXN0LmtleScpLFxuICAgICAgICAgICAgY2VydDogZnMucmVhZEZpbGVTeW5jKCcuL2NlcnRzL3ByZWdhby50ZXN0LmNydCcpLFxuICAgICAgICB9LFxuICAgIH0sXG4gICAgcGx1Z2luczogW1xuICAgICAgICBsYXJhdmVsKHtcbiAgICAgIC8vICAgICAgaW5wdXQ6ICdyZXNvdXJjZXMvanMvYXBwLmpzJyxcbiAgICAgICAgICAgIGlucHV0OiBbJ3Jlc291cmNlcy9qcy9tYWluLmpzJ10sXG4gICAgICAgICAgICByZWZyZXNoOiB0cnVlLFxuICAgICAgICB9KSxcbiAgICAgICAgdnVlKCksXG4gICAgXSxcbn0pXG4iXSwKICAibWFwcGluZ3MiOiAiO0FBQXlQLFNBQVMsb0JBQW9CO0FBQ3RSLE9BQU8sYUFBYTtBQUNwQixPQUFPLFNBQVM7QUFDaEIsT0FBTyxRQUFRO0FBRWYsSUFBTyxzQkFBUSxhQUFhO0FBQUEsRUFDeEIsUUFBTztBQUFBLElBQ0gsTUFBTTtBQUFBLElBQ04sTUFBTTtBQUFBLElBQ04sT0FBTTtBQUFBLE1BQ0YsS0FBSSxHQUFHLGFBQWEseUJBQXlCO0FBQUEsTUFDN0MsTUFBTSxHQUFHLGFBQWEseUJBQXlCO0FBQUEsSUFDbkQ7QUFBQSxFQUNKO0FBQUEsRUFDQSxTQUFTO0FBQUEsSUFDTCxRQUFRO0FBQUE7QUFBQSxNQUVKLE9BQU8sQ0FBQyxzQkFBc0I7QUFBQSxNQUM5QixTQUFTO0FBQUEsSUFDYixDQUFDO0FBQUEsSUFDRCxJQUFJO0FBQUEsRUFDUjtBQUNKLENBQUM7IiwKICAibmFtZXMiOiBbXQp9Cg==
