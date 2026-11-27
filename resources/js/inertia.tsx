import "../css/app.css";

import { createInertiaApp } from "@inertiajs/react";

import { AppProviders } from "@/app-providers";
import { pageTitle } from "@/lib/page-title";

// Pages resolve from ./pages via @inertiajs/vite, which also wraps this entry in the SSR server.
void createInertiaApp({
    title: (title) => pageTitle(title),
    strictMode: true,
    withApp: (app) => <AppProviders>{app}</AppProviders>,
});
