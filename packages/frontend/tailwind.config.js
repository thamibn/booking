/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./index.html",
        "./src/**/*.{js,ts,jsx,tsx,vue}",
    ],
    theme: {
        extend: {
            colors:{
                'primary' : '#ECB200',
                'light-gray' : '#d1d5db',
                'black' : '#0f172a'
            }
        },
    },
    plugins: [],
}

