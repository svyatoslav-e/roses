<?php if (count($languages) > 1) { ?>
<div class="lang_block">


      <div class="col-xs-12 pull-left">

     

      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="language">
        <div class="btn-group pull-left">

          <ul class="lang_ul">
             <li>Мова: </li>

            <?php foreach ($languages as $language) { ?>
            <?if ($lang === $language['code']){?>
               <li class="active"><a href="<?php echo $language['code']; ?>" class="lang_text " rel="nofollow"><noindex><?php echo $language['name']; ?></noindex></a></li>
            <?}else{?>
                <li><a href="<?php echo $language['code']; ?>" class="lang_text " rel="nofollow"><noindex><?php echo $language['name']; ?></noindex></a></li>
            <?}?>
            <?php } ?>

          </ul>
        </div>

        <input type="hidden" name="code" value="" />
        <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
      </form>
      
        </div>

</div>

<?php } ?>
