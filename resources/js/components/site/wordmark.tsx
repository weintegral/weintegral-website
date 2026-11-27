import { cn } from "cn";

/** The Poppins "WEINTEGRAL" wordmark (no monogram), linking home. */
export function Wordmark({ className }: { className?: string }) {
    return (
        <a
            href="/"
            aria-label="WeIntegral home"
            className={cn(
                "inline-flex shrink-0 items-center border-l-[6px] border-brand-coral pl-2 font-wordmark text-[1.0625rem] leading-none font-bold tracking-[0.04em] text-primary uppercase lg:text-xl",
                className,
            )}
        >
            WeIntegral
        </a>
    );
}
