import { z } from "zod";

/**
 * Client-side mirror of the Visitor Request API rules (App\Http\Requests\VisitorApiRequest):
 * every field required, with the same maximum lengths. The server trims input before
 * validating, so whitespace-only values count as empty here too.
 */
function requiredText(requiredMessage: string, max: number, maxMessage: string) {
    return z.string().trim().min(1, requiredMessage).max(max, maxMessage);
}

export const visitorRequestSchema = z.object({
    name: requiredText(
        "Please enter your name.",
        255,
        "Your name must be 255 characters or fewer.",
    ),
    email: requiredText(
        "Please enter your email address.",
        255,
        "Your email address must be 255 characters or fewer.",
    ).pipe(z.email("Please enter a valid email address.")),
    subject: requiredText(
        "Please enter a subject.",
        500,
        "The subject must be 500 characters or fewer.",
    ),
    message: requiredText(
        "Please enter a message.",
        1000,
        "The message must be 1000 characters or fewer.",
    ),
});

export type VisitorRequest = z.input<typeof visitorRequestSchema>;

export const visitorRequestFields = [
    "name",
    "email",
    "subject",
    "message",
] as const satisfies readonly (keyof VisitorRequest)[];
