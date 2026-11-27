import { ArrowRight } from "lucide-react";

import { Placeholder } from "@/components/site/placeholder";
import { SiteLayout } from "@/components/site/site-layout";
import { openPositionsLink } from "@/components/site/site-navigation";
import { Button } from "@/components/ui/button";
import {
    CareersPageIntro,
    CareersSection,
    SectionHeading,
} from "@/features/careers/careers-page-intro";

/** Benefit groups. Every specific awaits the owner (launch checklist). */
const benefitGroups: { title: string; detail: React.ReactNode }[] = [
    {
        title: "Health",
        detail: (
            <Placeholder>
                Medical, dental and vision coverage and eligibility, owner to supply
            </Placeholder>
        ),
    },
    {
        title: "Time off",
        detail: <Placeholder>Paid time off and holidays, owner to supply</Placeholder>,
    },
    {
        title: "Retirement",
        detail: <Placeholder>Retirement plan and any employer match, owner to supply</Placeholder>,
    },
    {
        title: "Growth",
        detail: (
            <>
                Continuous learning and development, with opportunities to build skills and grow
                your career.{" "}
                <Placeholder>Training or certification budget, owner to confirm</Placeholder>
            </>
        ),
    },
];

export default function Benefits() {
    return (
        <SiteLayout
            seo={{
                title: "Benefits",
                description:
                    "Benefits for WeIntegral employees and consultants, covering health, time off, retirement and career growth, plus how eligibility works for each role.",
            }}
        >
            <CareersPageIntro
                title="Benefits"
                withinCareers
                lead="We look after the people who do the work. Here's what we offer our employees and consultants."
            />

            <CareersSection labelledBy="benefits-heading">
                <SectionHeading id="benefits-heading">What we offer</SectionHeading>
                <ul className="mt-10 grid gap-x-10 gap-y-8 sm:grid-cols-2">
                    {benefitGroups.map((group) => (
                        <li key={group.title} className="border-t pt-6">
                            <span aria-hidden="true" className="block h-0.5 w-6 bg-brand-coral" />
                            <h3 className="mt-4 text-(length:--text-h3) font-semibold">
                                {group.title}
                            </h3>
                            <p className="mt-2 text-pretty text-muted-foreground">{group.detail}</p>
                        </li>
                    ))}
                </ul>
            </CareersSection>

            <CareersSection labelledBy="eligibility-heading" muted>
                <div className="grid gap-10 lg:grid-cols-[5fr_7fr]">
                    <SectionHeading id="eligibility-heading">
                        Employees and consultants
                    </SectionHeading>
                    <div className="space-y-4 text-pretty text-muted-foreground">
                        <p>
                            Benefits can differ between full-time employees and consultants on
                            Client assignments. Ask us what applies to the role you're considering.
                        </p>
                        <p>
                            <Placeholder>
                                When benefits start (eligibility timing) and what differs for W-2
                                consultants vs employees, owner to supply
                            </Placeholder>
                        </p>
                    </div>
                </div>
            </CareersSection>

            <CareersSection labelledBy="next-heading">
                <SectionHeading id="next-heading">Ready to take the next step?</SectionHeading>
                <Button asChild size="brand" className="mt-8">
                    <a href={openPositionsLink.href}>
                        Browse open positions
                        <ArrowRight aria-hidden="true" />
                    </a>
                </Button>
            </CareersSection>
        </SiteLayout>
    );
}
