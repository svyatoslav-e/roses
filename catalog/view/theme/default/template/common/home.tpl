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
                        <iframe width="560" height="315"
                                src="https://www.youtube.com/embed/ekCdd3g33t4"
                                frameborder="0"
                                allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen></iframe>
                    </div>
                    <div class="col-sm-12  youtube__video">
                        <iframe width="560" height="315"
                                src="https://www.youtube.com/embed/fnQPOHujxK0"
                                frameborder="0"
                                allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                        </iframe>
                    </div>
                    <div class="col-sm-12 youtube__video">
                        <iframe width="560" height="315"
                                src="https://www.youtube.com/embed/f4dRrK3L6uE"
                                frameborder="0"
                                allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                        </iframe>
                    </div>
                    <div class="col-sm-12 youtube__video">
                        <iframe width="560" height="315"
                                src="https://www.youtube.com/embed/1x3MUmB6a4c"
                                frameborder="0"
                                allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                        </iframe>
                    </div>
                    <div class="col-sm-12 youtube__video">
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/v9ejbqe4PqQ" frameborder="0"
                                allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen></iframe>
                    </div>
                    <div class="col-sm-12 youtube__video">
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/shBS28xqoOA" frameborder="0"
                                allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen></iframe>
                    </div>
                    <div class="col-sm-12 youtube__video">
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/zarIqtDE8no" frameborder="0"
                                allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen></iframe>
                    </div>
                    <div class="col-sm-12 youtube__video">
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/PcpXqg9F3PA" frameborder="0"
                                allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen></iframe>
                    </div>
                    <div class="col-sm-12 youtube__video">
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/4Sc_ZiSXpRk" frameborder="0"
                                allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen></iframe>
                    </div>
                    <div class="col-am-12 youtube__video">
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/jp82RUrhK9k" frameborder="0"
                                allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen></iframe>
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