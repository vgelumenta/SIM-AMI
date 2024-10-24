function data() {
    return {

        dark: localStorage.getItem("dark") === "true",
        toggleTheme() {
            this.dark = !this.dark;
            localStorage.setItem("dark", this.dark);
        },
        
        isSideMenuOpen: localStorage.getItem('isSideMenuOpen') === 'true',
        toggleSideMenu() {
            this.isSideMenuOpen = !this.isSideMenuOpen;
            localStorage.setItem('isSideMenuOpen', this.isSideMenuOpen);
        },
        
        isSideMenuOpenResponsive: false,
        toggleSideMenuResponsive() {
            this.isSideMenuOpenResponsive = !this.isSideMenuOpenResponsive;
        },
        closeSideMenuResponsive() {
            this.isSideMenuOpenResponsive = false;
        },

        isPagesMenuOpen: localStorage.getItem("isPagesMenuOpen") === "true",
        togglePagesMenu() {
            this.isPagesMenuOpen = !this.isPagesMenuOpen;
            localStorage.setItem("isPagesMenuOpen", this.isPagesMenuOpen);
        },

        isPagesMenuOpenResponsive:
            localStorage.getItem("isPagesMenuOpenResponsive") === "true",
        togglePagesMenuResponsive() {
            this.isPagesMenuOpenResponsive = !this.isPagesMenuOpenResponsive;
            localStorage.setItem(
                "isPagesMenuOpenResponsive",
                this.isPagesMenuOpenResponsive
            );
        },

        isNotificationsMenuOpen: false,
        toggleNotificationsMenu() {
            this.isNotificationsMenuOpen = !this.isNotificationsMenuOpen;
        },
        closeNotificationsMenu() {
            this.isNotificationsMenuOpen = false;
        },

        isProfileMenuOpen: false,
        toggleProfileMenu() {
            this.isProfileMenuOpen = !this.isProfileMenuOpen;
        },
        closeProfileMenu() {
            this.isProfileMenuOpen = false;
        },
    };
}
