import * as React from "react";
import { cva } from "class-variance-authority";
import { cn } from "cn";
import { NavigationMenu as NavigationMenuPrimitive } from "radix-ui";
import { ChevronDownIcon } from "lucide-react";

// shadcn/ui navigation-menu, restyled to DESIGN.md (Navigation): 6px triggers with the
// accent wash when hovered or open, a rotating chevron, and no shared viewport so each
// menu's content positions itself (the Services mega-menu spans the header).

function NavigationMenu({
    className,
    children,
    ...props
}: React.ComponentProps<typeof NavigationMenuPrimitive.Root>) {
    return (
        <NavigationMenuPrimitive.Root
            data-slot="navigation-menu"
            className={cn("group/navigation-menu relative flex items-center", className)}
            {...props}
        >
            {children}
        </NavigationMenuPrimitive.Root>
    );
}

function NavigationMenuList({
    className,
    ...props
}: React.ComponentProps<typeof NavigationMenuPrimitive.List>) {
    return (
        <NavigationMenuPrimitive.List
            data-slot="navigation-menu-list"
            className={cn("flex list-none items-center gap-1", className)}
            {...props}
        />
    );
}

function NavigationMenuItem({
    className,
    ...props
}: React.ComponentProps<typeof NavigationMenuPrimitive.Item>) {
    return (
        <NavigationMenuPrimitive.Item
            data-slot="navigation-menu-item"
            className={cn("relative", className)}
            {...props}
        />
    );
}

const navigationMenuTriggerStyle = cva(
    "group/navigation-menu-trigger inline-flex min-h-10 w-max items-center gap-1 rounded-md px-3 py-2 text-[0.9375rem] font-[550] text-foreground transition-colors duration-(--duration-fast) ease-brand outline-none hover:bg-accent hover:text-accent-foreground focus-visible:outline-2 focus-visible:outline-offset-3 focus-visible:outline-ring data-[state=open]:bg-accent data-[state=open]:text-accent-foreground aria-[current=page]:rounded-none aria-[current=page]:shadow-[inset_0_-2px_0_var(--brand-coral)]",
);

function NavigationMenuTrigger({
    className,
    children,
    ...props
}: React.ComponentProps<typeof NavigationMenuPrimitive.Trigger>) {
    return (
        <NavigationMenuPrimitive.Trigger
            data-slot="navigation-menu-trigger"
            className={cn(navigationMenuTriggerStyle(), className)}
            {...props}
        >
            {children}
            <ChevronDownIcon
                className="size-3.5 transition-transform duration-(--duration-base) ease-brand group-data-[state=open]/navigation-menu-trigger:rotate-180"
                aria-hidden="true"
            />
        </NavigationMenuPrimitive.Trigger>
    );
}

function NavigationMenuContent({
    className,
    ...props
}: React.ComponentProps<typeof NavigationMenuPrimitive.Content>) {
    return (
        <NavigationMenuPrimitive.Content
            data-slot="navigation-menu-content"
            className={cn(
                "absolute top-full z-50 bg-popover text-popover-foreground shadow-token-lg data-[state=open]:animate-in data-[state=open]:fade-in-0 data-[state=closed]:animate-out data-[state=closed]:fade-out-0",
                className,
            )}
            {...props}
        />
    );
}

function NavigationMenuLink({
    className,
    ...props
}: React.ComponentProps<typeof NavigationMenuPrimitive.Link>) {
    return (
        <NavigationMenuPrimitive.Link
            data-slot="navigation-menu-link"
            className={cn(
                "block rounded-md transition-colors duration-(--duration-fast) ease-brand outline-none hover:bg-accent focus-visible:bg-accent focus-visible:outline-2 focus-visible:outline-offset-0 focus-visible:outline-ring",
                className,
            )}
            {...props}
        />
    );
}

export {
    NavigationMenu,
    NavigationMenuList,
    NavigationMenuItem,
    NavigationMenuContent,
    NavigationMenuTrigger,
    NavigationMenuLink,
    navigationMenuTriggerStyle,
};
