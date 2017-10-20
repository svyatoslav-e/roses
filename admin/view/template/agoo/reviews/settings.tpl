<table class="mynotable" style="margin-bottom:20px; background: white; vertical-align: center;">

	<tr>
	  <td><?php echo $language->get('entry_widget_status'); ?></td>
	  <td>
	  <div class="input-group"><select class="form-control" name="ascp_settings[reviews_widget_status]">
	      <?php if (isset($ascp_settings['reviews_widget_status']) && $ascp_settings['reviews_widget_status']) { ?>
	      <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
	      <option value="0"><?php echo $text_disabled; ?></option>
	      <?php } else { ?>
	      <option value="1"><?php echo $text_enabled; ?></option>
	      <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
	      <?php } ?>
	    </select></div></td>
	</tr>

				    <tr>
				     <td class="left"><?php echo $entry_blog_num_comments; ?></td>
				     <td class="left">
				      <div class="input-group">
				      <input type="text" class="form-control" name="ascp_settings[blog_num_comments]" value="<?php  if (isset($ascp_settings['blog_num_comments'])) echo $ascp_settings['blog_num_comments']; ?>" size="3" />
				      </div>
				     </td>
				    </tr>

					<tr class="">
						<td class="left">
							<?php echo $language->get('entry_comment_types'); ?>
						</td>
							<td>
								<div style="float: left;">

				   <table id="comment_types" class="list">
					   <thead>
				             <tr>
				                <td class="left"><?php echo $language->get('entry_id'); ?></td>
				                <td><?php echo $language->get('entry_title'); ?></td>
				                <td></td>
				             </tr>

				      </thead>

				      <?php if (isset($ascp_settings['comment_type']) && !empty($ascp_settings['comment_type'])) { ?>
				      <?php foreach ($ascp_settings['comment_type'] as $comment_type_id => $comment_type) { ?>
				      <?php $comment_type_row = $comment_type_id; ?>
				      <tbody id="comment_type_row<?php echo $comment_type_row; ?>">
				          <tr>
				               <td class="left">
								<input type="text" name="ascp_settings[comment_type][<?php echo $comment_type_id; ?>][type_id]" value="<?php if (isset($comment_type['type_id'])) echo $comment_type['type_id']; ?>" size="3">
				               </td>

								<td class="right">
								 <?php foreach ($languages as $lang) { ?>
							<div class="input-group">
							<span class="input-group-addon"><?php echo strtoupper($lang['code']); ?>&nbsp;&nbsp;<img src="<?php echo $lang['image']; ?>" title="<?php echo $lang['name']; ?>" ></span>

									<input type="text" class="form-control" name="ascp_settings[comment_type][<?php echo $comment_type_id; ?>][title][<?php echo $lang['language_id']; ?>]" value="<?php if (isset($comment_type['title'][$lang['language_id']])) echo $comment_type['title'][$lang['language_id']]; ?>" style="width: 300px;">
									</div>
				                 <?php } ?>
								</td>

				                <td class="left"><a onclick="$('#comment_type_row<?php echo $comment_type_row; ?>').remove();" class="markbutton button_purple nohref  sc_button"><?php echo $button_remove; ?></a></td>
				              </tr>
				            </tbody>

				            <?php } ?>
				            <?php } ?>

		            		<tfoot>
				              <tr>
                                <td colspan="4" class="left" style="text-align: right;"><div style="text-align: center;"><a onclick="addCommentType();" class="markbutton nohref sc_button"><?php echo $language->get('entry_add_comment_type'); ?></a></div></td>
				              </tr>
				            </tfoot>


				          </table>

								</div>
							</td>
					</tr>



</table>

<script type="text/javascript">

var array_comment_type_row = Array();
array_comment_type_row.push(0);
<?php
 foreach ($ascp_settings['comment_type'] as $indx => $comment_type) {
?>
array_comment_type_row.push(<?php echo $indx; ?>);
<?php
}
?>

var comment_type_row = <?php echo $comment_type_row + 1; ?>;

function addCommentType() {

	var aindex = -1;
	for(i = 0; i < array_comment_type_row.length; i++) {
	 flg = jQuery.inArray(i, array_comment_type_row);
	 if (flg == -1) {
	  aindex = i;
	 }
	}
	if (aindex == -1) {
	  aindex = array_comment_type_row.length;
	}
	comment_type_row = aindex;
	array_comment_type_row.push(aindex);

    html  = '<tbody id="comment_type_row' + comment_type_row + '">';
	html += '  <tr>';
    html += '  <td class="left">';
	html += ' 	<input type="text" name="ascp_settings[comment_type]['+ comment_type_row +'][type_id]" value="'+ comment_type_row +'" size="3">';
    html += '  </td>';

 	html += '  <td class="right">';
 	<?php foreach ($languages as $lang) { ?>


	html += '	<div class="input-group">';
	html += '		<span class="input-group-addon"><?php echo strtoupper($lang['code']); ?>&nbsp;&nbsp;<img src="<?php echo $lang['image']; ?>" title="<?php echo $lang['name']; ?>" ></span>';
	html += '		<input type="text" class="form-control" name="ascp_settings[comment_type]['+ comment_type_row +'][title][<?php echo $lang['language_id']; ?>]" value="" style="width: 300px;">';
	html += '	</div>';

	<?php } ?>
    html += '  </td>';
    html += '  <td class="left"><a onclick="$(\'#comment_type_row'+comment_type_row+'\').remove(); array_comment_type_row.remove(comment_type_row);" class="markbutton button_purple nohref sc_button"><?php echo $button_remove; ?></a></td>';




	html += '  </tr>';
	html += '</tbody>';

	$('#comment_types tfoot').before(html);

	comment_type_row++;
}
</script>

