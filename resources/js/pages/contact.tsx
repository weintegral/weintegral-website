import { Head } from "@inertiajs/react";
import { Mail, MapPin, Phone } from "lucide-react";

import { VisitorRequestForm } from "@/features/visitor-request/visitor-request-form";

/** Props from ManagementController::contactAction. */
export interface ContactPageProps {
    contactDetails: { email: string; phone: string };
    offices: { name: string; addressLines: string[] }[];
    visitorRequestUrl: string;
}

export default function Contact({ contactDetails, offices, visitorRequestUrl }: ContactPageProps) {
    return (
        <>
            <Head title="Contact" />
            <main className="mx-auto max-w-6xl px-4 py-12 sm:px-6 lg:py-16">
                <nav aria-label="Breadcrumb" className="text-sm text-muted-foreground">
                    <ol className="flex gap-2">
                        <li>
                            <a href="/" className="hover:text-foreground hover:underline">
                                Home
                            </a>
                        </li>
                        <li aria-hidden="true">/</li>
                        <li aria-current="page">Contact</li>
                    </ol>
                </nav>
                <h1 className="mt-4 text-3xl font-semibold tracking-tight sm:text-4xl">Contact</h1>
                <p className="mt-3 max-w-2xl text-muted-foreground">
                    Talk to an Expert. Send us a message and we will get back to you, or reach us
                    directly.
                </p>

                <div className="mt-10 grid gap-10 lg:grid-cols-[1fr_1.25fr]">
                    <section aria-labelledby="contact-details-heading" className="space-y-6">
                        <h2 id="contact-details-heading" className="sr-only">
                            Contact details
                        </h2>
                        <dl className="space-y-6">
                            <div className="flex gap-3">
                                <Mail
                                    className="mt-0.5 size-5 shrink-0 text-muted-foreground"
                                    aria-hidden="true"
                                />
                                <div>
                                    <dt className="font-medium">Email Us</dt>
                                    <dd>
                                        <a
                                            href={`mailto:${contactDetails.email}`}
                                            className="hover:underline"
                                        >
                                            {contactDetails.email}
                                        </a>
                                    </dd>
                                </div>
                            </div>
                            <div className="flex gap-3">
                                <Phone
                                    className="mt-0.5 size-5 shrink-0 text-muted-foreground"
                                    aria-hidden="true"
                                />
                                <div>
                                    <dt className="font-medium">Call Us</dt>
                                    <dd>
                                        <a
                                            href={`tel:${contactDetails.phone.replace(/[^+\d]/g, "")}`}
                                            className="hover:underline"
                                        >
                                            {contactDetails.phone}
                                        </a>
                                    </dd>
                                </div>
                            </div>
                            {offices.map((office) => (
                                <div key={office.name} className="flex gap-3">
                                    <MapPin
                                        className="mt-0.5 size-5 shrink-0 text-muted-foreground"
                                        aria-hidden="true"
                                    />
                                    <div>
                                        <dt className="font-medium">{office.name}</dt>
                                        <dd>
                                            <address className="not-italic">
                                                {office.addressLines.map((line) => (
                                                    <span key={line} className="block">
                                                        {line}
                                                    </span>
                                                ))}
                                            </address>
                                        </dd>
                                    </div>
                                </div>
                            ))}
                        </dl>
                    </section>

                    <section
                        aria-labelledby="visitor-request-heading"
                        className="rounded-xl border bg-card p-6 shadow-sm"
                    >
                        <h2 id="visitor-request-heading" className="text-xl font-semibold">
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
            </main>
        </>
    );
}
