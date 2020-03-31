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
      <h1><?php echo $heading_title; ?></h1>
        <div class="checkout-form" id="checkout-app">
            <div class="col-sm-6" v-if="checkoutData">
                <h3>{{ checkoutData.text_checkout_payment_address }}</h3>
                <form id="checkout-form" v-if="customer">
                    <label for="customer-firstname">
                        <input type="text" id="customer-name" v-model="$v.customer.firstname.$model">
                        <span class="error" v-if="$v.customer.firstname.$error">Field is invalid</span>
                    </label> <br>
                    <label for="customer-lastname">
                        <input type="text" id="customer-name" v-model="$v.customer.lastname.$model">
                        <span class="error" v-if="$v.customer.lastname.$error">Field is invalid</span>
                    </label> <br>
                    <label for="customer-telephone">
                        <input type="text" id="customer-name" v-model="$v.customer.telephone.$model">
                        <span class="error" v-if="$v.customer.telephone.$error">Field is invalid</span>
                    </label> <br>
                    <label for="customer-email">
                        <input type="text" id="customer-name" v-model="$v.customer.email.$model">
                        <span class="error" v-if="$v.customer.email.$error">Field is invalid</span>
                    </label> <br>
                    <label for="">
                        <select v-model="$v.customer.zone_id.$model">
                            <option :value="zone.zone_id" v-for="zone in zones" :selected="customer.zone_id === zone.zone_id">{{zone.name}}</option>
                        </select>
                        <span class="error" v-if="$v.customer.zone_id.$error">Field is invalid</span>
                    </label><br>
                    <label for="customer-city">
                        <input type="text" id="customer-name" v-model="$v.customer.city.$model">
                        <span class="error" v-if="$v.customer.city.$error">Field is invalid</span>
                    </label> <br>
                    <label for="checkout-comment">
                        <input type="text" id="customer-comment" v-model="$v.checkoutData.comment.$model">
                        <span class="error" v-if="$v.checkoutData.comment.$error">Field is invalid</span>
                    </label> <br>
                    <label for="checkout-payment" v-for="(payment, paymentIndex) in paymentMethods">
                        {{payment.title}}
                        <input type="radio" :id="payment.code" v-model="$v.checkoutData.payment_method.$model" :value="payment.code" @change="handleChangePayment">
                        <span class="error" v-if="$v.checkoutData.payment_method.$error">Field is invalid</span>
                    </label> <br>
                    <label>
                        <span v-html="checkoutData.text_agree"></span>
                        <input type="checkbox" v-model="$v.checkoutData.agree.$model">
                        <span class="error" v-if="$v.checkoutData.agree.$error">Field is invalid</span>
                    </label>
                </form>
                <button @click="handleSaveOrder">SAVE ORDER</button>
            </div>
            <div class="col-sm-6" v-if="checkoutData && customer">
                <div v-show="customer">
                    <p><b>{{customer.entry_firstname}}</b> {{customer.firstname}} {{customer.lastname}}</p>
                    <p><b>{{customer.entry_telephone}}</b> {{customer.telephone}}</p>
                    <p><b>{{customer.entry_email}}</b> {{customer.email}}</p>
                    <p><b>{{customer.entry_zone}}</b> {{customerArea}}</p>
                    <p><b>{{customer.entry_city}}</b> {{customer.city}}</p>
                    <p><b>{{checkoutData.text_comments}}</b> {{checkoutData.comment}}</p>
                    <p><b>{{paymentMethod}}</b></p>
                    <p v-if="checkoutData.agree">Я згоден на обробку даних</p>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>
<script>
  $('button[type="submit"]').click(function (e){
    e.preventDefault();
    var buttonValue = $(this).attr('id');
    var inputValue = $(this).parent('.input-group').find('input').val();
    if(buttonValue=='minus'){
      var newVall = inputValue-1;
      $(this).parent('.input-group').find('input').val(newVall);
    }else if(buttonValue=='plus'){
      var newVall = parseInt(inputValue)+1;
      $(this).parent('.input-group').find('input').val(newVall);
    }

   $('#form-cart').submit();
  });
</script>

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
                paymentMethods: {
                    cod: {
                        code: 'cod',
                        title: 'Оплата при отриманні',
                    },
                    free_checkout: {
                        code: 'free_checkout',
                        title: 'Оплата на картку',
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
                comment: {
                    required,
                    numeric,
                },
                payment_method: {
                    required,
                },
                agree: {
                    required,
                }
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
                  return this.paymentMethods[this.checkoutData.payment_method].title;
              } else {
                  return null;
              }
            }
        },

        created() {
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
                   console.log('VALIDATION');
                    this.$v.$touch();
                   return;
                }
                console.log('save order');
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
                        console.log(json);
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
                        console.log('CONFIRMED',json);
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
                        console.log('CREATED',resp);
                        location = checkoutApp.checkoutData.continue;
                    }
                });
            }
        }
    });
</script>
<?php echo $footer; ?>
