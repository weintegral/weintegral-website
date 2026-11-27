import { usePage } from "@inertiajs/react";
import { Mail, Phone } from "lucide-react";
import { useEffect, useState } from "react";

import { Button } from "@/components/ui/button";

import { DesktopNavigation } from "./desktop-navigation";
import { MobileMenu } from "./mobile-menu";
import { candidateResourcesHref, careersHref, contactHref, telHref } from "./site-navigation";
import { Wordmark } from "./wordmark";

/** The utility bar and header: wordmark, primary navigation, "Talk to an Expert" and the mobile menu. */
export function SiteHeader() {
    const { props, url } = usePage();
    const { contact } = props.site;
    const currentPath = url.split("?")[0] ?? "/";

    const [openMenu, setOpenMenu] = useState("");
    // Marks the moment React has taken over the server-rendered header (tests wait on it).
    const [hydrated, setHydrated] = useState(false);
    useEffect(() => setHydrated(true), []);

    return (
        <>
            <header data-hydrated={hydrated ? "true" : undefined} className="relative z-30">
                <div className="hidden bg-inverse text-caption text-inverse-muted min-[36rem]:block">
                    <div className="mx-auto flex min-h-9 max-w-(--container-max) items-center justify-between gap-4 px-(--gutter)">
                        <div className="flex items-center gap-6">
                            <a
                                href={`mailto:${contact.email}`}
                                className="inline-flex items-center gap-1.5 hover:text-inverse-foreground"
                            >
                                <Mail className="size-3.5" aria-hidden="true" />
                                {contact.email}
                            </a>
                            <a
                                href={telHref(contact.phone)}
                                className="hidden items-center gap-1.5 hover:text-inverse-foreground min-[52rem]:inline-flex"
                            >
                                <Phone className="size-3.5" aria-hidden="true" />
                                {contact.phone}
                            </a>
                        </div>
                        <div className="flex items-center gap-6">
                            <a
                                href={candidateResourcesHref}
                                className="hover:text-inverse-foreground"
                            >
                                Candidate Resources
                            </a>
                            <a href={careersHref} className="hover:text-inverse-foreground">
                                Careers
                            </a>
                        </div>
                    </div>
                </div>

                <div className="relative border-b border-border bg-background">
                    <div className="mx-auto flex min-h-16 max-w-(--container-max) items-center justify-between gap-8 px-(--gutter) lg:min-h-18 lg:justify-start">
                        <Wordmark />
                        <DesktopNavigation
                            openMenu={openMenu}
                            onOpenMenuChange={setOpenMenu}
                            currentPath={currentPath}
                        />
                        <div className="flex items-center gap-2">
                            <Button
                                asChild
                                variant="cta"
                                size="brand"
                                className="hidden lg:inline-flex"
                            >
                                <a
                                    href={contactHref}
                                    data-header-cta=""
                                    aria-current={currentPath === contactHref ? "page" : undefined}
                                >
                                    Talk to an Expert
                                </a>
                            </Button>
                            <MobileMenu contact={contact} />
                        </div>
                    </div>
                </div>
            </header>

            {/* Dims the page behind the open Services mega-menu; a click on it closes the menu. */}
            {openMenu === "services" && (
                <div
                    aria-hidden="true"
                    className="fixed inset-0 z-20 hidden bg-[rgb(11_23_48/0.32)] lg:block"
                />
            )}
        </>
    );
}
