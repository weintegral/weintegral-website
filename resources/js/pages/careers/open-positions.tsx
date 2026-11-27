import { Placeholder } from "@/components/site/placeholder";
import { SiteLayout } from "@/components/site/site-layout";
import { candidateResourcesHref } from "@/components/site/site-navigation";
import { Button } from "@/components/ui/button";
import { CareersPageIntro, CareersSection } from "@/features/careers/careers-page-intro";
import { OpenPositionsTable, type OpenPosition } from "@/features/careers/open-positions-table";

/** Props from CareerController::jobOpeningsAction. */
export interface OpenPositionsProps {
    openPositions: OpenPosition[];
    /** Where candidates send a résumé (ContactInfo::getHrEmailId). */
    careersEmail: string;
}

export default function OpenPositions({ openPositions, careersEmail }: OpenPositionsProps) {
    return (
        <SiteLayout>
            <CareersPageIntro
                title="Open positions"
                withinCareers
                lead="Find your next role. Search by title, technology or skill, then apply by email with the role's reference."
            />

            <CareersSection labelledBy="positions-heading">
                <h2 id="positions-heading" className="sr-only">
                    Current openings
                </h2>
                {openPositions.length === 0 ? (
                    <div
                        data-empty-state=""
                        className="rounded-xl border border-dashed p-10 text-center"
                    >
                        <h3 className="text-(length:--text-h3) font-semibold">
                            No open positions right now
                        </h3>
                        <p className="mx-auto mt-2 max-w-xl text-muted-foreground">
                            We don't have openings at the moment, but we're always glad to hear from
                            skilled people. Send us your résumé and the kind of work you're looking
                            for.
                        </p>
                        <Button asChild size="brand" className="mt-6">
                            <a href={`mailto:${careersEmail}`}>Send your résumé</a>
                        </Button>
                    </div>
                ) : (
                    <OpenPositionsTable positions={openPositions} careersEmail={careersEmail} />
                )}
            </CareersSection>

            <CareersSection labelledBy="fit-heading" muted>
                <div className="grid gap-8 lg:grid-cols-2">
                    <div>
                        <h2 id="fit-heading" className="text-(length:--text-h3) font-semibold">
                            Don't see a fit?
                        </h2>
                        <p className="mt-2 text-pretty text-muted-foreground">
                            Email your résumé to{" "}
                            <a href={`mailto:${careersEmail}`} className="underline">
                                {careersEmail}
                            </a>{" "}
                            and tell us what you're looking for. Working through a visa or H-1B
                            process? Our{" "}
                            <a href={candidateResourcesHref} className="underline">
                                Candidate Resources
                            </a>{" "}
                            collect useful links.
                        </p>
                    </div>
                    <p className="text-sm text-pretty text-muted-foreground">
                        <Placeholder>
                            Equal employment opportunity statement, owner and counsel to confirm
                            wording
                        </Placeholder>
                    </p>
                </div>
            </CareersSection>
        </SiteLayout>
    );
}
