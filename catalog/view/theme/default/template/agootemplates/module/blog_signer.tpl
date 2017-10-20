<?php  if (isset($signer_code) && $signer_code=='customer_id') { ?>
<div class="form_customer_signer">

	<form action="<?php echo $action; ?>" name="customer_subscribe" id="customer_subscribe" method="post" enctype="multipart/form-data">
		<div style="float: right; text-align: right; margin-top: 5px; margin-right: 5px;">
			<a href="#" style="" class="hrefajax" onclick="$('.form_customer_signer').hide(); return false;"><?php echo $hide_block; ?></a>
		</div>
		<div class="form_customer_content">
			<b><?php echo $entry_email; ?></b><br />
			<input type="text" name="email" class="form-control sc-form-control" value="<?php echo $email; ?>" />
			<br />
			<b><?php echo $entry_password; ?></b><br />
			<input type="password" name="password" class="form-control sc-form-control" value="<?php echo $password; ?>" />
			<br />
			<a href="<?php echo $forgotten; ?>"><?php echo $text_forgotten; ?></a>
			<br />
			<input type="submit" value="<?php echo $button_login; ?>" class="button btn btn-primary" />
			<a href="<?php echo $register; ?>" class="marginleft10"><?php echo $error_register; ?></a>
			<?php if ($redirect) { ?>
			<input type="hidden" name="redirect" value="<?php echo $redirect; ?>#comments_signer" />
			<?php }  ?>
		</div>
		<div class="form_customer_content" style="margin-top:5px;">
			<?php echo $text_or_email; ?>
			<br>
			<input type="text" name="email_ghost" class="form-control sc-form-control" value="<?php if (isset($email_ghost) && $email_ghost!='') echo $email_ghost; ?>" />
			<?php if (isset($email_error) && $email_error=='email') { ?>
			<div class="error alert alert-danger">
				<?php echo $text_email_error; ?>
				<button class="close" data-dismiss="alert" type="button">×</button>
			</div>
			<?php }  ?>
			<?php if (isset($email_error) && $email_error=='noemail') { ?>
			<div class="error alert alert-danger">
				<?php echo $text_noemail_error; ?>
				<button class="close" data-dismiss="alert" type="button">×</button>
			</div>
			<?php }  ?>
			<div class="margintop5">
				<a class="button btn btn-primary textdecoration_none comments_signer" data-cmswidget="<?php echo $cmswidget; ?>"> <?php echo $text_subscribe; ?></a>
			</div>
		</div>
	</form>
</div>
<?php } ?>
<?php if (isset($signer_code) && $signer_code=='record_id') { ?>
<div class="alert alert-danger warning">
	<?php echo $error_record_id; ?>
	<img src="catalog/view/theme/default/image/close.png" alt="" class="close" />
	<button class="close" data-dismiss="alert" type="button">×</button>
</div>
<?php } ?>
<?php if (isset($signer_code) && $signer_code=='no_signer') { ?>
<div class="alert alert-danger warning">
	<?php echo $error_no_signer; ?>
	<img src="catalog/view/theme/default/image/close.png" alt="" class="close" />
	<button class="close" data-dismiss="alert" type="button">×</button>
</div>
<?php } ?>
<?php if (isset($signer_code) && $signer_code=='set') { ?>
<div class="alert alert-success success">
	<?php echo $success_set; ?>
	<img src="catalog/view/theme/default/image/close.png" alt="" class="close" />
	<button class="close" data-dismiss="alert" type="button">×</button>
</div>
<?php } ?>
<?php if (isset($signer_code) && $signer_code=='remove') { ?>
<div class="alert alert-success  success">
	<?php echo $success_remove; ?>
	<img src="catalog/view/theme/default/image/close.png" alt="" class="close" />
	<button class="close" data-dismiss="alert" type="button">×</button>
</div>
<?php } ?>