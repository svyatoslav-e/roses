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
        <div id="content" class="col-sm-12">
            <?php echo $content_top; ?>
            <div class="contacts" id="contacts">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="col-xs-12 contacts__phone">
                            <span class="contacts__phone_title"><?php echo $text_telephone; ?></span>
                            <?php foreach ($telephone_arr as $tel) { ?>
                                <p itemprop="telephone"> <?php echo $tel; ?></p>
                            <?php } ?>

                            <span class="contacts__phone_title"><?= $text_social; ?></span>
                            <ul class="contacts__phone_social">
                                <li class="fb"><a href="https://www.facebook.com/fruitsandrosescomua" target="_blank"><i
                                                class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                <li class="insta"><a href="https://www.instagram.com/fruitsandrosesshop"
                                                     target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                                </li>

                                <script src="https://apis.google.com/js/platform.js"></script>
                                <div class="g-ytsubscribe" data-channelid="UCN6dadFJR5QR6fcOxNvYukA"
                                     data-layout="default" data-count="hidden">
                                </div>
                            </ul>

                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="col-xs-12 contacts__address">
                            <span class="contacts__address_title"><?= $text_location; ?></span>
                            <p><?= $address; ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <!--COMMENTS BLOCK-->
            <div id="form_comments"></div>
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data"
                  class="form-horizontal contacts__question">
                <fieldset>
                    <h3><?php echo $text_contact; ?></h3>
                    <div class="form-group required">
                        <div class="col-sm-12">
                            <input type="text" name="name" value="<?php echo $name; ?>" id="input-name"
                                   class="form-control" placeholder="<?php echo $entry_name; ?>"/>
                            <?php if ($error_name) { ?>
                                <div class="text-danger"><?php echo $error_name; ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group required">
                        <div class="col-sm-12">
                            <input type="text" name="email" value="<?php echo $email; ?>" id="input-email"
                                   class="form-control" placeholder="<?php echo $entry_email; ?>"/>
                            <?php if ($error_email) { ?>
                                <div class="text-danger"><?php echo $error_email; ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group required">
                        <div class="col-sm-12">
                            <textarea name="enquiry" rows="10" id="input-enquiry" class="form-control"
                                      placeholder="<?php echo $entry_enquiry; ?>"><?php echo $enquiry; ?></textarea>
                            <?php if ($error_enquiry) { ?>
                                <div class="text-danger"><?php echo $error_enquiry; ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php if ($site_key) { ?>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="g-recaptcha" data-sitekey="<?php echo $site_key; ?>"></div>
                                <?php if ($error_captcha) { ?>
                                    <div class="text-danger"><?php echo $error_captcha; ?></div>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                </fieldset>
                <div class="col-xs-12 col-sm-4 pull-right">
                    <div class="row">
                        <button class="dtn-roses btn-green" type="submit">
                            <?php echo $button_submit; ?>
                        </button>
                    </div>
                </div>
            </form>
            <?php echo $content_bottom; ?></div>
        <?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>
