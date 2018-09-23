<footer class="footer">
<div class="conteiner-fluid top-linear"></div>
  <div class="container">
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
                <li><a href="<?=$about_us; ?>"><?=$about_us_text; ?></a></li>
                <li><a href="<?=$delivery_inf; ?>"><?=$delivery_inf_text; ?></a></li>
                <li><a href="<?=$payment_inf; ?>"><?=$payment_inf_text; ?></a></li>
                <li><a href="<?=$contact; ?>"><?=$text_contact; ?></a></li>
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
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v2.7";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
</body></html>