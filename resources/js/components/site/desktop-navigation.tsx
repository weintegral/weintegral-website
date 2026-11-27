import { usePage } from "@inertiajs/react";
import { ArrowRight, ArrowUpRight } from "lucide-react";
import type { PointerEvent } from "react";

import { Button } from "@/components/ui/button";
import {
    NavigationMenu,
    NavigationMenuContent,
    NavigationMenuItem,
    NavigationMenuLink,
    NavigationMenuList,
    NavigationMenuTrigger,
    navigationMenuTriggerStyle,
} from "@/components/ui/navigation-menu";

import {
    aboutLinks,
    careersLinks,
    contactHref,
    industriesHref,
    insightsHref,
    servicesHref,
    type NavLink,
} from "./site-navigation";

/** Menus open on click or Enter only (DESIGN.md), so cancel Radix's hover-to-open. */
const ignorePointer = (event: PointerEvent) => event.preventDefault();
const clickToOpen = { onPointerMove: ignorePointer, onPointerLeave: ignorePointer };
const keepOpenOnHover = { onPointerEnter: ignorePointer, onPointerLeave: ignorePointer };

interface DesktopNavigationProps {
    /** The open menu ("services", "about", "careers") or "" when all are closed. */
    openMenu: string;
    onOpenMenuChange: (menu: string) => void;
    currentPath: string;
}

/**
 * The primary navigation from 64rem up: the Services mega-menu, Industries,
 * Insights (the external blog) and the About and Careers dropdowns.
 */
export function DesktopNavigation({
    openMenu,
    onOpenMenuChange,
    currentPath,
}: DesktopNavigationProps) {
    // The root, Radix's relatively positioned list wrapper (the `> div`) and the Services
    // item are all static, so the mega-menu positions against the header bar and spans it.
    return (
        <NavigationMenu
            aria-label="Primary"
            value={openMenu}
            onValueChange={onOpenMenuChange}
            className="static mr-auto hidden lg:flex [&>div]:static!"
        >
            <NavigationMenuList>
                <NavigationMenuItem value="services" className="static">
                    <NavigationMenuTrigger {...clickToOpen}>Services</NavigationMenuTrigger>
                    <NavigationMenuContent
                        {...keepOpenOnHover}
                        className="inset-x-0 border-y border-border"
                    >
                        <ServicesMegaMenu />
                    </NavigationMenuContent>
                </NavigationMenuItem>

                <NavigationMenuItem>
                    <NavigationMenuLink
                        href={industriesHref}
                        aria-current={currentPath.startsWith(industriesHref) ? "page" : undefined}
                        className={navigationMenuTriggerStyle()}
                    >
                        Industries
                    </NavigationMenuLink>
                </NavigationMenuItem>

                <NavigationMenuItem>
                    <NavigationMenuLink
                        href={insightsHref}
                        target="_blank"
                        rel="noopener"
                        className={navigationMenuTriggerStyle()}
                    >
                        Insights
                        <ArrowUpRight className="size-3.5" aria-hidden="true" />
                        <span className="sr-only">(opens the blog in a new tab)</span>
                    </NavigationMenuLink>
                </NavigationMenuItem>

                <DropdownMenu value="about" label="About" links={aboutLinks} />
                <DropdownMenu value="careers" label="Careers" links={careersLinks} />
            </NavigationMenuList>
        </NavigationMenu>
    );
}

function ServicesMegaMenu() {
    const { services } = usePage().props.site;

    return (
        <div className="mx-auto grid max-w-(--container-max) grid-cols-[minmax(0,1fr)_20rem] gap-10 px-(--gutter) pt-8 pb-9">
            <div>
                <div className="mb-3 flex items-baseline justify-between px-4">
                    <h2 className="text-sm font-semibold text-muted-foreground">Services</h2>
                    <NavigationMenuLink
                        href={servicesHref}
                        className="group/link inline-flex items-center gap-1.5 px-1 text-sm font-semibold text-foreground hover:bg-transparent hover:text-emphasis"
                    >
                        View all Services
                        <ArrowRight
                            className="size-3.5 transition-transform duration-(--duration-slow) ease-brand group-hover/link:translate-x-0.75"
                            aria-hidden="true"
                        />
                    </NavigationMenuLink>
                </div>
                <ul className="grid grid-cols-2 gap-x-6 gap-y-1">
                    {services.map((service) => (
                        <li key={service.href}>
                            <NavigationMenuLink
                                href={service.href}
                                className="group/link px-4 py-3.5"
                            >
                                <span className="flex items-center gap-1.5 text-[0.9375rem] font-[620]">
                                    {service.name}
                                    <ArrowRight
                                        className="size-3.5 -translate-x-1 text-emphasis opacity-0 transition duration-(--duration-slow) ease-brand group-hover/link:translate-x-0 group-hover/link:opacity-100 group-focus-visible/link:translate-x-0 group-focus-visible/link:opacity-100"
                                        aria-hidden="true"
                                    />
                                </span>
                                <span className="mt-0.5 block text-sm text-muted-foreground">
                                    {service.outcome}
                                </span>
                            </NavigationMenuLink>
                        </li>
                    ))}
                </ul>
            </div>
            <div className="flex flex-col items-start gap-3 rounded-xl bg-inverse p-7 text-inverse-foreground">
                <h3 className="text-lg font-semibold">Not sure which Service fits?</h3>
                <p className="text-sm text-inverse-muted">
                    Tell us what you're building or who you need, and we'll point you to the right
                    team.
                </p>
                <Button asChild variant="cta" size="brand" className="mt-2">
                    <NavigationMenuLink href={contactHref} data-menu-cta="">
                        Talk to an Expert
                        <ArrowRight className="size-4" aria-hidden="true" />
                    </NavigationMenuLink>
                </Button>
            </div>
        </div>
    );
}

function DropdownMenu({ value, label, links }: { value: string; label: string; links: NavLink[] }) {
    return (
        <NavigationMenuItem value={value}>
            <NavigationMenuTrigger {...clickToOpen}>{label}</NavigationMenuTrigger>
            <NavigationMenuContent
                {...keepOpenOnHover}
                className="left-0 mt-2 min-w-60 rounded-xl border border-border p-1.5"
            >
                <ul>
                    {links.map((link) => (
                        <li key={link.href}>
                            <NavigationMenuLink
                                href={link.href}
                                className="px-3 py-2.5 text-[0.9375rem] font-medium"
                            >
                                {link.label}
                            </NavigationMenuLink>
                        </li>
                    ))}
                </ul>
            </NavigationMenuContent>
        </NavigationMenuItem>
    );
}
