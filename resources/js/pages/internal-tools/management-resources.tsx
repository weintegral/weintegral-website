import { ExternalLink } from "@/components/internal-tools/data-table";
import { InternalToolLayout } from "@/components/internal-tools/internal-tool-layout";

/** Props from InternalToolsController::managementResourcesAction. */
export interface ManagementResourcesPageProps {
    resources: { title: string; brief: string; url: string }[];
}

export default function ManagementResources({ resources }: ManagementResourcesPageProps) {
    return (
        <InternalToolLayout
            title="Management resources"
            intro="Company systems for WeIntegral staff."
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
