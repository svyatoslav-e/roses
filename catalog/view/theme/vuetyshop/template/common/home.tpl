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
            <div class="col-sm-12">
<!--                --><?php //echo $content_top; ?>
<!--                --><?php //echo $content_bottom; ?>
<!--                <div class="col-xs-12">-->
<!--                    <div class="row" id="insta-info">-->
<!--                        <div class="col-sm-6 insta__common">-->
<!--                            <a href="https://www.instagram.com/fruitsandrosesshop/"><span>--><?php //echo $insta ?><!--</span></a>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="row insta" id="insta"></div>-->
<!--                </div>-->
            </div>
            <?php echo $column_right; ?>
        </div>
    </div>
<?php echo $footer; ?>