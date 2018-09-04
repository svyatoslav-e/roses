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
<header>
<h1><a href="/"><?php echo $name; ?></a></h1>
<div class="conteiner-fluid top-linear"> </div>

  <div class="container">
       <?php echo $language; ?>
    <div class="row">

    <div class="hidden-xs col-sm-5 col-lg-5 main_text"><span>Fruits</span></div>



    <div class="hidden-xs col-sm-5 col-lg-5 main_text"><span>Roses</span>
    
    </div>

    </div>
  </div>
<div class="container-fluid top-linear"> </div>
</header>

<div class="container">
 <div class="col-xs-12">
  <nav id="menu" class="navbar">
      <div class="navbar-header"><span id="category" class="visible-xs"><?php echo $text_category; ?></span>
      <button type="button" class="btn btn-navbar navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
      <i class="fa fa-bars"></i>
      </button>
    </div>
      <div class="collapse navbar-collapse navbar-ex1-collapse left-menu-dig-block no-padding">
      <ul class="big-list main_menu" id="blog">
        <li><a href="<?=$about_us; ?>"><?=$about_us_text; ?><span class="number"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></span></a></li>
        <li><a href="<?=$delivery_inf; ?>"><?=$delivery_inf_text; ?><span class="number"><i class="fa fa-truck" aria-hidden="true"></i></span></a></li>
        <li><a href="<?=$payment_inf; ?>"><?=$payment_inf_text; ?><span class="number"><i class="fa fa-tags" aria-hidden="true"></i></span></a></li>
        <li><a href="<?=$contact; ?>"><?=$text_contact; ?><span class="number"><i class="fa fa-life-ring" aria-hidden="true"></i></span></a></li>
      </ul>
    </div>
  </nav>
 </div>
</div>
<div class="container-fluid top-linear"> </div>
<div class="div container">
 <div class="col-xs-12 contact_home_block">
  <div class="col-xs-12 col-md-6 text-left">
       <p class="viber"><a href="tel:<?=$telephone_arr[0];?>"><i class="fa fa-phone-square" aria-hidden="true"></i><?php echo $telephone_arr[0]; ?></a></p> 
  </div>  
     <?php echo $cart; ?>
 </div>  
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-xs-2">
            <div id="logo">
                <?php if ($logo) { ?>
                <a href="<?php echo $home; ?>"><img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" class="img-responsive" /></a>
                <?php } else { ?>
                <h1><a href="<?php echo $home; ?>"><?php echo $name; ?></a></h1>
                <?php } ?>
            </div>
        </div>
    </div>
</div>




