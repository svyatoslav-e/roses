<!DOCTYPE html>
<!--[if IE]><![endif]-->
<!--[if IE 8 ]>
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie8"><![endif]-->
<!--[if IE 9 ]>
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<!--<![endif]-->
<head>
    <meta name="yandex-verification" content="94780570f85693ad"/>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $title; ?></title>
    <base href="<?php echo $base; ?>"/>
    <?php if ($description) { ?>
        <meta name="description" content="<?php echo $description; ?>"/>
    <?php } ?>
    <?php if ($keywords) { ?>
        <meta name="keywords" content="<?php echo $keywords; ?>"/>
    <?php } ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php if ($icon) { ?>
        <link href="<?php echo $icon; ?>" rel="icon"/>
    <?php } ?>
    <?php foreach ($links as $link) { ?>
        <link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>"/>
    <?php } ?>
    <script src="catalog/view/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript"></script>
    <link href="catalog/view/javascript/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen"/>
    <script src="catalog/view/javascript/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <link href="catalog/view/javascript/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <link href="//fonts.googleapis.com/css?family=Open+Sans:400,400i,300,700" rel="stylesheet" type="text/css"/>
    <link href="catalog/view/theme/default/stylesheet/stylesheet.css" rel="stylesheet">
    <link href="catalog/view/theme/default/stylesheet/style.css" rel="stylesheet">
    <?php foreach ($styles as $style) { ?>
        <link href="<?php echo $style['href']; ?>" type="text/css" rel="<?php echo $style['rel']; ?>"
              media="<?php echo $style['media']; ?>"/>
    <?php } ?>
    <script src="catalog/view/javascript/common.js" type="text/javascript"></script>
    <?php foreach ($scripts as $script) { ?>
        <script src="<?php echo $script; ?>" type="text/javascript"></script>
    <?php } ?>

    <link rel="stylesheet" href="catalog/view/javascript/jquery/owl-carousel/owl.carousel.css" type="text/css">
    <script type="text/javascript" src="catalog/view/javascript/jquery/owl-carousel/owl.carousel.min.js"></script>

    <?php echo $google_analytics; ?>
    <!-- Event snippet for Покупка conversion page
In your html page, add the snippet and call gtag_report_conversion when someone clicks on the chosen link or button. -->
    <script>
        function gtag_report_conversion(url) {
            var callback = function () {
                if (typeof(url) != 'undefined') {
                    window.location = url;
                }
            };
            gtag('event', 'conversion', {
                'send_to': 'AW-872828525/1zbuCKSNlawBEO2cmaAD',
                'transaction_id': '',
                'event_callback': callback
            });
            return false;
        }
    </script>
</head>
<body class="<?php echo $class; ?>">
<header class="header-main">
    <!--<div class="conteiner-fluid top-linear"> </div>-->
    <div class="container">
        <div class="row">
            <!--LOGO-->
            <div class="col-xs-4 col-sm-6 col-lg-4">
                <div id="logo">
                    <h1 class="header-main__logo">
                        <a href="<?php echo $home; ?>" class="header-main__logo_link">
                            <?php if ($logo) { ?>
                                <img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>"
                                     class="img-responsive"/>
                            <?php } ?>
                            <span class="header-main__logo_link-green hidden-xs">Fruits</span>
                            <span class="header-main__logo_link-at hidden-xs">&</span>
                            <span class="header-main__logo_link-rose hidden-xs">Roses</span>
                        </a>
                    </h1>
                </div>
            </div>
            <!--LANG BLOCK MOBILE-->
            <div class="col-xs-5 visible-xs text-center">
                <div class="row">
                    <?php echo $language; ?>
                </div>
            </div>

            <div class="hidden-xs col-sm-4 col-lg-6 header-main__phone">
                <a href="tel:<?php echo $telephone_arr[0]; ?>"><i class="fa fa-phone-square"
                                                                  aria-hidden="true"></i><?php echo $telephone_arr[0]; ?>
                </a>
            </div>

            <!--CART-->
            <div class="col-xs-3 col-sm-2 col-lg-2">
                <?php echo $cart; ?>
            </div>
        </div>
    </div>
</header>
<div class="container-fluid top-linear"></div>
<div class="container">
    <div class="row">
        <!--Main menu-->
        <div class="col-sm-12 col-md-10">
            <nav id="menu" class="header-main__menu">
                <div class="navbar-header">
                    <span id="category" class="visible-xs header-main__menu_title"><?php echo $text_category; ?></span>
                    <button type="button" class="navbar-toggle header-main__menu_btn" data-toggle="collapse"
                            data-target=".navbar-ex1-collapse">
                        <i class="fa fa-bars"></i>
                    </button>
                </div>
                <div class="collapse navbar-collapse navbar-ex1-collapse left-menu-dig-block no-padding">
                    <ul>
                        <?php foreach ($categories as $category) { ?>
                            <li><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a>
                                <?php if ($category['children']) { ?>
                                    <ul class="header-main__sub-menu hidden-xs">
                                        <?php foreach ($category['children'] as $child) { ?>
                                            <li>
                                                <a href="<?php echo $child['href']; ?>"><?php echo $child['name']; ?></a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                <?php } ?>
                            </li>
                        <?php } ?>
                        <li class="special-item"><a href="<?= $about_us; ?>"><?= $about_us_text; ?></a></li>
                        <li class="special-item"><a href="<?= $delivery_inf; ?>"><?= $delivery_inf_text; ?>
                                <ul class="header-main__sub-menu special-item-tooltype hidden-xs">
                                    <li><img src="/image/catalog/np.png" alt="Доставка новой почтой"></li>
                                    <li><img src="/image/catalog/intime.jpg" alt="Доставка Интайм"></li>
                                </ul>
                            </a></li>
                        <li class="special-item">
                            <a href="<?= $videos; ?>"><?= $videos_title; ?></a>
                        </li>
                        <li class="special-item"><a href="<?= $contact; ?>"><?= $text_contact; ?></a></li>
                    </ul>
                </div>
            </nav>
        </div>
        <div class="hidden-xs hidden-sm col-md-2">
            <?php echo $language; ?>
        </div>
    </div>
</div>
<div class="container-fluid top-linear"></div>







