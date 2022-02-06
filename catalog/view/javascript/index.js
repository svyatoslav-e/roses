import Vue from "vue";
import $ from "jquery";

//	CART APP
var cartApp = new Vue({
    el: '#cart',
    data() {
        return {
            disabledCart: false,
            cartData: {},
            refetch: false,
            showCart: false,
        }
    },

    created() {
        console.log('CREATED', this);
        this.getCartData();
    },

    watch: {
        refetch(newV) {
            if(newV) {
                this.getCartData();
            }
        }
    },

    methods: {
        toggleVisible() {
            console.log('toggle');
            if(!this.disabledCart) {
                this.showCart=true
            }
        },
        getCartData() {
            console.log('GET DATA');
            $.ajax({
                url: 'index.php?route=common/cart',
                success: function(json) {
                    cartApp.setData(json);
                }
            });
        },

        setData(data) {
            console.log('Set data',data);
            data.products.map((product)=>{
                const productItem = product;
                productItem.removing = false;

                return productItem;
            });
            cartApp.cartData = data;
            cartApp.refetch = false;
        },

        goToCheckout() {
            window.location = cartApp.cartData.checkout;
        },

        continueShopping() {
            this.showCart = false;
        },

        removeProduct(productIndex, confirmed) {
            this.cartData.products[productIndex].removing = true;
            if(confirmed) {
                cart.remove(cartApp.cartData.products[productIndex].key);
                this.cartData.products.splice(productIndex, 1);
            }
        },
    }
});

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
});

const searchApp = new Vue({
    el: '#search',
    data: () => ({
        showSearchPage: false,
        searchPage: null,
        searchValue: '',
        disabledSearch: false,
        products: [],
    }),
    watch: {
        searchValue(val) {
            if (val) {
                this.getResults();
            } else {
                searchApp.products = [];
            }
        }
    },
    created() {
        // this.getResults();
    },
    methods: {
        toggleSearchPage() {
            if(!this.disabledSearch) {
                this.showSearchPage = !this.showSearchPage;
            }
        },
        async getResults() {
            await $.ajax({
                url: `index.php?route=product/search&search=${this.searchValue}`,
                type: 'post',
                dataType: 'json',
                success: function(json) {
                    searchApp.searchPage = json;
                    searchApp.products = json.products;
                },
                complete: function () {
                    if(!searchApp.searchValue) {
                        searchApp.products = [];
                    }
                }
            });
        },
        handleAddProduct(productId) {
            cart.add(productId);
        }
    },
});

// OLD

function getURLVar(key) {
    var value = [];

    var query = String(document.location).split('?');

    if (query[1]) {
        var part = query[1].split('&');

        for (i = 0; i < part.length; i++) {
            var data = part[i].split('=');

            if (data[0] && data[1]) {
                value[data[0]] = data[1];
            }
        }

        if (value[key]) {
            return value[key];
        } else {
            return '';
        }
    }
}
