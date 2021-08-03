<footer class="footer">
  <div class="container-fluid footer__wrapper">
    <div class="row">
     <?php if($categories) { ?>
      <div class="col-sm-3">
      <h5><i class="fa fa-tree" aria-hidden="true"></i>  <?php echo $text_category; ?></h5>
        <ul class="list-unstyled">
        <?php foreach ($categories as $category) { ?>
          <li><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a></li>
        <?php }?>
        </ul>
      </div>
      <?php } ?>


      <?php if ($informations) { ?>
      <div class="col-sm-3">
        <h5><i class="fa fa-info-circle" aria-hidden="true"></i>  <?php echo $text_information; ?></h5>
            <ul class="list-unstyled" id="blog">
                <li><a href="<?=$payment_inf; ?>"><?=$payment_inf_text; ?></a></li>
            </ul>
      </div>
      <?php } ?>
    </div>
<!--    <hr>-->
<!--    <p>--><?php //echo $powered; ?><!--</p>-->
  </div>
</footer>
<div class="visible-xs site__call-action">
    <a href="tel:<?php echo $telephone_arr[0]; ?>" class="dtn-roses btn-orange"><?php echo $call; ?></a>
</div>
<!-- development version, includes helpful console warnings -->
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="catalog/view/javascript/common.js" type="text/javascript"></script>
<script src="catalog/view/javascript/mobile.js" type="text/javascript"></script>
</body></html>