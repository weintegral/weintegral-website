import { usePage } from "@inertiajs/react";
import { ArrowRight } from "lucide-react";

import { ClosingBand } from "@/components/about/closing-band";
import { PageIntro, SectionHeading } from "@/components/about/page-intro";
import { Placeholder } from "@/components/site/placeholder";
import { SiteLayout } from "@/components/site/site-layout";
import { contactHref, services } from "@/components/site/site-navigation";
import { Button } from "@/components/ui/button";

/** One headline figure. Values are display strings, already formatted by the server. */
export interface Stat {
    value: string;
    label: string;
}

/** Props from AboutController::aboutAction. */
export interface AboutPageProps {
    stats: Stat[];
}

const values = [
    {
        title: "Your needs set the plan",
        body: "We start from your goals, your process and the systems you already run, then shape the solution around them rather than selling a fixed package.",
    },
    {
        title: "Always learning",
        body: "Our people keep building their skills, so the team on your project stays current with the technologies and practices it needs.",
    },
    {
        title: "Room to try new ideas",
        body: "We encourage our teams to experiment and adapt quickly when priorities change, so your project moves with your business.",
    },
    {
        title: "Everyone belongs",
        body: "We build a diverse, respectful workplace where every employee's perspective is valued, because better teams make better software.",
    },
];

const stages = [
    {
        title: "Discover",
        body: "We learn your goals, systems and constraints, then agree on scope, team and timeline with you.",
    },
    {
        title: "Build",
        body: "We design, develop and test in short cycles, with working software you can review along the way.",
    },
    {
        title: "Run",
        body: "We deploy, monitor and support what we built, and adjust the team as your needs change.",
    },
];

export default function About({ stats }: AboutPageProps) {
    const { offices } = usePage().props.site;

    return (
        <SiteLayout
            seo={{
                title: "Who We Are",
                description:
                    "WeIntegral builds, tests, deploys and supports business applications and staffs IT roles, from offices in Lakeway, Texas and Ongole, India.",
            }}
        >
            <PageIntro
                trail={[{ label: "Home", href: "/" }]}
                title="Who We Are"
                lead="WeIntegral is an IT services firm that builds, tests, deploys and supports business applications, and staffs the technical roles around them. One accountable team, from the first conversation to running software."
            >
                <Button asChild variant="cta" size="brand-lg">
                    <a href={contactHref}>
                        Talk to an Expert
                        <ArrowRight aria-hidden="true" />
                    </a>
                </Button>
                <Button asChild variant="outline" size="brand-lg">
                    <a href="/team">Meet our leadership</a>
                </Button>
            </PageIntro>

            <section aria-labelledby="story-heading" className="py-(--section-space)">
                <div className="mx-auto grid max-w-(--container-max) gap-10 px-(--gutter) lg:grid-cols-[minmax(0,5fr)_minmax(0,7fr)] lg:gap-20">
                    <SectionHeading id="story-heading">
                        One firm for the whole application
                    </SectionHeading>
                    <div className="space-y-5 text-(length:--text-lead)">
                        <p>
                            Most businesses juggle separate vendors to build, test, deploy and
                            support their software, and details get lost at every handoff. We bring
                            those Services under one roof, so the team that writes your code can
                            carry it into production and keep it healthy afterwards.
                        </p>
                        <p className="text-muted-foreground">
                            When you need people rather than a project, our IT Staffing Service
                            finds skilled professionals to join your own team.
                        </p>
                        <p className="text-base">
                            <Placeholder>Founding story and year, owner to supply</Placeholder>
                        </p>
                        <ul className="flex flex-wrap gap-x-6 gap-y-3 pt-2 text-base">
                            {services.map((service) => (
                                <li key={service.href}>
                                    <a
                                        href={service.href}
                                        className="inline-flex items-center gap-1.5 font-semibold text-emphasis hover:underline"
                                    >
                                        {service.label}
                                        <ArrowRight className="size-4" aria-hidden="true" />
                                    </a>
                                </li>
                            ))}
                        </ul>
                    </div>
                </div>
            </section>

            <section aria-labelledby="values-heading" className="bg-muted py-(--section-space)">
                <div className="mx-auto max-w-(--container-max) px-(--gutter)">
                    <SectionHeading
                        id="values-heading"
                        intro="Four commitments shape how we hire, how we work and how we treat the businesses we serve."
                    >
                        What we stand for
                    </SectionHeading>
                    <ul className="grid gap-10 sm:grid-cols-2 lg:grid-cols-4">
                        {values.map((value) => (
                            <li key={value.title}>
                                <h3 className="text-(length:--text-h4) font-semibold">
                                    {value.title}
                                </h3>
                                <p className="mt-2 text-muted-foreground">{value.body}</p>
                            </li>
                        ))}
                    </ul>
                </div>
            </section>

            <section
                aria-labelledby="process-heading"
                className="bg-inverse py-(--section-space) text-inverse-foreground"
            >
                <div className="mx-auto max-w-(--container-max) px-(--gutter)">
                    <h2
                        id="process-heading"
                        className="text-(length:--text-h2) leading-tight font-semibold tracking-tight"
                    >
                        How we work
                    </h2>
                    <p className="mt-4 max-w-[52ch] text-inverse-muted">
                        Every engagement follows the same three stages, whether you need a full
                        product team or one specialist.
                    </p>
                    <ol className="relative mt-12 grid gap-10 pt-11 md:grid-cols-3 md:before:absolute md:before:top-2.5 md:before:right-0 md:before:left-2.5 md:before:h-0.5 md:before:bg-linear-to-r md:before:from-cta md:before:from-70% md:before:to-transparent">
                        {stages.map((stage) => (
                            <li
                                key={stage.title}
                                className="relative before:absolute before:-top-11 before:left-0 before:size-5 before:rounded-full before:border-3 before:border-cta before:bg-inverse"
                            >
                                <h3 className="text-(length:--text-h3) font-semibold">
                                    {stage.title}
                                </h3>
                                <p className="mt-2.5 max-w-[34ch] text-inverse-muted">
                                    {stage.body}
                                </p>
                            </li>
                        ))}
                    </ol>
                </div>
            </section>

            <section aria-labelledby="offices-heading" className="py-(--section-space)">
                <div className="mx-auto grid max-w-(--container-max) gap-10 px-(--gutter) lg:grid-cols-[minmax(0,5fr)_minmax(0,7fr)] lg:gap-20">
                    <SectionHeading
                        id="offices-heading"
                        intro="A team in the United States and a team in India."
                    >
                        Where we work
                    </SectionHeading>
                    <div>
                        <ul className="grid gap-8 sm:grid-cols-2">
                            {offices.map((office) => (
                                <li key={office.name} className="border-t border-border pt-5">
                                    <h3 className="font-semibold">{office.name}</h3>
                                    <address className="mt-2 text-muted-foreground not-italic">
                                        {office.addressLines.map((line) => (
                                            <span key={line} className="block">
                                                {line}
                                            </span>
                                        ))}
                                    </address>
                                </li>
                            ))}
                        </ul>
                        <p className="mt-8 text-sm">
                            <Placeholder>How the two offices share work, to confirm</Placeholder>
                        </p>
                    </div>
                </div>
            </section>

            <section aria-labelledby="numbers-heading" className="bg-muted py-(--section-space)">
                <div className="mx-auto max-w-(--container-max) px-(--gutter)">
                    <SectionHeading id="numbers-heading">WeIntegral in numbers</SectionHeading>
                    <dl className="grid grid-cols-2 gap-x-6 gap-y-8 border-t border-border pt-6 lg:grid-cols-4">
                        {stats.map((stat) => (
                            <div key={stat.label} className="flex flex-col-reverse">
                                <dt className="text-sm text-muted-foreground">{stat.label}</dt>
                                <dd className="text-(length:--text-h2) leading-tight font-semibold tracking-tight">
                                    {stat.value}
                                </dd>
                            </div>
                        ))}
                    </dl>
                    <p className="mt-6 text-caption">
                        <Placeholder>
                            Figures carried over from the previous About page, to confirm with an
                            "as of" date
                        </Placeholder>
                    </p>
                </div>
            </section>

            <ClosingBand />
        </SiteLayout>
    );
}
