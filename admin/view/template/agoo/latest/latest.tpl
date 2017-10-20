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
  <a href="#tab-images-<?php echo $list_num;?>"><?php echo $language->get('entry_tab_images'); ?></a>
  <a href="#tab-templates-<?php echo $list_num;?>"><?php echo $language->get('entry_tab_templates'); ?></a>
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


			<!-- ************************ -->
			<?php if ($list['type'] == 'latest' ||  $list['type'] == 'related') { ?>
			<tr>
				<td><?php echo $language->get('entry_blog'); ?></td>
				<td>
					<div class="scrollbox">
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
					<a onclick="$(this).parent().find(':checkbox').prop('checked', true);" class="nohref"><?php echo $language->get('text_select_all'); ?></a> / <a onclick="$(this).parent().find(':checkbox').prop('checked', false);" class="nohref"><?php echo $language->get('text_unselect_all'); ?></a>
				</td>
			</tr>
			<?php } ?>

			<?php if ($list['type'] == 'records' ) { ?>
           <tr>
              <td><div><?php echo $language->get('entry_records'); ?></div></td>
              <td>
              <div class="input-group">
              <input class="form-control" type="text" name="ascp_widgets[<?php echo $list_num; ?>][related]" value="" />
              </div>
              </td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td><div class="scrollbox" id="record-related_<?php echo $list_num; ?>">
                  <?php $class = 'odd'; ?>
                   <?php
                  foreach ($related as $nm=>$record_related) {
                  ?>
                  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                  <div id="record-related_<?php echo $list_num; ?>_<?php echo $record_related['record_id']; ?>" class="<?php echo $class; ?>"> <?php echo $record_related['name']; ?><img src="view/image/delete.png" />
                    <input type="hidden" name="ascp_widgets[<?php echo $list_num; ?>][related][]" value="<?php echo $record_related['record_id']; ?>" />
                  </div>
                  <?php } ?>
                </div></td>
            </tr>

            <?php } ?>


			<tr>
              <td><?php echo $language->get('entry_widget_cached'); ?>
              </td>
              <td>

              <div class="input-group"><select class="form-control" name="ascp_widgets[<?php echo $list_num; ?>][cached]" id="ascp_widgets_<?php echo $list_num; ?>_cached">
                  <?php if (isset($list['cached']) && $list['cached']) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } ?>
               </select></div>

						<script>
						$( '#ascp_widgets_<?php echo $list_num; ?>_cached')
						.change(function () {
							var str = '';
							$( '#ascp_widgets_<?php echo $list_num; ?>_cached option:selected').each(function() {
							str = $(this).val();
							});
						});
						</script>
				</td>
			</tr>


			<?php if ($list['type'] == 'related' ) { ?>
          	<tr>
              <td><?php echo $language->get('entry_pointer'); ?></td>
              <td>

              <div class="input-group"><select class="form-control" name="ascp_widgets[<?php echo $list_num; ?>][pointer]">
		           <option value="product_id"  <?php if (isset($list['pointer']) &&  $list['pointer']=='product_id')  { echo 'selected="selected"'; } ?>><?php echo $language->get('text_pointer_product_id'); ?></option>
		           <option value="blog_id"  <?php if (isset( $list['pointer']) &&  $list['pointer']=='blog_id')  { echo 'selected="selected"'; } ?>><?php echo $language->get('text_pointer_blog_id'); ?></option>
		           <option value="category_id" <?php if (isset( $list['pointer']) &&  $list['pointer']=='category_id') { echo 'selected="selected"'; } ?>><?php echo $language->get('text_pointer_category_id'); ?></option>
		           <option value="manufacturer_id" <?php if (isset( $list['pointer']) &&  $list['pointer']=='manufacturer_id') { echo 'selected="selected"'; } ?>><?php echo $language->get('text_pointer_manufacturer_id'); ?></option>
       		</select></div>

       		</td>
            </tr>
            <?php } ?>

			<tr>
				<td><?php echo $language->get('entry_title_status'); ?></td>
				<td>
					<div class="input-group"><select class="form-control" name="ascp_widgets[<?php echo $list_num; ?>][title_status]">
						<?php if (isset($list['title_status']) && $list['title_status']) { ?>
						<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
						<option value="0"><?php echo $text_disabled; ?></option>
						<?php } else { ?>
						<option value="1"><?php echo $text_enabled; ?></option>
						<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
						<?php } ?>
					</select></div>
				</td>
			</tr>

			<tr>
				<td><?php echo $language->get('entry_title_position'); ?></td>
				<td>
					<div class="input-group"><select class="form-control" name="ascp_widgets[<?php echo $list_num; ?>][title_position]">
						<?php if (!isset($list['title_position']) || $list['title_position']=='before' || $list['title_position']=='1') { ?>
						<option value="before" selected="selected"><?php echo  $language->get('text_title_position_before'); ?></option>
						<option value="after"><?php echo $language->get('text_title_position_after'); ?></option>
						<?php } else { ?>
						<option value="before"><?php echo $language->get('text_title_position_before'); ?></option>
						<option value="after" selected="selected"><?php echo $language->get('text_title_position_after'); ?></option>
						<?php } ?>
					</select></div>
				</td>
			</tr>

			<tr>
				<td>
					<?php echo $language->get('entry_order'); ?>
				</td>
				<td>
					<div class="input-group"><select class="form-control" id="ascp_widgets_<?php echo $list_num; ?>_order"  name="ascp_widgets[<?php echo $list_num; ?>][order]">
						<option value="sort"  <?php if (isset( $list['order']) &&  $list['order']=='sort')  { echo 'selected="selected"'; } ?>><?php echo $language->get('text_what_sort'); ?></option>
						<option value="latest"  <?php if (isset( $list['order']) &&  $list['order']=='latest')  { echo 'selected="selected"'; } ?>><?php echo $language->get('text_what_latest'); ?></option>
						<option value="popular" <?php if (isset( $list['order']) &&  $list['order']=='popular') { echo 'selected="selected"'; } ?>><?php echo $language->get('text_what_popular'); ?></option>
						<option value="rating" <?php if (isset( $list['order']) &&  $list['order']=='rating') { echo 'selected="selected"'; } ?>><?php echo $language->get('text_what_rating'); ?></option>
						<option value="comments" <?php if (isset( $list['order']) &&  $list['order']=='comments') { echo 'selected="selected"'; } ?>><?php echo $language->get('text_what_comments'); ?></option>
						<option value="rand" <?php if (isset( $list['order']) &&  $list['order']=='rand') { echo 'selected="selected"'; } ?>><?php echo $language->get('text_what_rand'); ?></option>
					</select></div>
				</td>
			</tr>

			<tr>
				<td>
					<?php echo $language->get('entry_order_ad'); ?>
				</td>
				<td>
					<div class="input-group"><select class="form-control" id="ascp_widgets_<?php echo $list_num; ?>_order_ad"  name="ascp_widgets[<?php echo $list_num; ?>][order_ad]">
						<option value="desc"  <?php if (isset( $list['order_ad']) &&  $list['order_ad']=='desc') { echo 'selected="selected"'; } ?>><?php echo $language->get('text_what_desc'); ?></option>
						<option value="asc"   <?php if (isset( $list['order_ad']) &&  $list['order_ad']=='asc')  { echo 'selected="selected"'; } ?>><?php echo $language->get('text_what_asc'); ?></option>
					</select></div>
				</td>
			</tr>


			<tr>
				<td>
					<?php echo $language->get('entry_number_per_widget'); ?>
				</td>
				<td>
					<div class="input-group">
					<input class="form-control" type="text" name="ascp_widgets[<?php echo $list_num; ?>][number_per_widget]" value="<?php  if (isset( $list['number_per_widget'])) echo $list['number_per_widget']; ?>" size="3" />
					</div>
				</td>
			</tr>


			<tr  class="">
				<td class="left"><?php echo $language->get('entry_blog_num_desc'); ?></td>
				<td class="left">
					<div class="input-group">
					<input class="form-control" type="text" name="ascp_widgets[<?php echo $list_num; ?>][desc_symbols]" value="<?php  if (isset( $list['desc_symbols'])) echo $list['desc_symbols']; ?>" size="3" />
					</div>
				</td>
			</tr>
			<tr  class="">
				<td class="left"><?php echo $language->get('entry_blog_num_desc_words'); ?></td>
				<td class="left">
					<div class="input-group">
					<input class="form-control" type="text" name="ascp_widgets[<?php echo $list_num; ?>][desc_words]" value="<?php  if (isset( $list['desc_words'])) echo $list['desc_words']; ?>" size="3" />
					</div>
				</td>
			</tr>
			<tr  class="">
				<td class="left"><?php echo $language->get('entry_blog_num_desc_pred'); ?></td>
				<td class="left">
					<div class="input-group">
					<input class="form-control" type="text" name="ascp_widgets[<?php echo $list_num; ?>][desc_pred]" value="<?php  if (isset( $list['desc_pred'])) echo $list['desc_pred']; ?>" size="3" />
					</div>
				</td>
			</tr>

			<tr  class="">
				<td><?php echo $language->get('entry_short_desc_trim_status'); ?></td>
				<td>
					<div class="input-group"><select class="form-control" name="ascp_widgets[<?php echo $list_num; ?>][short_desc_trim_status]">
						<?php if (isset($list['short_desc_trim_status']) && $list['short_desc_trim_status']) { ?>
						<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
						<option value="0"><?php echo $text_disabled; ?></option>
						<?php } else { ?>
						<option value="1"><?php echo $text_enabled; ?></option>
						<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
						<?php } ?>
					</select></div>
				</td>
			</tr>


			<tr>
				<td><?php echo $language->get('entry_author_status'); ?></td>
				<td>
					<div class="input-group"><select class="form-control" name="ascp_widgets[<?php echo $list_num; ?>][author_status]">
						<?php if (isset($list['author_status']) && $list['author_status']) { ?>
						<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
						<option value="0"><?php echo $text_disabled; ?></option>
						<?php } else { ?>
						<option value="1"><?php echo $text_enabled; ?></option>
						<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
						<?php } ?>
					</select></div>
				</td>
			</tr>

			<tr>
				<td><?php echo $language->get('entry_description_status'); ?></td>
				<td>
					<div class="input-group"><select class="form-control" name="ascp_widgets[<?php echo $list_num; ?>][description_status]">
						<?php if (isset($list['description_status']) && $list['description_status']) { ?>
						<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
						<option value="0"><?php echo $text_disabled; ?></option>
						<?php } else { ?>
						<option value="1"><?php echo $text_enabled; ?></option>
						<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
						<?php } ?>
					</select></div>
				</td>
			</tr>


			<tr  class="">
				<td><?php echo $language->get('entry_category_status'); ?></td>
				<td>
					<div class="input-group"><select class="form-control" name="ascp_widgets[<?php echo $list_num; ?>][category_status]">
						<?php if (isset($list['category_status']) && $list['category_status']) { ?>
						<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
						<option value="0"><?php echo $text_disabled; ?></option>
						<?php } else { ?>
						<option value="1"><?php echo $text_enabled; ?></option>
						<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
						<?php } ?>
					</select></div>
				</td>
			</tr>
			<!-- ************************ -->
			<tr  class="">
				<td><?php echo $language->get('entry_view_date'); ?></td>
				<td>
					<div class="input-group"><select class="form-control" name="ascp_widgets[<?php echo $list_num; ?>][view_date]">
						<?php if (isset($list['view_date']) && $list['view_date']) { ?>
						<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
						<option value="0"><?php echo $text_disabled; ?></option>
						<?php } else { ?>
						<option value="1"><?php echo $text_enabled; ?></option>
						<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
						<?php } ?>
					</select></div>
				</td>
			</tr>
			<tr  class="">
				<td><?php echo $language->get('entry_view_share'); ?></td>
				<td>
					<div class="input-group"><select class="form-control" name="ascp_widgets[<?php echo $list_num; ?>][view_share]">
						<?php if (isset($list['view_share']) && $list['view_share']) { ?>
						<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
						<option value="0"><?php echo $text_disabled; ?></option>
						<?php } else { ?>
						<option value="1"><?php echo $text_enabled; ?></option>
						<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
						<?php } ?>
					</select></div>
				</td>
			</tr>
			<tr  class="">
				<td><?php echo $language->get('entry_view_comments'); ?></td>
				<td>
					<div class="input-group"><select class="form-control" name="ascp_widgets[<?php echo $list_num; ?>][view_comments]">
						<?php if (isset($list['view_comments']) && $list['view_comments']) { ?>
						<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
						<option value="0"><?php echo $text_disabled; ?></option>
						<?php } else { ?>
						<option value="1"><?php echo $text_enabled; ?></option>
						<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
						<?php } ?>
					</select></div>
				</td>
			</tr>
			<tr  class="">
				<td><?php echo $language->get('entry_view_viewed'); ?></td>
				<td>
					<div class="input-group"><select class="form-control" name="ascp_widgets[<?php echo $list_num; ?>][view_viewed]">
						<?php if (isset($list['view_viewed']) && $list['view_viewed']) { ?>
						<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
						<option value="0"><?php echo $text_disabled; ?></option>
						<?php } else { ?>
						<option value="1"><?php echo $text_enabled; ?></option>
						<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
						<?php } ?>
					</select></div>
				</td>
			</tr>
			<tr>
				<td><?php echo $language->get('entry_view_rating'); ?></td>
				<td>
					<div class="input-group"><select class="form-control" name="ascp_widgets[<?php echo $list_num; ?>][view_rating]">
						<?php if (isset($list['view_rating']) && $list['view_rating']) { ?>
						<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
						<option value="0"><?php echo $text_disabled; ?></option>
						<?php } else { ?>
						<option value="1"><?php echo $text_enabled; ?></option>
						<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
						<?php } ?>
					</select></div>
				</td>
			</tr>
			<tr>
				<td><?php echo $language->get('entry_category_button'); ?></td>
				<td>
					<div class="input-group"><select class="form-control" name="ascp_widgets[<?php echo $list_num; ?>][category_button]">
						<?php if (isset($list['category_button']) && $list['category_button']) { ?>
						<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
						<option value="0"><?php echo $text_disabled; ?></option>
						<?php } else { ?>
						<option value="1"><?php echo $text_enabled; ?></option>
						<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
						<?php } ?>
					</select></div>
				</td>
			</tr>

			<tr  class="">
				<td><?php echo $language->get('entry_widget_pagination'); ?></td>
				<td>
					<div class="input-group"><select class="form-control" name="ascp_widgets[<?php echo $list_num; ?>][pagination]">
						<?php if (isset($list['pagination']) && $list['pagination']) { ?>
						<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
						<option value="0"><?php echo $text_disabled; ?></option>
						<?php } else { ?>
						<option value="1"><?php echo $text_enabled; ?></option>
						<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
						<?php } ?>
					</select></div>
				</td>
			</tr>

			<tr  class="">
				<td><?php echo $language->get('entry_widget_limit'); ?></td>
				<td>
					<div class="input-group"><select class="form-control" name="ascp_widgets[<?php echo $list_num; ?>][limit]">
						<?php if (isset($list['limit']) && $list['limit']) { ?>
						<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
						<option value="0"><?php echo $text_disabled; ?></option>
						<?php } else { ?>
						<option value="1"><?php echo $text_enabled; ?></option>
						<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
						<?php } ?>
					</select></div>
				</td>
			</tr>


			<tr  class="">
				<td><?php echo $language->get('entry_widget_sort'); ?></td>
				<td>
					<div class="input-group"><select class="form-control" name="ascp_widgets[<?php echo $list_num; ?>][sort]">
						<?php if (isset($list['sort']) && $list['sort']) { ?>
						<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
						<option value="0"><?php echo $text_disabled; ?></option>
						<?php } else { ?>
						<option value="1"><?php echo $text_enabled; ?></option>
						<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
						<?php } ?>
					</select></div>
				</td>
			</tr>


              <tr>
              <td><?php echo $language->get('entry_attribute_groups_status'); ?></td>
              <td>
	              <div class="input-group"><select class="form-control" name="ascp_widgets[<?php echo $list_num; ?>][attribute_groups_status]">
	                  <?php if (isset($list['attribute_groups_status']) && $list['attribute_groups_status']) { ?>
	                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
	                  <option value="0"><?php echo $text_disabled; ?></option>
	                  <?php } else { ?>
	                  <option value="1"><?php echo $text_enabled; ?></option>
	                  <option value="0" <?php if ((isset($list['attribute_groups_status']) && !$list['attribute_groups_status']) || !isset($list['attribute_groups_status'])) { echo  'selected="selected"'; } ?>><?php echo $text_disabled; ?></option>
	                  <?php } ?>
	                </select></div>
                </td>
            </tr>



</table>
</div>

<div id="tab-images-<?php echo $list_num;?>" class="tabs_in_widgets">
<table>
			<tr class="">
				<td><?php echo $language->get('entry_avatar_status'); ?>

			</td>
				<td>
					<div class="input-group"><select class="form-control" name="ascp_widgets[<?php echo $list_num; ?>][avatar_status]" id="w_<?php echo $list_num; ?>_avatar_status">
						<?php if (isset($list['avatar_status']) && $list['avatar_status']) { ?>
						<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
						<option value="0"><?php echo $text_disabled; ?></option>
						<?php } else { ?>
						<option value="1"><?php echo $text_enabled; ?></option>
						<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
						<?php } ?>
					</select></div>

					<script>
					  if ($('#w_<?php echo $list_num; ?>_avatar_status').val() == 1 ) {
                      $('.avatar-<?php echo $list_num;?>').show('slow');
					  } else {
					  	$('.avatar-<?php echo $list_num;?>').hide();
					  }


					$('#w_<?php echo $list_num; ?>_avatar_status').on('change', function() {
					  if (this.value == 1 ) {
                      $('.avatar-<?php echo $list_num;?>').show('slow');
					  } else {
					  	$('.avatar-<?php echo $list_num;?>').hide('slow');
					  }

					});
					</script>
				</td>
			</tr>



			<tr  class="avatar-<?php echo $list_num;?> ">
				<td><?php echo $language->get('entry_avatar_adaptive_resize'); ?></td>
				<td>
					<div class="input-group"><select class="form-control" name="ascp_widgets[<?php echo $list_num; ?>][avatar_adaptive_resize]">
						<?php if (isset( $list['avatar_adaptive_resize']) && $list['avatar_adaptive_resize']) { ?>
						<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
						<option value="0"><?php echo $text_disabled; ?></option>
						<?php } else { ?>
						<option value="1"><?php echo $text_enabled; ?></option>
						<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
						<?php } ?>
					</select></div>
				</td>
			</tr>


			<tr class="avatar-<?php echo $list_num;?> ">
				<td class="left"><?php echo $entry_avatar_dim; ?></td>
				<td class="left">

				<div class="sc_table">

				<div class="input-group">
					<input class="form-control" type="text" name="ascp_widgets[<?php echo $list_num; ?>][avatar][width]" value="<?php  if (isset($list['avatar']['width'])) echo $list['avatar']['width']; ?>" size="3" />
				</div>

				<div>
				x
				</div>

				<div class="input-group">
					<input class="form-control" type="text" name="ascp_widgets[<?php echo $list_num; ?>][avatar][height]" value="<?php if (isset($list['avatar']['height'])) echo $list['avatar']['height']; ?>" size="3" />
				</div>

                </div>
				</td>
			</tr>

			<tr  class="">
				<td><?php echo $language->get('entry_images_view'); ?>

				</td>
				<td>
					<div class="input-group"><select class="form-control" name="ascp_widgets[<?php echo $list_num; ?>][images_view]" id="w_<?php echo $list_num; ?>_images_view">
						<?php if (isset( $list['images_view']) && $list['images_view']) { ?>
						<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
						<option value="0"><?php echo $text_disabled; ?></option>
						<?php } else { ?>
						<option value="1"><?php echo $text_enabled; ?></option>
						<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
						<?php } ?>
					</select></div>
					<script>
					  if ($('#w_<?php echo $list_num; ?>_images_view').val() == 1 ) {
                      $('.images-<?php echo $list_num;?>').show('slow');
					  } else {
					  	$('.images-<?php echo $list_num;?>').hide();
					  }


					$('#w_<?php echo $list_num; ?>_images_view').on('change', function() {
					  if (this.value == 1 ) {
                      $('.images-<?php echo $list_num;?>').show('slow');
					  } else {
					  	$('.images-<?php echo $list_num;?>').hide('slow');
					  }

					});
					</script>

				</td>
			</tr>


			<tr  class="images-<?php echo $list_num;?> ">
				<td><?php echo $language->get('entry_images_adaptive_resize'); ?></td>
				<td>
					<div class="input-group"><select class="form-control" name="ascp_widgets[<?php echo $list_num; ?>][images_adaptive_resize]">
						<?php if (isset( $list['images_adaptive_resize']) && $list['images_adaptive_resize']) { ?>
						<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
						<option value="0"><?php echo $text_disabled; ?></option>
						<?php } else { ?>
						<option value="1"><?php echo $text_enabled; ?></option>
						<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
						<?php } ?>
					</select></div>
				</td>
			</tr>





			<tr  class="images-<?php echo $list_num;?> ">

				<td class="left"><?php echo $language->get('entry_images_dim'); ?></td>
				<td class="left">
					<div class="sc_table">
						<div class="input-group">
						<input class="form-control" type="text" name="ascp_widgets[<?php echo $list_num; ?>][images][width]" value="<?php  if (isset($list['images']['width'])) echo $list['images']['width']; ?>" size="3" />
						</div>
						<div>
						x
						</div>
						<div class="input-group">
						<input class="form-control" type="text" name="ascp_widgets[<?php echo $list_num; ?>][images][height]" value="<?php if (isset($list['images']['height'])) echo $list['images']['height']; ?>" size="3" />
						</div>
					</div>
				</td>
			</tr>

			<tr  class="images-<?php echo $list_num;?> ">
				<td>
					<?php echo $language->get('entry_images_number'); ?>
				</td>
				<td>
					<div class="input-group">
					<input class="form-control" type="text" name="ascp_widgets[<?php echo $list_num; ?>][images_number]" value="<?php  if (isset( $list['images_number'])) echo $list['images_number']; ?>" size="3" />
					</div>
				</td>
			</tr>

			<tr  class="images-<?php echo $list_num;?> ">
				<td><?php echo $language->get('entry_images_number_hide'); ?></td>
				<td>
					<div class="input-group"><select class="form-control" name="ascp_widgets[<?php echo $list_num; ?>][images_number_hide]">
						<?php if (isset( $list['images_number_hide']) && $list['images_number_hide']) { ?>
						<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
						<option value="0"><?php echo $text_disabled; ?></option>
						<?php } else { ?>
						<option value="1"><?php echo $text_enabled; ?></option>
						<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
						<?php } ?>
					</select></div>
				</td>
			</tr>



			<tr  class="images-<?php echo $list_num;?> ">
				<td><?php echo $language->get('entry_images_position'); ?></td>
				<td>
					<div class="input-group"><select class="form-control" name="ascp_widgets[<?php echo $list_num; ?>][images_position]">
						<?php if (!isset($list['images_position']) || $list['images_position']=='1' || $list['images_position']=='before') { ?>
						<option value="before" selected="selected"><?php echo  $language->get('text_images_position_before'); ?></option>
						<option value="after"><?php echo $language->get('text_images_position_after'); ?></option>
						<?php } else { ?>
						<option value="before"><?php echo $language->get('text_images_position_before'); ?></option>
						<option value="after" selected="selected"><?php echo $language->get('text_images_position_after'); ?></option>
						<?php } ?>
					</select></div>
				</td>
			</tr>

         <tr>
              <td><?php echo $language->get('entry_blog_small_colorbox'); ?></td>
              <td>
              	<div class="input-group"><select class="form-control" name="ascp_widgets[<?php echo $list_num; ?>][blog_small_colorbox]">
                  <?php if (isset($list['blog_small_colorbox']) && $list['blog_small_colorbox']) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select></div>
               </td>
            </tr>



</table>
</div>

<div id="tab-templates-<?php echo $list_num;?>" class="tabs_in_widgets">
<table>

    <tr>
     <td class="left"><?php echo $language->get('entry_block_records_width'); ?></td>
     <td class="left">
      <div class="input-group">
      <input class="form-control" type="text" size="6" name="ascp_widgets[<?php echo $list_num; ?>][block_records_width]" id="ascp_widgets_block_records_width_<?php echo $list_num; ?>" value="<?php  if (isset($list['block_records_width'])) echo $list['block_records_width']; ?>" size="50" />
      </div>

                 <div>
                 <?php echo $language->get('entry_block_records_width_templates'); ?>
                 </div>
	               <div>
					<div class="input-group"><select class="form-control" id="select_block_records_width_<?php echo $list_num; ?>">

	                 <?php  if (!isset($list['block_records_width'])) {$list['block_records_width'] = ''; } ?>
	                 <option value="<?php echo $list['block_records_width']; ?>"><?php echo $language->get('entry_current_value'); ?></option>

                      <?php foreach ($block_records_width_templates as $block_records_width_name => $block_records_width_value) { ?>
	                   <option value="<?php echo $block_records_width_value; ?>"><?php echo $block_records_width_name; ?></option>
                       <?php } ?>
	                 </select></div>
	                 </div>
						<script>
						$( '#select_block_records_width_<?php echo $list_num; ?>' )
						.change(function () {
						var str = '';
						$( '#select_block_records_width_<?php echo $list_num; ?> option:selected' ).each(function() {
						str = $(this).val();
						});

						$( '#ascp_widgets_block_records_width_<?php echo $list_num; ?>' ).val( str );

						});
						</script>



     </td>
    </tr>




		<tr>
			<td>
				<?php echo $language->get('entry_template'); ?>
			</td>
			<td>
				<div class="input-group">
				<input class="form-control template" type="text" name="ascp_widgets[<?php echo $list_num; ?>][template]" value="<?php if (isset($list['template'])) echo $list['template']; ?>" size="60" />
				<input type="hidden" name="tpath" value="widgets/records">
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
				<td><?php echo $language->get('entry_modal_status'); ?></td>
				<td>
					<div class="input-group"><select class="form-control" id="ascp_widgets_<?php echo $list_num; ?>_modal_status" name="ascp_widgets[<?php echo $list_num; ?>][modal_status]">
						<?php if (isset( $list['modal_status']) && $list['modal_status']) { ?>
						<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
						<option value="0"><?php echo $text_disabled; ?></option>
						<?php } else { ?>
						<option value="1"><?php echo $text_enabled; ?></option>
						<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
						<?php } ?>
					</select></div>

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

						});


						</script>
				</td>
			</tr>


			<tr  class="modal-<?php echo $list_num;?>">
			<td>
				<?php echo $language->get('entry_template_modal'); ?>
			</td>
			<td>
				<div class="input-group">
				<input class="form-control template" type="text" name="ascp_widgets[<?php echo $list_num; ?>][template_modal]" value="<?php if (isset($list['template_modal'])) echo $list['template_modal']; ?>" size="60" />
				<input type="hidden" name="tpath" value="record">
				</div>
			</td>
			</tr>


			<tr  class=" modal-<?php echo $list_num;?>">
				<td><?php echo $language->get('entry_modal_positions'); ?></td>
				<td>
					<div class="scrollbox">
						<?php $class = 'odd'; ?>
						<?php foreach ($positions as $position => $position_name) { ?>
						<?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
						<div class="<?php echo $class; ?>">
							<?php if (isset($list['positions']) && in_array($position, $list['positions'])) { ?>
							<input type="checkbox" name="ascp_widgets[<?php echo $list_num; ?>][positions][]" value="<?php echo $position; ?>" checked="checked" />
							<?php echo $position_name; ?>
							<?php } else { ?>
							<input type="checkbox" name="ascp_widgets[<?php echo $list_num; ?>][positions][]" value="<?php echo $position; ?>" />
							<?php echo $position_name; ?>
							<?php } ?>

						</div>
						<?php } ?>
					</div>
					<a onclick="$(this).parent().find(':checkbox').prop('checked', true);" class="nohref"><?php echo $language->get('text_select_all'); ?></a> / <a onclick="$(this).parent().find(':checkbox').prop('checked', false);" class="nohref"><?php echo $language->get('text_unselect_all'); ?></a>
				</td>
			</tr>





   <?php foreach ($languages as $lang) { ?>
	<tr class="">
		<td class="left">
			<?php echo $language->get('entry_title_further'); ?> <br>(<?php echo $lang['name']; ?>)
		</td>
			<td>
				<div class="input-group marginbottom5px"><span class="input-group-addon"><?php echo strtoupper($lang['code']); ?><br><img src="<?php echo $lang['image']; ?>" title="<?php echo $lang['name']; ?>" ></span>
					<textarea class="form-control" name="ascp_widgets[<?php echo $list_num; ?>][further][<?php echo $lang['language_id']; ?>]" rows="3" cols="50" ><?php if (isset($list['further'][$lang['language_id']])) { echo $list['further'][$lang['language_id']]; } else { echo ''; } ?></textarea>
				</div>
			</td>

	</tr>
   <?php } ?>

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


		    <tr  class="pro-<?php echo $list_num;?>">
		     <td class="left"><?php echo $language->get('entry_reserved'); ?></td>
		     <td class="left">
  		     <textarea name="ascp_widgets[<?php echo $list_num; ?>][reserved]"><?php  if (isset($list['reserved'])) echo $list['reserved']; ?></textarea>
		     </td>
		    </tr>


</table>
</div>

<div id="tab-access-<?php echo $list_num;?>" class="tabs_in_widgets">
<table>

            <tr class="">
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
					<div class="input-group col-xs-2">
						<input class="form-control no_change" type="text" name="ascp_widgets[<?php echo $list_num; ?>][widget_order]" value="<?php if (isset($list['widget_order'])) echo $list['widget_order']; ?>" />
  					</div>
                </td>
			</tr>

</table>
</div>


</form>
</div>
<?php }  ?>



<script>
	$('#tabs-<?php echo $list_num;?> a').tabs();
</script>



<?php if ($list['type'] == 'records' ) { ?>

<script type="text/javascript">
$(document).ready(function () {

$('input[name=\'ascp_widgets[<?php echo $list_num; ?>][related]\']').autocomplete({
	'source': function(request, response) {
         	<?php
         	if (SC_VERSION < 20) {
         	?>
         	 var filter_name = request.term;
         	<?php
         	} else {
         	?>
         	 var filter_name = request;
         	<?php
         	}
         	?>
		$.ajax({
			url: 'index.php?route=catalog/record/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(filter_name),
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
         	 var  veli = ui.item.value;
         	 var  labi = ui.item.label;
         	<?php
         	} else {
         	?>
         	 var veli = event['value'];
         	 var labi = event['label'];
         	<?php
         	}
         	?>

		$('#record-related_<?php echo $list_num; ?>_' + veli).remove();

		$('#record-related_<?php echo $list_num; ?>').append('<div id=\"record-related_<?php echo $list_num; ?>_' + veli + '\">' + labi + '<img src=\"view\/image\/delete.png\" ><div class=\"input-group\"><input class=\"form-control\" type=\"hidden\" name=\"ascp_widgets[<?php echo $list_num; ?>][related][]\" value=\"' + veli + '\" ><\/div><\/div>');

		$('#record-related_<?php echo $list_num; ?> div:odd').attr('class', 'odd');
		$('#record-related_<?php echo $list_num; ?> div:even').attr('class', 'even');

		return false;
	}
});


if ($.isFunction($.fn.on)) {
$(document).on('click', '#record-related_<?php echo $list_num; ?> div img', function() {
	$(this).parent().remove();

	$('#record-related_<?php echo $list_num; ?> div:odd').attr('class', 'odd');
	$('#record-related_<?php echo $list_num; ?> div:even').attr('class', 'even');
});
} else {

$('#record-related_<?php echo $list_num; ?> div img').live('click',  function() {
	$(this).parent().remove();

	$('#record-related_<?php echo $list_num; ?> div:odd').attr('class', 'odd');
	$('#record-related_<?php echo $list_num; ?> div:even').attr('class', 'even');
});

}


});

</script>



<?php }  ?>
