import { QueryClient, QueryClientProvider } from "@tanstack/react-query";
import { useState, type ReactNode } from "react";

/** App-wide React context shared by every Inertia page, on the server and in the browser. */
export function AppProviders({ children }: { children: ReactNode }) {
    // One client per app instance, so SSR renders never share client state across requests.
    const [queryClient] = useState(() => new QueryClient());

    return <QueryClientProvider client={queryClient}>{children}</QueryClientProvider>;
}
