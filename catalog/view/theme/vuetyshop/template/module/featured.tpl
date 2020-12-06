<div class="row">
<div class="col-xs-12">
<!-- <h3><?php echo $heading_title; ?></h3> -->
<div id="carousel_home_<?=$indicator; ?>">

  <?php foreach ($products as $product) { ?>
  <div class="product-layout col-xs-12 col-sm-6 col-md-4 col-lg-3">
    <!--   <ul class="label_ul">

   <?php if ($product['come'] <= 70) { ?>

      <li class="labellatest">

          <span>NEW</span>

      </li>

    <?php } ?>

    <?php if ($product['special']) { ?>

      <li class="labelspecial">

           <span>-%</span>

      </li>

    <?php } ?>

        <?php if($product['bestseller']) { ?>

      <li class="labelbestseller">

           <span>TOP</span>

      </li>

    <?php } ?>

  </ul>-->

    <div class="product-thumb transition cildren_<?php echo $product['cid']; ?>">
    <h4 class="product_title"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></h4>

      <div class="image">
      <a href="<?php echo $product['href']; ?>">
      <img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" />
      <span class="description"><?php echo $product['description']; ?></span>
      </a>
      </div>
      <div class="caption" data-my="<? foreach($best as $be){
      echo $be.', ';
      } ?>" data-id="<?php echo $product['product_id']; ?>">
        
        <!-- <p><?php echo $product['description']; ?></p> -->
        <?php if ($product['rating']) { ?>
        <div class="rating">
          <?php for ($i = 1; $i <= 5; $i++) { ?>
          <?php if ($product['rating'] < $i) { ?>
          <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
          <?php } else { ?>
          <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
          <?php } ?>
          <?php } ?>
        </div>
        <?php } ?>
        <?php if ($product['price']) { ?>
        <p class="price">
          <?php if (!$product['special']) { ?>
          <?php echo $product['price']; ?>
          <?php } else { ?>
          <span class="price-new"><?php echo $product['special']; ?></span> <span class="price-old"><?php echo $product['price']; ?></span>
          <?php } ?>
        </p>
        <?php } ?>
      </div>
      <div class="button-group">
        <?php if ($product['quantity'] <= 3){ ?>
        <button type="button" class="filter_stock"><span class="">Продано</span></button>
        <?php }else{ ?>
        <button type="button" onclick="cart.add('<?php echo $product['product_id']; ?>');" id="button_<?php echo $product['product_id']; ?>"><span><?php echo $button_cart; ?></span></button>
        <?php } ?>
      </div>
    </div>
  </div>
  <?php } ?>
</div>
</div>
</div>

<!-- <script type="text/javascript"><!--
$('#carousel_home_<?=$indicator; ?>').owlCarousel({
  items: 4,
  autoPlay: 5000,
  navigation: true,
  navigationText: ['<i class="fa fa-chevron-left fa-5x"></i>', '<i class="fa fa-chevron-right fa-5x"></i>'],
  pagination: false,
  stopOnHover: true,
  mouseDrag: false
});
</script>-->

<!-- <script>
  $('.back_color').css('height', $('.image').height());
  $('.caption').css('height', $('.image').height());
</script> -->