import { defineConfig, lazyPlugins } from "vite-plus";
import inertia from "@inertiajs/vite";
import tailwindcss from "@tailwindcss/vite";
import react from "@vitejs/plugin-react";
import laravel from "laravel-vite-plugin";

// Published package assets, Composer code and generated files are not ours to lint or format.
const ignorePatterns = [
    "public/**",
    "vendor/**",
    "storage/**",
    "bootstrap/cache/**",
    "bootstrap/ssr/**",
    "resources/swagger/**",
];

export default defineConfig({
    fmt: {
        ignorePatterns,
    },
    lint: {
        ignorePatterns,
        jsPlugins: [{ name: "vite-plus", specifier: "vite-plus/oxlint-plugin" }],
        rules: { "vite-plus/prefer-vite-plus-imports": "error" },
        options: { typeAware: true, typeCheck: true },
    },
    test: {
        include: ["resources/js/**/*.test.ts"],
    },
    plugins: lazyPlugins(() => [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.js",
                "resources/js/main.js",
                "resources/js/inertia.tsx",
            ],
            // The Inertia plugin wraps this entry in an SSR server for `vp build --ssr`.
            ssr: "resources/js/inertia.tsx",
            refresh: true,
        }),
        inertia({ ssr: { entry: "resources/js/inertia.tsx" } }),
        react(),
        tailwindcss(),
    ]),
});
