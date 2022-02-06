<div id="search">
  <div class="header-mobile__search header-mobile__icon header-mobile__icon-green" @click="toggleSearchPage">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 396.82 396.74">
      <g id="Слой_2" data-name="Слой 2">
        <g id="Capa_1" data-name="Capa 1">
          <path class="cls-1"
                d="M352.1,44.64a151.89,151.89,0,0,0-220.33,209l-11.6,11.6a24,24,0,0,0-33.94,0h0L7,344.45A24,24,0,0,0,7,378.4H7l11.31,11.31h0a24,24,0,0,0,33.94,0l79.2-79.2a24,24,0,0,0,0-33.94h0l11.6-11.6a151.9,151.9,0,0,0,209-220.33ZM120.17,299.19,41,378.39a8,8,0,0,1-11.31,0L18.35,367.07a8,8,0,0,1,0-11.3l79.2-79.2a8.17,8.17,0,0,1,11.31,0l11.31,11.32A8,8,0,0,1,120.17,299.19Zm220.63-50.9A136,136,0,1,1,340.8,56,136,136,0,0,1,340.8,248.29Z"/>
          <path class="cls-1"
                d="M329.48,67.26,318.17,78.57a104.14,104.14,0,0,1,0,147.08L329.48,237a120.14,120.14,0,0,0,0-169.71Z"/>
        </g>
      </g>
    </svg>
  </div>
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