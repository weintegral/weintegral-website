import type { NavLink } from "@/components/site/site-navigation";

/** One Service on the line, with its one-word role in the build-to-run journey. */
export interface Station extends NavLink {
    role: string;
}

const path = "M 452 52 C 444 6 372 -4 352 92 C 318 230 262 350 228 488 C 208 584 136 574 128 528";

/** Station centres along the curve, top to bottom. */
const points: [number, number][] = [
    [352, 92],
    [323, 193],
    [290, 290],
    [257, 387],
    [228, 488],
];

/**
 * The Integral Line (DESIGN.md, Signature): one continuous coral line with the
 * five Services as linked stations. Hidden below 36rem, where the Services list follows.
 */
export function IntegralLine({ stations }: { stations: Station[] }) {
    return (
        <svg
            viewBox="0 0 640 600"
            role="group"
            aria-labelledby="integral-line-title"
            className="integral-line hidden h-auto w-full max-w-[26rem] justify-self-center overflow-visible min-[36rem]:block min-[52rem]:max-w-xl min-[52rem]:justify-self-end"
        >
            <title id="integral-line-title">
                Our five Services, one continuous line from build to run
            </title>
            <path className="track" d={path} />
            <path className="line" d={path} pathLength={1} />
            <circle className="end" cx="452" cy="52" r="5" />
            <circle className="end" cx="128" cy="528" r="5" />
            {stations.map((station, index) => {
                const [x, y] = points[index] ?? [0, 0];

                return (
                    <g key={station.href} className="station">
                        <a href={station.href}>
                            <circle cx={x} cy={y} r="9" />
                            <text x={x + 28} y={y - 1}>
                                {station.label}
                            </text>
                            <text className="role" x={x + 28} y={y + 19}>
                                {station.role}
                            </text>
                        </a>
                    </g>
                );
            })}
        </svg>
    );
}
