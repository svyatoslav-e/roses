<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="scp_grad" style="overflow: hidden;">
    <div style="float:left; margin-top: 10px;" >
    	<img src="view/image/blog-icon.png" style="height: 21px; margin-left: 10px; " >
    </div>

<div style="margin-left: 10px; float:left; margin-top: 10px;  color: #777;">
<ins style="color: #00A3D9; padding-top: 17px; text-shadow: 0 2px 1px #FFFFFF; padding-left: 3px;  font-weight: normal;  text-decoration: none; ">
<?php echo strip_tags($heading_title); ?>
</ins> ver.: <?php echo $blog_version; ?>
</div>

    <div class="scp_grad_green" style=" height: 40px; float:right; ">
      <div style="color: #555;margin-top: 2px; line-height: 18px; margin-left: 9px; margin-right: 9px; overflow: hidden;"><?php echo $language->get('heading_dev'); ?></div>
    </div>

</div>

  <div class="page-header">
    <div class="container-fluid">

<script type="text/javascript" src="view/javascript/ckeditor/ckeditor.js"></script>


<div id="content1" style="border: none;">

<div style="clear: both; line-height: 1px; font-size: 1px;"></div>


<?php if ($error_warning) { ?>
    <div class="alert alert-danger warning"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
<?php } ?>

<?php if ($success) { ?>
    <div class="alert alert-success success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
<?php } ?>


<div class="box1">

<div class="content">

<?php echo $agoo_menu; ?>


      <div class="buttons" style="float:right;">
      <a onclick="$('#form').submit();" class="markbutton button_orange nohref"><?php echo $button_save; ?></a>
      <a onclick="location = '<?php echo $cancel; ?>';" class="markbutton button_orange nohref"><?php echo $language->get('button_cancel'); ?></a>
      </div>

      <div style="width: 100%; overflow: hidden; clear: both; height: 1px; line-height: 1px;">&nbsp;</div>


  <div class="box">
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="form">

		 <tr>
		   <td><?php echo $language->get('entry_blog_categories'); ?></td>
		   <td>
			   <select id="category_information_id" name="category_information">
				<?php foreach ($categories as $cat) {  ?>
			     	<option value="<?php echo $cat['blog_id']; ?>" <?php if (isset($category_information) && $category_information == $cat['blog_id']) { ?> selected="selected" <?php } ?>><?php echo $cat['name']; ?></option>
			   	<?php } ?>
			    </select>
		     </td>
		 </tr>
<!--
    <tr>
     <td class="left"></td>
     <td class="left">

<a onclick="
        var file_sitemap = $('#category_information_id').val();
 		$.ajax({
					url: '<?php echo $url_convert_information; ?>',
					type: 'post',
					data:  {category_information_id: file_sitemap },
					dataType: 'html',
					beforeSend: function()
					{
                      $('.genbutton_').hide();
                      $('#convertor_loading').html('<?php echo $text_loading; ?>');
                      $('#convertor_loading').show();

					},
					success: function(html) {
						if (html) {
							$('.genbutton_').show();
							$('#convertor_loading').html(html);
						}

					}
				});


      return false; " class="markbutton genbutton_"><?php echo $language->get('button_gen'); ?></a>

 	 <div id='convertor_loading' style="display: none;"></div>




     </td>
    </tr>
-->


        </table>
      </form>
    </div>
  </div>
</div>
</div>
<?php echo $footer; ?>
