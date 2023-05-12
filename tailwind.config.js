module.exports = {
  content: [
    "./resources/views/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      backgroundImage: {
        'utah-road'         : "url('/bg/utah_road.jpg')",
        'gedung-akuntansi'  : "url('/bg/gedung_akuntansi.jpg')"
      },
      colors: {
        'sidebar'       : '#1b213d',
        'content'       : '#77c3ec',
        'navbar'        : '#1c2340',
        'ppurple'       : '#1b213d',
        'main-theme'    : '#1b213d'
      }
    },
  },
  plugins: [],
}