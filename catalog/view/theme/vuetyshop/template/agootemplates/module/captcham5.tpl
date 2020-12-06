<!-- // for the lazy. no need to thanks. no offense, i wanted to help them :) -->
<?php if ($captcha_status) { ?>
<div class="sc-clearfix">
	<div class="floatleft">
		<div class="height30px width95px">
			<img src="index.php?route=record/treecomments/captcham5&v=<?php echo rand(0,1000); ?>" alt="captcha" id="imgcaptcha" class="captcha_img">
		</div>

		<div class="align_center paddingtop5px">
			 <a class="captcha_update align_center"><?php echo $entry_captcha_update; ?></a>
		</div>
	</div>

	<div class="floatleft">
		<div class="height30px width95px">
		<input type="text" name="captcha" value="" id="captcha_fun" class="captcha captchainput captcha_img form-control" maxlength="5" size="5">
		</div>

		<div class="align_center">
			<?php
		 	for ($i=0; $i<strlen($captcha_keys); $i++) { ?><input type="button" class="bkey sc-cbtn btn btn-primary" value='<?php echo $captcha_keys[$i];?>'><?php }  ?>
		</div>
	</div>
</div>

<script type="text/javascript">
$(document).ready(function(){

	$('.bkey').bind('click', subcaptcha);

	$('.captcha_update').click(function() {
	 captcha_fun();
	 return false;
	});

});
</script>
<?php } ?>