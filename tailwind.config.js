/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./*.php",
    "./**/*.php",
    "./src/**/*.js",
    "./inc/**/*.php",
    "./js/**/*.js",
    "./src/**/*.jsx",
    "./src/**/*.ts",
    "./src/**/*.tsx",
    "./woocommerce/*.php",
  ],
  theme: {
    extend: {
      typography: (theme) => ({}),
      aspectRatio: {
        "21/9": "21 / 9",
      },
      colors: {
        muted: {
          DEFAULT: "#6B7280", // Muted gray
        },
        mutedForeground: {
          DEFAULT: "#9CA3AF", // Muted foreground gray
        },
      },
    },
  },
  plugins: [
    require("@tailwindcss/typography"),
    require("@tailwindcss/forms")({
      // strategy: "base", // only generate global styles
      strategy: "class", // only generate classes
    }),
  ],
};
