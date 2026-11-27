import type { VisitorRequest } from "./visitor-request-schema";

export type VisitorRequestFieldErrors = Partial<Record<keyof VisitorRequest, string>>;

/** The API rejected one or more form fields (HTTP 422); `fieldErrors` holds the first message per field and is never empty. */
export class VisitorRequestRejectedError extends Error {
    constructor(
        message: string,
        readonly fieldErrors: VisitorRequestFieldErrors,
    ) {
        super(message);
        this.name = "VisitorRequestRejectedError";
    }
}

interface ValidationErrorBody {
    message?: string;
    errors?: Record<string, string[]>;
}

/**
 * Posts a Visitor Request to the existing JSON API. Throws VisitorRequestRejectedError when
 * a 422 names form fields, and a plain Error on any other non-201 response.
 */
export async function submitVisitorRequest(
    url: string,
    visitorRequest: VisitorRequest,
): Promise<void> {
    const response = await fetch(url, {
        method: "POST",
        headers: { Accept: "application/json", "Content-Type": "application/json" },
        body: JSON.stringify(visitorRequest),
    });

    if (response.status === 201) {
        return;
    }

    if (response.status === 422) {
        const body = (await response.json()) as ValidationErrorBody;
        const fieldErrors: VisitorRequestFieldErrors = {};
        for (const [field, messages] of Object.entries(body.errors ?? {})) {
            if (field in visitorRequest && messages[0]) {
                fieldErrors[field as keyof VisitorRequest] = messages[0];
            }
        }
        // Errors the form can't show beside a field must still reach the visitor, as a general failure.
        if (Object.keys(fieldErrors).length === 0) {
            throw new Error(`Visitor Request rejected without field errors: ${body.message ?? ""}`);
        }
        throw new VisitorRequestRejectedError(
            body.message ?? "The Visitor Request was rejected.",
            fieldErrors,
        );
    }

    throw new Error(`Visitor Request failed with HTTP ${response.status}`);
}
