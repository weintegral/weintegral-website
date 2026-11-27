import {
    columnFilteringFeature,
    createColumnHelper,
    createFilteredRowModel,
    filterFn_equalsString,
    filterFn_includesString,
    globalFilteringFeature,
    tableFeatures,
    useTable,
} from "@tanstack/react-table";
import { Search } from "lucide-react";
import { useId, useMemo } from "react";

import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import {
    Table,
    TableBody,
    TableCaption,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from "@/components/ui/table";
import { typeRoles } from "@/lib/typography";

/** One job from App\Services\Job, as CareerController::openPosition() shapes it. */
export interface OpenPosition {
    id: string;
    role: string;
    technology: string;
    summary: string;
    skills: string[];
}

const features = tableFeatures({
    columnFilteringFeature,
    globalFilteringFeature,
    filteredRowModel: createFilteredRowModel(),
    filterFns: { includesString: filterFn_includesString, equalsString: filterFn_equalsString },
});

const helper = createColumnHelper<typeof features, OpenPosition>();

const columns = helper.columns([
    helper.accessor("role", { header: "Role" }),
    helper.accessor("technology", { header: "Technology", filterFn: "equalsString" }),
    helper.accessor("summary", { header: "Summary" }),
    helper.accessor((position) => position.skills.join(", "), {
        id: "skills",
        header: "Skills",
    }),
]);

/** Display order: alphabetical, so the filter reads predictably. */
function technologiesOf(positions: OpenPosition[]): string[] {
    return [...new Set(positions.map((position) => position.technology))].sort((a, b) =>
        a.localeCompare(b),
    );
}

function applyHref(email: string, position: OpenPosition): string {
    const subject = `Application: ${position.role} (${position.id})`;
    return `mailto:${email}?subject=${encodeURIComponent(subject)}`;
}

/**
 * Open Positions as a TanStack Table with a text search across role, technology, summary and
 * skills, plus a technology filter. Shows an empty state when no position matches.
 */
export function OpenPositionsTable({
    positions,
    careersEmail,
}: {
    positions: OpenPosition[];
    careersEmail: string;
}) {
    const searchId = useId();
    const technologyId = useId();
    const technologies = useMemo(() => technologiesOf(positions), [positions]);

    const table = useTable({
        features,
        columns,
        data: positions,
        globalFilterFn: "includesString",
        getRowId: (position) => position.id,
    });

    const search = typeof table.state.globalFilter === "string" ? table.state.globalFilter : "";
    const technologyColumn = table.getColumn("technology");
    const technologyFilter = technologyColumn?.getFilterValue();
    const technology = typeof technologyFilter === "string" ? technologyFilter : "";
    const rows = table.getRowModel().rows;
    const isFiltered = search !== "" || technology !== "";

    const clearFilters = () => {
        table.resetGlobalFilter(true);
        table.resetColumnFilters(true);
    };

    return (
        <div>
            <div
                role="search"
                aria-label="Open positions"
                className="flex flex-col gap-4 sm:flex-row sm:items-end"
            >
                <div className="flex-1">
                    <Label htmlFor={searchId}>Search positions</Label>
                    <div className="relative mt-2">
                        <Search
                            className="pointer-events-none absolute top-1/2 left-3 size-4 -translate-y-1/2 text-muted-foreground"
                            aria-hidden="true"
                        />
                        <Input
                            id={searchId}
                            type="search"
                            name="search"
                            value={search}
                            onChange={(event) => table.setGlobalFilter(event.target.value)}
                            placeholder="Role, technology or skill"
                            autoComplete="off"
                            className="h-11 pl-9 md:text-base"
                        />
                    </div>
                </div>
                <div className="sm:w-56">
                    <Label htmlFor={technologyId}>Technology</Label>
                    <select
                        id={technologyId}
                        name="technology"
                        value={technology}
                        onChange={(event) =>
                            technologyColumn?.setFilterValue(event.target.value || undefined)
                        }
                        className="mt-2 h-11 w-full rounded-lg border border-input bg-background px-3 text-base outline-none focus-visible:border-ring focus-visible:ring-3 focus-visible:ring-ring/50"
                    >
                        <option value="">All technologies</option>
                        {technologies.map((name) => (
                            <option key={name} value={name}>
                                {name}
                            </option>
                        ))}
                    </select>
                </div>
            </div>

            <p
                className="mt-6 text-sm text-muted-foreground"
                aria-live="polite"
                data-result-count=""
            >
                Showing {rows.length} of {positions.length}{" "}
                {positions.length === 1 ? "position" : "positions"}
            </p>

            {rows.length === 0 ? (
                <div
                    data-empty-state=""
                    className="mt-4 rounded-xl border border-dashed p-10 text-center"
                >
                    <h3 className={typeRoles.subtitle}>No positions match your search</h3>
                    <p className="mt-2 text-muted-foreground">
                        Try another role, technology or skill, or{" "}
                        <a href={`mailto:${careersEmail}`} className="underline">
                            send us your résumé
                        </a>{" "}
                        and we'll keep you in mind.
                    </p>
                    {isFiltered && (
                        <Button
                            variant="outline"
                            size="brand"
                            className="mt-6"
                            onClick={clearFilters}
                        >
                            Clear search and filters
                        </Button>
                    )}
                </div>
            ) : (
                <Table className="mt-4 text-base">
                    <TableCaption className="sr-only">
                        Open positions, filtered by your search and technology choices
                    </TableCaption>
                    <TableHeader>
                        {table.getHeaderGroups().map((group) => (
                            <TableRow key={group.id} className="hover:bg-transparent">
                                {group.headers.map((header) => (
                                    <TableHead key={header.id} scope="col">
                                        <table.FlexRender header={header} />
                                    </TableHead>
                                ))}
                                <TableHead scope="col">
                                    <span className="sr-only">Apply</span>
                                </TableHead>
                            </TableRow>
                        ))}
                    </TableHeader>
                    <TableBody>
                        {rows.map((row) => {
                            const position = row.original;
                            return (
                                <TableRow key={row.id} data-position-row="">
                                    <th
                                        scope="row"
                                        className="p-3 text-left align-top font-semibold"
                                    >
                                        {position.role}
                                        <span className="block text-xs font-normal text-muted-foreground">
                                            Ref. {position.id}
                                        </span>
                                    </th>
                                    <TableCell>{position.technology}</TableCell>
                                    <TableCell className="min-w-56 text-muted-foreground">
                                        {position.summary}
                                    </TableCell>
                                    <TableCell>
                                        <ul className="flex flex-wrap gap-1.5" aria-label="Skills">
                                            {position.skills.map((skill) => (
                                                <li
                                                    key={skill}
                                                    className="rounded-md border bg-muted px-2 py-0.5 text-sm whitespace-nowrap"
                                                >
                                                    {skill}
                                                </li>
                                            ))}
                                        </ul>
                                    </TableCell>
                                    <TableCell className="text-right">
                                        <Button asChild variant="outline" size="brand">
                                            <a href={applyHref(careersEmail, position)}>
                                                Apply
                                                <span className="sr-only">
                                                    {" "}
                                                    for {position.role}, ref. {position.id}
                                                </span>
                                            </a>
                                        </Button>
                                    </TableCell>
                                </TableRow>
                            );
                        })}
                    </TableBody>
                </Table>
            )}
        </div>
    );
}
