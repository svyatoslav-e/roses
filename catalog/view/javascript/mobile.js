var menuApp = new Vue({
    el: '#mobile-menu',
    data: () => ({
        showMenu: true,
    }),
    created() {
        window.addEventListener('scroll', this.handleDebouncedScroll);
    },
    methods: {
        toggleMenu() {
            this.showMenu = !this.showMenu;
        },
        // handleDebouncedScroll() {
        // 	console.log('SCROLL');
        // }
    }
})