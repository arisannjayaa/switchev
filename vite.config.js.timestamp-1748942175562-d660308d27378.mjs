// vite.config.js
import { defineConfig } from "file:///C:/laragon/www/pelayanan-surat/node_modules/vite/dist/node/index.js";
import laravel from "file:///C:/laragon/www/pelayanan-surat/node_modules/laravel-vite-plugin/dist/index.js";
var vite_config_default = defineConfig({
  plugins: [
    laravel({
      input: [
        "resources/css/app.css",
        "resources/js/app.js",
        "resources/js/apps/auth/login.js",
        "resources/js/apps/utils/helper.js",
        "resources/js/apps/auth/register.js",
        "resources/js/apps/user/user.js",
        "resources/js/apps/conversion/conversion.js",
        "resources/js/apps/mechanical/mechanical.js",
        "resources/js/apps/equipment/equipment.js",
        "resources/js/apps/certificate/certificate.js",
        "resources/js/apps/test-letter/test_letter.js",
        "resources/js/apps/test-letter/spu.js",
        "resources/js/apps/test-letter/certificate.js",
        "resources/js/apps/test-letter/permohonan-srut.js",
        "resources/js/apps/template-certificate/template.js"
      ],
      refresh: true
    })
  ]
});
export {
  vite_config_default as default
};
//# sourceMappingURL=data:application/json;base64,ewogICJ2ZXJzaW9uIjogMywKICAic291cmNlcyI6IFsidml0ZS5jb25maWcuanMiXSwKICAic291cmNlc0NvbnRlbnQiOiBbImNvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9kaXJuYW1lID0gXCJDOlxcXFxsYXJhZ29uXFxcXHd3d1xcXFxwZWxheWFuYW4tc3VyYXRcIjtjb25zdCBfX3ZpdGVfaW5qZWN0ZWRfb3JpZ2luYWxfZmlsZW5hbWUgPSBcIkM6XFxcXGxhcmFnb25cXFxcd3d3XFxcXHBlbGF5YW5hbi1zdXJhdFxcXFx2aXRlLmNvbmZpZy5qc1wiO2NvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9pbXBvcnRfbWV0YV91cmwgPSBcImZpbGU6Ly8vQzovbGFyYWdvbi93d3cvcGVsYXlhbmFuLXN1cmF0L3ZpdGUuY29uZmlnLmpzXCI7aW1wb3J0IHsgZGVmaW5lQ29uZmlnIH0gZnJvbSAndml0ZSc7XG5pbXBvcnQgbGFyYXZlbCBmcm9tICdsYXJhdmVsLXZpdGUtcGx1Z2luJztcblxuZXhwb3J0IGRlZmF1bHQgZGVmaW5lQ29uZmlnKHtcbiAgICBwbHVnaW5zOiBbXG4gICAgICAgIGxhcmF2ZWwoe1xuICAgICAgICAgICAgaW5wdXQ6IFtcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL2Nzcy9hcHAuY3NzJyxcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL2pzL2FwcC5qcycsXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9qcy9hcHBzL2F1dGgvbG9naW4uanMnLFxuICAgICAgICAgICAgICAgICdyZXNvdXJjZXMvanMvYXBwcy91dGlscy9oZWxwZXIuanMnLFxuICAgICAgICAgICAgICAgICdyZXNvdXJjZXMvanMvYXBwcy9hdXRoL3JlZ2lzdGVyLmpzJyxcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL2pzL2FwcHMvdXNlci91c2VyLmpzJyxcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL2pzL2FwcHMvY29udmVyc2lvbi9jb252ZXJzaW9uLmpzJyxcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL2pzL2FwcHMvbWVjaGFuaWNhbC9tZWNoYW5pY2FsLmpzJyxcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL2pzL2FwcHMvZXF1aXBtZW50L2VxdWlwbWVudC5qcycsXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9qcy9hcHBzL2NlcnRpZmljYXRlL2NlcnRpZmljYXRlLmpzJyxcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL2pzL2FwcHMvdGVzdC1sZXR0ZXIvdGVzdF9sZXR0ZXIuanMnLFxuICAgICAgICAgICAgICAgICdyZXNvdXJjZXMvanMvYXBwcy90ZXN0LWxldHRlci9zcHUuanMnLFxuICAgICAgICAgICAgICAgICdyZXNvdXJjZXMvanMvYXBwcy90ZXN0LWxldHRlci9jZXJ0aWZpY2F0ZS5qcycsXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9qcy9hcHBzL3Rlc3QtbGV0dGVyL3Blcm1vaG9uYW4tc3J1dC5qcycsXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9qcy9hcHBzL3RlbXBsYXRlLWNlcnRpZmljYXRlL3RlbXBsYXRlLmpzJyxcbiAgICAgICAgICAgIF0sXG4gICAgICAgICAgICByZWZyZXNoOiB0cnVlLFxuICAgICAgICB9KSxcbiAgICBdLFxufSk7XG4iXSwKICAibWFwcGluZ3MiOiAiO0FBQW9SLFNBQVMsb0JBQW9CO0FBQ2pULE9BQU8sYUFBYTtBQUVwQixJQUFPLHNCQUFRLGFBQWE7QUFBQSxFQUN4QixTQUFTO0FBQUEsSUFDTCxRQUFRO0FBQUEsTUFDSixPQUFPO0FBQUEsUUFDSDtBQUFBLFFBQ0E7QUFBQSxRQUNBO0FBQUEsUUFDQTtBQUFBLFFBQ0E7QUFBQSxRQUNBO0FBQUEsUUFDQTtBQUFBLFFBQ0E7QUFBQSxRQUNBO0FBQUEsUUFDQTtBQUFBLFFBQ0E7QUFBQSxRQUNBO0FBQUEsUUFDQTtBQUFBLFFBQ0E7QUFBQSxRQUNBO0FBQUEsTUFDSjtBQUFBLE1BQ0EsU0FBUztBQUFBLElBQ2IsQ0FBQztBQUFBLEVBQ0w7QUFDSixDQUFDOyIsCiAgIm5hbWVzIjogW10KfQo=
