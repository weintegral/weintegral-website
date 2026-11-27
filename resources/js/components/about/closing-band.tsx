import { usePage } from "@inertiajs/react";
import { ArrowRight } from "lucide-react";

import { Placeholder } from "@/components/site/placeholder";
import { contactHref } from "@/components/site/site-navigation";

/** The sitewide closing call to action (comp A): coral band, ink button, email fallback. */
export function ClosingBand() {
    const { contact } = usePage().props.site;

    return (
        <section aria-labelledby="closing-heading" className="bg-cta text-cta-foreground">
            <div className="mx-auto grid max-w-(--container-max) items-end gap-8 px-(--gutter) py-14 lg:grid-cols-[minmax(0,1.4fr)_minmax(0,1fr)] lg:py-24">
                <div>
                    <h2
                        id="closing-heading"
                        className="max-w-[18ch] text-(length:--text-h1) leading-[1.08] font-semibold tracking-tight"
                    >
                        Have a project or a role to fill? Let's talk.
                    </h2>
                    <p className="mt-4 max-w-[48ch] text-(length:--text-lead)">
                        Tell us what you need and the right person from our team will follow up.{" "}
                        <Placeholder className="border-[#0b1730] bg-[rgb(255_255_255/0.45)]">
                            Reply-time commitment, to confirm
                        </Placeholder>
                    </p>
                </div>
                <div className="flex flex-col items-start gap-4 lg:justify-self-end">
                    <a
                        href={contactHref}
                        className="inline-flex min-h-13 items-center gap-2 rounded-lg bg-[#0b1730] px-6 py-3.5 font-semibold text-white transition-colors hover:bg-[#13294b]"
                    >
                        Talk to an Expert
                        <ArrowRight className="size-4" aria-hidden="true" />
                    </a>
                    <a href={`mailto:${contact.email}`} className="font-semibold hover:underline">
                        Or email {contact.email}
                    </a>
                </div>
            </div>
        </section>
    );
}
