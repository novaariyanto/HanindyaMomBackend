var userSettings = {
  Layout: "vertical", // vertical | horizontal
  SidebarType: "mini-sidebar", // full | mini-sidebar
  BoxedLayout: true, // true | false
  Direction: "ltr", // ltr | rtl
  Theme: "light", // light | dark
  ColorTheme: "Blue_Theme", // Blue_Theme | Aqua_Theme | Purple_Theme | Green_Theme | Cyan_Theme | Orange_Theme
  cardBorder: false, // true | false
};


if (window.location.pathname === "/jam-kerja" || window.location.pathname === "/jadwal-kerja" || window.location.pathname === "/monitoring/absensi") {
  userSettings.SidebarType = "mini-sidebar";
} else {
  userSettings.SidebarType = "full";
}

