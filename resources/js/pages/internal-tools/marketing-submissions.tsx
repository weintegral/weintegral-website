import { InternalToolLayout } from "@/components/internal-tools/internal-tool-layout";

/** Props from InternalToolsController::marketingSubmissionsAction. */
export interface MarketingSubmissionsPageProps {
    /** A published Google Sheets chart. */
    chartUrl: string;
}

export default function MarketingSubmissions({ chartUrl }: MarketingSubmissionsPageProps) {
    return (
        <InternalToolLayout
            title="Marketing submissions"
            intro="Submission data from the shared marketing sheet."
        >
            <div className="overflow-x-auto rounded-xl border bg-card p-4">
                <iframe
                    title="Marketing submissions chart"
                    src={chartUrl}
                    width={600}
                    height={500}
                    className="max-w-none border-0"
                />
            </div>
        </InternalToolLayout>
    );
}
