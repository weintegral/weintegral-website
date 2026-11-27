import { InternalToolLayout } from "@/components/internal-tools/internal-tool-layout";

/** Props from InternalToolsController::marketingDataAction. */
export interface MarketingDataPageProps {
    marketingSubmissionsUrl: string;
}

export default function MarketingData({ marketingSubmissionsUrl }: MarketingDataPageProps) {
    return (
        <InternalToolLayout title="Marketing data">
            <p className="rounded-xl border border-dashed p-8 text-center text-muted-foreground">
                No marketing data is recorded here yet. See{" "}
                <a
                    href={marketingSubmissionsUrl}
                    className="font-medium text-foreground underline underline-offset-4"
                >
                    marketing submissions
                </a>{" "}
                for the shared submission chart.
            </p>
        </InternalToolLayout>
    );
}
