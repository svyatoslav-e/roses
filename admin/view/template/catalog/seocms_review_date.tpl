<script type="text/javascript">
if ($('head').html().indexOf('wbbtheme.css') <0) {
	$('head').append('<link href="view/javascript/wysibb/theme/default/wbbtheme.css" type="text/css" rel="stylesheet" />');
 }
</script>

<div id="seocms_review_date_<?php echo $review_id; ?>" style="display: view;">
<input type="hidden" name="thislist" value="<?php echo base64_encode(serialize($thislist)); ?>">

          <div class="form-group">
            <label class="col-sm-2 control-label" for="date_added"><?php echo $entry_date_added; ?></label>
                <div class="col-sm-10">
                <input type="text" id="date_added" name="date_added" value="<?php echo $date_added; ?>" size="20" class="datetime form-control" >
                </div>
           </div>




          <?php if (isset($karma) && count($karma)>0) { ?>
            <div class="form-group">
			<label class="col-sm-2 control-label" for="karma_delta"><?php echo $language->get('entry_karma'); ?></label>

           <div class="col-sm-10">
            <?php if (!empty($karma_all)) { ?>
            <table style="text-align: center;">
            <tr>
            <td><?php echo $language->get('entry_karma'); ?></td>
            <td><?php echo $language->get('entry_karma_rate_count'); ?></td>
            <td><?php echo $language->get('entry_karma_rate_delta_blog_plus'); ?></td>
            <td><?php echo $language->get('entry_karma_rate_delta_blog_minus'); ?></td>
            </tr>
            <tr>
            <?php  foreach ($karma_all as $num => $karma_all_val) { ?>

            <td><input type="text" name="karma_delta" value="<?php if (isset($karma_all_val['rate_delta'])) { echo $karma_all_val['rate_delta']; } ?>" disabled="disabled" size="3"></td>
            <td><input type="text" name="karma_rate_count" value="<?php if (isset($karma_all_val['rate_count'])) { echo $karma_all_val['rate_count']; } ?>" disabled="disabled" size="3"></td>
            <td><input type="text" name="karma_rate_delta_blog_plus" value="<?php if (isset($karma_all_val['rate_delta_blog_plus'])) { echo $karma_all_val['rate_delta_blog_plus']; } ?>" disabled="disabled" size="3"></td>
            <td><input type="text" name="karma_rate_delta_blog_minus" value="<?php if (isset($karma_all_val['rate_delta_blog_minus'])) { echo $karma_all_val['rate_delta_blog_minus']; } ?>" disabled="disabled" size="3"></td>

           <?php  }      ?>
           </tr>
           </table>
           <?php  }      ?>
           </div>
             </div>
          <?php }  ?>



<?php   if (isset($fields) && count($fields)>0) { foreach   ($fields as $af_name => $field) {
//print_r($fields);

?>
 <div class="form-group">
<label class="col-sm-2 control-label" for="af[<?php echo $field['field_name']; ?>]"><?php echo html_entity_decode($field['field_description'], ENT_QUOTES, 'UTF-8'); ?></label>
          <div class="col-sm-10">
             <textarea name="af[<?php echo $field['field_name']; ?>]" cols="40" rows="1"><?php if (isset($field['value'])) echo $field['value'];  ?></textarea>
          </div>
</div>
<?php  }  } ?>






</div>

<div id="notify">
<div class="form-group">

				<label class="col-sm-2 control-label" for="notify">
	          		<?php echo $language->get('entry_notify'); ?>
				</label>
	          	<div class="col-sm-10">
	          		<input type="checkbox" value="1" name="notify">
	          	</div>
</div>
</div>


<script type="text/javascript" src="view/javascript/wysibb/jquery.wysibb.js"></script>

<script type="text/javascript">

$(document).ready(function(){

var seocms_review_date_<?php echo $review_id; ?> = $('#seocms_review_date_<?php echo $review_id; ?>').html();
$('form').append(seocms_review_date_<?php echo $review_id; ?>);

$('#seocms_review_date_<?php echo $review_id; ?>').hide('slow');
$('#seocms_review_date_<?php echo $review_id; ?>').remove();

var notify = $('#notify').html();
//$('#content .form tr:first td:nth-child(2)').append(notify);
$('#form-review').prepend(notify)

$('#notify').remove();

	$('textarea[name="text"]').wysibb({
      buttons: 'bold,italic,underline,|,img,video,link,|,fontcolor,fontsize,|'
	});
   $('span.powered').hide();


});
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
