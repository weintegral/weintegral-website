import { LegalPage } from "@/components/legal/legal-page";
import { Placeholder } from "@/components/site/placeholder";

/** Props from AboutController::termsOfServiceAction. */
export interface TermsOfServicePageProps {
    contactEmail: string;
}

export default function TermsOfService({ contactEmail }: TermsOfServicePageProps) {
    return (
        <LegalPage
            title="Terms of Service"
            description="The Terms of Service for weintegral.com, the website of West East Integral Inc. (WeIntegral), an IT services and staffing firm."
            contactEmail={contactEmail}
        >
            {/* The previous page showed only "under construction": no terms text exists yet. */}
            <p>
                <Placeholder>Terms of Service text, owner to supply before launch</Placeholder>
            </p>
        </LegalPage>
    );
}
