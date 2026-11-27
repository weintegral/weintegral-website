import { usePage } from "@inertiajs/react";
import { Mail, MapPin, Phone, type LucideIcon } from "lucide-react";
import type { ReactNode } from "react";

import { PageIntro } from "@/components/site/page-intro";
import { SiteLayout } from "@/components/site/site-layout";
import { telHref } from "@/components/site/site-navigation";
import { VisitorRequestForm } from "@/features/visitor-request/visitor-request-form";
import { typeRoles } from "@/lib/typography";

/** Props from ManagementController::contactAction; contact details and offices are shared site props. */
export interface ContactPageProps {
    visitorRequestUrl: string;
}

export default function Contact({ visitorRequestUrl }: ContactPageProps) {
    const { contact: contactDetails, offices } = usePage().props.site;

    return (
        <SiteLayout>
            <PageIntro
                title="Contact"
                lead="Talk to an Expert. Send us a message and we will get back to you, or reach us directly."
            />
            <div className="mx-auto max-w-(--container-max) px-(--gutter) py-12 lg:py-16">
                <div className="grid gap-10 lg:grid-cols-[1fr_1.25fr]">
                    <section aria-labelledby="contact-details-heading" className="space-y-6">
                        <h2 id="contact-details-heading" className="sr-only">
                            Contact details
                        </h2>
                        <dl className="space-y-6">
                            <ContactDetail icon={Mail} label="Email Us">
                                <a
                                    href={`mailto:${contactDetails.email}`}
                                    className="hover:underline"
                                >
                                    {contactDetails.email}
                                </a>
                            </ContactDetail>
                            <ContactDetail icon={Phone} label="Call Us">
                                <a href={telHref(contactDetails.phone)} className="hover:underline">
                                    {contactDetails.phone}
                                </a>
                            </ContactDetail>
                            {offices.map((office) => (
                                <ContactDetail key={office.name} icon={MapPin} label={office.name}>
                                    <address className="not-italic">
                                        {office.addressLines.map((line) => (
                                            <span key={line} className="block">
                                                {line}
                                            </span>
                                        ))}
                                    </address>
                                </ContactDetail>
                            ))}
                        </dl>
                    </section>

                    <section
                        aria-labelledby="visitor-request-heading"
                        className="rounded-xl border bg-card p-6 shadow-sm"
                    >
                        <h2 id="visitor-request-heading" className={typeRoles.title}>
                            Send us a message
                        </h2>
                        <div className="mt-6">
                            <VisitorRequestForm
                                action={visitorRequestUrl}
                                fallbackEmail={contactDetails.email}
                            />
                        </div>
                    </section>
                </div>
            </div>
        </SiteLayout>
    );
}

/** One term/description pair in the contact details list, with its icon in the term. */
function ContactDetail({
    icon: Icon,
    label,
    children,
}: {
    icon: LucideIcon;
    label: string;
    children: ReactNode;
}) {
    return (
        <div>
            <dt className="flex items-center gap-3 font-medium">
                <Icon className="size-5 shrink-0 text-muted-foreground" aria-hidden="true" />
                {label}
            </dt>
            <dd className="pl-8">{children}</dd>
        </div>
    );
}
