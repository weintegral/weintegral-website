/**
 * A Client testimonial. Publish only real quotes with the person's written consent;
 * the old site's testimonials are template placeholders and must never be used.
 */
export interface Testimonial {
    quote: string;
    name: string;
    /** Job title, e.g. "Director of Engineering". */
    title: string;
    company: string;
}

/** Testimonials band for the homepage. Renders nothing until real testimonials exist. */
export function Testimonials({ testimonials }: { testimonials: Testimonial[] }) {
    if (testimonials.length === 0) {
        return null;
    }

    return (
        <section aria-labelledby="testimonials-heading" className="py-(--section-space)">
            <div className="mx-auto max-w-(--container-max) px-(--gutter)">
                <h2
                    id="testimonials-heading"
                    className="text-(length:--text-h2) leading-[1.15] font-semibold tracking-[-0.025em]"
                >
                    What our Clients say
                </h2>
                <ul className="mt-10 grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                    {testimonials.map((testimonial) => (
                        <li key={`${testimonial.name}-${testimonial.company}`}>
                            <figure className="flex h-full flex-col gap-6 border-t border-border pt-6">
                                <blockquote className="text-(length:--text-lead) leading-normal">
                                    <p>&ldquo;{testimonial.quote}&rdquo;</p>
                                </blockquote>
                                <figcaption className="mt-auto text-sm">
                                    <span className="block font-semibold">{testimonial.name}</span>
                                    <span className="text-muted-foreground">
                                        {testimonial.title}, {testimonial.company}
                                    </span>
                                </figcaption>
                            </figure>
                        </li>
                    ))}
                </ul>
            </div>
        </section>
    );
}
