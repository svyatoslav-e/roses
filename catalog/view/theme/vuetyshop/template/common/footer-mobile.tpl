<footer class="footer">
  <div class="container">
    <div class="row">
      MOBILE
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
            <li>
              <script src="https://apis.google.com/js/platform.js"></script>
              <div class="g-ytsubscribe" data-channelid="UCN6dadFJR5QR6fcOxNvYukA" data-layout="default" data-count="hidden">
              </div></li>
            <li><a href="<?=$payment_inf; ?>"><?=$payment_inf_text; ?></a></li>
          </ul>
        </div>
      <?php } ?>
      <div class="col-sm-6 text-center footer__facebook">
        <div class="fb-page" data-href="https://www.facebook.com/fruitsandrosescomua" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/fruitsandrosescomua" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/fruitsandrosescomua">Fruits&amp;Roses</a></blockquote></div>
      </div>
    </div>
    <hr>
    <p><?php echo $powered; ?></p>
  </div>
</footer>
<div class="visible-xs site__call-action">
  <a href="tel:<?php echo $telephone_arr[0]; ?>" class="dtn-roses btn-orange"><?php echo $call; ?></a>
</div>
</body></html>