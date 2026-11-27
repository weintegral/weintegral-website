import { DataTable, ExternalLink } from "@/components/internal-tools/data-table";
import { InternalToolLayout } from "@/components/internal-tools/internal-tool-layout";

interface ClientCareerPage {
    name: string;
    url: string;
}

/** Props from InternalToolsController::clientListAction. */
export interface ClientListPageProps {
    clients: ClientCareerPage[];
}

export default function ClientList({ clients }: ClientListPageProps) {
    return (
        <InternalToolLayout title="Client list" intro="Client career pages for recruiting.">
            <DataTable<ClientCareerPage>
                caption="Client list"
                rows={clients}
                rowKey={(client) => client.url}
                emptyMessage="No clients listed yet."
                columns={[
                    { header: "Name", cell: (client) => client.name, className: "font-medium" },
                    {
                        header: "Career page",
                        cell: (client) => <ExternalLink href={client.url}>Visit</ExternalLink>,
                    },
                ]}
            />
        </InternalToolLayout>
    );
}
