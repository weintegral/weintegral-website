import { BadgeAlert, BadgeCheck } from "lucide-react";

import { DataTable, ExternalLink } from "@/components/internal-tools/data-table";
import { InternalToolLayout } from "@/components/internal-tools/internal-tool-layout";

interface Vendor {
    name: string;
    url: string;
    verified: boolean;
}

/** Props from InternalToolsController::vendorsAction. */
export interface VendorsPageProps {
    vendors: Vendor[];
}

export default function Vendors({ vendors }: VendorsPageProps) {
    return (
        <InternalToolLayout title="Vendors" intro="Staffing vendors and their job pages.">
            <DataTable<Vendor>
                caption="Vendors"
                rows={vendors}
                rowKey={(vendor) => vendor.name}
                emptyMessage="No vendors listed yet."
                columns={[
                    { header: "Name", cell: (vendor) => vendor.name, className: "font-medium" },
                    {
                        header: "Job page",
                        cell: (vendor) => <ExternalLink href={vendor.url}>Visit</ExternalLink>,
                    },
                    {
                        header: "Approved vendor",
                        cell: (vendor) =>
                            vendor.verified ? (
                                <span className="inline-flex items-center gap-1.5 text-success">
                                    <BadgeCheck className="size-4" aria-hidden="true" />
                                    Yes
                                </span>
                            ) : (
                                <span className="inline-flex items-center gap-1.5 text-muted-foreground">
                                    <BadgeAlert className="size-4" aria-hidden="true" />
                                    No
                                </span>
                            ),
                    },
                ]}
            />
        </InternalToolLayout>
    );
}
