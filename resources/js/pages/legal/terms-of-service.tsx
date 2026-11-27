import { LegalPage } from "@/components/legal/legal-page";

/** Props from AboutController::termsOfServiceAction. */
export interface TermsOfServicePageProps {
    contactEmail: string;
}

/**
 * The Terms of Service. DRAFT: generic website terms naming West East Integral Inc.,
 * awaiting legal review (launch checklist), including the governing-law clause.
 */
export default function TermsOfService({ contactEmail }: TermsOfServicePageProps) {
    return (
        <LegalPage
            title="Terms of Service"
            lead="The terms that apply when you use weintegral.com."
            contactEmail={contactEmail}
        >
            <p className="text-sm text-muted-foreground">Last updated: November 27, 2026</p>

            <p>
                These terms govern your use of weintegral.com (the &ldquo;site&rdquo;), operated by
                West East Integral Inc. (&ldquo;WeIntegral&rdquo;, &ldquo;we&rdquo;,
                &ldquo;us&rdquo;). By using the site, you agree to them. If you do not agree, please
                do not use the site.
            </p>

            <h2>About the site</h2>
            <p>
                The site describes our Services and open positions and lets you contact us. It is
                for general information only. Nothing on it is an offer to provide Services or an
                offer of employment; any engagement or employment is governed by a separate written
                agreement.
            </p>

            <h2>Using the site</h2>
            <p>You agree not to:</p>
            <ul className="list-disc space-y-2 pl-6">
                <li>
                    Use the site in a way that breaks the law or infringes anyone&rsquo;s rights.
                </li>
                <li>
                    Try to gain unauthorized access to the site, its servers or the systems
                    connected to it.
                </li>
                <li>
                    Interfere with the site&rsquo;s operation, for example by sending automated
                    requests at a rate that burdens it.
                </li>
                <li>Send false, misleading or harmful content through our forms.</li>
            </ul>

            <h2>What you send us</h2>
            <p>
                When you send us a request or a résumé, you confirm that the information is accurate
                and that you have the right to share it. Our{" "}
                <a href="/privacy-policy" className="underline underline-offset-4">
                    Privacy Policy
                </a>{" "}
                explains how we handle it. Sending a request does not create a Client relationship
                or oblige either of us to work together.
            </p>

            <h2>Intellectual property</h2>
            <p>
                The site and its content, including text, graphics and the WeIntegral name and logo,
                belong to WeIntegral or its licensors. You may view and share pages for your own,
                non-commercial use. Any other use needs our written permission. Some photographs are
                licensed from third parties.
            </p>

            <h2>Links to other sites</h2>
            <p>
                The site links to sites we do not operate, such as our blog and the third-party
                pages listed in Candidate Resources. We are not responsible for their content,
                availability or practices.
            </p>

            <h2>No warranty</h2>
            <p>
                We work to keep the site accurate and available, but we provide it &ldquo;as
                is&rdquo; and &ldquo;as available&rdquo;, without warranties of any kind, to the
                extent the law allows. Information on the site may change without notice.
            </p>

            <h2>Limitation of liability</h2>
            <p>
                To the extent the law allows, WeIntegral is not liable for any indirect, incidental
                or consequential loss arising from your use of the site or your reliance on its
                content.
            </p>

            <h2>Governing law</h2>
            <p>
                These terms are governed by the laws of the State of Texas, United States, without
                regard to its conflict-of-law rules.
            </p>

            <h2>Changes to these terms</h2>
            <p>
                We may update these terms from time to time. The date at the top shows when they
                last changed, and continuing to use the site means you accept the updated terms.
            </p>
        </LegalPage>
    );
}
