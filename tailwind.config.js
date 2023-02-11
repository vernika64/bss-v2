module.exports = {
  content: [
    "./resources/views/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      backgroundImage: {
        'utah-road': "url('/bg/utah_road.jpg')"
      },
      colors: {
        'sidebar': '#1b213d',
        'content': '#151934',
        'navbar': '#1c2340',
        'ppurple': '#1b213d'
      }
    },
  },
  plugins: [],
}