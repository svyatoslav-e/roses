var menuApp = new Vue({
    el: '#mobile-menu',
    data: () => ({
        showMenu: false,
    }),
    created() {
        window.addEventListener('scroll', this.handleDebouncedScroll);
    },
    methods: {
        toggleMenu() {
            console.log('TOGGLE MENU');
            this.showMenu = !this.showMenu;
        },
        // handleDebouncedScroll() {
        // 	console.log('SCROLL');
        // }
    }
})