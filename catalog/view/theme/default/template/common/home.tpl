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
                <div class="row youtube">
                    <div class="col-sm-12 youtube__video">
                        <div class="js-lazyYT" data-youtube-id="ekCdd3g33t4" data-ratio="16:9"></div>
                    </div>
                    <div class="col-sm-12  youtube__video">
                        <div class="js-lazyYT" data-youtube-id="fnQPOHujxK0" data-ratio="16:9"></div>
                    </div>
                    <div class="col-sm-12 youtube__video">
                        <div class="js-lazyYT" data-youtube-id="f4dRrK3L6uE" data-ratio="16:9"></div>
                    </div>
                    <div class="col-sm-12 youtube__video">
                        <div class="js-lazyYT" data-youtube-id="1x3MUmB6a4c" data-ratio="16:9"></div>
                    </div>
                    <div class="col-sm-12 youtube__video">
                        <div class="js-lazyYT" data-youtube-id="v9ejbqe4PqQ" data-ratio="16:9"></div>
                    </div>
                    <div class="col-sm-12 youtube__video">
                        <div class="js-lazyYT" data-youtube-id="shBS28xqoOA" data-ratio="16:9"></div>
                    </div>
                    <div class="col-sm-12 youtube__video">
                        <div class="js-lazyYT" data-youtube-id="zarIqtDE8no" data-ratio="16:9"></div>
                    </div>
                    <div class="col-sm-12 youtube__video">
                        <div class="js-lazyYT" data-youtube-id="PcpXqg9F3PA" data-ratio="16:9"></div>
                    </div>
                    <div class="col-sm-12 youtube__video">
                        <div class="js-lazyYT" data-youtube-id="4Sc_ZiSXpRk" data-ratio="16:9"></div>
                    </div>
                    <div class="col-am-12 youtube__video">
                        <div class="js-lazyYT" data-youtube-id="jp82RUrhK9k" data-ratio="16:9"></div>
                    </div>
                </div>
                <script type="text/javascript">
                    $('.youtube').owlCarousel({
                        items: 2,
                        autoPlay: 3000,
                        navigation: true,
                        navigationText: ['<i class="fa fa-chevron-left fa-5x"></i>', '<i class="fa fa-chevron-right fa-5x"></i>'],
                        pagination: false,
                        stopOnHover: true,
                        mouseDrag: false
                    });
                </script>
                <?php echo $content_top; ?>
                <?php echo $content_bottom; ?>
                <div class="col-xs-12">
                    <div class="row" id="insta-info">
                        <div class="col-sm-6 insta__common">
                            <a href="https://www.instagram.com/fruitsandrosesshop/"><span><?php echo $insta ?></span></a>
                        </div>
                    </div>
                    <div class="row insta" id="insta"></div>
                </div>
            </div>
            <?php echo $column_right; ?>
        </div>
    </div>
<?php echo $footer; ?>