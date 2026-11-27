import type { ReactNode } from "react";

import { SiteLayout } from "@/components/site/site-layout";

/**
 * A legal document (Terms of Service, Privacy Policy) on the public site: breadcrumb,
 * heading, the document body set for long-form reading, and a contact line.
 */
export function LegalPage({
    title,
    contactEmail,
    children,
}: {
    title: string;
    contactEmail: string;
    children: ReactNode;
}) {
    return (
        <SiteLayout>
            <article className="mx-auto max-w-(--container-max) px-(--gutter) py-12 lg:py-16">
                <nav aria-label="Breadcrumb" className="text-sm text-muted-foreground">
                    <ol className="flex gap-2">
                        <li>
                            <a href="/" className="hover:text-foreground hover:underline">
                                Home
                            </a>
                        </li>
                        <li aria-hidden="true">/</li>
                        <li aria-current="page">{title}</li>
                    </ol>
                </nav>
                <h1 className="mt-4 text-(length:--text-h1) leading-tight font-semibold tracking-tight text-balance">
                    {title}
                </h1>

                <div className="mt-8 max-w-[68ch] space-y-5 text-pretty [&_h2]:mt-10 [&_h2]:text-(length:--text-h3) [&_h2]:font-semibold">
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
