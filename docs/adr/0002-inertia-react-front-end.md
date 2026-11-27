# Render public pages with Inertia + React inside Laravel, not a separate TanStack Start app

The public site is moving from Blade and a purchased Bootstrap template to typed React components on shadcn/ui and Tailwind. We render those pages through Inertia.js with server-side rendering, so Laravel stays the application and router: controllers return Inertia responses with typed props, and the existing routes, Visitor Request API, emails and Internal Tools stay where they are. We considered a separate TanStack Start (TanStack Router) front-end app calling Laravel as an API, and rejected it because it would mean a second deployable service, duplicated routing and SEO metadata, and a new API for content that Laravel already owns, for a marketing site with one form. We still use TanStack where it helps inside Inertia pages: TanStack Form for the contact form, TanStack Query for client-side mutations such as submitting a Visitor Request, and TanStack Table for Open Positions.

## Consequences

- A Node process must run the Inertia SSR server beside PHP in every environment (the `we-scheduler` container locally; see `docs/deployment.md` for production). If it is down, pages fall back to client-side rendering rather than failing, but lose server-rendered HTML for search engines and first paint.
- Pages migrate one at a time: an Inertia page and the remaining Blade pages coexist until each is moved, with separate root templates (`resources/views/app.blade.php` and `resources/views/layout/main.blade.php`).
- Inertia owns client-side routing, so TanStack Router is not used.
