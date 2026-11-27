import { LegalPage } from "@/components/legal/legal-page";
import { Placeholder } from "@/components/site/placeholder";

/** Props from AboutController::privacyPolicyAction. */
export interface PrivacyPolicyPageProps {
    contactEmail: string;
}

export default function PrivacyPolicy({ contactEmail }: PrivacyPolicyPageProps) {
    return (
        <LegalPage
            title="Privacy Policy"
            description="The Privacy Policy for weintegral.com, the website of West East Integral Inc. (WeIntegral), an IT services and staffing firm."
            contactEmail={contactEmail}
        >
            {/* The previous page showed only "under construction": no policy text exists yet. */}
            <p>
                <Placeholder>Privacy Policy text, owner to supply before launch</Placeholder>
            </p>
        </LegalPage>
    );
}
