<div id="cart">
    <button class="cart__button" @click="toggleVisible">
        <i class="fa fa-shopping-cart" aria-hidden="true"></i>
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
                disabledCart: false,
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
            toggleVisible() {
                if(!this.disabledCart) {
                  this.showCart=true
                }
            },
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

</script>
