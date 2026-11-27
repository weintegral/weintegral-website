import { describe, expect, it } from "vite-plus/test";
import { z } from "zod";

import { visitorRequestSchema } from "./visitor-request-schema";

const validRequest = {
    name: "Jane Visitor",
    email: "jane@example.com",
    subject: "Project enquiry",
    message: "We would like to discuss a new project.",
};

function fieldErrors(input: unknown) {
    const result = visitorRequestSchema.safeParse(input);
    return result.success ? {} : z.flattenError(result.error).fieldErrors;
}

describe("visitorRequestSchema", () => {
    it("accepts a complete Visitor Request", () => {
        expect(visitorRequestSchema.safeParse(validRequest).success).toBe(true);
    });

    it("requires every field", () => {
        expect(fieldErrors({ name: "", email: "", subject: "", message: "" })).toEqual({
            name: ["Please enter your name."],
            email: ["Please enter your email address."],
            subject: ["Please enter a subject."],
            message: ["Please enter a message."],
        });
    });

    it("treats whitespace-only fields as empty, as the server trims input", () => {
        expect(fieldErrors({ ...validRequest, name: "   " })).toEqual({
            name: ["Please enter your name."],
        });
    });

    it("rejects an email address without a domain", () => {
        expect(fieldErrors({ ...validRequest, email: "jane@" })).toEqual({
            email: ["Please enter a valid email address."],
        });
    });

    it.each([
        ["name", 255, "Your name must be 255 characters or fewer."],
        ["subject", 500, "The subject must be 500 characters or fewer."],
        ["message", 1000, "The message must be 1000 characters or fewer."],
    ] as const)("limits %s to %i characters, matching the API", (field, limit, error) => {
        expect(
            visitorRequestSchema.safeParse({ ...validRequest, [field]: "a".repeat(limit) }).success,
        ).toBe(true);
        expect(fieldErrors({ ...validRequest, [field]: "a".repeat(limit + 1) })).toEqual({
            [field]: [error],
        });
    });

    it("limits the email address to 255 characters, matching the API", () => {
        const email = `jane@${`${"a".repeat(60)}.`.repeat(4)}example`; // 256 characters
        expect(email).toHaveLength(256);
        expect(fieldErrors({ ...validRequest, email })).toEqual({
            email: ["Your email address must be 255 characters or fewer."],
        });
    });
});
