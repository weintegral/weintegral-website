import { ArrowRight } from "lucide-react";
import type { ReactNode } from "react";

import { Placeholder } from "@/components/site/placeholder";
import { PageIntro } from "@/components/site/page-intro";
import { SectionHeading } from "@/components/site/section-heading";
import { SiteLayout } from "@/components/site/site-layout";
import { careersLink, openPositionsLink } from "@/components/site/site-navigation";
import { Button } from "@/components/ui/button";
import type { CareersSample } from "@/features/careers/careers-sample";
import { CareersSection } from "@/features/careers/careers-section";
import { typeRoles } from "@/lib/typography";

/** Props from CareerController::benefitsAction. */
export interface BenefitsProps {
    sample: CareersSample | null;
}

/**
 * Benefit groups. Every specific awaits the owner (launch checklist), shown as a
 * placeholder unless sample content supplies a fictional value.
 */
function benefitGroups(sample: CareersSample | null): { title: string; detail: ReactNode }[] {
    return [
        {
            title: "Health",
            detail: sample?.health ?? (
                <Placeholder>
                    Medical, dental and vision coverage and eligibility, owner to supply
                </Placeholder>
            ),
        },
        {
            title: "Time off",
            detail: sample?.timeOff ?? (
                <Placeholder>Paid time off and holidays, owner to supply</Placeholder>
            ),
        },
        {
            title: "Retirement",
            detail: sample?.retirement ?? (
                <Placeholder>Retirement plan and any employer match, owner to supply</Placeholder>
            ),
        },
        {
            title: "Growth",
            detail: (
                <>
                    Continuous learning and development, with opportunities to build skills and grow
                    your career.{" "}
                    {sample?.growth ?? (
                        <Placeholder>
                            Training or certification budget, owner to confirm
                        </Placeholder>
                    )}
                </>
            ),
        },
    ];
}

export default function Benefits({ sample }: BenefitsProps) {
    return (
        <SiteLayout>
            <PageIntro
                title="Benefits"
                trail={[careersLink]}
                lead="We look after the people who do the work. Here's what we offer our employees and consultants."
            />

            <CareersSection labelledBy="benefits-heading">
                <SectionHeading id="benefits-heading">What we offer</SectionHeading>
                <ul className="mt-10 grid gap-x-10 gap-y-8 sm:grid-cols-2">
                    {benefitGroups(sample).map((group) => (
                        <li key={group.title} className="border-t pt-6">
                            <span aria-hidden="true" className="block h-0.5 w-6 bg-brand-coral" />
                            <h3 className={`mt-4 ${typeRoles.title}`}>{group.title}</h3>
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
                            {sample?.eligibility ?? (
                                <Placeholder>
                                    When benefits start (eligibility timing) and what differs for
                                    W-2 consultants vs employees, owner to supply
                                </Placeholder>
                            )}
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
