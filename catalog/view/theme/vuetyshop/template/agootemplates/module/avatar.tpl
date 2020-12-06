<div class="avatar-content">
		<div class="marginbottom5 fontsize1em"><?php echo $heading_title; ?></div>
		<div class="avatar-info">
		<div id="avatar-image">
		<?php if (isset($avatar) && $avatar!='') { ?>
         <img src="<?php echo $avatar; ?>" alt="<?php echo $avatar; ?>" title="<?php echo $avatar; ?>" style="width:<?php echo $avatar_width; ?>px ; height:<?php echo $avatar_height; ?>px ; ">
		<?php } ?>
		</div>
        <div id="avatar-option" class="option">
          <form>
	          <input type="button" value="<?php echo  $language->get('button_upload'); ?>" id="avatar-form"   class=" btn btn-primary button">
	          <input type="button" value="<?php echo  $language->get('button_delete'); ?>" onclick="avatardelete(); return false;" id="avatar-delete" class="btn btn-primary button">
  			  <input type="hidden" name="avatar" value="" />
          </form>
        </div>
		<?php echo  $language->get('text_upload_allowed'); ?><br><span class="help"><?php echo  $filetypes; ?></span><br>
		<?php echo  $language->get('text_avatar_dim'); ?><br><span class="help"><?php echo  $avatar_width; ?> x <?php echo  $avatar_height; ?> (px)</span><br>
		</div>
</div>

<script>

  avatardelete = function() {
	 $.ajax({
	   url: "<?php echo  $link; ?>",
	   type: "POST",
	   data: { action: "delete"},
	   dataType: "json",
			beforeSend: function()
			{
				$('#avatar-delete').after('<img src="catalog/view/theme/default/image/aloading16.png" class="loading" style="padding-left: 5px;" />');
				$('#avatar-delete').attr('disabled', true);
			},
			success: function(json) {
             if (json['error']) {

             $('.loading').remove();
             $('#avatar-delete').attr('disabled', false);
             avatarload();
             $('#notification').html('<div class="success">' + json['error'] +' <img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');
			 $('.breadcrumb').after('<div class="alert alert-success">' + json['error'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
             }
			},
			error: function(json) {
             alert( "Error");
			}
	 });
 }
</script>

<script type="text/javascript" src="catalog/view/javascript/blog/ajaxupload.js"></script>
<script type="text/javascript">
new AjaxUpload('#avatar-form', {
	action: '<?php echo  $link; ?>',
	name: 'file',
    data: {
      cmswidget: '<?php echo $cmswidget; ?>',
      layout_id: '<?php echo $layout_id; ?>',
      url: '<?php echo $url; ?>',
      sc_ajax: '1'
    },
	autoSubmit: true,
	responseType: 'json',
	onSubmit: function(file, extension) {
        $('.error').remove();
        $('.alert').remove();
        $('#notification').remove();

		$('#avatar-form').after('<img src="catalog/view/theme/default/image/aloading16.png" class="loading" style="padding-left: 5px;" />');
		$('#avatar-form').attr('disabled', true);
	},
	onComplete: function(file, json) {
		$('#avatar-form').attr('disabled', false);



		if (json['success']) {

			$('input[name=\'avatar-form\']').attr('value', json['file']);
			$('#avatar-image').html('<img style="border: 2px solid #EAF7D9;" src="'+json['file']+'">');

			avatarload();

            $('#notification').html('<div class="success">' + json['success'] +' <img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');
			$('.breadcrumb').after('<div class="alert alert-success">' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');

		}

		if (json['error']) {
			$('#avatar-option').after('<span class="error">' + json['error'] + '</span>');
		}

		$('.loading').remove();
	}
});
</script>