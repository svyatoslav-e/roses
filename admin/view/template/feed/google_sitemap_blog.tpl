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
            <td><?php echo $entry_status; ?></td>
            <td><select name="google_sitemap_blog_status">
                <?php if (isset($google_sitemap_blog_status) &&  $google_sitemap_blog_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
          </tr>

          <tr>
            <td><?php echo $entry_data_feed; ?></td>
            <td>

            <!-- <textarea rows="1" style="width: 100%;"><?php echo $data_feed; ?></textarea> -->
            <a href="<?php echo $data_feed; ?>"  target="_blank"><?php echo $data_feed; ?></a>
            </td>
          </tr>


          <tr>
            <td><?php echo $entry_language_status; ?></td>
            <td><select name="ascp_settings_sitemap[google_sitemap_blog_language_status]">
                <?php if (isset($ascp_settings_sitemap['google_sitemap_blog_language_status']) &&  $ascp_settings_sitemap['google_sitemap_blog_language_status']) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
          </tr>


          <tr>
            <td><?php echo $entry_cache_status; ?></td>
            <td><select name="ascp_settings_sitemap[google_sitemap_blog_cache_status]">
                <?php if (isset($ascp_settings_sitemap['google_sitemap_blog_cache_status']) &&  $ascp_settings_sitemap['google_sitemap_blog_cache_status']) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
          </tr>


          <tr>
            <td><?php echo $entry_page_status; ?></td>
            <td><select name="ascp_settings_sitemap[google_sitemap_blog_page_status]">
                <?php if (isset($ascp_settings_sitemap['google_sitemap_blog_page_status']) &&  $ascp_settings_sitemap['google_sitemap_blog_page_status']) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
          </tr>

          <tr>
            <td><?php echo $entry_image_status; ?></td>
            <td><select name="ascp_settings_sitemap[google_sitemap_blog_image_status]">
                <?php if (isset($ascp_settings_sitemap['google_sitemap_blog_image_status']) &&  $ascp_settings_sitemap['google_sitemap_blog_image_status']) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
          </tr>


    <tr>
     <td class="left"><?php echo $entry_cache_expire; ?></td>
     <td class="left">
      <input type="text" name="ascp_settings_sitemap[google_sitemap_blog_cache_expire]" value="<?php  if (isset($ascp_settings_sitemap['google_sitemap_blog_cache_expire'])) echo $ascp_settings_sitemap['google_sitemap_blog_cache_expire']; ?>" size="20" />
     </td>
    </tr>

          <tr>
            <td><?php echo $entry_inter_status; ?></td>
            <td><select name="ascp_settings_sitemap[google_sitemap_blog_inter_status]">
                <?php if (isset($ascp_settings_sitemap['google_sitemap_blog_inter_status']) &&  $ascp_settings_sitemap['google_sitemap_blog_inter_status']) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
          </tr>

    <tr>
     <td class="left"><?php echo $entry_inter_route; ?></td>
     <td class="left">
      <input type="text" name="ascp_settings_sitemap[google_sitemap_blog_inter_route]" value="<?php  if (isset($ascp_settings_sitemap['google_sitemap_blog_inter_route'])) echo $ascp_settings_sitemap['google_sitemap_blog_inter_route']; ?>" size="50" />
     </td>
    </tr>

    <tr>
     <td class="left"><?php echo $entry_inter_tag; ?></td>
     <td class="left">
      <input type="text" name="ascp_settings_sitemap[google_sitemap_blog_inter_tag]" value="<?php  if (isset($ascp_settings_sitemap['google_sitemap_blog_inter_tag'])) echo $ascp_settings_sitemap['google_sitemap_blog_inter_tag']; ?>" size="50" />
     </td>
    </tr>

    <tr>
     <td class="left"><?php echo $entry_file_sitemap; ?>&nbsp;<span class="help"><a href="<?php echo $data_feed_file_sitemap; ?>" target="_blank"><?php echo $data_feed_file_sitemap; ?></a></span></td>
     <td class="left">
      <input type="text" id="google_sitemap_blog_file_sitemap" name="ascp_settings_sitemap[google_sitemap_blog_file_sitemap]" value="<?php  if (isset($ascp_settings_sitemap['google_sitemap_blog_file_sitemap'])) echo $ascp_settings_sitemap['google_sitemap_blog_file_sitemap']; ?>" size="50" />

<a onclick="
        var file_sitemap = $('#google_sitemap_blog_file_sitemap').val();
 		$.ajax({
					url: '<?php echo $url_sitemap_file; ?>',
					type: 'post',
					data:  {file_sitemap: file_sitemap },
					dataType: 'html',
					beforeSend: function()
					{
                      $('.genbutton_').hide();
                      $('#sitemap_loading').html('<?php echo $text_loading; ?>');
                      $('#sitemap_loading').show();

					},
					success: function(html) {
						if (html) {
							$('.genbutton_').show();
							$('#sitemap_loading').html(html);
						}

					}
				});


      return false; " id="href_sitemap_file" class="markbutton genbutton_"><?php echo $language->get('button_gen'); ?></a>

 	 <div id='sitemap_loading' style="display: none;"></div>




     </td>
    </tr>



        </table>
      </form>
    </div>
  </div>
</div>
</div>
<?php echo $footer; ?>
