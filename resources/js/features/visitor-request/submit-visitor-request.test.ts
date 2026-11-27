import { afterEach, describe, expect, it, vi } from "vite-plus/test";

import { submitVisitorRequest, VisitorRequestRejectedError } from "./submit-visitor-request";

const visitorRequest = {
    name: "Jane Visitor",
    email: "jane@example.com",
    subject: "Project enquiry",
    message: "We would like to discuss a new project.",
};

function respondWith(status: number, body: unknown = {}) {
    vi.stubGlobal(
        "fetch",
        vi.fn(async () => new Response(JSON.stringify(body), { status })),
    );
}

async function rejection(): Promise<unknown> {
    try {
        await submitVisitorRequest("/api/visitor-request", visitorRequest);
    } catch (error) {
        return error;
    }
    throw new Error("Expected the Visitor Request to be rejected");
}

afterEach(() => {
    vi.unstubAllGlobals();
});

describe("submitVisitorRequest", () => {
    it("resolves when the API creates the Visitor Request", async () => {
        respondWith(201);

        await expect(
            submitVisitorRequest("/api/visitor-request", visitorRequest),
        ).resolves.toBeUndefined();
    });

    it("reports the first server message for each rejected field", async () => {
        respondWith(422, {
            message: "The email field must be a valid email address.",
            errors: { email: ["The email field must be a valid email address.", "Second"] },
        });

        const error = await rejection();

        expect(error).toBeInstanceOf(VisitorRequestRejectedError);
        expect((error as VisitorRequestRejectedError).fieldErrors).toEqual({
            email: "The email field must be a valid email address.",
        });
    });

    it("treats a 422 whose errors name none of the form's fields as a general failure", async () => {
        respondWith(422, { message: "Too many requests.", errors: { token: ["Invalid."] } });

        const error = await rejection();

        expect(error).toBeInstanceOf(Error);
        expect(error).not.toBeInstanceOf(VisitorRequestRejectedError);
    });

    it("treats a 422 without any errors as a general failure", async () => {
        respondWith(422, { message: "Unprocessable." });

        expect(await rejection()).not.toBeInstanceOf(VisitorRequestRejectedError);
    });

    it("treats any other status as a general failure", async () => {
        respondWith(500);

        expect(await rejection()).not.toBeInstanceOf(VisitorRequestRejectedError);
    });
});
