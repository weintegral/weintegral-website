import type { ReactNode } from "react";

import { PageIntro } from "@/components/site/page-intro";
import { SiteLayout } from "@/components/site/site-layout";

/**
 * A legal document (Terms of Service, Privacy Policy) on the public site: the page
 * intro, the document body set for long-form reading, and a contact line.
 */
export function LegalPage({
    title,
    lead,
    contactEmail,
    children,
}: {
    title: string;
    lead: ReactNode;
    contactEmail: string;
    children: ReactNode;
}) {
    return (
        <SiteLayout>
            <PageIntro title={title} lead={lead} />
            <article className="mx-auto max-w-(--container-max) px-(--gutter) py-12 lg:py-16">
                <div className="max-w-[68ch] space-y-5 text-pretty [&_h2]:mt-10 [&_h2]:text-(length:--text-h3) [&_h2]:font-semibold">
                    {children}
                    <p className="border-t pt-6 text-muted-foreground">
                        Questions about this page? Email{" "}
                        <a
                            href={`mailto:${contactEmail}`}
                            className="font-medium text-foreground underline underline-offset-4"
                        >
                            {contactEmail}
                        </a>
                        .
                    </p>
                </div>
            </article>
        </SiteLayout>
    );
}
