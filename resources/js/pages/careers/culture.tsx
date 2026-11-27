import { ArrowRight } from "lucide-react";

import { PageIntro } from "@/components/site/page-intro";
import { SectionHeading } from "@/components/site/section-heading";
import { SiteLayout } from "@/components/site/site-layout";
import { careersLink, openPositionsLink } from "@/components/site/site-navigation";
import { Button } from "@/components/ui/button";
import { CareersSection, PillarList } from "@/features/careers/careers-section";

export default function Culture() {
    return (
        <SiteLayout>
            <PageIntro
                title="Culture"
                trail={[careersLink]}
                lead="People are our business. We build long-lasting relationships with our employees and consultants, and we give everyone room to learn, try new ideas and be heard."
            />

            <CareersSection labelledBy="values-heading">
                <SectionHeading id="values-heading">How we work</SectionHeading>
                <PillarList
                    pillars={[
                        {
                            title: "Keep learning",
                            body: "We invest in continuous learning and development, so you can sharpen your skills and stay current with the latest technologies and trends.",
                        },
                        {
                            title: "Experiment and adapt",
                            body: "We encourage new ideas and calculated risks. When challenges or opportunities change, we adapt quickly.",
                        },
                        {
                            title: "Everyone belongs",
                            body: "We're committed to a diverse, inclusive and respectful workplace that values the perspective and contribution of every person.",
                        },
                    ]}
                />
            </CareersSection>

            <CareersSection labelledBy="support-heading" muted>
                <div className="grid gap-10 lg:grid-cols-[5fr_7fr]">
                    <div>
                        <SectionHeading id="support-heading">
                            Support on every assignment
                        </SectionHeading>
                        <p className="mt-4 text-pretty text-muted-foreground">
                            We foster a creative, transparent and collaborative environment, whether
                            you work with our own team or on a Client assignment.
                        </p>
                    </div>
                    <dl className="divide-y border-y">
                        <SupportItem term="Your point of contact">
                            On a Client assignment you are still part of WeIntegral. Our team stays
                            in touch, and you can come to us with questions about the work, the
                            assignment or what comes next.
                        </SupportItem>
                        <SupportItem term="Learning and certifications">
                            We talk with you about the skills and certifications that fit your
                            goals, and we encourage learning on the job as well as off it.
                        </SupportItem>
                        <SupportItem term="Where we work">
                            Our offices are in Lakeway, Texas and Ongole, Andhra Pradesh, India.
                        </SupportItem>
                    </dl>
                </div>
            </CareersSection>

            <CareersSection labelledBy="team-heading">
                <div className="grid items-center gap-10 lg:grid-cols-2">
                    {/* Unsplash stock (docs/image-credits.md) until WeIntegral's own team photo is available. */}
                    <img
                        src="/img/careers/culture-team-800.webp"
                        srcSet="/img/careers/culture-team-480.webp 480w, /img/careers/culture-team-800.webp 800w, /img/careers/culture-team-1200.webp 1200w"
                        sizes="(min-width: 64rem) 45vw, 100vw"
                        width={800}
                        height={600}
                        loading="lazy"
                        decoding="async"
                        alt="Four colleagues gathered around a computer screen, one pointing at the work"
                        className="aspect-4/3 h-auto w-full rounded-xl object-cover"
                    />
                    <div>
                        <SectionHeading id="team-heading">Grow with us</SectionHeading>
                        <p className="mt-4 text-pretty text-muted-foreground">
                            We offer every employee and consultant opportunities to grow and further
                            their careers. See where you could start.
                        </p>
                        <Button asChild size="brand" className="mt-8">
                            <a href={openPositionsLink.href}>
                                Browse open positions
                                <ArrowRight aria-hidden="true" />
                            </a>
                        </Button>
                    </div>
                </div>
            </CareersSection>
        </SiteLayout>
    );
}

function SupportItem({ term, children }: { term: string; children: React.ReactNode }) {
    return (
        <div className="grid gap-2 py-5 sm:grid-cols-[14rem_1fr]">
            <dt className="font-semibold">{term}</dt>
            <dd className="text-muted-foreground">{children}</dd>
        </div>
    );
}
