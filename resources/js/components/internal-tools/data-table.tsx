import type { ReactNode } from "react";

export interface DataTableColumn<Row> {
    header: string;
    cell: (row: Row) => ReactNode;
    /** Extra classes for this column's cells, e.g. a width. */
    className?: string;
}

/**
 * A plain, accessible table for Internal Tools lists. Scrolls sideways on narrow
 * screens and shows `emptyMessage` when there are no rows.
 */
export function DataTable<Row>({
    caption,
    columns,
    rows,
    rowKey,
    emptyMessage,
}: {
    caption: string;
    columns: DataTableColumn<Row>[];
    rows: Row[];
    rowKey: (row: Row) => string;
    emptyMessage: string;
}) {
    if (rows.length === 0) {
        return (
            <p className="rounded-xl border border-dashed p-8 text-center text-muted-foreground">
                {emptyMessage}
            </p>
        );
    }

    return (
        <div className="overflow-x-auto rounded-xl border">
            <table className="w-full text-left text-sm">
                <caption className="sr-only">{caption}</caption>
                <thead className="bg-muted">
                    <tr>
                        {columns.map((column) => (
                            <th
                                key={column.header}
                                scope="col"
                                className="px-4 py-3 font-semibold whitespace-nowrap"
                            >
                                {column.header}
                            </th>
                        ))}
                    </tr>
                </thead>
                <tbody>
                    {rows.map((row) => (
                        <tr key={rowKey(row)} className="border-t align-top">
                            {columns.map((column) => (
                                <td
                                    key={column.header}
                                    className={`px-4 py-3 ${column.className ?? ""}`}
                                >
                                    {column.cell(row)}
                                </td>
                            ))}
                        </tr>
                    ))}
                </tbody>
            </table>
        </div>
    );
}

/** An external link that opens in a new tab, announced as such to screen readers. */
export function ExternalLink({ href, children }: { href: string; children: ReactNode }) {
    return (
        <a
            href={href}
            target="_blank"
            rel="noopener noreferrer"
            className="font-medium underline underline-offset-4 hover:text-emphasis"
        >
            {children}
            <span className="sr-only"> (opens in a new tab)</span>
        </a>
    );
}
