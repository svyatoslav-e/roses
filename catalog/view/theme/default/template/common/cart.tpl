<div id="cart" class="header-cart">
  <button type="button" data-toggle="dropdown"
                        data-loading-text="<?php echo $text_loading; ?>"
                        class="header-cart__button pull-right">
    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
    <span class="header-cart__button_total-items"><?php echo $text_items; ?></span>
  </button>




  <ul class="dropdown-menu header-cart__total-list">
    <?php if ($products) { ?>
      <li>
        <table class="table table-striped">
          <?php foreach ($products as $product) { ?>
          <tr>
            <td class="text-center"><?php if ($product['thumb']) { ?>
              <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-thumbnail" /></a>
              <?php } ?></td>
            <td class="text-left"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></td>
            <td class="text-right">x <?php echo $product['quantity']; ?></td>
            <td class="text-right"><?php echo $product['total']; ?></td>
            <td class="text-center"><button type="button" onclick="cart.remove('<?php echo $product['key']; ?>');" title="<?php echo $button_remove; ?>" class="btn btn-danger btn-xs"><i class="fa fa-times"></i></button></td>
          </tr>
          <?php } ?>
        </table>
      </li>
      <li>
        <div>
          <table class="table table-bordered">
            <?php foreach ($totals as $total) { ?>
            <tr>
              <td class="text-right"><strong><?php echo $total['title']; ?></strong></td>
              <td class="text-right"><?php echo $total['text']; ?></td>
            </tr>
            <?php } ?>
          </table>

          <div class="col-xs-12">
            <a href="<?php echo $checkout; ?>" class="dtn-roses btn-orange">
              <?php echo $text_checkout; ?>
            </a>
          </div>
        </div>
      </li>
    <?php } else { ?>
    <li>
      <p class="text-center"><?php echo $text_empty; ?></p>
    </li>
    <?php } ?>
  </ul>
</div>

<!-- <script>
var cartHeight = $('.contact_home_block').height();
var headerHeight = $('header').height();
var offsetElem = cartHeight+headerHeight;
$(window).scroll(function(){
  var scrollH = $(this).scrollTop();
  if (scrollH >= offsetElem){
   $('#cart').addClass('i_have_some_prod');
   $('#cart-total-price').addClass('i_have_prod');
  }else{
   $('#cart').removeClass('i_have_some_prod');
   $('#cart-total-price').removeClass('i_have_prod');    
  }
});

</script>
 -->