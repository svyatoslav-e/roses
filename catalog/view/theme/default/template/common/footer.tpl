<footer>
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
        <ul class="list-unstyled">
            <ul class="big-list main_menu" id="blog">
                <li><a href="<?=$about_us; ?>"><?=$about_us_text; ?></a></li>
                <li><a href="<?=$delivery_inf; ?>"><?=$delivery_inf_text; ?></a></li>
                <li><a href="<?=$payment_inf; ?>"><?=$payment_inf_text; ?></a></li>
                <li><a href="<?=$contact; ?>"><?=$text_contact; ?></a></li>
            </ul>
        </ul>
      </div>
      <?php } ?>
      <div class="col-sm-3">

         <!--   <h5><i class="fa fa-life-ring" aria-hidden="true"></i> <?php echo $text_service; ?></h5>
        <ul class="list-unstyled">
       <li><a href="<?php echo $contact; ?>"><?php echo $text_contact; ?></a></li>
         <li><a href="<?php echo $return; ?>"><?php echo $text_return; ?></a></li>
          <li><a href="<?php echo $sitemap; ?>"><?php echo $text_sitemap; ?></a></li> 
        </ul>
        <ul class="social">
          <li class="vk"><a href="https://vk.com/fruitsandroses" target="_blank"><i class="fa fa-vk" aria-hidden="true"></i></a></li>
          <li class="fb"><a href="https://www.facebook.com/fruitsandrosescomua" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
        </ul> -->
        <div class="fb-page" data-href="https://www.facebook.com/fruitsandrosescomua" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/fruitsandrosescomua" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/fruitsandrosescomua">Fruits&amp;Roses</a></blockquote></div>
      </div>
    </div>
    <hr>
    <p><?php echo $powered; ?></p>
  </div>
</footer>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v2.7";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
</body></html>