import { usePage } from "@inertiajs/react";
import { ArrowRight } from "lucide-react";

import { Button } from "@/components/ui/button";

import { Placeholder } from "./placeholder";
import { contactHref } from "./site-navigation";

/** The sitewide closing call to action: a coral band ending with "Talk to an Expert". */
export function ClosingBand() {
    const { contact } = usePage().props.site;

    return (
        <section aria-labelledby="closing-band-heading" className="bg-cta text-cta-foreground">
            <div className="mx-auto grid max-w-(--container-max) items-end gap-8 px-(--gutter) py-[clamp(3.5rem,2.5rem+4vw,6rem)] md:grid-cols-[minmax(0,1.4fr)_minmax(0,1fr)]">
                <div>
                    <h2
                        id="closing-band-heading"
                        className="max-w-[18ch] text-(length:--text-h1) leading-[1.1] font-semibold tracking-tight"
                    >
                        Have a project or a role to fill? Let's talk.
                    </h2>
                    <p className="mt-4 max-w-[48ch] text-(length:--text-lead)">
                        Tell us what you need and the right person from our team will follow up.{" "}
                        <Placeholder className="border-[#0b1730] bg-[rgb(255_255_255/0.45)] text-[#0b1730]">
                            Reply-time commitment, e.g. "within N business days", owner to confirm
                        </Placeholder>
                    </p>
                </div>
                <div className="flex flex-col items-start gap-4 md:justify-self-end">
                    <Button
                        asChild
                        size="brand-lg"
                        className="bg-[#0b1730] font-semibold text-white hover:bg-[#13294b]"
                    >
                        <a href={contactHref} data-closing-cta="">
                            Talk to an Expert
                            <ArrowRight className="size-4" aria-hidden="true" />
                        </a>
                    </Button>
                    <a
                        href={`mailto:${contact.email}`}
                        className="font-semibold text-[#0b1730] underline-offset-4 hover:underline"
                    >
                        Or email {contact.email}
                    </a>
                </div>
            </div>
        </section>
    );
}
