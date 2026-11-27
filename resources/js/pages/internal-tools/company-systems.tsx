import { ExternalLink } from "@/components/internal-tools/data-table";
import { InternalToolLayout } from "@/components/internal-tools/internal-tool-layout";

/** Props from InternalToolsController::companySystemsAction. */
export interface CompanySystemsPageProps {
    resources: { title: string; brief: string; url: string }[];
}

export default function CompanySystems({ resources }: CompanySystemsPageProps) {
    return (
        <InternalToolLayout
            title="Company systems"
            intro="Links to the systems WeIntegral staff use."
        >
            <ul className="grid gap-4 sm:grid-cols-2">
                {resources.map((resource) => (
                    <li key={resource.url} className="rounded-xl border bg-card p-5 shadow-sm">
                        <h2 className="font-semibold">
                            <ExternalLink href={resource.url}>{resource.title}</ExternalLink>
                        </h2>
                        <p className="mt-1 text-sm text-muted-foreground">{resource.brief}</p>
                    </li>
                ))}
            </ul>
        </InternalToolLayout>
    );
}
