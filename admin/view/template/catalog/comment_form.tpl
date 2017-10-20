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
      	<a onclick="location = '<?php echo $cancel; ?>';" class="markbutton button_orange nohref"><?php echo $button_cancel; ?></a>

      </div>
     <div style="width: 100%; overflow: hidden; clear: both; height: 1px; line-height: 1px;">&nbsp;</div>


  <div class="box">
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <input type="hidden" name="settings_widget" value="<?php echo base64_encode(serialize($settings_widget)); ?>">
      <input type="hidden" name="action" value="<?php echo $mark_name; ?>">

        <table class="form">
          <tr>
            <td><span class="required">*</span> <?php echo $entry_author; ?></td>
            <td><input type="text" name="author" value="<?php echo $author; ?>" />
            <?php echo $entry_author_id; ?> <input type="text" name="customer_id" value="<?php echo $customer_id; ?>" size="3" />
            <input type="hidden" name="name" value="<?php echo $author; ?>" />
              <?php if ($error_author) { ?>
              <span class="error"><?php echo $error_author; ?></span>
              <?php } ?></td>

          <td>
          <div style="text-align: right">
          <?php echo $language->get('entry_notify'); ?>

          <input type="checkbox" value="1" name="notify">
          </div>
          </td>


          </tr>

          <tr>
            <td><?php echo $entry_record; ?></td>
            <td><input type="text" name="record" value="<?php echo $record; ?>" style="width: 90%;">
              <input type="hidden" name="record_id" value="<?php echo $record_id; ?>" />
              <?php if ($error_record) { ?>
              <span class="error"><?php echo $error_record; ?></span>
              <?php } ?></td>
          </tr>

          <?php if (isset($parent_info))  {?>
          <tr>
            <td><?php echo $language->get('entry_answer_id'); ?></td>
            <td>
              <div>
              <input type="text" name="parent_id" value="<?php echo $parent_id; ?>" size="3"/>
              </div>
              <a  onclick="$('.comment_text').toggle(); return false;" class="nohref"><?php echo $language->get('entry_answer_view'); ?></a>
              <div class="comment_text" style="display: none;">
              <div>
              <span class="help"><?php echo $entry_author; ?></span>
              </div>

              <?php
                echo $parent_info['author'];
              ?>
              </div>
              <div class="comment_text" style="display: none;">
            <div>
             <span class="help"><?php echo $entry_text; ?></span>
             </div>
              <?php
                echo $parent_info['text'];
              ?>
              </div>

			</td>
          </tr>
           <?php } ?>


          <tr>
            <td><span class="required">*</span> <?php echo $entry_text; ?></td>
            <td><textarea id="bbtext" name="text" cols="60" rows="8"><?php echo $text; ?></textarea>
              <?php if ($error_text) { ?>
              <span class="error"><?php echo $error_text; ?></span>
              <?php } ?></td>
          </tr>


          <tr>
            <td><?php echo $entry_language; ?></td>
            <td><select name="language_id">
			<?php foreach ($languages as $lang) {  ?>
	              	<option value="<?php echo $lang['language_id']; ?>" <?php if (isset($language_id) && $language_id == $lang['language_id']) { ?> selected="selected" <?php } ?> <?php if (!isset($language_id) && $config_language_id == $lang['language_id']) { ?> selected="selected" <?php } ?>><?php echo $lang['name']; ?></option>
            <?php } ?>
              </select></td>
          </tr>


          <tr>
            <td><?php echo $entry_type_id; ?></td>
           <td><select name="type_id">
			<?php foreach ($comment_type as $type_comment) {  ?>
	           <option value="<?php echo $type_comment['type_id']; ?>" <?php if (isset($type_id) && $type_id == $type_comment['type_id']) { ?> selected="selected" <?php } ?>><?php echo $type_comment['type_id'].".".$type_comment['title'][$config_language_id]; ?></option>
            <?php } ?>
              </select></td>
          </tr>


          <tr>
            <td><?php echo $entry_widget_id; ?></td>
           <td><select name="cmswidget">
			<?php foreach ($widget_type as $cmswidget_id=>$type_widget) {  ?>
	           <option value="<?php echo $cmswidget_id; ?>" <?php if (isset($cmswidget) && $cmswidget == $cmswidget_id) { ?> selected="selected" <?php } ?>><?php echo $cmswidget_id.".".$type_widget['title_list_latest'][$config_language_id]; ?></option>
            <?php } ?>
              </select></td>
          </tr>



           <tr>
              <td><?php echo $entry_date_available; ?></td>
              <td><input type="text" name="date_available" value="<?php echo $date_available; ?>" size="20" class="datetime" /></td>
            </tr>

          <tr>
            <td><?php echo $entry_rating; ?></td>
            <td>
            <b class="rating"><?php echo $entry_bad; ?></b>&nbsp;
              <?php if ($rating == 1) { ?>
              <input type="radio" name="rating" value="1" checked />
              <?php } else { ?>
              <input type="radio" name="rating" value="1" />
              <?php } ?>
              &nbsp;
              <?php if ($rating == 2) { ?>
              <input type="radio" name="rating" value="2" checked />
              <?php } else { ?>
              <input type="radio" name="rating" value="2" />
              <?php } ?>
              &nbsp;
              <?php if ($rating == 3) { ?>
              <input type="radio" name="rating" value="3" checked />
              <?php } else { ?>
              <input type="radio" name="rating" value="3" />
              <?php } ?>
              &nbsp;
              <?php if ($rating == 4) { ?>
              <input type="radio" name="rating" value="4" checked />
              <?php } else { ?>
              <input type="radio" name="rating" value="4" />
              <?php } ?>
              &nbsp;
              <?php if ($rating == 5) { ?>
              <input type="radio" name="rating" value="5" checked />
              <?php } else { ?>
              <input type="radio" name="rating" value="5" />
              <?php } ?>
              &nbsp; <b class="rating"><?php echo $entry_good; ?></b>
              <?php if ($error_rating) { ?>
              <span class="error"><?php echo $error_rating; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_rating_mark; ?></td>
            <td><select name="rating_mark">
                <?php if (!$rating_mark) { ?>
                <option value="0" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="1"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="0"><?php echo $text_enabled; ?></option>
                <option value="1" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
          </tr>

         <?php if (isset($karma) && count($karma)>0) { ?>
          <tr>
            <td><?php echo $language->get('entry_karma'); ?></td>
            <td>
            <table style="text-align: center;">
            <tr>
            <td><?php echo $language->get('entry_karma'); ?></td>
            <td><?php echo $language->get('entry_karma_rate_count'); ?></td>
            <td><?php echo $language->get('entry_karma_rate_delta_blog_plus'); ?></td>
            <td><?php echo $language->get('entry_karma_rate_delta_blog_minus'); ?></td>
            </tr>
            <tr>
            <?php foreach ($karma_all as $num => $karma_all_val) { ?>


            <td><input type="text" name="karma_delta" value="<?php if (isset($karma_all_val['rate_delta'])) { echo (int)$karma_all_val['rate_delta']; } ?>" disabled="disabled" size="3"></td>
            <td><input type="text" name="karma_rate_count" value="<?php if (isset($karma_all_val['rate_count'])) { echo $karma_all_val['rate_count']; } ?>" disabled="disabled" size="3"></td>
            <td><input type="text" name="karma_rate_delta_blog_plus" value="<?php if (isset($karma_all_val['rate_delta_blog_plus'])) { echo $karma_all_val['rate_delta_blog_plus']; } ?>" disabled="disabled" size="3"></td>
            <td><input type="text" name="karma_rate_delta_blog_minus" value="<?php if (isset($karma_all_val['rate_delta_blog_minus'])) { echo $karma_all_val['rate_delta_blog_minus']; } ?>" disabled="disabled" size="3"></td>


             <?php } ?>

           </tr>
           </table>
			</td>
          </tr>


          <tr>
          <td>
			<?php echo $language->get('entry_karma_detail'); ?>
          </td>
          <td>

            <table style="text-align: center;">
            <tr>
            <td><?php echo $language->get('entry_karma_name'); ?></td>
            <td><?php echo $language->get('entry_karma_name_id'); ?></td>
            <td><?php echo $language->get('entry_karma_value'); ?></td>
            <td><?php echo $language->get('entry_karma_action'); ?></td>
            </tr>


            <?php foreach ($karma as $num => $karma_val) { ?>
             <tr id="karma_<?php echo $karma_val['rate_id']; ?>">
	            <td><input type="text" value="<?php if (isset($karma_val['name'])) { echo $karma_val['name']; } ?>" disabled="disabled" size="20"></td>
	            <td><input type="text" value="<?php if (isset($karma_val['customer_id'])) { echo $karma_val['customer_id']; } ?>" disabled="disabled" size="3"></td>
	            <td><input type="text" value="<?php if (isset($karma_val['delta'])) { echo (int)$karma_val['delta'];  } ?>" disabled="disabled" size="3"></td>
	            <td><a onclick="karma_delete(<?php echo $karma_val['rate_id']; ?>);" class="markbutton button_orange nohref"><?php echo $language->get('button_delete'); ?></a></td>
            </tr>
           <?php } ?>



           </table>


          </td>
          </tr>
          <?php } ?>





<?php   if (isset($fields) && count($fields)>0) { foreach   ($fields as $af_name => $field) {
//print_r($fields);

?>
		 <tr>
            <td><?php echo html_entity_decode($field['field_description'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td>
             <textarea name="af[<?php echo $field['field_name']; ?>]" cols="40" rows="1"><?php if (isset($field['value'])) echo $field['value'];  ?></textarea>
            </td>
          </tr>
<?php  }  } ?>



          <tr>
            <td><?php echo $entry_status; ?></td>
            <td><select name="status">
                <?php if ($status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
          </tr>


        </table>
      </form>
    </div>
  </div>
</div>

<script>
karma_delete = function(id)	{

		$.ajax({
			url: 'index.php?route=catalog/comment/karma_delete&action=<?php echo $mark_name; ?>&id=' + id + '&token=<?php echo $token; ?>',
			dataType: 'html',
			beforeSend: function()
			{
               $('#karma_'+id).html('<?php echo $language->get('text_loading_delete'); ?>');
			},
			success: function(html) {				//$('#karma_'+id).html(html);
				$('#karma_'+id).remove();
			},
			error: function(json) {
				$('#karma_'+id).html('error');
			}
		});
}


</script>

<script>
$('input[name=\'record\']').autocomplete({
	'source': function(request, response) {
         	<?php
         	if (SC_VERSION < 20) {
         	?>
         	 var irequest = request.term;
         	<?php
         	} else {
         	?>
         	var irequest = request;
         	<?php
         	}
         	?>
		$.ajax({
			url: 'index.php?route=catalog/comment/autocomplete&action=<?php echo $mark_name; ?>&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(irequest),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item.name,
						value: item.record_id
					}
				}));
			}
		});
	},
	'select': function(event, ui) {
         	<?php
         	if (SC_VERSION < 20) {
         	?>
         	 var ilabel = ui.item.label;
         	 var ivalue = ui.item.value;
         	<?php
         	} else {
         	?>
         		var ilabel = event['label'];
         		var ivalue = event['value'];
         	<?php
         	}
         	?>
			$('input[name=\'record\']').val(ilabel);
			$('input[name=\'record_id\']').val(ivalue);

		return false;
	}
});
</script>


<script type="text/javascript">
$('input[name=\'author\']').autocomplete({
	'source': function(request, response) {
         	<?php
         	if (SC_VERSION < 20) {
         	?>
         	 var irequest = request.term;
         	<?php
         	} else {
         	?>
         	var irequest = request;
         	<?php
         	}
         	?>
		$.ajax({
			url: 'index.php?route=catalog/comment/authorcomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(irequest),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item.name,
						value: item.customer_id
					}
				}));
			}
		});
	},
	'select': function(event, ui) {
         	<?php
         	if (SC_VERSION < 20) {
         	?>
         	 var ilabel = ui.item.label;
         	 var ivalue = ui.item.value;
         	<?php
         	} else {
         	?>
         		var ilabel = event['label'];
         		var ivalue = event['value'];
         	<?php
         	}
         	?>

		$('input[name=\'author\']').val(ilabel);
		$('input[name=\'customer_id\']').val(ivalue);

		return false;
	}
});

</script>


<script type="text/javascript">
	$('#bbtext').wysibb({
	  img_uploadurl:		"view/javascript/wysibb/iupload.php",
      buttons: 'bold,italic,underline,|,img,video,link,|,fontcolor,fontsize,|,code,quote'
	});
   $('span.powered').hide();
</script>

<script type="text/javascript" src="view/javascript/blog/timepicker/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="view/javascript/blog/timepicker/localization/jquery-ui-timepicker-<?php echo $config_language; ?>.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('.datetime').datetimepicker({
       <?php if (SC_VERSION < 20) { ?>
		dateFormat: 'yy-mm-dd',
		timeFormat: 'HH:mm:ss'
	<?php } else { ?>
        format: 'YYYY-MM-DD HH:mm:SS'
	<?php } ?>

	});
});
</script>


</div>
<?php echo $footer; ?>
