<?php echo $header; ?>
<div class="container-fluid breadcrumb-wrapper">
  <div class="row">
    <div class="container">
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
</div>
<div class="container checkout">
  <?php if ($error_warning) { ?>
  <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php } ?>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>

    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
        <div class="checkout-form" id="checkout-app">
            <div class="col-sm-4" v-if="checkoutData">
                <h3>{{checkoutData.text_checkout_cart_review}}</h3>
                <div class="checkout__products bill">
                    <div v-for="product in checkoutData.products" :key="product.key" class="checkout__product">
                        <img :src="product.thumb" :alt="product.name">
                        <span class="checkout__product-name">{{ product.name }}</span>
                        <span>{{ product.quantity }}</span>
                        <span>{{ product.price }}</span>
                    </div>
                    <div class="checkout__total">{{checkoutData.total_title}}: {{checkoutData.total_value}}</div>
                </div>
            </div>
            <div class="col-sm-4" v-if="checkoutData">
                <h3>{{checkoutData.text_checkout_payment_address}}</h3>
                <form id="checkout-form" v-if="customer">
                    <label for="customer-firstname" class="checkout_customer__label">
                        <input type="text"
                               id="customer-name"
                               v-model="$v.customer.firstname.$model"
                               :placeholder="customer.entry_firstname"
                               class="checkout_customer__input"
                        >
                        <span class="error" v-if="$v.customer.firstname.$error">{{checkoutData.error_firstname}}</span>
                    </label>
                    <label for="customer-lastname" class="checkout_customer__label">
                        <input type="text"
                               id="customer-lastname"
                               v-model="$v.customer.lastname.$model"
                               :placeholder="customer.entry_lastname"
                               class="checkout_customer__input">
                        <span class="error" v-if="$v.customer.lastname.$error">{{checkoutData.error_lastname}}</span>
                    </label>
                    <label for="customer-telephone" class="checkout_customer__label">
                        <input type="tel"
                               id="customer-telephone"
                               v-model="$v.customer.telephone.$model"
                               :placeholder="customer.entry_telephone"
                               class="checkout_customer__input">
                        <span class="error" v-if="$v.customer.telephone.$error">{{checkoutData.error_telephone}}</span>
                    </label>
                    <label for="customer-email" class="checkout_customer__label">
                        <input type="email"
                               id="customer-email"
                               v-model="$v.customer.email.$model"
                               :placeholder="customer.entry_email"
                               class="checkout_customer__input">
                        <span class="error" v-if="$v.customer.email.$error">{{checkoutData.error_telephone}}</span>
                    </label>
                    <label for="" class="checkout_customer__label">
                        <select v-model="$v.customer.zone_id.$model" class="checkout_customer__input">
                            <option value="" disabled selected>{{customer.entry_zone}}</option>
                            <option :value="zone.zone_id" v-for="zone in zones" :selected="customer.zone_id === zone.zone_id">{{zone.name}}</option>
                        </select>
                        <span class="error" v-if="$v.customer.zone_id.$error">{{checkoutData.error_telephone}}</span>
                    </label>
                    <label for="customer-city" class="checkout_customer__label">
                        <input type="text"
                               id="customer-city"
                               v-model="$v.customer.city.$model"
                               :placeholder="customer.entry_city"
                               class="checkout_customer__input">
                        <span class="error" v-if="$v.customer.city.$error">{{checkoutData.error_email}}</span>
                    </label>
                    <label for="checkout-comment" class="checkout_customer__label">
                        <input type="text"
                               id="customer-comment"
                               v-model="$v.checkoutData.comment.$model"
                               :placeholder="checkoutData.text_nowa_poshta"
                               class="checkout_customer__input">
                        <span class="error" v-if="$v.checkoutData.comment.$error">{{checkoutData.error_nowa_poshta}}</span>
                    </label>
                    <div class="checkout__payment">
                        <label :for="payment.code" v-for="(payment, paymentIndex) in paymentMethods" :key="paymentIndex" class="checkout_customer__payment-label">
                            <input type="radio"
                                   :id="payment.code"
                                   v-model="$v.checkoutData.payment_method.$model"
                                   :value="payment.code"
                                   @change="handleChangePayment"
                                   class="checkout_customer__payment-input">
                            <span class="checkout_customer__payment-checkmark">{{payment.title[localeValue]}}</span>
                            <span class="error" v-if="$v.checkoutData.payment_method.$error">{{checkoutData.error_payment}}</span>
                        </label>
                    </div>
                </form>
            </div>
            <div class="col-sm-4" v-if="checkoutData && customer">
                <h3>{{checkoutData.text_checkout_data_review}}</h3>
                <div v-show="customer" class="checkout__review bill">
                    <p>
                        <span class="checkout__review-label">{{customer.entry_firstname}}:</span>
                        <span class="checkout__review-value">{{customer.firstname}} {{customer.lastname}}</span>
                    </p>
                    <p>
                        <span class="checkout__review-label">{{customer.entry_telephone}}:</span>
                        <span class="checkout__review-value">{{customer.telephone}}</span>
                    </p>
                    <p>
                        <span class="checkout__review-label">{{customer.entry_email}}:</span>
                        <span class="checkout__review-value">{{customer.email}}</span>
                    </p>
                    <p>
                        <span class="checkout__review-label">{{customer.entry_zone}}:</span>
                        <span class="checkout__review-value">{{customerArea}}</span>
                    </p>
                    <p>
                        <span class="checkout__review-label">{{customer.entry_city}}:</span>
                        <span class="checkout__review-value">{{customer.city}}</span>
                    </p>
                    <p>
                        <span class="checkout__review-label">{{checkoutData.text_comments}}:</span>
                        <span class="checkout__review-value">{{checkoutData.comment}}</span>
                    </p>
                    <p><span class="checkout__review-value">{{paymentMethod}}</span></p>
                    <span v-if="checkoutData.agree" class="checkout__review-value">{{checkoutData.text_agreed}}</span>
                    <label class="checkout__review-agreed">
                        <input type="checkbox" v-model="$v.checkoutData.agree.$model" @change="$v.checkoutData.agree.$touch()">
                        <span v-html="checkoutData.text_agree"></span>
                        <span class="error" v-if="$v.checkoutData.agree.$error">{{checkoutData.error_agree}}</span>
                    </label>
                    <button
                            class="dtn-roses_small dtn-roses btn-cta"
                            @click="handleSaveOrder">{{checkoutData.text_confirm}}</button>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>

<script>
    var validationMixin = window.vuelidate.validationMixin;
    const { required, minLength, email, numeric } = window.validators;
    var checkoutApp = new Vue({
        el: '#checkout-app',
        mixins: [validationMixin],
        data() {
            return {
                checkoutData: null,
                customer: null,
                zones: null,
                localeValue: null,
                paymentMethods: {
                    cod: {
                        code: 'cod',
                        title: {
                            ru: 'Оплата при получениии',
                            uk: 'Оплата при отриманні'
                        },
                    },
                    free_checkout: {
                        code: 'free_checkout',
                        title: {
                            ru: 'Оплата на карту',
                            uk: 'Оплата на картку'
                        },
                    },
                }
            }
        },

        validations: {
            customer: {
                firstname: {
                    required,
                },
                lastname: {
                    required,
                },
                telephone: {
                    required,
                    numeric,
                },
                email: {
                    required,
                    email,
                },
                zone_id: {
                    required,
                },
                city: {
                    required,
                }
            },
            checkoutData: {
                agree: {
                    requiredIf: value => value === true
                },
                comment: {
                    required,
                    numeric,
                },
                payment_method: {
                    required,
                },
            }
        },

        computed: {
          customerArea() {
              if(this.zones && this.customer.zone_id !== '') {
                  const zoneIndex = this.zones.map(e => e.zone_id).indexOf(this.customer.zone_id);
                  return this.zones[zoneIndex].name;
              } else {
                  return null;
              }
          },
            paymentMethod() {
              if(this.checkoutData) {
                  return this.paymentMethods[this.checkoutData.payment_method].title[this.localeValue];
              } else {
                  return null;
              }
            }
        },

        created() {
            cartApp.disabledCart = true;
            this.localeValue = document.all[0].lang;
            this.getCheckoutData();
        },

        methods: {
            handleChangePayment() {
                this.checkoutData.payment_title = this.paymentMethod;
            },
            getCheckoutData() {
                $.ajax({
                    url: 'index.php?route=checkout/checkout/instance',
                    type: 'post',
                    success: function(json) {
                        checkoutApp.checkoutData = json;
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    }
                });

                $.ajax({
                    url: 'index.php?route=checkout/guest',
                    dataType: 'json',
                    success: function(json) {
                        checkoutApp.customer = json;
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    }
                });

                $.ajax({
                    url: 'index.php?route=checkout/checkout/country&country_id=220',
                    dataType: 'json',
                    success: function(json) {
                        checkoutApp.zones = json.zone;
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    }
                });
            },
            handleSaveOrder() {
                if(this.$v.$invalid) {
                    this.$v.$touch();
                   return;
                }

                const {payment_method, payment_title, shipping_method, comment} = this.checkoutData;
                const {firstname, lastname, telephone, email, city, country_id, zone_id, customer_group_id, shipping_address } = this.customer;
                const preOrderData = {
                    firstname,
                    lastname,
                    telephone,
                    email,
                    city,
                    country_id,
                    zone_id,
                    payment_method,
                    payment_title,
                    comment,
                    customer_group_id,
                    shipping_method,
                    shipping_address,
                };
                $.ajax({
                    url: 'index.php?route=checkout/guest/save',
                    type: 'POST',
                    data: preOrderData,
                    dataType: 'json',
                    success: function(json) {
                        checkoutApp.confirmSaveOrder(payment_method);
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    }
                });
            },
            confirmSaveOrder(payment_method) {
                $.ajax({
                    url: 'index.php?route=checkout/confirm',
                    dataType: 'json',
                    success: function(json) {
                        checkoutApp.saveOrder(payment_method);
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    }
                });

            },
            saveOrder() {
                const {payment_method} = this.checkoutData;
                $.ajax({
                    type: 'get',
                    url: `index.php?route=payment/${payment_method}/confirm`,
                    cache: false,
                    success: function(resp) {
                        location = checkoutApp.checkoutData.continue;
                    }
                });
            }
        }
    });
</script>
<?php echo $footer; ?>
