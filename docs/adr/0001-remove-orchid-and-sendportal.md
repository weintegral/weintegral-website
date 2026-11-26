# Remove Orchid and SendPortal along with their data

The site carried two third-party subsystems it no longer used: the Orchid admin platform (user and role management plus demo screens) and SendPortal (email campaigns, whose routes were reachable without authentication). Keeping them meant maintaining and securing an admin UI and a campaign tool nobody used, and they held back major upgrades of shared dependencies. We removed both entirely, leaving a plain Laravel marketing site with the default `User` model and auth tables but no admin panel and no login UI. `/admin` and `/sendportal` return 404 rather than redirecting home, so the removal is explicit.

Their data goes with them. Forward migrations drop Orchid's `roles`, `role_users`, `attachments` and `attachmentable` tables, the `permissions` column on `users`, and every `sendportal_*` table, each only where it exists. Their `down()` methods restore nothing. We chose this over keeping the tables "just in case" because orphaned tables with no code reading them are a liability, and over exporting the data because nothing would consume it.

## Consequences

- Deploys run migrations automatically, so merging this change deletes the production data. Take a production database backup before merging; that backup is the only way back.
- Reintroducing an admin panel or campaign tool means starting from scratch, not reverting these commits.
