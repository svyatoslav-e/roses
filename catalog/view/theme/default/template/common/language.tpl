<?php if (count($languages) > 1) { ?>
          <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="js-lang header-main__lang-form">
            <div class="header-main__lang">
              <ul class="header-main__lang_list">
                <?php foreach ($languages as $language) { ?>
                    <?php if ($lang === $language['code']){ ?>
                       <li class="active"><?php echo $language['name']; ?></li>
                    <?php } else { ?>
                        <li><a href="<?php echo $language['code']; ?>" rel="nofollow"><noindex><?php echo $language['name']; ?></noindex></a></li>
                    <?php } ?>
                <?php } ?>
              </ul>
            </div>

            <input type="hidden" name="code" value="" />
            <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
          </form>
<?php } ?>
