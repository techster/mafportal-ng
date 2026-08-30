import type { NextConfig } from "next";

const apiOrigin = (process.env.MAFPORTAL_API_URL ?? "http://127.0.0.1:8001").replace(/\/$/, "");

const nextConfig: NextConfig = {
  async rewrites() {
    return [
      {
        source: "/assets/:path*",
        destination: `${apiOrigin}/assets/:path*`,
      },
    ];
  },
};

export default nextConfig;