<div id="search">
  <button class="search__button" @click="toggleSearchPage">
    <i class="fa fa-search"></i>
  </button>
  <div class="search" v-show="showSearchPage">
    <div class="search__backdrop" @click="toggleSearchPage"></div>
    <transition name="slide-fade">
      <div class="search__content" v-show="showSearchPage">
        <label for="search-input-q" class="search__label">
          <span><?php echo $text_label; ?></span>
          <input type="text" name="search" id="search-input-q" v-model="searchValue" placeholder="<?php echo $text_search; ?>"
                 class="search__input input-lg" />
        </label>
        <div class="search__products" v-if="products.length">
          <div class="search__product-item" v-for="product in products" :key="product.product_id">
            <div class="cart__product-image">
              <img :src="product.thumb" :alt="product.name" :title="product.name" class="img-thumbnail" />
            </div>
            <div class="cart__product-info">
              <span class="cart__product-info_name">{{ product.name }}</span>
              <div>
                <span class="cart__product-info_price">Ціна: <b>{{ product.price }}</b></span>
              </div>
            </div>
            <div class="search__product-add">
              <button class="dtn-roses_small dtn-roses btn-cta" @click="handleAddProduct(product.product_id)">
                <i class="fa fa-shopping-cart"></i>
              </button>
            </div>
          </div>
        </div>
        <div v-else class="search__empty">
          <span><?php echo $text_empty; ?></span>
        </div>
        <div class="cart__footer">
          <div class="cart__cta">
            <div class="col-sm-12">
              <button @click="toggleSearchPage" class="dtn-roses_small dtn-roses btn-cta">
                <?php echo $text_close_search; ?>
              </button>
            </div>
          </div>
        </div>
      </div>
    </transition>
  </div>
</div>


<script>
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
  })
</script>