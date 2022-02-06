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
    <!-- development version, includes helpful console warnings -->
    <script src="catalog/view/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript"></script>
    <link href="catalog/view/javascript/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen"/>
    <link href="catalog/view/theme/vuetyshop/stylesheet/style.min.css" rel="stylesheet">
    <!--    VUE -->
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script async src="catalog/view/javascript/common.js" type="text/javascript"></script>
    <script async src="catalog/view/javascript/menu.js" type="text/javascript"></script>
</head>
<body class="<?php echo $class; ?>">
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
                                <path class="cls-1"
                                      d="M187.73,42.67H102.4a8.54,8.54,0,0,1,0-17.07h85.33a8.54,8.54,0,1,1,0,17.07Z"/>
                                <path class="cls-1"
                                      d="M247.47,42.67h-8.54a8.54,8.54,0,0,1,0-17.07h8.54a8.54,8.54,0,0,1,0,17.07Z"/>
                                <path class="cls-1"
                                      d="M155.66,486.4H134.47a23.57,23.57,0,0,1-23.54-23.53v-4.13a23.58,23.58,0,0,1,23.55-23.54h21.19a23.56,23.56,0,0,1,23.53,23.54v4.13A23.56,23.56,0,0,1,155.66,486.4Zm-21.18-34.13a6.48,6.48,0,0,0-6.48,6.47v4.13a6.47,6.47,0,0,0,6.48,6.46h21.19a6.47,6.47,0,0,0,6.46-6.46v-4.13a6.47,6.47,0,0,0-6.47-6.47Z"/>
                                <path class="cls-1"
                                      d="M259.29,512H30.85A30.89,30.89,0,0,1,0,481.15V30.85A30.89,30.89,0,0,1,30.85,0H259.29a30.88,30.88,0,0,1,30.84,30.85V481.16A30.88,30.88,0,0,1,259.29,512ZM30.85,17.07A13.79,13.79,0,0,0,17.07,30.85V481.16a13.78,13.78,0,0,0,13.78,13.77H259.29a13.79,13.79,0,0,0,13.78-13.78V30.85a13.79,13.79,0,0,0-13.78-13.78Z"/>
                                <path class="cls-1"
                                      d="M281.6,426.67H8.53A8.54,8.54,0,0,1,0,418.13V59.73A8.53,8.53,0,0,1,8.53,51.2H281.6a8.53,8.53,0,0,1,8.53,8.53v358.4A8.54,8.54,0,0,1,281.6,426.67ZM17.07,409.6h256V68.27h-256Z"/>
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
        <div class="">
            <?php echo $search; ?>
        </div>

        <!--CART-->
        <div class="">
            <?php echo $cart; ?>
        </div>
    </div>
    <div class="header-list__wrapper">
            <div id="mobile-menu">
                <button @click="toggleMenu" class="menu__button">КАТАЛОГ</button>
                <div class="menu" v-show="showMenu">
                    <div class="menu__backdrop" @click="toggleMenu"></div>
                    <transition name="slide">
                        <nav v-show="showMenu" class="menu menu__content">
                            <a href="/roses" class="menu__item menu__item-rose">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 110.93 230.59">
                                    <g id="Слой_2" data-name="Слой 2">
                                        <g id="Layer_1" data-name="Layer 1">
                                            <g>
                                                <path class="cls-1"
                                                      d="M13.36,129.45a40.33,40.33,0,0,1-11.07-36C7,67.52,6.6,53.56.35,31.16a2.83,2.83,0,0,1-.1-.71A6.41,6.41,0,0,1,6.6,24,74.09,74.09,0,0,1,57.49,43.46a2.7,2.7,0,0,1,.17,3.86,2.73,2.73,0,0,1-3.86.18,68.61,68.61,0,0,0-47.12-18,.93.93,0,0,0-.92.71C12.07,53,12.51,68.06,7.67,94.4a34.1,34.1,0,0,0,34,40.86,35.17,35.17,0,0,0,13.67-2.89c3.35-1.44,5.51,3.58,2.16,5a40.69,40.69,0,0,1-15.8,3.33,39.94,39.94,0,0,1-24-7.6,37.43,37.43,0,0,1-4.38-3.68Z"/>
                                                <path class="cls-1"
                                                      d="M40.71,38a2.76,2.76,0,0,1-.61-3A56.26,56.26,0,0,1,52,17a16.37,16.37,0,0,1,1.24-1.26l.21-.22A55.58,55.58,0,0,1,91.24.25a5.47,5.47,0,0,1,5.51,5.41,3,3,0,0,1-.09.72A106,106,0,0,0,93.5,27.19a2.74,2.74,0,1,1-5.46-.3A113,113,0,0,1,91.19,5.72a50.14,50.14,0,0,0-34,13.76l-.25.23c-.33.3-.65.61-.95.94a51.16,51.16,0,0,0-10.87,16.4,2.74,2.74,0,0,1-4.45.91Z"/>
                                                <path class="cls-1"
                                                      d="M18.18,29.61a2.78,2.78,0,0,1-.81-1.76A103.94,103.94,0,0,0,13.84,7.13a2.25,2.25,0,0,1-.08-.69A5.45,5.45,0,0,1,19.11.91,55.62,55.62,0,0,1,57.19,15.44l-1.8,2.07-2,1.91a50.07,50.07,0,0,0-34.13-13,109.19,109.19,0,0,1,3.52,21.09,2.73,2.73,0,0,1-4.64,2.14Z"/>
                                                <path class="cls-1"
                                                      d="M40.6,153.08a20.32,20.32,0,0,1-6.1-14.33,7.47,7.47,0,0,1,.11-1.5,2.73,2.73,0,1,1,5.37,1,2,2,0,0,0,0,.42,14.89,14.89,0,1,0,29.78-.28,2,2,0,0,0,0-.35A2.8,2.8,0,0,1,72.1,135a2.69,2.69,0,0,1,3.05,2.23,8.88,8.88,0,0,1,.07,1.15,20.35,20.35,0,0,1-34.61,14.7Z"/>
                                                <path class="cls-1"
                                                      d="M53.76,229.54a2.74,2.74,0,0,1-.82-1.93l-.66-71.41a2.74,2.74,0,0,1,5.47,0l.66,71.42a2.73,2.73,0,0,1-4.65,2Z"/>
                                                <path class="cls-1"
                                                      d="M42.54,128.87a40.37,40.37,0,0,1-12.13-28.48l0-2.13A74.58,74.58,0,0,1,104.2,23.09a6.44,6.44,0,0,1,6.48,6.37,2.43,2.43,0,0,1-.09.71c-5.84,22.49-6,36.46-.79,62.25a39.93,39.93,0,0,1-67.26,36.44ZM35.86,98.21l0,2.13a35,35,0,0,0,55.91,27.72,34.52,34.52,0,0,0,12.65-34.54c-5.33-26.26-5.16-41.35.74-64.25a1,1,0,0,0-.93-.71A69.11,69.11,0,0,0,35.86,98.21Z"/>
                                                <path class="cls-1"
                                                      d="M53.5,183.37a2.73,2.73,0,0,1-.62-3,34.14,34.14,0,0,1,47.37-17.89,2.73,2.73,0,0,1,1.32,3.49,34.12,34.12,0,0,1-47.38,17.87,2.58,2.58,0,0,1-.69-.48Zm41.89-17A28.54,28.54,0,0,0,59.05,180a28.53,28.53,0,0,0,36.34-13.71Z"/>
                                                <path class="cls-1"
                                                      d="M16.81,187.81a35.73,35.73,0,0,1-7.73-11.36,2.73,2.73,0,0,1,1.25-3.51,34.13,34.13,0,0,1,47.68,17,2.73,2.73,0,0,1-1.25,3.51,34.34,34.34,0,0,1-27.61,2.08,33.63,33.63,0,0,1-12.34-7.72Zm-1.56-11.14a28.53,28.53,0,0,0,36.59,13,28.53,28.53,0,0,0-36.59-13Z"/>
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                                Розы
                            </a>
                            <a href="/plodovie" class="menu__item menu__item-blue ">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 243.58 243.58">
                                    <g id="Слой_2" data-name="Слой 2">
                                        <g id="Layer_1" data-name="Layer 1">
                                            <path class="cls-1"
                                                  d="M41.87,197.91a39.52,39.52,0,0,0,16.65-3.68v39.84H20.46a4.76,4.76,0,1,0,0,9.51H223.12a4.76,4.76,0,1,0,0-9.51H185.06V194.23a39.53,39.53,0,0,0,16.66,3.68c22.69,0,41.86-18.52,41.86-40.44,0-17.48-12.7-33.5-30.11-38.7a33.48,33.48,0,0,0-17.08-26.14,47.68,47.68,0,0,0,1.52-28.1,4.76,4.76,0,0,0-9.23,2.32,38.27,38.27,0,0,1-1.19,22.42,33.32,33.32,0,0,0-40.35,29.5,43.28,43.28,0,0,0-20.59,13.53V93.39l27.26-13a4.76,4.76,0,0,0-4.09-8.59l-23.17,11V47.57a4.76,4.76,0,0,0-9.52,0v21l-23.16-11a4.76,4.76,0,1,0-4.1,8.59l27.26,13V132.3a43.28,43.28,0,0,0-20.59-13.53,33.32,33.32,0,0,0-40.35-29.5,37.94,37.94,0,0,1,30-50.61,4.75,4.75,0,0,0,4-3.84c2.62-14.19,16.58-25.31,31.78-25.31S151,20.63,153.57,34.82a4.76,4.76,0,0,0,4,3.84A39,39,0,0,1,163.28,40a4.76,4.76,0,1,0,2.88-9.07c-1.31-.41-2.64-.77-4-1.07C157.39,12.62,140.6,0,121.79,0S86.19,12.63,81.4,29.86A47.43,47.43,0,0,0,47.19,92.63a33.48,33.48,0,0,0-17.08,26.14C12.7,124,0,140,0,157.47c0,21.92,19.17,40.44,41.87,40.44ZM68,194.23a39.45,39.45,0,0,0,16.65,3.68A42.59,42.59,0,0,0,117,182.8v51.27H68Zm58.52,39.84V182.8a42.59,42.59,0,0,0,32.35,15.11,39.45,39.45,0,0,0,16.65-3.68v39.84Zm26.22-106.9a4.79,4.79,0,0,0,3.75-5.59,23.79,23.79,0,0,1,47.57,0,4.8,4.8,0,0,0,3.75,5.59c14.95,3,26.23,16,26.23,30.3,0,16.76-14.82,30.92-32.35,30.92a30.41,30.41,0,0,1-16.66-5V167.55l25.92-13a4.76,4.76,0,1,0-4.25-8.51l-21.67,10.83V121.79a4.76,4.76,0,1,0-9.51,0v17.06l-6.15-6.15a4.76,4.76,0,0,0-6.73,6.73l12.88,12.87v31.08a30.37,30.37,0,0,1-16.65,5c-17.54,0-32.35-14.16-32.35-30.92,0-14.27,11.27-27.3,26.22-30.3Zm-117,0a4.79,4.79,0,0,0,3.75-5.59,23.79,23.79,0,0,1,47.57,0,4.79,4.79,0,0,0,3.75,5.59c15,3,26.22,16,26.22,30.3,0,16.76-14.81,30.92-32.35,30.92a30.37,30.37,0,0,1-16.65-5v-2.53L80.91,168a4.76,4.76,0,0,0-6.73-6.73L68,167.4V136.06a4.76,4.76,0,0,0-9.51,0v20.85L36.86,146.08a4.76,4.76,0,1,0-4.26,8.51l25.92,13v15.83a30.37,30.37,0,0,1-16.65,5c-17.54,0-32.36-14.16-32.36-30.92,0-14.27,11.28-27.3,26.23-30.3Z"/>
                                            <path class="cls-1"
                                                  d="M134.28,89.71l19.53-9.3a4.76,4.76,0,0,0-4.09-8.59l-15.66,7.46C134.1,82.76,134.2,86.24,134.28,89.71Z"/>
                                            <path class="cls-1"
                                                  d="M192.66,87.85a45.2,45.2,0,0,0-4.5-1,37.48,37.48,0,0,0-30.63-48.15,4.71,4.71,0,0,1-1.12-.35A40.69,40.69,0,0,0,162.58,30a47.27,47.27,0,0,1,34.63,60.12A15,15,0,0,0,192.66,87.85Z"/>
                                        </g>
                                    </g>
                                </svg>
                                Плодовые
                            </a>
                            <a href="/yagodi" class="menu__item menu__item-green">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                     viewBox="0 0 218.5 194.63">
                                    <g id="Слой_2" data-name="Слой 2">
                                        <g id="Layer_1" data-name="Layer 1">
                                            <g class="cls-2">
                                                <path class="cls-3"
                                                      d="M192.52,131.13a53.89,53.89,0,0,0,4.77-22.25,54.47,54.47,0,0,0-34.24-50.5c.1-1.34.15-2.7.15-4.05A54.31,54.31,0,0,0,82.17,7a3.23,3.23,0,0,0-1.63,1A54.47,54.47,0,0,0,55.68,43.27,76.79,76.79,0,0,0,3.31,32.71,3.18,3.18,0,0,0,.63,35.45,78,78,0,0,0,4,70.06a76,76,0,0,0,19.15,30.43c.71.68,1.43,1.36,2.16,2a54.32,54.32,0,1,0,92.73,54.66,54,54,0,0,0,12.73,4.65,76.59,76.59,0,0,0,62.36,32.06,78.17,78.17,0,0,0,22.32-3.25,3.21,3.21,0,0,0,2.28-3.09A77.06,77.06,0,0,0,192.52,131.13ZM83.43,13.7a3.94,3.94,0,0,1,.73.56,3.61,3.61,0,0,1,1.07,2.57,3.57,3.57,0,0,1-1.07,2.56,3.18,3.18,0,0,0-.93,2.26,3.14,3.14,0,0,0,.93,2.25A3.63,3.63,0,0,1,79,29a3.18,3.18,0,0,0-4.51,0,3.64,3.64,0,0,1-5.13,0,3.92,3.92,0,0,1-.66-.91A48.41,48.41,0,0,1,83.43,13.7Zm-18,20.35a10,10,0,0,0,11.34,1.19,10,10,0,0,0,13.6-13.59,10,10,0,0,0-1-11.12,47.94,47.94,0,0,1,67.45,43.8c0,.66,0,1.33,0,2-.67-.17-1.36-.31-2-.47v-.08a48.86,48.86,0,0,0-19.34-.8l0,.13A54.26,54.26,0,0,0,92.85,87.87a54,54,0,0,0-23.24-6,47.89,47.89,0,0,1-4.18-47.8ZM10.07,68A71.48,71.48,0,0,1,6.69,38.68a70.31,70.31,0,0,1,48,11.56c-.09,1.35-.15,2.71-.15,4.09a54,54,0,0,0,7.65,27.8A53.51,53.51,0,0,0,56.8,83L29.31,55.48A3.19,3.19,0,1,0,24.79,60l25,25A54.52,54.52,0,0,0,29.57,97.74c-.66-.6-1.31-1.2-1.94-1.82A69.54,69.54,0,0,1,10.07,68ZM68,184.1a47.95,47.95,0,1,1,48-47.95A48,48,0,0,1,68,184.1Zm52.24-33A54.32,54.32,0,0,0,98.4,91.17a48.17,48.17,0,0,1,38.34-29.76,45.59,45.59,0,0,1,16.09.55,47.95,47.95,0,1,1-32.63,89.13Zm61.6,35.5a69.57,69.57,0,0,1-30.36-12.82,70.57,70.57,0,0,1-11.51-10.65c1,0,2,.09,3,.09a53.93,53.93,0,0,0,24.68-5.94l19,14.36a3.16,3.16,0,0,0,1.92.65,3.19,3.19,0,0,0,1.93-5.73l-16.9-12.8A54.63,54.63,0,0,0,189.45,137a70.67,70.67,0,0,1,21.86,48.19A71.54,71.54,0,0,1,181.8,186.59Z"
                                                      transform="translate(0.37 0.38)"/>
                                            </g>
                                            <path class="cls-4"
                                                  d="M71.63,116a10,10,0,0,0-7.08-2.93h0a9.91,9.91,0,0,0-4.82,1.24,10,10,0,0,0-13.59,13.59,10,10,0,0,0,13.59,13.59,10,10,0,0,0,13.59-13.59A10,10,0,0,0,71.63,116Zm-4.51,14.16A3.63,3.63,0,0,1,62,135.31a3.17,3.17,0,0,0-2.25-.94,3.21,3.21,0,0,0-2.26.94,3.63,3.63,0,0,1-5.13-5.13,3.18,3.18,0,0,0,0-4.51,3.63,3.63,0,0,1,5.13-5.13,3.19,3.19,0,0,0,4.51,0,3.63,3.63,0,0,1,5.14,5.14,3.18,3.18,0,0,0,0,4.51Z"
                                                  transform="translate(0.37 0.38)"/>
                                            <path class="cls-4"
                                                  d="M153.81,125.31a10,10,0,0,0,19.22,0,10,10,0,0,0,0-19.22,10,10,0,0,0-19.22,0,10,10,0,0,0,0,19.22Zm2.79-13.24a3.19,3.19,0,0,0,3.19-3.19,3.63,3.63,0,0,1,7.26,0,3.19,3.19,0,0,0,3.19,3.19,3.63,3.63,0,0,1,0,7.26,3.19,3.19,0,0,0-3.19,3.19,3.63,3.63,0,0,1-7.26,0,3.19,3.19,0,0,0-3.19-3.19,3.63,3.63,0,0,1,0-7.26Z"
                                                  transform="translate(0.37 0.38)"/>
                                        </g>
                                    </g>
                                </svg>
                                Ягодные
                            </a>
                            <a href="/decor" class="menu__item menu__item-rose">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 207.14 223.71"><g id="Слой_2" data-name="Слой 2"><g id="Layer_1" data-name="Layer 1"><g class="cls-2"><path class="cls-3" d="M145.31,83.83c14.86-.35,30.21-7.42,42.31-19.51,12.56-12.56,19.67-28.58,19.52-43.95a3.84,3.84,0,0,0-3.8-3.8h-.49c-15.22,0-31.06,7.12-43.47,19.53-12.11,12.11-19.16,27.45-19.5,42.31l-33.06,33.05V89.69C117.09,78.94,122.94,63.11,122.94,46c0-17.77-6.29-34.13-17.27-44.88a3.83,3.83,0,0,0-5.38,0C89.31,11.85,83,28.21,83,46c0,17.13,5.85,33,16.12,43.71v29.45L78.5,139.77V121.92c6.75-2.2,11.62-10.11,11.62-19.8,0-11.45-6.79-20.41-15.46-20.41s-15.45,9-15.45,20.41c0,9.69,4.86,17.6,11.61,19.8v25.53l-26.1,26.1V155.7c6.75-2.2,11.62-10.11,11.62-19.8,0-11.45-6.79-20.41-15.46-20.41s-15.46,9-15.46,20.41c0,9.69,4.87,17.6,11.62,19.8v25.54L1.13,217.15a3.84,3.84,0,1,0,5.43,5.43L25.5,203.64H51.2c2.2,6.75,10.11,11.62,19.8,11.62,11.45,0,20.41-6.79,20.41-15.46s-9-15.46-20.41-15.46c-9.69,0-17.6,4.87-19.8,11.62h-18l9.91-9.91a4.1,4.1,0,0,0,.93-.93l9.88-9.88H83.34c10.75,10.26,26.58,16.12,43.71,16.12,17.77,0,34.13-6.29,44.89-17.27a3.85,3.85,0,0,0,0-5.38c-10.76-11-27.12-17.28-44.89-17.28-17.13,0-33,5.86-43.71,16.13H61.58l15.29-15.29a3.91,3.91,0,0,0,.93-.93L114.17,115h25.71c2.2,6.76,10.11,11.62,19.8,11.62,11.44,0,20.41-6.79,20.41-15.46s-9-15.45-20.41-15.45c-9.69,0-17.6,4.86-19.8,11.61h-18ZM103,9.49C110.73,18.71,115.27,32,115.27,46S110.73,73.25,103,82.47C95.23,73.25,90.7,59.92,90.7,46S95.23,18.71,103,9.49Zm-36.1,92.63c0-6.78,3.64-12.73,7.78-12.73s7.78,6,7.78,12.73-3.64,12.73-7.78,12.73-7.78-5.95-7.78-12.73ZM33.1,135.9c0-6.78,3.64-12.73,7.78-12.73s7.77,6,7.77,12.73S45,148.63,40.88,148.63s-7.78-5.95-7.78-12.73ZM71,192c6.78,0,12.73,3.64,12.73,7.78s-6,7.78-12.73,7.78-12.73-3.64-12.73-7.78S64.22,192,71,192Zm56.05-32.91c13.94,0,27.27,4.54,36.49,12.29-9.22,7.75-22.55,12.28-36.49,12.28s-27.27-4.53-36.49-12.28c9.22-7.75,22.55-12.29,36.49-12.29Zm32.63-55.76c6.78,0,12.73,3.63,12.73,7.77s-5.95,7.78-12.73,7.78-12.74-3.63-12.74-7.78,6-7.77,12.74-7.77Zm5.13-61.83c10-10,22.39-16.11,34.49-17.12-1,12-7.26,24.63-17.12,34.49S159.8,75,147.69,76c1.05-12,7.26-24.64,17.12-34.5Z" transform="translate(0 0)"/></g></g></g></svg>
                                Декор
                            </a>
                        </nav>
                    </transition>
                </div>
            </div>
        <ul class="header-list__container">
            <li class="header-list__item"><a href="<?= $about_us; ?>"><?= $about_us_text; ?></a></li>
            <li class="header-list__item"><a href="<?= $delivery_inf; ?>"><?= $delivery_inf_text; ?></a></li>
            <li class="header-list__item"><a href="<?= $videos; ?>"><?= $videos_title; ?></a></li>
            <li class="header-list__item" id="blog"><a href="<?= $contact; ?>"><?= $text_contact; ?></a></li>
        </ul>
    </div>
</header>