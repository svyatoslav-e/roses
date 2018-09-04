<!DOCTYPE html>
<!--[if IE]><![endif]-->
<!--[if IE 8 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie8"><![endif]-->
<!--[if IE 9 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<!--<![endif]-->
<head>
<meta name="yandex-verification" content="32d2c49a20258eec" />
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<?php if ($description) { ?>
<meta name="description" content="<?php echo $description; ?>" />
<?php } ?>
<?php if ($keywords) { ?>
<meta name="keywords" content= "<?php echo $keywords; ?>" />
<?php } ?>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<?php if ($icon) { ?>
<link href="<?php echo $icon; ?>" rel="icon" />
<?php } ?>
<?php foreach ($links as $link) { ?>
<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
<?php } ?>
<script src="catalog/view/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript"></script>
<link href="catalog/view/javascript/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen" />
<script src="catalog/view/javascript/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<link href="catalog/view/javascript/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="//fonts.googleapis.com/css?family=Open+Sans:400,400i,300,700" rel="stylesheet" type="text/css" />
<link href="catalog/view/theme/default/stylesheet/stylesheet.css" rel="stylesheet">
<link href="catalog/view/theme/default/stylesheet/style.css" rel="stylesheet">
<?php foreach ($styles as $style) { ?>
<link href="<?php echo $style['href']; ?>" type="text/css" rel="<?php echo $style['rel']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>
<script src="catalog/view/javascript/common.js" type="text/javascript"></script>
<?php foreach ($scripts as $script) { ?>
<script src="<?php echo $script; ?>" type="text/javascript"></script>
<?php } ?>

<link rel="stylesheet" href="catalog/view/javascript/jquery/owl-carousel/owl.carousel.css" type="text/css">
<script type="text/javascript" src="catalog/view/javascript/jquery/owl-carousel/owl.carousel.min.js"></script>

<?php echo $google_analytics; ?>
</head>
<body class="<?php echo $class; ?>">
<header class="header-main">
<!--<div class="conteiner-fluid top-linear"> </div>-->
    <div class="container-fluid">
        <div class="row">
            <!--LOGO-->
            <div class="col-sm-3">
                <div id="logo">
                    <h1 class="header-main__logo">
                        <a href="<?php echo $home; ?>" class="header-main__logo_link">
                            <?php if ($logo) { ?>
                            <img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" class="img-responsive" />
                            <?php } ?>
                            <span class="header-main__logo_link-green">Fruits</span>
                            &
                            <span class="header-main__logo_link-rose">Roses</span>
                        </a>
                    </h1>
                </div>
            </div>
            <!--Main menu-->
            <div class="col-sm-5">
                <nav id="menu" class="header-main__menu">
                    <div class="navbar-header"><span id="category" class="visible-xs"><?php echo $text_category; ?></span>
                        <button type="button" class="btn btn-navbar navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                            <i class="fa fa-bars"></i>
                        </button>
                    </div>
                    <div class="collapse navbar-collapse navbar-ex1-collapse left-menu-dig-block no-padding">
                        <ul>
                            <?php foreach ($categories as $category) { ?>
                            <li><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a></li>
                            <?php }?>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>

       <!--<p class="viber"><a href="tel:<?=$telephone_arr[0];?>"><i class="fa fa-phone-square" aria-hidden="true"></i><?php echo $telephone_arr[0]; ?></a></p>-->

    </div>
<div class="container-fluid top-linear"> </div>
</header>






