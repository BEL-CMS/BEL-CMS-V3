(function () {

    var savedConfig = localStorage.getItem("__CONFIG__");

    var defaultConfig = {
        direction: "ltr",
        theme: "light",
        layout: {
            width: "default",
            position: "fixed",
        },
        topbar: {
            color: "dark",
        },
        menu: {
            color: "dark",
        },
        sidenav: {
            view: "default"  
        },
    };

    const html = document.getElementsByTagName("html")[0];

    config = Object.assign(JSON.parse(JSON.stringify(defaultConfig)), {});

    config.direction = html.getAttribute("dir") || defaultConfig.direction;
    config.theme = html.getAttribute("data-mode") || defaultConfig.theme;
    config.layout.width = html.getAttribute("data-layout-width") || defaultConfig.layout.width;
    config.layout.position = html.getAttribute("data-layout-position") || defaultConfig.layout.position;
    config.topbar.color = html.getAttribute("data-topbar-color") || defaultConfig.topbar.color;
    config.menu.color = html.getAttribute("data-menu-color") || defaultConfig.menu.color;
    config.sidenav.view = html.getAttribute("data-sidenav-view") || defaultConfig.sidenav.view;

    window.defaultConfig = JSON.parse(JSON.stringify(config));

    if (savedConfig !== null) {
        config = JSON.parse(savedConfig);
    }

    window.config = config;

    if (config) {
        html.setAttribute("dir", config.direction);
        html.setAttribute("data-mode", config.theme);
        html.setAttribute("data-layout-width", config.layout.width);
        html.setAttribute("data-layout-position", config.layout.position);
        html.setAttribute("data-topbar-color", config.topbar.color);
        html.setAttribute("data-menu-color", config.menu.color);

        if (window.innerWidth <= 1140) {
            html.setAttribute("data-sidenav-view", "mobile");
        } else {
            html.setAttribute("data-sidenav-view", config.sidenav.view);
        }
    }
})();