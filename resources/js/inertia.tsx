import "../css/app.css";

import { createInertiaApp } from "@inertiajs/react";

import { AppProviders } from "@/app-providers";

// Pages resolve from ./pages via @inertiajs/vite, which also wraps this entry in the SSR server.
void createInertiaApp({
    title: (title) => (title ? `WEI - ${title}` : "WEI"),
    strictMode: true,
    withApp: (app) => <AppProviders>{app}</AppProviders>,
});
