module.exports = {
  content: [
    "./resources/views/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      backgroundSize: {
        'vec-star-repeat'   : "50px 50px, 50px 50px, 25px 25px, 25px 25px",
        'size-200'          : "200% 200%",
        'size-0-to-min100'  : "0 100%",
        'size-100-to-200'   : "100% 200%"
      },
      backgroundImage: {
        'pikisuperstars-circle'   : "url('/bg/pikisuperstars_circular.jpg')",
        'utah-road'               : "url('/bg/utah_road.jpg')",
        'gedung-akuntansi'        : "url('/bg/gedung_akuntansi.jpg')",
        'vec-star'                : "radial-gradient(circle, transparent 20%, #e5e5f7 20%, #e5e5f7 80%, transparent 80%, transparent), radial-gradient(circle, transparent 20%, #e5e5f7 20%, #e5e5f7 80%, transparent 80%, transparent) 25px 25px, linear-gradient(#444cf7 2px, transparent 2px) 0 -1px, linear-gradient(90deg, #444cf7 2px, #e5e5f7 2px) -1px 0"
      },
      colors: {
        'sidebar'       : '#1b213d',
        'content'       : '#77c3ec',
        'navbar'        : '#1c2340',
        'ppurple'       : '#1b213d',
        'main-theme'    : '#1b213d'
      },
      backgroundPosition: {
        'pos-0'         : "0% 0%",
        'pos-100'       : "100% 100%"
      }
    },
  },
  plugins: [],
}