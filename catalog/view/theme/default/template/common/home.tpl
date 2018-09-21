<?php echo $header; ?>
<div class="container homepage">
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>">
        <!--<div class="row">
          <nav id="menu-categories">

              <ul class="main-categorie-list container">
               <li class="col-sm-3"><a href="<?echo $roses; ?>" class="roses"><div class="mid-align"><span class="inblock"><?echo $roses_text; ?></span></div></a></li>
               <li class="col-sm-3"><a href="<?echo $fruit; ?>" class="trees"><div class="mid-align"><span class="inblock"><?echo $fruit_text; ?></span></div></a></li>
               <li class="col-sm-3"><a href="<?echo $shrubbery; ?>" class="green"><div class="mid-align"><span class="inblock"><?echo $shrubbery_text; ?></span></div></a></li>
               <li class="col-sm-3"><a href="<?echo $decorative; ?>" class="decor"><div class="mid-align"><span class="inblock"><?echo $decorative_text; ?></span></div></a></li>
              </ul>

          </nav>
        </div>-->
        <?php echo $content_top; ?>
            <div class="col-xs-12">
                <div class="row" id="insta-info">
                    <div class="col-sm-6 insta__common">
                        <span><?php echo $insta ?></span>
                    </div>
                </div>
                <div class="row" id="insta" class="insta"></div>
            </div>
        <?php echo $content_bottom; ?>
    </div>
    <?php echo $column_right; ?>
  </div>
</div>
<?php echo $footer; ?>