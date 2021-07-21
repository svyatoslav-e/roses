<div id="cart">
    <button class="cart__button cart__icon cart__icon-green" onclick="cartApp.showCart=true">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 363.24 322.79">
            <defs>
                <clipPath id="clip-path" transform="translate(-0.38 -0.59)">
                    <rect class="cls-1" width="364" height="324"/>
                </clipPath>
            </defs>
            <g id="Слой_2" data-name="Слой 2">
                <g id="Layer_1" data-name="Layer 1">
                    <g>
                        <path d="M352,182.24H12A11.62,11.62,0,0,1,.38,170.65V141.76A11.62,11.62,0,0,1,12,130.16H352a11.62,11.62,0,0,1,11.6,11.6v28.87A11.61,11.61,0,0,1,352,182.24ZM12,140.56a1.21,1.21,0,0,0-1.22,1.2v28.87A1.22,1.22,0,0,0,12,171.85H352a1.21,1.21,0,0,0,1.22-1.2V141.76a1.22,1.22,0,0,0-1.22-1.22Z" transform="translate(-0.38 -0.59)"/>
                        <path d="M292.6,323.38H71.4a25.81,25.81,0,0,1-25.61-21.87L26.11,177.88a5.18,5.18,0,0,1,5.12-6H332.77a5.18,5.18,0,0,1,5.12,6L318.22,301.54a25.82,25.82,0,0,1-25.62,21.84ZM37.31,182.24,56,299.88A15.49,15.49,0,0,0,71.4,313H292.6A15.48,15.48,0,0,0,308,299.89l18.72-117.65Z" transform="translate(-0.38 -0.59)"/>
                        <path d="M246.16,286a6.3,6.3,0,0,1-.75-.05,5.19,5.19,0,0,1-4.39-5.88l9.62-66.29a5.19,5.19,0,1,1,10.27,1.49l-9.62,66.28a5.18,5.18,0,0,1-5.13,4.45Z" transform="translate(-0.38 -0.59)"/>
                        <path d="M182,286a5.19,5.19,0,0,1-5.19-5.19v-66.3c0-6.92,10.38-6.92,10.38,0v66.3A5.19,5.19,0,0,1,182,286Z" transform="translate(-0.38 -0.59)"/>
                        <g class="cls-2">
                            <path d="M117.84,286a5.18,5.18,0,0,1-5.12-4.44l-9.63-66.3a5.19,5.19,0,1,1,10.27-1.49L123,280a5.19,5.19,0,0,1-4.39,5.88,4.74,4.74,0,0,1-.75.06Z" transform="translate(-0.38 -0.59)"/>
                            <path d="M309.48,140.56a5.19,5.19,0,0,1-4.72-3L250.55,19.36a14.36,14.36,0,0,0-19.05-7.07,14.54,14.54,0,0,0-8.38,13.12,14.16,14.16,0,0,0,1.32,6L271.21,133.2c2.89,6.29-6.54,10.62-9.43,4.33L215,35.71a24.48,24.48,0,0,1-2.27-10.31A24.75,24.75,0,0,1,260,15L314.2,133.21a5.19,5.19,0,0,1-4.71,7.35Z" transform="translate(-0.38 -0.59)"/>
                            <path d="M54.52,140.56a5.19,5.19,0,0,1-4.71-7.35L104,15A24.75,24.75,0,0,1,151.26,25.4,24.45,24.45,0,0,1,149,35.73l-46.77,101.8c-2.89,6.29-12.32,2-9.43-4.33L139.56,31.38a14,14,0,0,0,1.33-6,14.52,14.52,0,0,0-8.42-13.13,14.37,14.37,0,0,0-19,7.08L59.24,137.53a5.18,5.18,0,0,1-4.72,3Z" transform="translate(-0.38 -0.59)"/>
                        </g>
                    </g>
                </g>
            </g>
        </svg>
        <span :class="['cart__button_total-items', {'pulse': cartData.text_items > 0}] ">{{ cartData.text_items }}</span>
    </button>
    <div class="cart" v-show="showCart">
        <div class="cart__backdrop" @click="continueShopping"></div>
        <transition name="slide-fade">
            <div class="cart__content" v-show="showCart">
                <div class="cart__header">
                    <span>{{ cartData.text_main_in_cart }}</span>
                    <span>{{ cartData.text_items }}</span>
                </div>
                <div class="cart__product-list">
                    <transition-group name="list">
                        <div v-for="(product, productIndex) in cartData.products" :key="product.key" class="cart__product-item" >
                            <div class="cart__product-image">
                                <img :src="product.thumb" :alt="product.name" :title="product.name" class="img-thumbnail" />
                            </div>
                            <div class="cart__product-info">
                                <span class="cart__product-info_name">{{ product.name }}</span>
                                <div class="cart__product-remove" @click="removeProduct(productIndex)"><i class="fa fa-times"></i></div>
                                <div>
                                    <div class="cart__product-info_qty">
                                        <span>Кількість: <b>{{ product.quantity }}</b></span>
                                    </div>
                                    <span class="cart__product-info_price">Ціна: <b>{{ product.total }}</b></span>
                                </div>
                            </div>
                            <div v-show="product.removing" class="cart__product-dialog">
                                {{cartData.button_remove}} {{ product.name }}?
                                <div>
                                    <button class="cart__product-dialog_button" @click="removeProduct(productIndex, true)">{{ cartData.text_yes }}</button>
                                    <button class="cart__product-dialog_button" @click="product.removing = false">{{ cartData.text_no }}</button>
                                </div>
                            </div>
                        </div>
                    </transition-group>
                </div>
                <div class="cart__footer">
                    <div class="cart__total">
                        <span>{{ cartData.total_title }}</span>
                        <span>{{ cartData.total_value }}</span>
                    </div>
                    <div class="cart__cta">
                        <div class="col-sm-6">
                            <button @click="continueShopping" class="dtn-roses_small dtn-roses btn-cta">
                                {{cartData.text_continue_shopping}}
                            </button>
                        </div>
                        <div class="col-sm-6">
                            <button @click="goToCheckout" class="dtn-roses_small dtn-roses btn-cta">
                                {{cartData.text_checkout}}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</div>

<script>
    var cartApp = new Vue({
        el: '#cart',
        data() {
            return {
                cartData: {},
                refetch: false,
                showCart: false,
            }
        },

        created() {
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
            getCartData() {
                $.ajax({
                    url: 'index.php?route=common/cart',
                    success: function(json) {
                        cartApp.setData(json);
                    }
                });
            },

            setData(data) {
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
                cartApp.showCart = false;
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

</script>
