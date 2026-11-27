import { usePage } from "@inertiajs/react";
import { ArrowRight } from "lucide-react";

import { Button } from "@/components/ui/button";
import { typeRoles } from "@/lib/typography";

import { Placeholder } from "./placeholder";
import { contactHref } from "./site-navigation";

/**
 * The sitewide closing call to action (comp A): the page's one coral band, with ink
 * text, the ink "Talk to an Expert" button and an email fallback.
 */
export function ClosingBand() {
    const { contact } = usePage().props.site;

    return (
        <section aria-labelledby="closing-heading" className="bg-cta text-cta-foreground">
            <div className="mx-auto grid max-w-(--container-max) items-end gap-8 px-(--gutter) py-[clamp(3.5rem,2.5rem+4vw,6rem)] min-[52rem]:grid-cols-[minmax(0,1.4fr)_minmax(0,1fr)]">
                <div>
                    <h2 id="closing-heading" className={`max-w-[18ch] ${typeRoles.headline}`}>
                        Have a project or a role to fill? Let&rsquo;s talk.
                    </h2>
                    <p className={`mt-4 max-w-[48ch] ${typeRoles.lead}`}>
                        Tell us what you need and the right person from our team will follow up.{" "}
                        <Placeholder className="border-cta-foreground bg-white/45 text-cta-foreground">
                            Reply-time commitment, e.g. &ldquo;within N business days&rdquo;, owner
                            to confirm
                        </Placeholder>
                    </p>
                </div>
                <div className="flex flex-col items-start gap-4 min-[52rem]:justify-self-end">
                    <Button asChild variant="ink" size="brand-lg" className="group/btn">
                        <a href={contactHref} data-closing-cta="">
                            Talk to an Expert
                            <ArrowRight
                                aria-hidden="true"
                                className="transition-transform duration-(--duration-slow) ease-brand group-hover/btn:translate-x-[3px]"
                            />
                        </a>
                    </Button>
                    <a
                        href={`mailto:${contact.email}`}
                        className="font-semibold underline-offset-4 hover:underline"
                    >
                        Or email {contact.email}
                    </a>
                </div>
            </div>
        </section>
    );
}
