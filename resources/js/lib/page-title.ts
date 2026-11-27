export const siteName = "WeIntegral";

/** The document title for a page: "Contact | WeIntegral", or just the site name. */
export function pageTitle(title?: string): string {
    return title ? `${title} | ${siteName}` : siteName;
}
