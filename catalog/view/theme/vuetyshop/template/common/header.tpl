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
    <link href="catalog/view/theme/vuetyshop/stylesheet/stylesheet.css" rel="stylesheet">
    <link href="catalog/view/theme/vuetyshop/stylesheet/style.css" rel="stylesheet">
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
    <!--    VUE -->
    <!-- development version, includes helpful console warnings -->
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>

  <?php echo $google_analytics; ?>
    <!-- Event snippet for Покупка conversion page
In your html page, add the snippet and call gtag_report_conversion when someone clicks on the chosen link or button. -->
    <script>
        function gtag_report_conversion(url) {
            var callback = function () {
                if (typeof (url) != 'undefined') {
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
<?php if ($GLOBALS['isMobile']) { ?>
    <header class="header-mobile">
        <div class="header-mobile__wrapper">
            <!--LOGO-->
            <div id="logo" class="header-mobile__logo">
                <a href="<?php echo $home; ?>" class="header-main__logo_link">
                    <img src="/catalog/view/theme/vuetyshop/image/svg/logo.svg" title="<?php echo $name; ?>"
                         alt="<?php echo $name; ?>"/>
                </a>
            </div>
<!--            PHONE BLOCK-->
                <a href="tel:<?php echo $telephone_arr[0]; ?>" class="header-mobile__phone">
                    <span class="header-mobile__icon header-mobile__icon-blue">
                     <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 290.13 512">
                        <defs>
                            <style>
                                .cls-1 {
                                    fill: #39373a;
                                }
                            </style>
                        </defs>
                        <g id="Слой_2" data-name="Слой 2">
                            <g id="Capa_1" data-name="Capa 1">
                                <path class="cls-1" d="M187.73,42.67H102.4a8.54,8.54,0,0,1,0-17.07h85.33a8.54,8.54,0,1,1,0,17.07Z"/>
                                <path class="cls-1" d="M247.47,42.67h-8.54a8.54,8.54,0,0,1,0-17.07h8.54a8.54,8.54,0,0,1,0,17.07Z"/>
                                <path class="cls-1" d="M155.66,486.4H134.47a23.57,23.57,0,0,1-23.54-23.53v-4.13a23.58,23.58,0,0,1,23.55-23.54h21.19a23.56,23.56,0,0,1,23.53,23.54v4.13A23.56,23.56,0,0,1,155.66,486.4Zm-21.18-34.13a6.48,6.48,0,0,0-6.48,6.47v4.13a6.47,6.47,0,0,0,6.48,6.46h21.19a6.47,6.47,0,0,0,6.46-6.46v-4.13a6.47,6.47,0,0,0-6.47-6.47Z"/>
                                <path class="cls-1" d="M259.29,512H30.85A30.89,30.89,0,0,1,0,481.15V30.85A30.89,30.89,0,0,1,30.85,0H259.29a30.88,30.88,0,0,1,30.84,30.85V481.16A30.88,30.88,0,0,1,259.29,512ZM30.85,17.07A13.79,13.79,0,0,0,17.07,30.85V481.16a13.78,13.78,0,0,0,13.78,13.77H259.29a13.79,13.79,0,0,0,13.78-13.78V30.85a13.79,13.79,0,0,0-13.78-13.78Z"/>
                                <path class="cls-1" d="M281.6,426.67H8.53A8.54,8.54,0,0,1,0,418.13V59.73A8.53,8.53,0,0,1,8.53,51.2H281.6a8.53,8.53,0,0,1,8.53,8.53v358.4A8.54,8.54,0,0,1,281.6,426.67ZM17.07,409.6h256V68.27h-256Z"/>
                            </g>
                        </g>
                    </svg>
                    </span>
                  <span class="header-mobile__title-block">
                      <span><?php echo $telephone_arr[0]; ?></span>
                      <h1 class="header-mobile__title">Саджанці від виробника</h1>
                  </span>
                </a>
<!-- SEARCH BLOCK-->
            <div class="header-mobile__search header-mobile__icon header-mobile__icon-green">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 396.82 396.74">
                    <defs>
                        <style>
                            .cls-1 {
                                fill: #39373a;
                            }
                        </style>
                    </defs>
                    <g id="Слой_2" data-name="Слой 2">
                        <g id="Capa_1" data-name="Capa 1">
                            <path class="cls-1" d="M352.1,44.64a151.89,151.89,0,0,0-220.33,209l-11.6,11.6a24,24,0,0,0-33.94,0h0L7,344.45A24,24,0,0,0,7,378.4H7l11.31,11.31h0a24,24,0,0,0,33.94,0l79.2-79.2a24,24,0,0,0,0-33.94h0l11.6-11.6a151.9,151.9,0,0,0,209-220.33ZM120.17,299.19,41,378.39a8,8,0,0,1-11.31,0L18.35,367.07a8,8,0,0,1,0-11.3l79.2-79.2a8.17,8.17,0,0,1,11.31,0l11.31,11.32A8,8,0,0,1,120.17,299.19Zm220.63-50.9A136,136,0,1,1,340.8,56,136,136,0,0,1,340.8,248.29Z"/>
                            <path class="cls-1" d="M329.48,67.26,318.17,78.57a104.14,104.14,0,0,1,0,147.08L329.48,237a120.14,120.14,0,0,0,0-169.71Z"/>
                        </g>
                    </g>
                </svg>
            </div>

            <!--CART-->
            <div class="">
              <?php echo $cart; ?>
            </div>
        </div>


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
                </ul>
            </div>
        </nav>
    </header>
<?php } else { ?>
    <header class="header-desktop">
        <!--<div class="conteiner-fluid top-linear"> </div>-->
      <?php if (!$GLOBALS['isMobile']) { ?>
          <p>HELLO</p>
      <?php } ?>
        <div class="container header-wrapper">
            <!--LOGO-->
            <div class="col-xs-4 col-sm-6 col-lg-4">
                <div id="logo" class="header-main__logo">
                    <h1 class="header-main__logo_wrapper">
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
            <div class="col-xs-3 col-sm-2 col-lg-2 header-main__cart">
              <?php echo $cart; ?>
            </div>
        </div>
        <div class="container-fluid top-linear"></div>
        <div class="container">
            <div class="row">
                <!--Main menu-->
                <div class="col-sm-12 col-md-10">
                    <nav id="menu" class="header-main__menu">
                        <div class="navbar-header">
                            <span id="category"
                                  class="visible-xs header-main__menu_title"><?php echo $text_category; ?></span>
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
    </header>
<?php } ?>







