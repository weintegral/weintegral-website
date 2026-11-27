import { usePage } from "@inertiajs/react";
import { ArrowRight, ArrowUpRight, Check } from "lucide-react";
import type { ReactNode } from "react";

import { IntegralLine, type Station } from "@/components/home/integral-line";
import { Testimonials, type Testimonial } from "@/components/home/testimonials";
import { ClosingBand } from "@/components/site/closing-band";
import { Placeholder } from "@/components/site/placeholder";
import { ProcessBand } from "@/components/site/process-band";
import { SectionHeading, sectionHeadingGap } from "@/components/site/section-heading";
import { SiteLayout } from "@/components/site/site-layout";
import {
    careersLinks,
    contactHref,
    industriesHref,
    insightsHref,
    openPositionsLink,
    servicesHref,
    telHref,
} from "@/components/site/site-navigation";
import { Button } from "@/components/ui/button";
import { typeRoles } from "@/lib/typography";
import type { ServiceListing } from "@/types/inertia";

/** A figure shown in "Why WeIntegral", awaiting owner confirmation. */
export interface Statistic {
    value: string;
    label: string;
}

/** A post from the external blog's feed. */
export interface Insight {
    title: string;
    url: string;
    /** ISO date (YYYY-MM-DD), or null when the feed gave none. */
    publishedOn: string | null;
}

/** Props from HomePageController::indexAction. */
export interface HomePageProps {
    statistics: Statistic[];
    testimonials: Testimonial[];
    /** Newest first, at most three; empty when the blog feed is unavailable (sample posts when sample content is on). */
    insights: Insight[];
    /** Sample copy for the page's gaps (App\Content\SampleContent::home()); null unless sample content is on. */
    sample: { officeWork: string } | null;
}

const { section: h2, title: h3, subtitle: h4, lead } = typeRoles;
const container = "mx-auto max-w-(--container-max) px-(--gutter)";
const section = "py-(--section-space)";
const linkArrow =
    "group/link inline-flex items-center gap-1.5 font-semibold hover:text-emphasis [&_svg]:transition-transform [&_svg]:duration-(--duration-slow) [&_svg]:ease-brand hover:[&_svg]:translate-x-[3px]";

/** Homepage copy for each Service, keyed by its page path. */
const serviceDetails: Record<string, { summary: string; role: string }> = {
    "/app-development": {
        summary:
            "Web and mobile applications designed and built around how your business actually works.",
        role: "Build",
    },
    "/app-support": {
        summary:
            "Maintenance and production support that keeps the applications your business depends on stable.",
        role: "Run",
    },
    "/testing": {
        summary:
            "Testing aimed at deployment readiness, so every release ships with fewer surprises.",
        role: "Test",
    },
    "/devops": {
        summary:
            "Build pipelines and cloud deployment that move code from commit to production reliably.",
        role: "Deploy",
    },
    "/staffing": {
        summary: "Skilled IT professionals who join your team for the roles you need to fill.",
        role: "People for every stage",
    },
};

/** The line runs build, test, deploy, run, with staffing alongside every stage. */
const stationOrder = ["/app-development", "/testing", "/devops", "/app-support", "/staffing"];

function stationsFor(services: ServiceListing[]): Station[] {
    return stationOrder.flatMap((href) => {
        const service = services.find((candidate) => candidate.href === href);

        return service
            ? [{ label: service.name, href, role: serviceDetails[href]?.role ?? "" }]
            : [];
    });
}

/** "Why WeIntegral" items; `officeWork` is the sample split of work between the offices, if any. */
function differentiators(officeWork: string | undefined): { title: string; body: ReactNode }[] {
    return [
        {
            title: "Build, test and run under one roof",
            body: "Development, quality assurance, DevOps and support sit with one firm, so nothing gets lost between vendors.",
        },
        {
            title: "Built around your needs",
            body: "We customize every solution to your goals, your process and the systems you already run.",
        },
        {
            title: "Teams in Texas and India",
            body: (
                <>
                    An office in Lakeway, Texas and a team in Ongole, Andhra Pradesh.{" "}
                    {officeWork ?? (
                        <Placeholder>Owner to confirm how the two offices share work</Placeholder>
                    )}
                </>
            ),
        },
        {
            title: "People who keep learning",
            body: "We invest in continuous learning, so our people stay current with the technologies your project needs.",
        },
    ];
}

const careerPillars = [
    {
        title: "People first",
        body: "People are our business, and we invest in long-lasting relationships.",
    },
    {
        title: "Room to grow",
        body: "Every employee and consultant can build skills and move their career forward.",
    },
    {
        title: "Connected teams",
        body: "A transparent, collaborative workplace where everyone has a voice.",
    },
];

const cultureLink = careersLinks.find((link) => link.label === "Culture");

const insightDate = new Intl.DateTimeFormat("en-US", { dateStyle: "medium", timeZone: "UTC" });

export default function Home({ statistics, testimonials, insights, sample }: HomePageProps) {
    const { contact, services, industries } = usePage().props.site;

    return (
        <SiteLayout>
            {/* Hero */}
            <section
                aria-labelledby="home-heading"
                className="overflow-hidden bg-inverse text-inverse-foreground"
            >
                <div
                    className={`${container} grid items-center gap-8 py-[clamp(3.5rem,2rem+6vw,7rem)] min-[52rem]:grid-cols-[minmax(0,1.05fr)_minmax(0,0.95fr)]`}
                >
                    <div>
                        <h1 id="home-heading" className={`max-w-[13ch] ${typeRoles.display}`}>
                            One team for the software your business runs on.
                        </h1>
                        <p className={`${lead} mt-6 max-w-[46ch] text-inverse-muted`}>
                            WeIntegral builds web and mobile applications, tests them, deploys them
                            to the cloud and keeps them running, and supplies the IT specialists to
                            extend your team.
                        </p>
                        <div className="mt-9 flex flex-wrap gap-3">
                            <Button asChild variant="cta" size="brand-lg" className="group/cta">
                                <a href={contactHref} data-hero-cta="">
                                    Talk to an Expert
                                    <ArrowRight
                                        aria-hidden="true"
                                        className="transition-transform duration-(--duration-slow) ease-brand group-hover/cta:translate-x-[3px]"
                                    />
                                </a>
                            </Button>
                            <Button
                                asChild
                                variant="outline"
                                size="brand-lg"
                                className="border-inverse-border bg-transparent text-inverse-foreground hover:border-inverse-muted hover:bg-white/8 hover:text-inverse-foreground dark:border-inverse-border dark:bg-transparent dark:hover:bg-white/8"
                            >
                                <a href={openPositionsLink.href}>Find a role</a>
                            </Button>
                        </div>
                        <p className="mt-6 text-sm text-inverse-muted">
                            Prefer the phone? Call{" "}
                            <a
                                href={telHref(contact.phone)}
                                className="text-inverse-foreground underline underline-offset-4 hover:decoration-2"
                            >
                                {contact.phone}
                            </a>
                            .
                        </p>
                    </div>
                    <IntegralLine stations={stationsFor(services)} />
                </div>
            </section>

            {/* Services */}
            <section aria-labelledby="services-heading" className={section}>
                <div className={container}>
                    <SectionHeading
                        id="services-heading"
                        intro="Start with the Service you need today. Because we cover build, testing, deployment and support, one firm can carry your application from first release to day-to-day support."
                        action={<SeeAllLink label="All Services" href={servicesHref} />}
                        className={sectionHeadingGap}
                    >
                        Five Services. One accountable team.
                    </SectionHeading>
                    <ul className="border-t border-border">
                        {services.map((service) => (
                            <li key={service.href}>
                                <a
                                    href={service.href}
                                    className="group/svc grid grid-cols-[minmax(0,1fr)_2.75rem] items-center gap-x-4 gap-y-2 border-b border-border py-7 transition-colors duration-(--duration-base) ease-brand hover:bg-muted min-[52rem]:grid-cols-[minmax(0,1fr)_minmax(0,1.25fr)_2.75rem] min-[52rem]:gap-8 min-[52rem]:px-3"
                                >
                                    <h3
                                        className={`${h3} transition-colors group-hover/svc:text-emphasis`}
                                    >
                                        {service.name}
                                    </h3>
                                    <p className="col-start-1 row-start-2 max-w-[56ch] text-muted-foreground min-[52rem]:col-start-auto min-[52rem]:row-start-auto">
                                        {serviceDetails[service.href]?.summary}
                                    </p>
                                    <span
                                        aria-hidden="true"
                                        className="col-start-2 row-span-2 row-start-1 grid size-11 place-items-center rounded-full border border-border transition-colors group-hover/svc:border-cta group-hover/svc:bg-cta group-hover/svc:text-cta-foreground min-[52rem]:col-start-auto min-[52rem]:row-span-1 min-[52rem]:row-start-auto"
                                    >
                                        <ArrowRight className="size-5" />
                                    </span>
                                </a>
                            </li>
                        ))}
                    </ul>
                </div>
            </section>

            {/* Why WeIntegral */}
            <section aria-labelledby="why-heading" className={`${section} bg-muted`}>
                <div className={container}>
                    <div className="grid gap-[clamp(2rem,1rem+4vw,5rem)] min-[52rem]:grid-cols-[minmax(0,5fr)_minmax(0,7fr)]">
                        <div>
                            <h2 id="why-heading" className={h2}>
                                Why Clients choose WeIntegral
                            </h2>
                            <p className={`${lead} mt-4 max-w-[40ch] text-muted-foreground`}>
                                We shape every engagement around your goals and constraints, not a
                                fixed package.
                            </p>
                        </div>
                        <ul className="grid gap-10 sm:grid-cols-2">
                            {differentiators(sample?.officeWork).map((item) => (
                                <li key={item.title}>
                                    <h3
                                        className={`${h4} relative mb-2 pt-4 before:absolute before:top-0 before:left-0 before:h-0.5 before:w-6 before:bg-brand-coral`}
                                    >
                                        {item.title}
                                    </h3>
                                    <p className="text-muted-foreground">{item.body}</p>
                                </li>
                            ))}
                        </ul>
                    </div>
                    <div
                        data-statistics=""
                        className="mt-[clamp(2.5rem,2rem+2vw,4rem)] border-t border-border pt-6"
                    >
                        <dl className="grid grid-cols-2 gap-6 md:grid-cols-4">
                            {statistics.map((statistic) => (
                                <div key={statistic.label} className="flex flex-col-reverse">
                                    <dt className="text-sm text-muted-foreground">
                                        {statistic.label}
                                    </dt>
                                    <dd className={`${h2} tabular-nums`}>{statistic.value}</dd>
                                </div>
                            ))}
                        </dl>
                        {!sample && (
                            <p className="mt-6 text-caption">
                                <Placeholder>
                                    To confirm: figures copied from the current About page. Owner to
                                    confirm them, and add an &ldquo;as of&rdquo; date, before
                                    launch.
                                </Placeholder>
                            </p>
                        )}
                    </div>
                </div>
            </section>

            {/* Industries */}
            <section aria-labelledby="industries-heading" className={section}>
                <div className={container}>
                    <SectionHeading
                        id="industries-heading"
                        intro="Domain knowledge shortens every project. These are the sectors our teams work in."
                        action={<SeeAllLink label="All Industries" href={industriesHref} />}
                        className={sectionHeadingGap}
                    >
                        Industries we serve
                    </SectionHeading>
                    <ul className="grid border-t border-foreground min-[52rem]:grid-cols-3">
                        {industries.map((industry) => (
                            <li
                                key={industry.name}
                                className="border-b border-border min-[52rem]:border-r min-[52rem]:border-b-0 min-[52rem]:not-first:pl-6 min-[52rem]:last:border-r-0"
                            >
                                <a
                                    href={industriesHref}
                                    className="group/ind flex flex-col gap-3 py-6 min-[52rem]:pt-7 min-[52rem]:pr-6 min-[52rem]:pb-8"
                                >
                                    <h3
                                        className={`${h2} transition-colors group-hover/ind:text-emphasis`}
                                    >
                                        {industry.name}
                                    </h3>
                                    <span className="text-sm text-muted-foreground">
                                        {industry.summary}
                                    </span>
                                </a>
                            </li>
                        ))}
                    </ul>
                    {!sample && (
                        <p className="mt-6 text-sm text-muted-foreground">
                            <Placeholder>
                                Industry list taken from the current Industries page; owner to
                                confirm or extend
                            </Placeholder>
                        </p>
                    )}
                </div>
            </section>

            <ProcessBand heading="From first conversation to running software" />

            <Testimonials testimonials={testimonials} />

            {/* Latest Insights */}
            <section aria-labelledby="insights-heading" className={section}>
                <div className={container}>
                    <SectionHeading
                        id="insights-heading"
                        intro="Notes from our team on building, testing and running software."
                        action={<SeeAllLink label="Visit the blog" href={insightsHref} external />}
                        className={sectionHeadingGap}
                    >
                        Latest Insights
                    </SectionHeading>
                    <ul className="grid gap-8 min-[52rem]:grid-cols-3">
                        {insights.length > 0
                            ? insights.map((insight) => (
                                  <li key={insight.url}>
                                      <InsightLink href={insight.url}>
                                          {insight.publishedOn && (
                                              <time
                                                  dateTime={insight.publishedOn}
                                                  className="text-caption text-muted-foreground"
                                              >
                                                  {insightDate.format(
                                                      new Date(`${insight.publishedOn}T00:00:00Z`),
                                                  )}
                                              </time>
                                          )}
                                          <span
                                              className={`${h4} transition-colors group-hover/insight:text-emphasis`}
                                          >
                                              {insight.title}
                                          </span>
                                      </InsightLink>
                                  </li>
                              ))
                            : ["Latest post title", "Second post title", "Third post title"].map(
                                  (title) => (
                                      <li key={title}>
                                          <InsightLink href={insightsHref}>
                                              <span className="text-caption text-muted-foreground">
                                                  <Placeholder>Post date</Placeholder>
                                              </span>
                                              <span className={h4}>
                                                  <Placeholder>
                                                      {title}, pulled from the blog
                                                  </Placeholder>
                                              </span>
                                          </InsightLink>
                                      </li>
                                  ),
                              )}
                    </ul>
                </div>
            </section>

            {/* Careers teaser */}
            <section aria-labelledby="careers-heading" className={`${section} bg-muted`}>
                <div
                    className={`${container} grid items-center gap-[clamp(2rem,1rem+4vw,5rem)] min-[52rem]:grid-cols-2`}
                >
                    <img
                        src="/img/home/careers-team-800.webp"
                        srcSet="/img/home/careers-team-480.webp 480w, /img/home/careers-team-800.webp 800w, /img/home/careers-team-1200.webp 1200w"
                        sizes="(min-width: 52rem) 40vw, 100vw"
                        width={800}
                        height={600}
                        loading="lazy"
                        decoding="async"
                        alt="Three colleagues laughing together over laptops at a shared table"
                        className="aspect-4/3 h-auto w-full rounded-xl object-cover"
                    />
                    <div>
                        <h2 id="careers-heading" className={h2}>
                            Grow your career with WeIntegral
                        </h2>
                        <p className={`${lead} mt-4 max-w-[44ch] text-muted-foreground`}>
                            We offer our employees and consultants room to grow, real support and a
                            voice in how we work.
                        </p>
                        <ul className="mt-8 grid gap-5">
                            {careerPillars.map((pillar) => (
                                <li
                                    key={pillar.title}
                                    className="grid grid-cols-[1.5rem_1fr] gap-3"
                                >
                                    <span className="mt-0.5 grid size-6 place-items-center rounded-full bg-secondary text-emphasis">
                                        <Check className="size-3.5" aria-hidden="true" />
                                    </span>
                                    <div>
                                        <b className="block font-[620]">{pillar.title}</b>
                                        <span className="text-sm text-muted-foreground">
                                            {pillar.body}
                                        </span>
                                    </div>
                                </li>
                            ))}
                        </ul>
                        <div className="mt-9 flex flex-wrap items-center gap-5">
                            <Button asChild size="brand" className="group/btn font-semibold">
                                <a href={openPositionsLink.href}>
                                    Browse open positions
                                    <ArrowRight
                                        aria-hidden="true"
                                        className="transition-transform duration-(--duration-slow) ease-brand group-hover/btn:translate-x-[3px]"
                                    />
                                </a>
                            </Button>
                            {cultureLink && (
                                <a href={cultureLink.href} className={linkArrow}>
                                    Life at WeIntegral
                                    <ArrowRight className="size-4" aria-hidden="true" />
                                </a>
                            )}
                        </div>
                    </div>
                </div>
            </section>

            <ClosingBand />
        </SiteLayout>
    );
}

/** A section's "see all" link, shown to the right of its heading. */
function SeeAllLink({
    label,
    href,
    external = false,
}: {
    label: string;
    href: string;
    external?: boolean;
}) {
    return external ? (
        <a href={href} target="_blank" rel="noopener" className={linkArrow}>
            {label}
            <ArrowUpRight className="size-4" aria-hidden="true" />
            <span className="sr-only">(opens in a new tab)</span>
        </a>
    ) : (
        <a href={href} className={linkArrow}>
            {label}
            <ArrowRight className="size-4" aria-hidden="true" />
        </a>
    );
}

/** An Insight card: date, title and "Read on the blog", opening the blog in a new tab. */
function InsightLink({ href, children }: { href: string; children: ReactNode }) {
    return (
        <a
            href={href}
            target="_blank"
            rel="noopener"
            className="group/insight flex h-full flex-col gap-3 border-t border-border pt-5"
        >
            {children}
            <span className="mt-auto inline-flex items-center gap-1.5 text-sm font-semibold">
                Read on the blog
                <ArrowUpRight className="size-3.5" aria-hidden="true" />
                <span className="sr-only">(opens in a new tab)</span>
            </span>
        </a>
    );
}
