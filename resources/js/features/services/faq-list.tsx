import { ChevronDown } from "lucide-react";

import { CopyText } from "./copy-text";
import type { Copy } from "./service";

export interface Faq {
    question: string;
    answer: Copy;
}

/** Questions as native disclosure widgets: readable and operable before JavaScript loads. The first starts open. */
export function FaqList({ faqs }: { faqs: Faq[] }) {
    return (
        <div className="max-w-4xl border-t border-border">
            {faqs.map((faq, index) => (
                <details
                    key={faq.question}
                    open={index === 0}
                    className="group border-b border-border"
                >
                    <summary className="flex cursor-pointer list-none items-center justify-between gap-4 py-5 text-(length:--text-h4) font-semibold tracking-[-0.01em] hover:text-emphasis [&::-webkit-details-marker]:hidden">
                        {faq.question}
                        <ChevronDown
                            className="size-5 shrink-0 transition-transform duration-(--duration-base) ease-brand group-open:rotate-180"
                            aria-hidden="true"
                        />
                    </summary>
                    <p className="max-w-[64ch] pb-6 text-muted-foreground">
                        <CopyText copy={faq.answer} />
                    </p>
                </details>
            ))}
        </div>
    );
}
