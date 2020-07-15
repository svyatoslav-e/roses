<?php echo $header; ?>
<div class="container-fluid breadcrumb-wrapper">
    <div class="row">
        <div class="container">
            <ul class="breadcrumb">
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <h2 class="col-xs-12 text-center category_title"><?php echo $heading_title; ?></h2>
        <div class="col-xs-12"><span class="cildren_<?= $category_id ?>"></span></div>


        <?php if ($categories) { ?>


            <div class="col-sm-12 hidden-xs hidden-sm">
                <ul class="category_list">
                    <?php foreach ($categories as $category) { ?>
                        <li><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a></li>
                    <?php } ?>
                </ul>
            </div>


        <?php } ?>

        <?php echo $column_left; ?>
        <?php if ($column_left && $column_right) { ?>
            <?php $class = 'col-sm-6'; ?>
        <?php } elseif ($column_left || $column_right) { ?>
            <?php $class = 'col-xs-12 col-md-9'; ?>
        <?php } else { ?>
            <?php $class = 'col-lg-12'; ?>
        <?php } ?>

        <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
            <?php if ($products) { ?>
                <?php foreach ($products as $product) { ?>

                    <? if ($product['quantity'] <= 3) { ?>
                        <? $filter_stock = 'filter_stock'; ?>
                    <? } else { ?>
                        <? $filter_stock = ' '; ?>
                    <? } ?>

                    <div class="product-layout product-list col-xs-12 col-sm-6 col-md-4">
                        <div class="product-thumb transition cildren_<?php echo $product['cid']; ?>">
                            <h4 class="product_title <?= $filter_stock; ?>"><a
                                        href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></h4>

                            <div class="image">
                                <a href="<?php echo $product['href']; ?>">
                                    <img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>"
                                         title="<?php echo $product['name']; ?>" class="img-responsive"/>
                                    <span class="description"><?php echo $product['description']; ?></span>
                                </a>
                            </div>
                            <div class="caption">
                                <?php if ($product['rating']) { ?>
                                    <div class="rating">
                                        <?php for ($i = 1; $i <= 5; $i++) { ?>
                                            <?php if ($product['rating'] < $i) { ?>
                                                <span class="fa fa-stack"><i
                                                            class="fa fa-star-o fa-stack-2x"></i></span>
                                            <?php } else { ?>
                                                <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i
                                                            class="fa fa-star-o fa-stack-2x"></i></span>
                                            <?php } ?>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                                <?php if ($product['price']) { ?>
                                    <p class="price">
                                        <?php if (!$product['special']) { ?>
                                            <?php echo $product['price']; ?>
                                        <?php } else { ?>
                                            <span class="price-new"><?php echo $product['special']; ?></span> <span
                                                    class="price-old"><?php echo $product['price']; ?></span>
                                        <?php } ?>
                                    </p>
                                <?php } ?>
                            </div>
                            <div class="button-group">
                                <? if ($product['quantity'] <= 3) { ?>
                                    <button type="button" id="button_next_<?php echo $product['product_id']; ?>"
                                            class="filter_stock"><span class="">Продано</span></button>
                                <? } else { ?>
                                    <button type="button" onclick="cart.add('<?php echo $product['product_id']; ?>');"
                                            id="button_<?php echo $product['product_id']; ?>"><span
                                                class=""><?php echo $button_cart; ?></span></button>
                                <? } ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>


                <div class="col-xs-12 text-left"><?php echo $pagination; ?></div>
                <div class="col-xs-12 text-right"><?php echo $results; ?></div>

            <?php } ?>
            <?php if (!$categories && !$products) { ?>
                <p><?php echo $text_empty; ?></p>
                <div class="buttons">
                    <div class="pull-right"><a href="<?php echo $continue; ?>"
                                               class="btn btn-primary"><?php echo $button_continue; ?></a></div>
                </div>
            <?php } ?>
            <?php if ($thumb || $description) { ?>
                <div class="row">
                    <?php if ($thumb) { ?>
                        <div class="col-sm-2"><img src="<?php echo $thumb; ?>" alt="<?php echo $heading_title; ?>"
                                                   title="<?php echo $heading_title; ?>" class="img-thumbnail"/>
                        </div>
                    <?php } ?>
                    <?php if ($description) { ?>
                        <div class="col-sm-12"><?php echo $description; ?></div>
                    <?php } ?>
                </div>

            <?php } ?>
            <?php echo $content_bottom; ?></div>
        <?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>
