import { usePage } from "@inertiajs/react";
import { ArrowUpRight, Mail, Menu, Phone, X } from "lucide-react";
import type { ReactNode } from "react";

import {
    Accordion,
    AccordionContent,
    AccordionItem,
    AccordionTrigger,
} from "@/components/ui/accordion";
import { Button } from "@/components/ui/button";
import {
    Sheet,
    SheetClose,
    SheetContent,
    SheetDescription,
    SheetTitle,
    SheetTrigger,
} from "@/components/ui/sheet";
import type { SiteProps } from "@/types/inertia";

import {
    aboutLinks,
    careersLinks,
    contactHref,
    industriesHref,
    insightsHref,
    servicesHref,
    telHref,
    type NavLink,
} from "./site-navigation";
import { Wordmark } from "./wordmark";

const rowClass =
    "flex min-h-14 w-full items-center justify-between px-5 text-[1.0625rem] font-semibold text-foreground";

/**
 * Below 64rem: a menu button opening a full-height sheet. Sections are accordions
 * (Services starts expanded) and the CTA, email and phone are pinned to the bottom.
 */
export function MobileMenu({ contact }: { contact: SiteProps["contact"] }) {
    const { services } = usePage().props.site;

    return (
        <Sheet>
            <SheetTrigger asChild>
                <Button
                    variant="ghost"
                    size="icon-brand"
                    aria-label="Open menu"
                    className="lg:hidden"
                >
                    <Menu aria-hidden="true" />
                </Button>
            </SheetTrigger>
            <SheetContent
                side="right"
                showCloseButton={false}
                className="w-full gap-0 border-l-0 bg-background data-[side=right]:w-full data-[side=right]:sm:max-w-md"
            >
                <SheetTitle className="sr-only">Menu</SheetTitle>
                <SheetDescription className="sr-only">Site navigation</SheetDescription>
                <div className="flex min-h-16 items-center justify-between border-b border-border pr-2 pl-4">
                    <Wordmark />
                    <SheetClose asChild>
                        <Button variant="ghost" size="icon-brand" aria-label="Close menu">
                            <X aria-hidden="true" />
                        </Button>
                    </SheetClose>
                </div>

                <nav aria-label="Mobile" className="flex-1 overflow-y-auto">
                    <Accordion type="multiple" defaultValue={["services"]}>
                        <MenuSection value="services" label="Services">
                            {services.map((service) => (
                                <SubLink
                                    key={service.href}
                                    href={service.href}
                                    label={service.name}
                                >
                                    {service.outcome}
                                </SubLink>
                            ))}
                            <a
                                href={servicesHref}
                                className="block rounded-md py-2.5 pr-2 pl-3 text-[0.9375rem] font-semibold text-emphasis hover:bg-accent"
                            >
                                All Services
                            </a>
                        </MenuSection>
                        <div className="border-b border-border">
                            <a href={industriesHref} className={rowClass}>
                                Industries
                            </a>
                        </div>
                        <div className="border-b border-border">
                            <a
                                href={insightsHref}
                                target="_blank"
                                rel="noopener"
                                className={rowClass}
                            >
                                <span>
                                    Insights
                                    <span className="sr-only"> (opens the blog in a new tab)</span>
                                </span>
                                <ArrowUpRight className="size-5" aria-hidden="true" />
                            </a>
                        </div>
                        <LinkSection value="about" label="About" links={aboutLinks} />
                        <LinkSection value="careers" label="Careers" links={careersLinks} />
                    </Accordion>
                </nav>

                <div className="sticky bottom-0 grid gap-4 border-t border-border bg-muted p-5">
                    <Button asChild variant="cta" size="brand-lg" className="w-full">
                        <a href={contactHref}>Talk to an Expert</a>
                    </Button>
                    <a
                        href={`mailto:${contact.email}`}
                        className="flex items-center gap-2 text-sm text-muted-foreground"
                    >
                        <Mail className="size-4" aria-hidden="true" />
                        {contact.email}
                    </a>
                    <a
                        href={telHref(contact.phone)}
                        className="flex items-center gap-2 text-sm text-muted-foreground"
                    >
                        <Phone className="size-4" aria-hidden="true" />
                        {contact.phone}
                    </a>
                </div>
            </SheetContent>
        </Sheet>
    );
}

function MenuSection({
    value,
    label,
    children,
}: {
    value: string;
    label: string;
    children: ReactNode;
}) {
    return (
        <AccordionItem value={value} className="border-b border-border">
            <AccordionTrigger className="min-h-14 items-center rounded-none px-5 py-0 text-[1.0625rem] font-semibold hover:no-underline">
                {label}
            </AccordionTrigger>
            <AccordionContent className="px-3 pb-3 [&_a]:no-underline">{children}</AccordionContent>
        </AccordionItem>
    );
}

function LinkSection({ value, label, links }: { value: string; label: string; links: NavLink[] }) {
    return (
        <MenuSection value={value} label={label}>
            {links.map((link) => (
                <SubLink key={link.href} href={link.href} label={link.label} />
            ))}
        </MenuSection>
    );
}

function SubLink({ href, label, children }: { href: string; label: string; children?: ReactNode }) {
    return (
        <a href={href} className="block rounded-md py-2.5 pr-2 pl-3 hover:bg-accent">
            <span className="block text-[0.9375rem] font-[550] text-foreground">{label}</span>
            {children && (
                <span className="block text-[0.8125rem] text-muted-foreground">{children}</span>
            )}
        </a>
    );
}
