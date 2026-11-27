import { useForm, useStore } from "@tanstack/react-form";
import { useMutation } from "@tanstack/react-query";
import { CircleAlert, CircleCheck } from "lucide-react";
import { useEffect, useState } from "react";

import { Alert, AlertDescription, AlertTitle } from "@/components/ui/alert";
import { Button } from "@/components/ui/button";
import { Field, FieldError, FieldGroup, FieldLabel } from "@/components/ui/field";
import { Input } from "@/components/ui/input";
import { Textarea } from "@/components/ui/textarea";

import { submitVisitorRequest, VisitorRequestRejectedError } from "./submit-visitor-request";
import {
    visitorRequestFields,
    visitorRequestSchema,
    type VisitorRequest,
} from "./visitor-request-schema";

const emptyVisitorRequest: VisitorRequest = { name: "", email: "", subject: "", message: "" };

const fieldLabels: Record<keyof VisitorRequest, string> = {
    name: "Your Name",
    email: "Your Email",
    subject: "Subject",
    message: "Message",
};

interface VisitorRequestFormProps {
    /** The Visitor Request API endpoint. */
    action: string;
    /** Shown in the failure message as another way to reach the firm. */
    fallbackEmail: string;
}

/** The "Talk to an Expert" form: validates in the browser, then submits a Visitor Request to the API. */
export function VisitorRequestForm({ action, fallbackEmail }: VisitorRequestFormProps) {
    // The server-rendered form can't validate or submit until React has hydrated it.
    const [hydrated, setHydrated] = useState(false);
    useEffect(() => setHydrated(true), []);

    const mutation = useMutation({
        mutationFn: (visitorRequest: VisitorRequest) =>
            submitVisitorRequest(action, visitorRequest),
    });

    const form = useForm({
        defaultValues: emptyVisitorRequest,
        // Validate as the visitor types so errors clear as soon as a field is fixed; see showErrors.
        validators: { onChange: visitorRequestSchema, onSubmit: visitorRequestSchema },
        onSubmit: async ({ value, formApi }) => {
            try {
                await mutation.mutateAsync(value);
                formApi.reset();
            } catch (error) {
                if (error instanceof VisitorRequestRejectedError) {
                    // Server rules are the source of truth; show what it rejected beside each field.
                    for (const field of visitorRequestFields) {
                        const message = error.fieldErrors[field];
                        formApi.setFieldMeta(field, (meta) => ({
                            ...meta,
                            errorMap: {
                                ...meta.errorMap,
                                onServer: message ? { message } : undefined,
                            },
                        }));
                    }
                }
            }
        },
    });

    const submissionAttempts = useStore(form.store, (state) => state.submissionAttempts);

    if (mutation.isSuccess) {
        return (
            <Alert role="status">
                <CircleCheck aria-hidden="true" />
                <AlertTitle>Your message has been sent. Thank you!</AlertTitle>
                <AlertDescription>
                    <p>We have received your Visitor Request and will be in touch soon.</p>
                    <Button
                        variant="outline"
                        size="sm"
                        className="mt-3"
                        onClick={() => mutation.reset()}
                    >
                        Send another message
                    </Button>
                </AlertDescription>
            </Alert>
        );
    }

    const failed = mutation.isError && !(mutation.error instanceof VisitorRequestRejectedError);

    return (
        <form
            id="visitor-request-form"
            noValidate
            onSubmit={(event) => {
                event.preventDefault();
                void form.handleSubmit();
            }}
        >
            <FieldGroup>
                {visitorRequestFields.map((name) => (
                    <form.Field
                        key={name}
                        name={name}
                        listeners={{
                            // A server error describes the value it saw; editing the field retracts it.
                            onChange: ({ fieldApi }) => {
                                if (fieldApi.state.meta.errorMap.onServer) {
                                    fieldApi.setMeta((meta) => ({
                                        ...meta,
                                        errorMap: { ...meta.errorMap, onServer: undefined },
                                    }));
                                }
                            },
                        }}
                    >
                        {(field) => {
                            // Errors appear once the visitor leaves a field or tries to submit,
                            // never while they are still typing into it for the first time.
                            const showErrors = field.state.meta.isBlurred || submissionAttempts > 0;
                            const errors = showErrors ? field.state.meta.errors : [];
                            const invalid = errors.length > 0;
                            const inputProps = {
                                id: `visitor-request-${name}`,
                                name,
                                value: field.state.value,
                                onBlur: field.handleBlur,
                                "aria-invalid": invalid,
                                "aria-describedby": invalid
                                    ? `visitor-request-${name}-error`
                                    : undefined,
                            };

                            return (
                                <Field data-invalid={invalid}>
                                    <FieldLabel htmlFor={inputProps.id}>
                                        {fieldLabels[name]}
                                    </FieldLabel>
                                    {name === "message" ? (
                                        <Textarea
                                            {...inputProps}
                                            rows={5}
                                            onChange={(event) =>
                                                field.handleChange(event.target.value)
                                            }
                                        />
                                    ) : (
                                        <Input
                                            {...inputProps}
                                            type={name === "email" ? "email" : "text"}
                                            autoComplete={
                                                name === "name"
                                                    ? "name"
                                                    : name === "email"
                                                      ? "email"
                                                      : "off"
                                            }
                                            onChange={(event) =>
                                                field.handleChange(event.target.value)
                                            }
                                        />
                                    )}
                                    <FieldError
                                        id={`visitor-request-${name}-error`}
                                        errors={errors.map(toFieldError)}
                                    />
                                </Field>
                            );
                        }}
                    </form.Field>
                ))}

                {failed && (
                    <Alert variant="destructive">
                        <CircleAlert aria-hidden="true" />
                        <AlertTitle>Your message could not be sent.</AlertTitle>
                        <AlertDescription>
                            Please try again, or email us at{" "}
                            <a href={`mailto:${fallbackEmail}`}>{fallbackEmail}</a>.
                        </AlertDescription>
                    </Alert>
                )}

                <form.Subscribe selector={(state) => state.isSubmitting}>
                    {(isSubmitting) => (
                        <Button
                            type="submit"
                            disabled={!hydrated || isSubmitting}
                            className="self-start"
                        >
                            {isSubmitting ? "Sending…" : "Send Message"}
                        </Button>
                    )}
                </form.Subscribe>
            </FieldGroup>
        </form>
    );
}

/** Schema issues and server errors both carry a message; FieldError renders either. */
function toFieldError(error: unknown): { message?: string } | undefined {
    if (typeof error === "string") {
        return { message: error };
    }
    if (
        error &&
        typeof error === "object" &&
        "message" in error &&
        typeof error.message === "string"
    ) {
        return { message: error.message };
    }
    return undefined;
}
