<?php  foreach ($ascp_widgets as $list_num=>$list) { ?>
<div id="list<?php echo $list_num;?>" style="padding-left: 200px;">

<style>
.avatar-<?php echo $list_num;?>, .images-<?php echo $list_num;?> {
display: none;
}
</style>

	<form class="ascp_widgets_form">
		<input type="hidden" name="ascp_widgets[<?php echo $list_num; ?>][remove]" class="hremove" value="">
		<input type="hidden" name="ascp_widgets[<?php echo $list_num; ?>][type]" value="<?php if (isset($list['type'])) echo $list['type']; else echo 'blogs'; ?>">


	<table>
		<tr style="margin-bottom: 5px;" class="scp_grad noeven">
			<td colspan="2" style="background-color: #7D00A6; color: #FFF; font-size: 15px; padding: 4px 14px 5px 7px;  text-align: center;">
				<span style="color: #EEE;"><?php echo $language->get('entry_widget'); ?>:</span> <?php echo $language->get('text_widget_'.$list['type']); ?>. <?php echo $language->get('entry_id'); ?>: <?php echo $id;?>
			</td>
		</tr>

		<?php foreach ($languages as $lang) { ?>
			<tr class="noeven">

				<td colspan="2">

							<div class="input-group">
							<span class="input-group-addon"><?php echo strtoupper($lang['code']); ?>&nbsp;&nbsp;<img src="<?php echo $lang['image']; ?>" title="<?php echo $lang['name']; ?>" ></span>
								<input class="form-control no_change" type="text" placeholder="<?php echo $language->get('entry_title_list_latest'); ?>" name="ascp_widgets[<?php echo $list_num; ?>][title_list_latest][<?php echo $lang['language_id']; ?>]" value="<?php if (isset($list['title_list_latest'][$lang['language_id']])) echo $list['title_list_latest'][$lang['language_id']]; ?>" />
  							</div>

                </td>

			</tr>

			<?php } ?>

			<tr class="noeven">
				<td colspan="2">
					<div class="buttons" style="top: 0;">

 	 <a style="top: 0;" onclick="
 	 //ascp_widgets_num--;
 	 $('input[name=\'ascp_widgets[<?php echo $list_num; ?>][remove]\']').val('remove');
	 $('.blog_save_new').html('<?php echo $button_save; ?> ('+$('.hremove[value!=\'remove\']').length+')' );
 	 //$('#mytabs<?php echo $list_num;?>').hide();
 	 //$('#mytabs a').tabs();
 	 $('#amytabs<?php echo $list_num;?>').addClass('remove');
 	 $('#amytabs<?php echo $list_num;?>').hide();
 	 $('#mytabs<?php echo $list_num;?>').hide();
 	 return false; " class="mbutton button_purple"><?php echo $language->get('sc_button_delete'); ?></a>

						<a onclick="
							ascp_widgets_num++;
							type_what = '<?php echo $list['type']; ?>';
							$.ajax({
							url: 'index.php?route=module/blog/ajax_list&token=<?php echo $token; ?>',
							type: 'post',
							data: { type: type_what, list: '<?php echo base64_encode($slist); ?>', num: ascp_widgets_num },
							dataType: 'html',
							beforeSend: function()
							{
							},
							success: function(html) {
							if (html) {
							$('#mytabs').append('<a href=\'#mytabs' + ascp_widgets_num + '\' id=\'amytabs'+ascp_widgets_num+'\'>Widget-' + ascp_widgets_num + '<\/a>');
							$('#lists').append('<div id=\'mytabs'+ascp_widgets_num+'\'>'+html+'<\/div>');
							$('#mytabs a').tabs();
							$('#amytabs' + ascp_widgets_num).click();
							template_auto();
							}
							$('.mbutton').removeClass('loader');
							}
							});
							return false; " class="mbutton" style="left: 0; "><?php echo $language->get('button_clone_widget'); ?></a>
      <a onclick="$('.help').addClass('help_hide').toggle('slow'); return false; " class="mbutton button_blue" style="margin-top: 7px;"><?php echo $language->get('button_help'); ?></a>
      <!--
      <a onclick="$('.').toggle('slow'); return false; " class="mbutton button_darkblue" style="margin-top: 7px; margin-left: 7px;"><?php echo $language->get('button_pro'); ?></a>
      -->
					</div>
				</td>
			</tr>
</table>




 <div id="tabs-<?php echo $list_num;?>" class="htabs tabs_in_widgets margintop5px">
  <a href="#tab-options-<?php echo $list_num;?>"><?php echo $language->get('entry_tab_options'); ?></a>
  <a href="#tab-templates-<?php echo $list_num;?>"><?php echo $language->get('entry_tab_templates'); ?></a>
  <a href="#tab-modal-<?php echo $list_num;?>"><?php echo $language->get('entry_tab_modal'); ?></a>
  <a href="#tab-access-<?php echo $list_num;?>"><?php echo $language->get('entry_tab_access'); ?></a>
 </div>


<div id="tab-options-<?php echo $list_num;?>" class="tabs_in_widgets">
<table>
    <tr>
    <td class="left"><?php echo $language->get('entry_id_widget'); ?></td>
     <td class="left">
 		<?php echo $id;?>
     </td>
    </tr>
          <tr>
              <td><?php echo $language->get('entry_widget_cached'); ?></td>
              <td><div class="input-group"><select class="form-control" name="ascp_widgets[<?php echo $list_num; ?>][cached]">
                  <?php if (isset($list['cached']) && $list['cached']) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select></div></td>
            </tr>

	<?php foreach ($languages as $lang) { ?>
	<tr>
			<td>
			<?php echo $language->get('entry_html'); ?>
			</td>

			<td>
				<div style="width: 100%;">
				<div class="input-group marginbottom5px"><span class="input-group-addon"><?php echo strtoupper($lang['code']); ?><br><img src="<?php echo $lang['image']; ?>" title="<?php echo $lang['name']; ?>" ></span>
				<textarea class="form-control" rows="7" cols="70" style="width: 100%;"  id="html_<?php echo $list_num; ?>_<?php echo $lang['language_id']; ?>" name="ascp_widgets[<?php echo $list_num; ?>][html][<?php echo $lang['language_id']; ?>]"><?php if (isset($list['html'][$lang['language_id']])) echo $list['html'][$lang['language_id']]; ?></textarea>
                </div>
				<a href="#" class="hrefajax" onclick="load_editor('html_<?php echo $list_num; ?>_<?php echo $lang['language_id']; ?>', '100'); return false;"><?php echo $language->get('entry_editor'); ?></a>
				</div>
			</td>

	</tr>

   <?php } ?>

          <tr>
              <td><?php echo $language->get('entry_search'); ?></td>
              <td>
              <div class="input-group">
	              <select class="form-control" name="ascp_widgets[<?php echo $list_num; ?>][search]">
	                  <?php if (isset($list['search']) && $list['search']) { ?>
	                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
	                  <option value="0"><?php echo $text_disabled; ?></option>
	                  <?php } else { ?>
	                  <option value="1"><?php echo $text_enabled; ?></option>
	                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
	                  <?php } ?>
	                </select>
                </div>
                </td>
            </tr>

            <tr>
              <td><?php echo $language->get('entry_ajax'); ?></td>
              <td>
              <div class="input-group"><select class="form-control" name="ascp_widgets[<?php echo $list_num; ?>][ajax]">
                  <?php if (isset($list['ajax']) && $list['ajax']) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" <?php if ((isset($list['ajax']) && !$list['ajax']) || !isset($list['ajax'])) { echo  'selected="selected"'; } ?>><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select></div>
              </td>
            </tr>


</table>
</div>

<div id="tab-templates-<?php echo $list_num;?>" class="tabs_in_widgets">
<table>


		<tr>
			<td>
				<?php echo $language->get('entry_template'); ?>
			</td>
			<td>
				<div class="input-group">
				<input class="form-control template" type="text" name="ascp_widgets[<?php echo $list_num; ?>][template]" value="<?php if (isset($list['template'])) echo $list['template']; ?>" size="60" />
				<input type="hidden" name="tpath" value="widgets/html">
				</div>
			</td>
		</tr>


		<tr>
				<td class="left"><?php echo $language->get('entry_anchor'); ?></td>
				<td class="left">
				 <div class="input-group"><span class="input-group-addon"></span>
				 <textarea class="form-control" style="width: 96%; height: 150px;" id="ascp_widgets_<?php echo $list_num; ?>_anchor" name="ascp_widgets[<?php echo $list_num; ?>][anchor]"><?php  if (isset($list['anchor'])) echo $list['anchor']; ?></textarea>
				 </div>

				 <?php if (isset($list['anchor_templates']) && is_array($list['anchor_templates']) && !empty($list['anchor_templates'])) { ?>
                 <div>
                 <?php echo $language->get('entry_anchor_templates'); ?>
                 </div>

	               <div>
					<div class="input-group"><select class="form-control" name="ascp_widgets[<?php echo $list_num; ?>][anchor_templates]" id="ascp_widgets_<?php echo $list_num; ?>_anchor_templates">

	                 <?php  if (!isset($list['anchor'])) { $list['anchor'] = ''; } ?>
	                 <option value="<?php echo $list['anchor']; ?>"><?php echo $language->get('entry_anchor_value'); ?></option>

	                 <?php foreach ($list['anchor_templates'] as $anchor_name => $anchor_template) { ?>
	                   <option value="<?php echo $anchor_template; ?>"><?php echo $anchor_name; ?></option>
	                  <?php } ?>

	                 </select></div>
	                 </div>
						<script>
						$( '#ascp_widgets_<?php echo $list_num; ?>_anchor_templates' )
						.change(function () {
						var str = '';
						$( '#ascp_widgets_<?php echo $list_num; ?>_anchor_templates option:selected' ).each(function() {
						str = $(this).val();
						});

						$( '#ascp_widgets_<?php echo $list_num; ?>_anchor' ).html( str );

						});
						</script>

                 <?php } ?>
				</td>
			</tr>


            <tr>
              <td><?php echo $language->get('entry_doc_ready'); ?></td>
              <td>
              	<div class="input-group"><select class="form-control" name="ascp_widgets[<?php echo $list_num; ?>][doc_ready]">
                  <?php if (isset($list['doc_ready']) && $list['doc_ready']) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="1" <?php if (!isset($list['doc_ready'])) { echo  'selected="selected"'; }  ?>><?php echo $text_enabled; ?></option>
                  <option value="0" <?php if (!isset($list['doc_ready'])) {  } else { echo  'selected="selected"'; }  ?>><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select></div>
              </td>
            </tr>


	<tr>
		<td class="left">
			<?php echo $language->get('entry_box_begin'); ?>
		</td>
			<td>
				<div style="float: left;">

				<div class="input-group"><span class="input-group-addon"></span>
				<textarea class="form-control" id="ascp_widgets_<?php echo $list_num; ?>_box_begin"  name="ascp_widgets[<?php echo $list_num; ?>][box_begin]" rows="3" cols="50" ><?php if (isset($list['box_begin'])) { echo $list['box_begin']; } else { echo ''; } ?></textarea>
				</div>

				 <?php if (isset($list['box_begin_templates']) && is_array($list['box_begin_templates']) && !empty($list['box_begin_templates'])) { ?>
                 <div>
                 <?php echo $language->get('entry_box_begin_templates'); ?>
                 </div>

	               <div>
					<div class="input-group"><select class="form-control" name="ascp_widgets[<?php echo $list_num; ?>][box_begin_templates]" id="ascp_widgets_<?php echo $list_num; ?>_box_begin_templates">

	                 <?php  if (!isset($list['box_begin'])) { $list['box_begin'] = ''; } ?>
	                 <option value='<?php echo str_replace("'", '"', $list['box_begin']);  ?>'><?php echo $language->get('entry_box_begin_value'); ?></option>

	                 <?php foreach ($list['box_begin_templates'] as $box_begin_name => $box_begin_template) { ?>
	                   <option value='<?php echo str_replace("'", '"', $box_begin_template); ?>'><?php echo $box_begin_name; ?></option>
	                  <?php } ?>

	                 </select></div>
	                 </div>
						<script>
						$( '#ascp_widgets_<?php echo $list_num; ?>_box_begin_templates' )
						.change(function () {
						var str = '';
						$( '#ascp_widgets_<?php echo $list_num; ?>_box_begin_templates option:selected' ).each(function() {
						str = $(this).val();
						});

						$( '#ascp_widgets_<?php echo $list_num; ?>_box_begin' ).html( str );

						});
						</script>

                 <?php } ?>


				</div>
			</td>
	</tr>

	<tr>
		<td class="left">
			<?php echo $language->get('entry_box_end'); ?>
		</td>
			<td>
				<div style="float: left;">
				<div class="input-group"><span class="input-group-addon"></span>
				<textarea class="form-control" id="ascp_widgets_<?php echo $list_num; ?>_box_end" name="ascp_widgets[<?php echo $list_num; ?>][box_end]" rows="3" cols="50" ><?php if (isset($list['box_end'])) { echo $list['box_end']; } else { echo ''; } ?></textarea>
				</div>

				 <?php if (isset($list['box_end_templates']) && is_array($list['box_end_templates']) && !empty($list['box_end_templates'])) { ?>
                 <div>
                 <?php echo $language->get('entry_box_end_templates'); ?>
                 </div>

	               <div>
					<div class="input-group"><select class="form-control" name="ascp_widgets[<?php echo $list_num; ?>][box_end_templates]" id="ascp_widgets_<?php echo $list_num; ?>_box_end_templates">

	                 <?php  if (!isset($list['box_end'])) { $list['box_end'] = ''; } ?>
	                 <option value='<?php echo str_replace("'", '"', $list['box_end']);  ?>'><?php echo $language->get('entry_box_end_value'); ?></option>

	                 <?php foreach ($list['box_end_templates'] as $box_end_name => $box_end_template) { ?>
	                   <option value='<?php echo str_replace("'", '"', $box_end_template); ?>'><?php echo $box_end_name; ?></option>
	                  <?php } ?>

	                 </select></div>
	                 </div>
						<script>
						$( '#ascp_widgets_<?php echo $list_num; ?>_box_end_templates' )
						.change(function () {
						var str = '';
						$( '#ascp_widgets_<?php echo $list_num; ?>_box_end_templates option:selected' ).each(function() {
						str = $(this).val();
						});

						$( '#ascp_widgets_<?php echo $list_num; ?>_box_end' ).html( str );

						});
						</script>

                 <?php } ?>
				</div>
			</td>
	</tr>
            </tr>
		    <tr  class="pro-<?php echo $list_num;?>">
		     <td class="left"><?php echo $language->get('entry_reserved'); ?></td>
		     <td class="left">
  		     <textarea name="ascp_widgets[<?php echo $list_num; ?>][reserved]"><?php  if (isset($list['reserved'])) echo $list['reserved']; ?></textarea>
		     </td>
		    </tr>

</table>
</div>

<div id="tab-modal-<?php echo $list_num;?>" class="tabs_in_widgets">
<table class="left">
			<tr class="left">
				<td class="left"><?php echo $language->get('entry_modal_status'); ?></td>
				<td>
					<div class="input-group">
					<select class="form-control" id="ascp_widgets_<?php echo $list_num; ?>_modal_status" name="ascp_widgets[<?php echo $list_num; ?>][modal_status]">
						<?php if (isset( $list['modal_status']) && $list['modal_status']) { ?>
						<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
						<option value="0"><?php echo $text_disabled; ?></option>
						<?php } else { ?>
						<option value="1"><?php echo $text_enabled; ?></option>
						<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
						<?php } ?>
					</select>
					</div>

						<script>
						$( '#ascp_widgets_<?php echo $list_num; ?>_modal_status')
						.change(function () {
							var str = '';
							$( '#ascp_widgets_<?php echo $list_num; ?>_modal_status option:selected').each(function() {
							str = $(this).val();
							});
							if (str == 1) {
                              $('.modal-<?php echo $list_num;?>').show('slow');
							} else {
                              $('.modal-<?php echo $list_num;?>').hide('slow');
							}

						}).change();


						</script>
				</td>
			</tr>


			<tr class="modal-<?php echo $list_num;?> left">
            <td class="left"><?php echo $language->get('entry_modal_a_class'); ?></td>
            <td>
				<div class="input-group">
					<input class="form-control" size="50" type="text" name="ascp_widgets[<?php echo $list_num; ?>][modal_a_class]" value="<?php if (isset($list['modal_a_class'])) echo $list['modal_a_class']; ?>" />
  				</div>
            </td>
			</tr>


			<tr class="modal-<?php echo $list_num;?> left">
            <td class="left"><?php echo $language->get('entry_modal_cb_width'); ?></td>
            <td>
				<div class="input-group">
					<input class="form-control" type="text" name="ascp_widgets[<?php echo $list_num; ?>][modal_cb_width]" value="<?php if (isset($list['modal_cb_width'])) echo $list['modal_cb_width']; ?>" />
  				</div>
            </td>
			</tr>

			<tr class="modal-<?php echo $list_num;?> left">
            <td class="left"><?php echo $language->get('entry_modal_cb_height'); ?></td>
            <td>
				<div class="input-group">
					<input class="form-control" type="text" name="ascp_widgets[<?php echo $list_num; ?>][modal_cb_height]" value="<?php if (isset($list['modal_cb_height'])) echo $list['modal_cb_height']; ?>" />
  				</div>
  			</td>
			</tr>

			<tr class="modal-<?php echo $list_num;?> left">
            <td class="left"><?php echo $language->get('entry_modal_cb_maxWidth'); ?></td>
            <td>
				<div class="input-group">
					<input class="form-control" type="text" name="ascp_widgets[<?php echo $list_num; ?>][modal_cb_maxwidth]" value="<?php if (isset($list['modal_cb_maxwidth'])) echo $list['modal_cb_maxwidth']; ?>" />
  				</div>
            </td>
			</tr>

			<tr class="modal-<?php echo $list_num;?> left">
            <td class="left"><?php echo $language->get('entry_modal_cb_maxHeight'); ?></td>
            <td>
				<div class="input-group">
					<input class="form-control" type="text" name="ascp_widgets[<?php echo $list_num; ?>][modal_cb_maxheight]" value="<?php if (isset($list['modal_cb_maxheight'])) echo $list['modal_cb_maxheight']; ?>" />
  				</div>
            </td>
			</tr>

			<tr class="modal-<?php echo $list_num;?>">
            <td class="left"><?php echo $language->get('entry_modal_cb_innerWidth'); ?></td>
            <td>
				<div class="input-group">
					<input class="form-control" type="text" name="ascp_widgets[<?php echo $list_num; ?>][modal_cb_innerwidth]" value="<?php if (isset($list['modal_cb_innerwidth'])) echo $list['modal_cb_innerwidth']; ?>" />
  				</div>
            </td>
			</tr>

			<tr class="modal-<?php echo $list_num;?>">
            <td class="left"><?php echo $language->get('entry_modal_cb_innerHeight'); ?></td>
            <td>
				<div class="input-group">
					<input class="form-control" type="text" name="ascp_widgets[<?php echo $list_num; ?>][modal_cb_innerheight]" value="<?php if (isset($list['modal_cb_innerheight'])) echo $list['modal_cb_innerheight']; ?>" />
  				</div>
            </td>
			</tr>


			<tr class="modal-<?php echo $list_num;?>">
            <td class="left"><?php echo $language->get('entry_modal_cb_initialWidth'); ?></td>
            <td>
				<div class="input-group">
					<input class="form-control" type="text" name="ascp_widgets[<?php echo $list_num; ?>][modal_cb_initialwidth]" value="<?php if (isset($list['modal_cb_initialwidth'])) echo $list['modal_cb_initialwidth']; ?>" />
  				</div>
            </td>
			</tr>

			<tr class="modal-<?php echo $list_num;?>">
            <td class="left"><?php echo $language->get('entry_modal_cb_initialHeight'); ?></td>
            <td>
				<div class="input-group">
					<input class="form-control" type="text" name="ascp_widgets[<?php echo $list_num; ?>][modal_cb_initialheight]" value="<?php if (isset($list['modal_cb_initialheight'])) echo $list['modal_cb_initialheight']; ?>" />
  				</div>
            </td>
			</tr>

			<tr class="modal-<?php echo $list_num;?>">
            <td class="left"><?php echo $language->get('entry_modal_cb_top'); ?></td>
            <td>
				<div class="input-group">
					<input class="form-control" type="text" name="ascp_widgets[<?php echo $list_num; ?>][modal_cb_top]" value="<?php if (isset($list['modal_cb_top'])) echo $list['modal_cb_top']; ?>" />
  				</div>
            </td>
			</tr>

			<tr class="modal-<?php echo $list_num;?>">
            <td class="left"><?php echo $language->get('entry_modal_cb_bottom'); ?></td>
            <td>
				<div class="input-group">
					<input class="form-control" type="text" name="ascp_widgets[<?php echo $list_num; ?>][modal_cb_bottom]" value="<?php if (isset($list['modal_cb_bottom'])) echo $list['modal_cb_bottom']; ?>" />
  				</div>
            </td>
			</tr>

			<tr class="modal-<?php echo $list_num;?>">
            <td class="left"><?php echo $language->get('entry_modal_cb_left'); ?></td>
            <td>
				<div class="input-group">
					<input class="form-control" type="text" name="ascp_widgets[<?php echo $list_num; ?>][modal_cb_left]" value="<?php if (isset($list['modal_cb_left'])) echo $list['modal_cb_left']; ?>" />
  				</div>
            </td>
			</tr>

			<tr class="modal-<?php echo $list_num;?>">
            <td class="left"><?php echo $language->get('entry_modal_cb_right'); ?></td>
            <td>
				<div class="input-group">
					<input class="form-control" type="text" name="ascp_widgets[<?php echo $list_num; ?>][modal_cb_right]" value="<?php if (isset($list['modal_cb_right'])) echo $list['modal_cb_right']; ?>" />
  				</div>
            </td>
			</tr>


			<tr class="modal-<?php echo $list_num;?>">
            <td class="left"><?php echo $language->get('entry_modal_cb_opacity'); ?></td>
            <td>
				<div class="input-group">
					<input class="form-control" type="text" name="ascp_widgets[<?php echo $list_num; ?>][modal_cb_opacity]" value="<?php if (isset($list['modal_cb_opacity'])) echo $list['modal_cb_opacity']; ?>" />
  				</div>
            </td>
			</tr>


			<tr class="modal-<?php echo $list_num;?>">
            <td class="left"><?php echo $language->get('entry_modal_cb_title'); ?></td>
            <td>
              <div class="input-group">
	              <select class="form-control" name="ascp_widgets[<?php echo $list_num; ?>][modal_cb_title]">
	                  <?php if (isset($list['modal_cb_title']) && $list['modal_cb_title']) { ?>
	                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
	                  <option value="0"><?php echo $text_disabled; ?></option>
	                  <?php } else { ?>
	                  <option value="1"><?php echo $text_enabled; ?></option>
	                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
	                  <?php } ?>
	                </select>
                </div>
            </td>
			</tr>

			<tr class="modal-<?php echo $list_num;?>">
            <td class="left"><?php echo $language->get('entry_modal_cb_fixed'); ?></td>
            <td>
              <div class="input-group">
	              <select class="form-control" name="ascp_widgets[<?php echo $list_num; ?>][modal_cb_fixed]">
	                  <?php if (isset($list['modal_cb_fixed']) && $list['modal_cb_fixed']) { ?>
	                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
	                  <option value="0"><?php echo $text_disabled; ?></option>
	                  <?php } else { ?>
	                  <option value="1"><?php echo $text_enabled; ?></option>
	                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
	                  <?php } ?>
	                </select>
                </div>
            </td>
			</tr>

			<tr class="modal-<?php echo $list_num;?>">
            <td class="left"><?php echo $language->get('entry_modal_cb_reposition'); ?></td>
            <td>
              <div class="input-group">
	              <select class="form-control" name="ascp_widgets[<?php echo $list_num; ?>][modal_cb_reposition]">
	                  <?php if (isset($list['modal_cb_reposition']) && $list['modal_cb_reposition']) { ?>
	                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
	                  <option value="0"><?php echo $text_disabled; ?></option>
	                  <?php } else { ?>
	                  <option value="1"><?php echo $text_enabled; ?></option>
	                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
	                  <?php } ?>
	                </select>
                </div>
            </td>
			</tr>

			<tr class="modal-<?php echo $list_num;?>">
            <td class="left"><?php echo $language->get('entry_modal_cb_scrolling'); ?></td>
            <td>
              <div class="input-group">
	              <select class="form-control" name="ascp_widgets[<?php echo $list_num; ?>][modal_cb_scrolling]">
	                  <?php if (isset($list['modal_cb_scrolling']) && $list['modal_cb_scrolling']) { ?>
	                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
	                  <option value="0"><?php echo $text_disabled; ?></option>
	                  <?php } else { ?>
	                  <option value="1"><?php echo $text_enabled; ?></option>
	                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
	                  <?php } ?>
	                </select>
                </div>
            </td>
			</tr>


			<tr class="modal-<?php echo $list_num;?>">
            <td class="left"><?php echo $language->get('entry_modal_cb_resize'); ?></td>
            <td>
              <div class="input-group">
	              <select class="form-control" name="ascp_widgets[<?php echo $list_num; ?>][modal_cb_resize]">
	                  <?php if (isset($list['modal_cb_resize']) && $list['modal_cb_resize']) { ?>
	                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
	                  <option value="0"><?php echo $text_disabled; ?></option>
	                  <?php } else { ?>
	                  <option value="1"><?php echo $text_enabled; ?></option>
	                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
	                  <?php } ?>
	                </select>
                </div>
            </td>
			</tr>

	<?php foreach ($languages as $lang) { ?>
	<tr class="modal-<?php echo $list_num;?>">
			<td>
			<?php echo $language->get('entry_modal_html'); ?>
			</td>

			<td>
				<div style="width: 100%;">
				<div class="input-group marginbottom5px"><span class="input-group-addon"><?php echo strtoupper($lang['code']); ?><br><img src="<?php echo $lang['image']; ?>" title="<?php echo $lang['name']; ?>" ></span>
				<textarea class="form-control" rows="7" cols="70" style="width: 100%;"  id="html_modal_<?php echo $list_num; ?>_<?php echo $lang['language_id']; ?>" name="ascp_widgets[<?php echo $list_num; ?>][html_modal][<?php echo $lang['language_id']; ?>]"><?php if (isset($list['html_modal'][$lang['language_id']])) echo $list['html_modal'][$lang['language_id']]; ?></textarea>
                </div>
				<a href="#" class="hrefajax" onclick="load_editor('html_modal_<?php echo $list_num; ?>_<?php echo $lang['language_id']; ?>', '100'); return false;"><?php echo $language->get('entry_editor'); ?></a>
				</div>
			</td>

	</tr>

   <?php } ?>

	</table>
</div>



<div id="tab-access-<?php echo $list_num;?>" class="tabs_in_widgets">
<table>

			 <?php if (isset($categories) && is_array($categories) && !empty($categories)) { ?>

			 <tr>
              <td><?php echo $language->get('entry_blog'); ?></td>
              <td><div class="scrollbox">
                  <?php $class = 'odd'; ?>
                  <?php foreach ($categories as $blog) { ?>
                  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                  <div class="<?php echo $class; ?>">
                    <?php if (isset($list['blogs']) && in_array($blog['blog_id'], $list['blogs'])) { ?>
                    <input type="checkbox" name="ascp_widgets[<?php echo $list_num; ?>][blogs][]" value="<?php echo $blog['blog_id']; ?>" checked="checked" />
                    <?php echo $blog['name']; ?>
                    <?php } else { ?>
                    <input type="checkbox" name="ascp_widgets[<?php echo $list_num; ?>][blogs][]" value="<?php echo $blog['blog_id']; ?>" />
                    <?php echo $blog['name']; ?>
                    <?php } ?>
                  </div>
                  <?php } ?>
                </div>
                <a onclick="$(this).parent().find(':checkbox').prop('checked', true);" class="nohref"><?php echo $language->get('text_select_all'); ?></a> / <a onclick="$(this).parent().find(':checkbox').prop('checked', false);" class="nohref"><?php echo $language->get('text_unselect_all'); ?></a></td>
            </tr>
            <?php } ?>

			 <tr>
              <td><?php echo $language->get('entry_categories'); ?></td>
              <td><div class="scrollbox">
                  <?php $class = 'odd'; ?>
                  <?php foreach ($cat as $category) { ?>
                  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                  <div class="<?php echo $class; ?>">
                    <?php if (isset($list['categories']) && in_array($category['category_id'], $list['categories'])) { ?>
                    <input type="checkbox" name="ascp_widgets[<?php echo $list_num; ?>][categories][]" value="<?php echo $category['category_id']; ?>" checked="checked" />
                    <?php echo $category['name']; ?>
                    <?php } else { ?>
                    <input type="checkbox" name="ascp_widgets[<?php echo $list_num; ?>][categories][]" value="<?php echo $category['category_id']; ?>" />
                    <?php echo $category['name']; ?>
                    <?php } ?>
                  </div>
                  <?php } ?>
                </div>
                <a onclick="$(this).parent().find(':checkbox').prop('checked', true);" class="nohref"><?php echo $language->get('text_select_all'); ?></a> / <a onclick="$(this).parent().find(':checkbox').prop('checked', false);" class="nohref"><?php echo $language->get('text_unselect_all'); ?></a></td>
            </tr>

          <tr class="pro-<?php echo $list_num;?>">
              <td><?php echo $language->get('entry_customer_groups'); ?></td>
              <td><div class="scrollbox">
                  <?php $class = 'even'; ?>
                  <?php if (!isset($list['customer_groups'])) { ?>
                  <?php foreach ($customer_groups as $customer_group) { ?>
                  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                  <div class="<?php echo $class; ?>">
                    <input type="checkbox" name="ascp_widgets[<?php echo $list_num; ?>][customer_groups][]" value="<?php echo $customer_group['customer_group_id']; ?>" checked="checked" />
                    <?php echo $customer_group['name']; ?>
                    </div>
                  <?php } ?>

                  <?php } else { ?>

                  <?php foreach ($customer_groups as $customer_group) { ?>
                  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                  <div class="<?php echo $class; ?>">
                    <?php if (isset($list['customer_groups']) && in_array($customer_group['customer_group_id'], $list['customer_groups'])) { ?>
                    <input type="checkbox" name="ascp_widgets[<?php echo $list_num; ?>][customer_groups][]" value="<?php echo $customer_group['customer_group_id']; ?>" checked="checked" />
                    <?php echo $customer_group['name']; ?>
                    <?php } else { ?>
                    <input type="checkbox" name="ascp_widgets[<?php echo $list_num; ?>][customer_groups][]" value="<?php echo $customer_group['customer_group_id']; ?>" />
                    <?php echo $customer_group['name']; ?>
                    <?php } ?>
                  </div>
                  <?php } ?>

                  <?php } ?>
                  </div>
                <a onclick="$(this).parent().find(':checkbox').prop('checked', true);" class="nohref"><?php echo $language->get('text_select_all'); ?></a> / <a onclick="$(this).parent().find(':checkbox').prop('checked', false);" class="nohref"><?php echo $language->get('text_unselect_all'); ?></a></td>
                </td>
            </tr>

            <tr class="pro-<?php echo $list_num;?>">
              <td><?php echo $language->get('entry_store'); ?></td>
              <td><div class="scrollbox">
                  <?php $class = 'even'; ?>
                  <div class="<?php echo $class; ?>">
                    <?php if (!isset($list['store']) || in_array(0, $list['store'])) { ?>
                    <input type="checkbox" name="ascp_widgets[<?php echo $list_num; ?>][store][]" value="0" checked="checked" />
                    <?php echo $language->get('text_default_store'); ?>
                    <?php } else { ?>
                    <input type="checkbox" name="ascp_widgets[<?php echo $list_num; ?>][store][]" value="0" />
                    <?php echo $language->get('text_default_store'); ?>
                    <?php } ?>
                  </div>
                  <?php foreach ($stores as $store) { ?>
                  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                  <div class="<?php echo $class; ?>">
                    <?php if (isset($list['store']) && in_array($store['store_id'], $list['store'])) { ?>
                    <input type="checkbox" name="ascp_widgets[<?php echo $list_num; ?>][store][]" value="<?php echo $store['store_id']; ?>" checked="checked" />
                    <?php echo $store['name']; ?>
                    <?php } else { ?>
                    <input type="checkbox" name="ascp_widgets[<?php echo $list_num; ?>][store][]" value="<?php echo $store['store_id']; ?>" <?php if (!isset($list['store'])) { ?> checked="checked" <?php } ?>/>
                    <?php echo $store['name']; ?>
                    <?php } ?>
                  </div>
                  <?php } ?>
                </div>
                <a onclick="$(this).parent().find(':checkbox').prop('checked', true);" class="nohref"><?php echo $language->get('text_select_all'); ?></a> / <a onclick="$(this).parent().find(':checkbox').prop('checked', false);" class="nohref"><?php echo $language->get('text_unselect_all'); ?></a></td>
                </td>
            </tr>



			<tr class="noeven">
				<td><?php echo $language->get('entry_widget_order'); ?></td>
				<td>
					<div class="input-group">
						<input class="form-control no_change" type="text" name="ascp_widgets[<?php echo $list_num; ?>][widget_order]" value="<?php if (isset($list['widget_order'])) echo $list['widget_order']; ?>" />
  					</div>
                </td>
			</tr>

</table>
</div>

<script type="text/javascript">
	$('#tabs-<?php echo $list_num;?> a').tabs();
</script>

</form>
</div>


<?php }  ?>
