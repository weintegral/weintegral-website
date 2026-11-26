import { defineConfig, lazyPlugins } from "vite-plus";
import laravel from "laravel-vite-plugin";

// Published package assets, Composer code and generated files are not ours to lint or format.
const ignorePatterns = [
    "public/**",
    "vendor/**",
    "storage/**",
    "bootstrap/cache/**",
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
    plugins: lazyPlugins(() => [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js", "resources/js/main.js"],
            refresh: true,
        }),
    ]),
});
