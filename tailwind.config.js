module.exports = {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/css/filament/admin/theme.css',
  ],
  theme: {
    extend: {
      colors: {
        primary: '#1a56db', // Example custom color
        secondary: '#fbbf24',
      },
      fontFamily: {
        sans: ['Inter', 'sans-serif'], // Example custom font
      },
    },
  },
  plugins: [],
} 