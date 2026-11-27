import { DataTable, ExternalLink } from "@/components/internal-tools/data-table";
import { InternalToolLayout } from "@/components/internal-tools/internal-tool-layout";

interface JobPortal {
    name: string;
    url: string;
}

/** Props from InternalToolsController::jobPortalsAction. */
export interface JobPortalsPageProps {
    jobPortals: JobPortal[];
}

export default function JobPortals({ jobPortals }: JobPortalsPageProps) {
    return (
        <InternalToolLayout title="Job portals" intro="Job boards used for recruiting.">
            <DataTable<JobPortal>
                caption="Job portals"
                rows={jobPortals}
                rowKey={(portal) => portal.url}
                emptyMessage="No job portals listed yet."
                columns={[
                    { header: "Name", cell: (portal) => portal.name, className: "font-medium" },
                    {
                        header: "Website",
                        cell: (portal) => <ExternalLink href={portal.url}>Visit</ExternalLink>,
                    },
                ]}
            />
        </InternalToolLayout>
    );
}
