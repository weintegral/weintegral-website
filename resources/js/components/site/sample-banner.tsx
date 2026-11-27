import { usePage } from "@inertiajs/react";

/**
 * The "Sample content — not for publication" banner, shown at the top of every page
 * while sample content is on (SITE_SAMPLE_CONTENT, never in production). It cannot be
 * dismissed, so no screenshot of a sample page can pass for the real site.
 */
export function SampleBanner() {
    const { sample } = usePage().props.site;

    if (!sample) {
        return null;
    }

    return (
        <aside
            aria-label="Sample content notice"
            data-sample-banner=""
            className="bg-emphasis text-background"
        >
            <p className="mx-auto max-w-(--container-max) px-(--gutter) py-2 text-center text-caption font-semibold">
                {sample.notice}. People, Clients, figures, quotes and policies on this page are
                fictional.
            </p>
        </aside>
    );
}
