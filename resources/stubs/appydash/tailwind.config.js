import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
  darkMode: "class",
  mode: "jit",
  content: [
    "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
    "./storage/framework/views/*.php",
    "./resources/views/**/*.blade.php",
    "./node_modules/flowbite/**/*.js",
  ],

  theme: {
    extend: {
      fontFamily: {
        sans: ["Figtree", ...defaultTheme.fontFamily.sans],
      },
      colors: {
        current: "primary",
        primary: {
          50: "#4565d8",
          100: "#3b5bce",
          200: "#3151c4",
          300: "#2747ba",
          400: "#1d3db0",
          500: "#1333a6",
          600: "#09299c",
          700: "#001f92",
          800: "#001588",
          900: "#000b7e",
        },
        secondary: {
          50: "#f4f7f7",
          100: "#e3e9ea",
          200: "#cad4d7",
          300: "#a6b7ba",
          400: "#7a9096",
          500: "#5f757b",
          600: "#516269",
          700: "#465358",
          800: "#3d464a",
          900: "#373e42",
        },
      },
    },
  },

  plugins: [forms, require("flowbite/plugin")],
};
