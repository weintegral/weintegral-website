import { usePage } from "@inertiajs/react";

import { LegalPage } from "@/components/legal/legal-page";

/** Props from AboutController::privacyPolicyAction. */
export interface PrivacyPolicyPageProps {
    contactEmail: string;
}

/**
 * The Privacy Policy. DRAFT: written from what the site actually collects (the
 * Visitor Request form, session and security cookies, server logs, Sentry error
 * reports; no analytics or advertising) and awaiting legal review (launch checklist).
 */
export default function PrivacyPolicy({ contactEmail }: PrivacyPolicyPageProps) {
    const { offices } = usePage().props.site;
    const corporateOffice = offices[0];

    return (
        <LegalPage
            title="Privacy Policy"
            lead="How WeIntegral handles information collected through weintegral.com."
            contactEmail={contactEmail}
        >
            <p className="text-sm text-muted-foreground">Last updated: November 27, 2026</p>

            <p>
                This policy explains what information West East Integral Inc.
                (&ldquo;WeIntegral&rdquo;, &ldquo;we&rdquo;, &ldquo;us&rdquo;) collects when you use
                weintegral.com, how we use it and the choices you have.
            </p>

            <h2>Information you give us</h2>
            <p>
                When you send a request through the Talk to an Expert form, we collect your name,
                email address, the subject and your message. We store the request so the right
                person on our team can reply, and we email you an acknowledgement.
            </p>
            <p>
                When you apply for a role, you email your résumé and any details you choose to
                include to our team. We use them to consider you for that role and similar ones.
            </p>

            <h2>Information collected automatically</h2>
            <p>
                Like most websites, our servers record basic technical details of each visit: your
                IP address, browser type, the pages you request and the time of the request. We use
                these logs to run the site, keep it secure and limit abusive traffic.
            </p>
            <p>
                If something on the site fails, an error report is sent to Sentry, the error
                monitoring service we use. A report describes the error and the request that caused
                it, such as the page address and browser details, so we can fix the problem.
            </p>

            <h2>Cookies</h2>
            <p>
                The site sets two cookies that it needs to work: a session cookie that keeps your
                visit consistent between pages, and a security token that protects forms against
                cross-site request forgery. Both expire after a short period. We do not use
                advertising cookies, and we do not use analytics or tracking tools.
            </p>

            <h2>How we use information</h2>
            <ul className="list-disc space-y-2 pl-6">
                <li>To reply to your requests and discuss the Services you ask about.</li>
                <li>To consider you for open positions.</li>
                <li>To operate, secure and fix the site.</li>
                <li>To meet our legal obligations.</li>
            </ul>
            <p>We do not sell your personal information or use it for advertising.</p>

            <h2>Who we share it with</h2>
            <p>
                We share information only with the service providers that help us run the site and
                our business, such as hosting, email and error monitoring providers, and only so
                they can provide that service to us. We may also disclose information when the law
                requires it, or to protect our rights and the safety of others.
            </p>

            <h2>How long we keep it</h2>
            <p>
                We keep requests and applications for as long as we need them to respond and to keep
                a record of our conversations, and server logs and error reports for a limited
                period. You can ask us to delete your information at any time.
            </p>

            <h2>Your choices</h2>
            <p>
                You can ask to see, correct or delete the personal information we hold about you by
                emailing us at the address below. Depending on where you live, you may have further
                rights under local law, and we will honor them.
            </p>

            <h2>Security</h2>
            <p>
                We use reasonable safeguards to protect your information. No method of transmission
                or storage is completely secure, so we cannot guarantee absolute security.
            </p>

            <h2>Links to other sites</h2>
            <p>
                Our blog and Candidate Resources link to sites we do not operate. Their own privacy
                policies apply when you visit them.
            </p>

            <h2>Children</h2>
            <p>
                The site is meant for businesses and job seekers. It is not directed at children
                under 13, and we do not knowingly collect their information.
            </p>

            <h2>Changes to this policy</h2>
            <p>
                We may update this policy from time to time. The date at the top shows when it last
                changed.
            </p>

            <h2>Contact</h2>
            <p>
                West East Integral Inc.
                {corporateOffice && (
                    <>
                        ,{" "}
                        {corporateOffice.addressLines
                            .map((line) => line.replace(/,$/, ""))
                            .join(", ")}
                    </>
                )}
                .
            </p>
        </LegalPage>
    );
}
