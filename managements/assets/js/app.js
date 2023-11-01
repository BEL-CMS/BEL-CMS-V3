class App {
    // Components
    initComponents() {
        // Feather Icons
        feather.replace()
    }
    // Topbar Fullscreen Button
    initfullScreenListener() {
        var self = this;
        var fullScreenBtn = document.querySelector('[data-toggle="fullscreen"]');

        if (fullScreenBtn) {
            fullScreenBtn.addEventListener('click', function (e) {
                e.preventDefault();
                document.body.classList.toggle('fullscreen-enable')
                if (!document.fullscreenElement && !document.mozFullScreenElement && !document.webkitFullscreenElement) {
                    if (document.documentElement.requestFullscreen) {
                        document.documentElement.requestFullscreen();
                    } else if (document.documentElement.mozRequestFullScreen) {
                        document.documentElement.mozRequestFullScreen();
                    } else if (document.documentElement.webkitRequestFullscreen) {
                        document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
                    }
                } else {
                    if (document.cancelFullScreen) {
                        document.cancelFullScreen();
                    } else if (document.mozCancelFullScreen) {
                        document.mozCancelFullScreen();
                    } else if (document.webkitCancelFullScreen) {
                        document.webkitCancelFullScreen();
                    }
                }
            });
        }
    }

    init() {
        this.initComponents();
        this.initfullScreenListener();
    }
}

class ThemeCustomizer {

    constructor() {
        this.html = document.getElementsByTagName('html')[0]
        this.config = {};
        this.defaultConfig = window.config;
    }

    initConfig() {
        this.defaultConfig = JSON.parse(JSON.stringify(window.defaultConfig));
        this.config = JSON.parse(JSON.stringify(window.config));
        this.setSwitchFromConfig();
    }

    initSidenav() {
        var self = this;
        var pageUrl = window.location.href.split(/[?#]/)[0];
        document.querySelectorAll('ul.menu a.menu-link').forEach((element) => {
            if (element.href === pageUrl) {
                element.classList.add('active');
                let parentMenu = element.parentElement.parentElement.parentElement;
                if (parentMenu && parentMenu.classList.contains('menu-item')) {
                    const collapseElement = parentMenu.querySelector('[data-fc-type="collapse"]');
                    if (collapseElement && frost != null) {
                        const collapse = frost.Collapse.getInstanceOrCreate(collapseElement);
                        collapse.show();
                    }
                }
            }
        })

        setTimeout(function () {
            var activatedItem = document.querySelector('ul.menu .active');
            if (activatedItem != null) {
                var simplebarContent = document.querySelector('.app-menu .simplebar-content-wrapper');
                var offset = activatedItem.offsetTop - 300;
                if (simplebarContent && offset > 100) {
                    scrollTo(simplebarContent, offset, 600);
                }
            }
        }, 200);

        // scrollTo (Sidenav Active Menu)
        function easeInOutQuad(t, b, c, d) {
            t /= d / 2;
            if (t < 1) return c / 2 * t * t + b;
            t--;
            return -c / 2 * (t * (t - 2) - 1) + b;
        }

        function scrollTo(element, to, duration) {
            var start = element.scrollTop, change = to - start, currentTime = 0, increment = 20;
            var animateScroll = function () {
                currentTime += increment;
                var val = easeInOutQuad(currentTime, start, change, duration);
                element.scrollTop = val;
                if (currentTime < duration) {
                    setTimeout(animateScroll, increment);
                }
            };
            animateScroll();
        }
    }

    reverseQuery(element, query) {
        while (element) {
            if (element.parentElement) {
                if (element.parentElement.querySelector(query) === element) return element
            }
            element = element.parentElement;
        }
        return null;
    }

    changeThemeDirection(direction) {
        this.config.direction = direction;
        this.html.setAttribute('dir', direction);
        this.setSwitchFromConfig();
    }

    changeThemeMode(color) {
        this.config.theme = color;
        this.html.setAttribute('data-mode', color);
        this.setSwitchFromConfig();
    }

    changeLayoutWidth(width, save = true) {
        this.html.setAttribute('data-layout-width', width);
        if (save) {
            this.config.layout.width = width;
            this.setSwitchFromConfig();
        }
    }

    changeLayoutPosition(position, save = true) {
        this.html.setAttribute('data-layout-position', position);
        if (save) {
            this.config.layout.position = position;
            this.setSwitchFromConfig();
        }
    }

    changeTopbarColor(color) {
        this.config.topbar.color = color;
        this.html.setAttribute('data-topbar-color', color);
        this.setSwitchFromConfig();
    }

    changeMenuColor(color) {
        this.config.menu.color = color;
        this.html.setAttribute('data-menu-color', color);
        this.setSwitchFromConfig();
    }

    changeSidenavView(view, save = true) {
        this.html.setAttribute('data-sidenav-view', view);
        if (save) {
            this.config.sidenav.view = view;
            this.setSwitchFromConfig();
        }
    }

    resetTheme() {
        this.config = JSON.parse(JSON.stringify(window.defaultConfig));
        this.changeThemeDirection(this.config.direction);
        this.changeThemeMode(this.config.theme);
        this.changeLayoutWidth(this.config.layout.width);
        this.changeLayoutPosition(this.config.layout.position);
        this.changeTopbarColor(this.config.topbar.color);
        this.changeMenuColor(this.config.menu.color);
        this.changeSidenavView(this.config.sidenav.view);
        this.adjustLayout();
    }

    initSwitchListener() {
        var self = this;

        document.querySelectorAll('input[name=dir]').forEach(function (element) {
            element.addEventListener('change', function (e) {
                self.changeThemeDirection(element.value);
            })
        });

        document.querySelectorAll('input[name=data-mode]').forEach(function (element) {
            element.addEventListener('change', function (e) {
                self.changeThemeMode(element.value);
            })
        });

        document.querySelectorAll('input[name=data-layout-width]').forEach(function (element) {
            element.addEventListener('change', function (e) {
                self.changeLayoutWidth(element.value);
            })
        });

        document.querySelectorAll('input[name=data-layout-position]').forEach(function (element) {
            element.addEventListener('change', function (e) {
                self.changeLayoutPosition(element.value);
            })
        });

        document.querySelectorAll('input[name=data-topbar-color]').forEach(function (element) {
            element.addEventListener('change', function (e) {
                self.changeTopbarColor(element.value);
            })
        });

        document.querySelectorAll('input[name=data-menu-color]').forEach(function (element) {
            element.addEventListener('change', function (e) {
                self.changeMenuColor(element.value);
            })
        });

        document.querySelectorAll('input[name=data-sidenav-view]').forEach(function (element) {
            element.addEventListener('change', function (e) {
                self.changeSidenavView(element.value);
            })
        });

        //  Light Dark Button
        var themeColorToggle = document.getElementById('light-dark-mode');
        if (themeColorToggle) {
            themeColorToggle.addEventListener('click', function (e) {

                if (self.config.theme === 'light') {
                    self.changeThemeMode('dark');
                } else {
                    self.changeThemeMode('light');
                }
            });
        }

        // Menu Toggle Button ( Placed in Topbar)
        var menuToggleBtn = document.querySelector('#button-toggle-menu');
        if (menuToggleBtn) {
            menuToggleBtn.addEventListener('click', function () {
                var configView = self.config.sidenav.view;
                var view = self.html.getAttribute('data-sidenav-view', configView);

                if (view === 'mobile') {
                    self.showBackdrop();
                    self.html.classList.toggle('sidenav-enable');
                } else {
                    if (configView == 'hidden') {
                        if (view === 'hidden') {
                            self.changeSidenavView(configView == 'hidden' ? 'default' : configView, false);
                        } else {
                            self.changeSidenavView('hidden', false);
                        }
                    } else {
                        if (view === 'sm') {
                            self.changeSidenavView(configView == 'sm' ? 'default' : configView, false);
                        } else {
                            self.changeSidenavView('sm', false);
                        }
                    }
                }
            });
        }

        var menuHoverToggleBtn = document.querySelector('#button-hover-toggle');
        if (menuHoverToggleBtn) {
            menuHoverToggleBtn.addEventListener('click', function () {
                var configView = self.config.sidenav.view;
                var view = self.html.getAttribute('data-sidenav-view', configView);

                if (configView == 'hover') {
                    if (view === 'hover') {
                        self.changeSidenavView(configView == 'hover' ? 'hover-active' : configView, true);
                    } else {
                        self.changeSidenavView('hover', true);
                    }
                } else {
                    if (view === 'hover-active') {
                        self.changeSidenavView(configView == 'hover-active' ? 'hover' : configView, true);
                    } else {
                        self.changeSidenavView('hover-active', true);
                    }
                }
            });
        }

        // Config Reset Button
        var resetBtn = document.querySelector('#reset-layout')
        if (resetBtn) {
            resetBtn.addEventListener('click', function (e) {
                self.resetTheme();
            });
        }
    }

    showBackdrop() {
        const backdrop = document.createElement('div');
        backdrop.id = 'backdrop';
        backdrop.classList = 'transition-all fixed inset-0 z-40 bg-gray-900 bg-opacity-50 dark:bg-opacity-80';
        document.body.appendChild(backdrop);

        if (document.getElementsByTagName('html')[0]) {
            document.body.style.overflow = "hidden";
            if (window.innerWidth > 1140) {
                document.body.style.paddingRight = "15px";
            }
        }

        const self = this
        backdrop.addEventListener('click', function (e) {
            self.html.classList.remove('sidenav-enable');
            self.hideBackdrop();
        })
    }

    hideBackdrop() {
        var backdrop = document.getElementById('backdrop');
        if (backdrop) {
            document.body.removeChild(backdrop);
            document.body.style.overflow = null;
            document.body.style.paddingRight = null;
        }
    }

    initWindowSize() {
        var self = this;
        window.addEventListener('resize', function (e) {
            self.adjustLayout();
        })
    }

    adjustLayout() {
        var self = this;

        if (window.innerWidth <= 1140) {
            self.changeSidenavView('mobile', false);
        } else {
            self.changeSidenavView(self.config.sidenav.view);
        }
    }

    setSwitchFromConfig() {

        sessionStorage.setItem('__CONFIG__', JSON.stringify(this.config));
        // localStorage.setItem('__CONFIG__', JSON.stringify(this.config));

        document.querySelectorAll('#theme-customization input[type=radio]').forEach(function (radio) {
            radio.checked = false;
        })

        var config = this.config;
        if (config) {
            var layoutDirectionSwitch = document.querySelector('input[type=radio][name=dir][value=' + config.direction + ']');
            var layoutModeSwitch = document.querySelector('input[type=radio][name=data-mode][value=' + config.theme + ']');
            var layoutWidthSwitch = document.querySelector('input[type=radio][name=data-layout-width][value=' + config.layout.width + ']');
            var layoutPositionSwitch = document.querySelector('input[type=radio][name=data-layout-position][value=' + config.layout.position + ']');
            var topbarColorSwitch = document.querySelector('input[type=radio][name=data-topbar-color][value=' + config.topbar.color + ']');
            var menuColorSwitch = document.querySelector('input[type=radio][name=data-menu-color][value=' + config.menu.color + ']');
            var sidenavViewSwitch = document.querySelector('input[type=radio][name=data-sidenav-view][value=' + config.sidenav.view + ']');

            if (layoutDirectionSwitch) layoutDirectionSwitch.checked = true;
            if (layoutModeSwitch) layoutModeSwitch.checked = true;
            if (layoutWidthSwitch) layoutWidthSwitch.checked = true;
            if (layoutPositionSwitch) layoutPositionSwitch.checked = true;
            if (topbarColorSwitch) topbarColorSwitch.checked = true;
            if (menuColorSwitch) menuColorSwitch.checked = true;
            if (sidenavViewSwitch) sidenavViewSwitch.checked = true;
        }
    }

    init() {
        this.initConfig();
        this.initSidenav();
        this.initSwitchListener();
        this.initWindowSize();
        this.adjustLayout();
        this.setSwitchFromConfig();
    }
}

new App().init();
new ThemeCustomizer().init();