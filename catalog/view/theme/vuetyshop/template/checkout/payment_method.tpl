<?php if ($error_warning) { ?>
<div class="alert alert-warning"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?></div>
<?php } ?>
<?php if ($payment_methods) { ?>
<p><?php echo $text_payment_method; ?></p>
<?php foreach ($payment_methods as $payment_method) { ?>
<div class="radio">
  <label>
    <?php if ($payment_method['code'] == $code || !$code) { ?>
    <?php $code = $payment_method['code']; ?>
    <input type="radio" name="payment_method" value="<?php echo $payment_method['code']; ?>" checked="checked" />
    <?php } else { ?>
    <input type="radio" name="payment_method" value="<?php echo $payment_method['code']; ?>" />
    <?php } ?>
    <?php echo $payment_method['title']; ?>
    <?php if ($payment_method['terms']) { ?>
    (<?php echo $payment_method['terms']; ?>)
    <?php } ?>
  </label>
</div>
<?php } ?>
<?php } ?>
<?php if ($text_agree) { ?>
<div class="buttons">
  <div class="pull-right col-xs-12 col-sm-3">
    <?php if ($agree) { ?>
    <input type="checkbox" name="agree" value="1" checked="checked" class="hidden"/>
    <?php } else { ?>
    <input type="checkbox" name="agree" value="1" checked="checked" class="hidden"/>
    <?php } ?>
    &nbsp;
    <input type="button" value="<?php echo $button_continue; ?>" id="button-payment-method" data-loading-text="<?php echo $text_loading; ?>" class="dtn-roses btn-orange" />
  </div>
</div>
<?php } else { ?>
<div class="buttons">
  <div class="pull-right col-xs-12 col-sm-3">
    <input type="button" value="<?php echo $button_continue; ?>" id="button-payment-method" data-loading-text="<?php echo $text_loading; ?>" class="dtn-roses btn-orange" />
  </div>
</div>
<?php } ?>
