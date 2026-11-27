import { DataTable } from "@/components/internal-tools/data-table";
import { InternalToolLayout } from "@/components/internal-tools/internal-tool-layout";

interface JobGroup {
    name: string;
    email: string;
    technologies: string[];
}

/** Props from InternalToolsController::jobGroupsAction. */
export interface JobGroupsPageProps {
    jobGroups: JobGroup[];
}

export default function JobGroups({ jobGroups }: JobGroupsPageProps) {
    return (
        <InternalToolLayout
            title="Job groups"
            intro="Mailing groups for job requirements, by technology."
        >
            <DataTable<JobGroup>
                caption="Job groups"
                rows={jobGroups}
                rowKey={(group) => group.email}
                emptyMessage="No job groups listed yet."
                columns={[
                    {
                        header: "Name",
                        cell: (group) => group.name,
                        className: "font-medium whitespace-nowrap",
                    },
                    {
                        header: "Email",
                        cell: (group) => (
                            <a
                                href={`mailto:${group.email}`}
                                className="underline underline-offset-4 hover:text-emphasis"
                            >
                                {group.email}
                            </a>
                        ),
                    },
                    {
                        header: "Technologies",
                        cell: (group) => (
                            <ul className="flex flex-wrap gap-1.5">
                                {group.technologies.map((technology) => (
                                    <li
                                        key={technology}
                                        className="rounded-full bg-secondary px-2.5 py-0.5 text-caption text-secondary-foreground"
                                    >
                                        {technology}
                                    </li>
                                ))}
                            </ul>
                        ),
                    },
                ]}
            />
        </InternalToolLayout>
    );
}
