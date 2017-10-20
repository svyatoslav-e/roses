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
      <button type="button" class="close sc_button" data-dismiss="alert">&times;</button>
    </div>
<?php } ?>

<?php if ($success) { ?>
    <div class="alert alert-success success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close sc_button" data-dismiss="alert">&times;</button>
    </div>
<?php } ?>


<div class="box1">

<div class="content">

<?php echo $agoo_menu; ?>
<div style="margin:5px; float:right;">
   <a href="#" class="mbutton blog_save sc_button <?php
   if (count($settings_install) > 0 && isset($settings_install['ascp_install_2']) && !$settings_install['ascp_install_2']) {
   ?> asc_blinking <?php
   }
   ?>"><?php echo $button_save; ?></a>
   <a onclick="location = '<?php echo $cancel; ?>';" class="mbutton nohref sc_button"><?php echo $button_cancel; ?></a>
   <?php echo $agoo_save; ?>
</div>

<div style="clear: both; width:100%; overflow: hidden; line-height: 1px; font-size: 1px;"></div>

<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">

<script type="text/javascript">
function delayer(){
    window.location = 'index.php?route=module/blog&token=<?php echo $token; ?>';
}
</script>

 <div id="tabs" class="htabs"><a href="#tab-options"><?php echo $language->get('tab_options'); ?></a>
  <a href="#tab-color"><?php echo $language->get('tab_color'); ?></a>
  <a href="#tab-install" id="sc_install"><?php echo $language->get('entry_install_update'); ?></a>
  <a href="#tab-scripts"><?php echo $language->get('entry_scripts'); ?></a>
  <a href="#tab-fields"><?php echo $language->get('entry_service'); ?></a>
  <a href="#tab-faq"><?php echo $language->get('entry_docs'); ?></a>
 </div>


<div style="clear: both; width:100%; overflow: hidden; line-height: 1px; font-size: 1px;"></div>


<div id="tab-options">

  <?php echo $text_new_version; ?>


<div style="margin-top:10px;">
		<a onclick="$('.pro').toggle('slow', function() {


		        if ($('.pro_updown').hasClass('pro_button_hidden')) {

		            $('.pro_updown').removeClass('pro_button_hidden').addClass('pro_button_show');
		            $('.pro_up_down').removeClass('pro_button_active');
		            $('.pro_updown').html('<?php echo $language->get('entry_show_pro'); ?>');

		        } else {

		            $('.pro_updown').html('<?php echo $language->get('entry_hidden_pro'); ?>');
		            $('.pro_updown').removeClass('pro_button_show').addClass('pro_button_hidden');
		            $('.pro_up_down').addClass('pro_button_active');

		        }

		    });" style="float: right;" class="pro_up_down pro_button sc_button">


		    <div class="pro_updown pro_button_show"><?php echo $language->get('entry_show_pro'); ?></div>

		</a>
</div>


<div style="margin-top: 10px;">
	<div id="tab-list">

			<div id="mytabs" class="vtabs" style="padding-top: 0px;">



				<a href='#mytabs_default' id='#mytabs_id_default'><?php echo $language->get('entry_tab_settings_default'); ?></a>

				<?php
				 foreach ($widgets as $widget => $setting) {
				 ?>
				<a href='#mytabs_<?php echo $setting['code']; ?>' id='#mytabs_id_<?php echo $setting['code']; ?>'><?php echo $setting['name']; ?></a>
				<?php
				 }
				?>




			</div>

			<div id="mytabs_default">
			<div class="tabcontent" style="padding-left: 220px;" id="list_default">

				<table class="mynotable" style="margin-bottom:20px; background: white; vertical-align: center;">

				          <tr>
				              <td style="width: 220px;"><?php echo $language->get('entry_menu_admin_status'); ?></td>
				              <td>
				              <div class="input-group">
				              <select class="form-control" name="ascp_settings[menu_admin_status]">
				                  <?php if (isset($ascp_settings['menu_admin_status']) && $ascp_settings['menu_admin_status']) { ?>
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
				              <td><?php echo $language->get('entry_cache_widgets'); ?></td>
				              <td>
				              <div class="input-group">
				              <select class="form-control" name="ascp_settings[cache_widgets]">
				                  <?php if (isset($ascp_settings['cache_widgets']) && $ascp_settings['cache_widgets']) { ?>
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







				    <tr class="">
				     <td class="left"><?php echo $language->get('entry_format_date'); ?></td>
				     <td class="left">
				      <div class="input-group">
				      <input type="text" class="form-control" name="ascp_settings[format_date]" value="<?php  if (isset($ascp_settings['format_date'])) echo $ascp_settings['format_date']; else echo $language->get('text_date'); ?>" size="11" />
				      </div>
				     </td>
				    </tr>

				    <tr class="">
				     <td class="left"><?php echo $language->get('entry_format_hours'); ?></td>
				     <td class="left">
				      <div class="input-group">
				      <input class="form-control" type="text" name="ascp_settings[format_hours]" value="<?php  if (isset($ascp_settings['format_hours'])) echo $ascp_settings['format_hours']; else  echo $language->get('text_hours'); ?>" size="11" />
				      </div>
				     </td>
				    </tr>

				      <tr class="pro">
				              <td><?php echo $language->get('entry_format_time'); ?></td>
				              <td>

				              <div class="input-group">
				              <select class="form-control" name="ascp_settings[format_time]">
				                  <?php if (isset($ascp_settings['format_time']) && $ascp_settings['format_time']) { ?>
				                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
				                  <option value="0"><?php echo $text_disabled; ?></option>
				                  <?php } else { ?>
				                  <option value="1" <?php if (!isset($ascp_settings['format_time'])) echo 'selected="selected"'; ?>><?php echo $text_enabled; ?></option>
				                  <option value="0" <?php if (isset($ascp_settings['format_time'])) echo 'selected="selected"'; ?>><?php echo $text_disabled; ?></option>
				                  <?php } ?>
				                </select>
				                </div>


				                </td>
				            </tr>





				          <!--
				           <td><?php echo $language->get('entry_review_visual'); ?></td>
				              <td><select name="ascp_settings[review_visual]">
				                  <?php if (isset($ascp_settings['review_visual']) && $ascp_settings['review_visual']) { ?>
				                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
				                  <option value="0"><?php echo $text_disabled; ?></option>
				                  <?php } else { ?>
				                  <option value="1"><?php echo $text_enabled; ?></option>
				                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
				                  <?php } ?>
				                </select></td>
				            </tr>
							-->
							 <input type="hidden" name="ascp_settings[review_visual]" value="0" />







				        <!--
				          <tr>
				              <td><?php echo $language->get('entry_layout_url_status'); ?></td>
				              <td><select name="ascp_settings[layout_url_status]">
				                  <?php if (isset($ascp_settings['layout_url_status']) && $ascp_settings['layout_url_status']) { ?>
				                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
				                  <option value="0"><?php echo $text_disabled; ?></option>
				                  <?php } else { ?>
				                  <option value="1"><?php echo $text_enabled; ?></option>
				                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
				                  <?php } ?>
				                </select></td>
				            </tr>
				            -->










 					<tr>
						<td class="left">
							<?php echo $language->get('entry_title_further'); ?>
						</td>
							<td>

					<?php foreach ($languages as $lang) { ?>

							<div class="input-group marginbottom5px"><span class="input-group-addon"><?php echo strtoupper($lang['code']); ?><br><img src="<?php echo $lang['image']; ?>" title="<?php echo $lang['name']; ?>" ></span>
								<textarea class="form-control" name="ascp_settings[further][<?php echo $lang['language_id']; ?>]" rows="3" cols="50" ><?php if (isset($ascp_settings['further'][$lang['language_id']])) { echo $ascp_settings['further'][$lang['language_id']]; } else { echo '&rarr;'; } ?></textarea>
							</div>

					<?php } ?>

						</td>
					</tr>


					<tr>
						<td class="left">
							<?php echo $language->get('entry_box_begin'); ?>
						</td>
							<td>
								<div class="input-group"><span class="input-group-addon"></span>
								<textarea class="form-control" name="ascp_settings[box_begin]" rows="3" cols="50" ><?php if (isset($ascp_settings['box_begin'])) { echo $ascp_settings['box_begin']; } else { echo ''; } ?></textarea>
								</div>
							</td>
					</tr>

					<tr>
						<td class="left">
							<?php echo $language->get('entry_box_end'); ?>
						</td>
							<td>
								<div class="input-group"><span class="input-group-addon"></span>
								<textarea class="form-control" name="ascp_settings[box_end]" rows="3" cols="50" ><?php if (isset($ascp_settings['box_end'])) { echo $ascp_settings['box_end']; } else { echo ''; } ?></textarea>
								</div>
							</td>
					</tr>

				            <tr class="">
				 			 <td><?php echo $language->get('entry_complete_status'); ?>
				 			  <?php foreach ($order_statuses as $order_status) { ?>

								 <?php if (isset($ascp_settings['complete_status']) && in_array($order_status['order_status_id'], $ascp_settings['complete_status'])) { ?>
				                    <div class="color_green"><?php echo $order_status['name']; ?></div>
				                 <?php } ?>


				 			  <?php } ?>
				 			 </td>
				              <td>
				               <div class="scrollbox">
				                  <?php  $class = 'even'; ?>
				                  <?php foreach ($order_statuses as $order_status) { ?>
				                  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
				                  <div class="<?php echo $class; ?>">
				                    <?php if (isset($ascp_settings['complete_status']) && in_array($order_status['order_status_id'], $ascp_settings['complete_status'])) { ?>
				                    <input type="checkbox" name="ascp_settings[complete_status][]" value="<?php echo $order_status['order_status_id']; ?>" checked="checked" />
				                    <?php echo $order_status['name']; ?>
				                    <?php } else { ?>
				                    <input type="checkbox" name="ascp_settings[complete_status][]" value="<?php echo $order_status['order_status_id']; ?>" />
				                    <?php echo $order_status['name']; ?>
				                    <?php } ?>
				                  </div>
				                  <?php } ?>
				                </div>
				               </td>
				            </tr>







				            <tr class="pro">
				            <td><?php echo $language->get('entry_colorbox_theme'); ?></td>
				              <td>
				               <div class="input-group">
				               <select class="form-control" name="ascp_settings[colorbox_theme]">
				           	<?php
								foreach ($colorbox_theme as $num =>$list) {
						    ?>
				                <?php if (isset($ascp_settings['colorbox_theme']) && $ascp_settings['colorbox_theme']==$list) { ?>
				                <option value="<?php echo $list; ?>" selected="selected"><?php echo $list; ?></option>
				                <?php } else { ?>
				                <option value="<?php echo $list; ?>"><?php echo $list; ?></option>
				                <?php } ?>

				              <?php
				              }
				              ?>
				              </select>
				              </div>
				              </td>
				              </tr>



				          <tr class="pro">
				              <td><?php echo $language->get('entry_resize'); ?></td>
				              <td><div class="input-group"><select class="form-control" name="ascp_settings[blog_resize]">
				                  <?php if (isset($ascp_settings['blog_resize']) && $ascp_settings['blog_resize']) { ?>
				                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
				                  <option value="0"><?php echo $text_disabled; ?></option>
				                  <?php } else { ?>
				                  <option value="1"><?php echo $text_enabled; ?></option>
				                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
				                  <?php } ?>
				                </select></div></td>
				            </tr>





				    <tr class="pro">
				     <td class="left"><?php echo $language->get('entry_get_pagination');  ?></td>
				     <td class="left">
				      <div class="input-group">
				      <input class="form-control template" size="11" type="text" name="ascp_settings[get_pagination]" value="<?php  if (isset($ascp_settings['get_pagination'])) echo $ascp_settings['get_pagination']; ?>" size="20" />
				      </div>
				     </td>
				    </tr>




					<tr class="pro">
						<td class="left">
							<?php echo $language->get('entry_position_types'); ?>
						</td>
							<td>
								<div style="float: left;">

				   <table id="position_types" class="list">
					   <thead>
				             <tr>
				                <td class="left"><?php echo $language->get('entry_position'); ?></td>
				                <td><?php echo $language->get('entry_title'); ?></td>
				                <td></td>
				             </tr>

				      </thead>

				      <?php if (isset($ascp_settings['position_type']) && !empty($ascp_settings['position_type'])) { ?>
				      <?php foreach ($ascp_settings['position_type'] as $position_type_id => $position_type) { ?>
				      <?php $position_type_row = $position_type_id; ?>
				      <tbody id="position_type_row<?php echo $position_type_row; ?>">
				          <tr>
				               <td class="left">
								<input type="text" name="ascp_settings[position_type][<?php echo $position_type_id; ?>][type_id]" value="<?php if (isset($position_type['type_id'])) echo $position_type['type_id']; ?>" size="20">
				               </td>

								<td class="right">
								 <?php foreach ($languages as $lang) { ?>
									<div style="margin-bottom: 3px;">
									<input type="text" name="ascp_settings[position_type][<?php echo $position_type_id; ?>][title][<?php echo $lang['language_id']; ?>]" value="<?php if (isset($position_type['title'][$lang['language_id']])) echo $position_type['title'][$lang['language_id']]; ?>" style="width: 300px;"><img src="<?php echo $lang['image']; ?>" title="<?php echo $lang['name']; ?>" >
									</div>
				                 <?php } ?>
								</td>

				                <td class="left"><a onclick="$('#position_type_row<?php echo $position_type_row; ?>').remove();" class="markbutton button_purple nohref  sc_button"><?php echo $button_remove; ?></a></td>
				              </tr>
				            </tbody>

				            <?php } ?>
				            <?php } ?>
				            <tfoot>
				              <tr>
                                <td colspan="4" class="left" style="text-align: right;"><div style="text-align: center;"><a onclick="addpositionType();" class="markbutton nohref sc_button"><?php echo $language->get('entry_add_position_type'); ?></a></div></td>
				              </tr>
				            </tfoot>
				          </table>





								</div>
							</td>
					</tr>





				    <tr>
				     <td></td>
				     <td></td>
				    </tr>
				   </table>

			</div>
			</div>


			<?php
			 foreach ($widgets as $widget => $setting) {
			 ?>
			<div id="mytabs_<?php echo $setting['code']; ?>">
			<div class="tabcontent" style="padding-left: 200px;" id="list_<?php echo $setting['code']; ?>">
			<?php echo $setting['html']; ?>
			</div>
			</div>
			<?php
			 }
			?>




		</div>
		<script>
			$('#mytabs a').tabs();
		</script>




</div>




</div>




<div id="tab-scripts">

<div style="float: left;">
	<div style="width: 100%;">
		<a href="#" onclick="
				$.ajax({
					url: '<?php echo $url_script_reviews; ?>',
					dataType: 'html',
					type: 'POST',
					data: {
		                layout_route: 'record/record'
		            },
					beforeSend: function()
					{
		               $('#create_scripts').html('<?php echo $language->get('text_loading_main'); ?>');
					},
					success: function(json) {
						$('#create_scripts').html(json);
						setTimeout('delayer()', 2000);
					},
					error: function(json) {
					$('#create_scripts').html('Error');
					}
				}); return false;" class="scenarybutton sc_button "  style="clear:both;">

		<div style=""><i class="fa fa-bars"></i>&nbsp;&nbsp;&nbsp;<?php echo $language->get('text_url_script_reviews_records'); ?></div>
		</a>
	</div>


	<div style="width: 100%;">
		<a href="#" onclick="
				$.ajax({
					url: '<?php echo $url_script_reviews; ?>',
					dataType: 'html',
					type: 'POST',
					data: {
		                layout_route: 'product/product'
		            },
					beforeSend: function()
					{
		               $('#create_scripts').html('<?php echo $language->get('text_loading_main'); ?>');
					},
					success: function(json) {
						$('#create_scripts').html(json);
						setTimeout('delayer()', 2000);
					},
					error: function(json) {
					$('#create_scripts').html('Error');
					}
				}); return false;" class="scenarybutton sc_button"  style="clear:both;">
		<div style=""><i class="fa fa-th"></i>&nbsp;&nbsp;&nbsp;<?php echo $language->get('text_url_script_reviews_products'); ?></div>
		</a>
	</div>

</div>







<div id="create_scripts" style="color: green; font-weight: bold;"></div>

</div>



<div id="tab-color">
 <div>
 <?php
 // echo $language->get('css_help');
 ?>
 </div>
<div>
	<table class="mynotable" style="vertical-align: center;">
	<tbody>

	<tr>
			     <td style="width: 220px;" class="left"><?php echo $language->get('css_user'); ?></td>
			     <td class="left">
						<div>
							<textarea name="ascp_settings[css][css]" rows="9" cols="40" ><?php if (isset($ascp_settings['css']['css'])) { echo $ascp_settings['css']['css']; } else { echo ''; } ?></textarea>
						</div>
			     </td>
	</tr>


	<tr>
	            <td class="left"><?php echo $language->get('entry_css_dir'); ?></td>
	            <td class="left">
		            <select name="ascp_settings[css_dir]">
		           	<?php  foreach ($css_dir as $num =>$list) { ?>
		                <?php if (isset($ascp_settings['css_dir']) && $ascp_settings['css_dir']==$list) { ?>
		                <option value="<?php echo $list; ?>" selected="selected"><?php echo $language->get( $list.'_css_dir'); ?></option>
		                <?php } else { ?>
		                <option value="<?php echo $list; ?>"><?php echo $language->get( $list.'_css_dir'); ?></option>
		                <?php } ?>

		              <?php } ?>
		              </select>
	              </td>
	</tr>


	<tr>
		<td colspan="2">
		<table class="table_width_100">
				<tr>
		        	<td colspan="2" class="entry_td"><?php echo $language->get('css_background_body'); ?></td>
		        	<td></td>
		      	</tr>

				<tr>
					<td class="left td_width"><?php echo $language->get('css_record-content'); ?></td>
					<td class="left">
						<div>
							<input type="text" name="ascp_settings[css][record-content]" class="colorpicker" size="6" value="<?php if (isset($ascp_settings['css']['record-content'])) echo $ascp_settings['css']['record-content']; ?>" />
						</div>
					</td>
				</tr>

	  			<tr>
	     			<td class="left td_width"><?php echo $language->get('css_blog-content'); ?></td>
	     			<td class="left">
						<div>
							<input type="text" name="ascp_settings[css][blog-content]" class="colorpicker" size="6" value="<?php if (isset($ascp_settings['css']['blog-content'])) echo $ascp_settings['css']['blog-content']; ?>" />
						</div>
	     			</td>
	    		</tr>
		</table>
		</td>
		<td>
		</td>
	</tr>


	<tr>
		<td colspan="2">
		<table class="table_width_100">
				<tr>
	            	<td colspan="2" class="entry_td"><?php echo $language->get('css_ascp-list-title'); ?></td>
	            	<td></td>
	      		</tr>

	  			<tr>
	     			<td class="left td_width"><?php echo $language->get('css_ascp-list-title-color'); ?></td>
	     			<td class="left">
						<div>
							<input type="text" name="ascp_settings[css][ascp-list-title-color]" class="colorpicker" size="6" value="<?php if (isset($ascp_settings['css']['ascp-list-title-color'])) echo $ascp_settings['css']['ascp-list-title-color']; ?>" />
						</div>
	     			</td>
	  			</tr>

	            <tr>
	            	<td class="left td_width"><?php echo $language->get('css_ascp-list-title-size'); ?></td>
	              	<td>
		            	<select name="ascp_settings[css][ascp-list-title-size]">
		           		<?php  foreach ($css_font_size as $num =>$list) { ?>
		                <?php if (isset($ascp_settings['css']['ascp-list-title-size']) && $ascp_settings['css']['ascp-list-title-size']==$list) { ?>
		                <option value="<?php echo $list; ?>" selected="selected"><?php echo $list; ?></option>
		                <?php } else { ?>
		                <option value="<?php echo $list; ?>"><?php echo $list; ?></option>
		                <?php } ?>

		              	<?php } ?>
		              	</select>
	     			</td>
	     		</tr>

	            <tr>
	            <td class="left td_width"><?php echo $language->get('css_ascp-list-title-line'); ?></td>
	              <td>
		               <select name="ascp_settings[css][ascp-list-title-line]">
			           	<?php  foreach ($css_font_size as $num =>$list) { ?>
			                <?php if (isset($ascp_settings['css']['ascp-list-title-line']) && $ascp_settings['css']['ascp-list-title-line']==$list) { ?>
			                <option value="<?php echo $list; ?>" selected="selected"><?php echo $list; ?></option>
			                <?php } else { ?>
			                <option value="<?php echo $list; ?>"><?php echo $list; ?></option>
			                <?php } ?>

			              <?php } ?>
		              </select>
	              	</td>
	              </tr>

	            <tr>
	            	<td class="left td_width"><?php echo $language->get('css_ascp-list-title-decoration'); ?></td>
	              	<td>
		               <select name="ascp_settings[css][ascp-list-title-decoration]">
			           	<?php  foreach ($css_text_decoration as $num =>$list) { ?>
			                <?php if (isset($ascp_settings['css']['ascp-list-title-decoration']) && $ascp_settings['css']['ascp-list-title-decoration']==$list) { ?>
			                <option value="<?php echo $list; ?>" selected="selected"><?php echo $list; ?></option>
			                <?php } else { ?>
			                <option value="<?php echo $list; ?>"><?php echo $list; ?></option>
			                <?php } ?>
			              <?php } ?>
		              </select>
	              	</td>
	            </tr>

	            <tr>
	            	<td class="left td_width"><?php echo $language->get('css_ascp-list-title-weight'); ?></td>
	              	<td>
		               <select name="ascp_settings[css][ascp-list-title-weight]">
			           	<?php  foreach ($css_font_weight as $num =>$list) { ?>
			                <?php if (isset($ascp_settings['css']['ascp-list-title-weight']) && $ascp_settings['css']['ascp-list-title-weight']==$list) { ?>
			                <option value="<?php echo $list; ?>" selected="selected"><?php echo $list; ?></option>
			                <?php } else { ?>
			                <option value="<?php echo $list; ?>"><?php echo $list; ?></option>
			                <?php } ?>
			              <?php } ?>
		              </select>
	              	</td>
	            </tr>
	      </table>
		</td>
		<td>
		</td>
	</tr>


	<tr>
		<td colspan="2">
		<table class="table_width_100">
				<tr>
	            	<td colspan="2" class="entry_td"><?php echo $language->get('css_ascp-list-title-widget'); ?></td>
	            	<td></td>
	      		</tr>

	  			<tr>
	     			<td class="left td_width"><?php echo $language->get('css_ascp-list-title-color'); ?></td>
	     			<td class="left">
						<div>
							<input type="text" name="ascp_settings[css][ascp-list-title-widget-color]" class="colorpicker" size="6" value="<?php if (isset($ascp_settings['css']['ascp-list-title-widget-color'])) echo $ascp_settings['css']['ascp-list-title-widget-color']; ?>" />
						</div>
	     			</td>
	  			</tr>

	            <tr>
	            	<td class="left td_width"><?php echo $language->get('css_ascp-list-title-size'); ?></td>
	              	<td>
		            	<select name="ascp_settings[css][ascp-list-title-widget-size]">
		           		<?php  foreach ($css_font_size as $num =>$list) { ?>
		                <?php if (isset($ascp_settings['css']['ascp-list-title-widget-size']) && $ascp_settings['css']['ascp-list-title-widget-size']==$list) { ?>
		                <option value="<?php echo $list; ?>" selected="selected"><?php echo $list; ?></option>
		                <?php } else { ?>
		                <option value="<?php echo $list; ?>"><?php echo $list; ?></option>
		                <?php } ?>

		              	<?php
		              	}
		              	?>
		              	</select>
	     			</td>
	     		</tr>

	            <tr>
	            <td class="left td_width"><?php echo $language->get('css_ascp-list-title-line'); ?></td>
	              <td>
		               <select name="ascp_settings[css][ascp-list-title-widget-line]">
			           	<?php  foreach ($css_font_size as $num =>$list) { ?>
			                <?php if (isset($ascp_settings['css']['ascp-list-title-widget-line']) && $ascp_settings['css']['ascp-list-title-widget-line']==$list) { ?>
			                <option value="<?php echo $list; ?>" selected="selected"><?php echo $list; ?></option>
			                <?php } else { ?>
			                <option value="<?php echo $list; ?>"><?php echo $list; ?></option>
			                <?php } ?>

			              <?php
			              }
			              ?>
		              </select>
	              	</td>
	              </tr>

	            <tr>
	            	<td class="left td_width"><?php echo $language->get('css_ascp-list-title-decoration'); ?></td>
	              	<td>
		               <select name="ascp_settings[css][ascp-list-title-widget-decoration]">
			           	<?php  foreach ($css_text_decoration as $num =>$list) { ?>
			                <?php if (isset($ascp_settings['css']['ascp-list-title-widget-decoration']) && $ascp_settings['css']['ascp-list-title-widget-decoration']==$list) { ?>
			                <option value="<?php echo $list; ?>" selected="selected"><?php echo $list; ?></option>
			                <?php } else { ?>
			                <option value="<?php echo $list; ?>"><?php echo $list; ?></option>
			                <?php } ?>

			              <?php
			              }
			              ?>
		              </select>
	              	</td>
	            </tr>

	            <tr>
	            	<td class="left td_width"><?php echo $language->get('css_ascp-list-title-weight'); ?></td>
	              	<td>
		               <select name="ascp_settings[css][ascp-list-title-widget-weight]">
			           	<?php  foreach ($css_font_weight as $num =>$list) { ?>
			                <?php if (isset($ascp_settings['css']['ascp-list-title-widget-weight']) && $ascp_settings['css']['ascp-list-title-widget-weight']==$list) { ?>
			                <option value="<?php echo $list; ?>" selected="selected"><?php echo $list; ?></option>
			                <?php } else { ?>
			                <option value="<?php echo $list; ?>"><?php echo $list; ?></option>
			                <?php } ?>

			              <?php
			              }
			              ?>
		              </select>
	              	</td>
	            </tr>



	      </table>
		</td>
		<td>
		</td>
	</tr>



	</tbody>
	</table>
</div>




				<style>
				input.colorpicker {
					border-radius: 3px;
					padding: 4px;
					border-left:30px solid #FFF;
				}
				.margintop5 {
				margin-top: 5px;
				}

				</style>
				<script>
					$('.colorpicker').each(function(index) {

				 		 $(this).attr('id', 'colorpicker_'+index );
				         var colorpicker = new Array();
				         colorpicker[index] = $('#colorpicker_'+index).val();
				        $('#colorpicker_'+index).css('border-left-color', colorpicker[index]);

						$('#colorpicker_'+index).colpick({
							layout:'rgbhex',
							submit:0,
							color: colorpicker[index],
							onChange:function(hsb,hex,rgb,el,bySetColor) {
								if(!bySetColor) {
								  $(el).val('#'+hex);
								  $('#colorpicker_'+index).val('#'+hex );
								}
								$(el).css('border-left-color','#'+hex);
								$(this+' .colpick_current_color').css('background-color', colorpicker[index] );
								$('.colpick_current_color').css('display', 'visible' );

							}
						}).keyup(function(){
							$(this).colpickSetColor(this.value);
						});

					});
				</script>

</div>






<div id="tab-fields">

<div style="float: left;">

	<div style="width: 100%;">
	<a href="<?php echo $url_adapter; ?>" class="scenarybutton sc_button"  style="clear:both; ">
	<div style=""><i class="fa fa-check-circle"></i>&nbsp;&nbsp;&nbsp;<?php echo $language->get('entry_adapter'); ?></div>
	</a>
	</div>

	<div style="width: 100%;">
	<a href="<?php echo $url_fields; ?>" class="scenarybutton sc_button"  style="clear:both;">
	<div style=""><i class="fa fa-caret-square-o-right"></i>&nbsp;&nbsp;&nbsp;<?php echo $language->get('entry_fields'); ?></div></a>
	</div>

	<div style="width: 100%;">
	<a href="<?php echo $url_convertor_news; ?>" class="scenarybutton sc_button"  style="clear:both; ">
	<div style=""><i class="fa fa-refresh "></i>&nbsp;&nbsp;&nbsp;<?php echo $language->get('entry_convertor_news'); ?></div>
	</a>
	</div>

	<div style="width: 100%;">
	<a href="<?php echo $url_convertor_information; ?>" class="scenarybutton sc_button"  style="clear:both; ">
	<div style=""><i class="fa fa-refresh "></i>&nbsp;&nbsp;&nbsp;<?php echo $language->get('entry_convertor_information'); ?></div>
	</a>
	</div>
</div>

</div>
<!--
<div id="tab-about">

<?php
//echo $language->get('text_about');
?>

</div>
-->

<div id="tab-faq">

<script>

function isVisible(){
    $('#iframeelement').each(function(){
        if($(this).is(':visible')){

			var if_offset = $("#iframeelement").offset();
			var if_height = $(window).height() - if_offset.top;

			$('#iframeelement').html('<iframe src="http://opencartadmin.com/doc/index.<?php echo substr(strtolower($config->get('config_admin_language')), 0,2); ?>.html" style="width: 100%; height: 100%; min-height: '+ if_height +'px; border-top: 1px solid #AAA; border-bottom: 1px solid #AAA;"></iframe>');
        	clearInterval(iframeelement);
        }
    });
}
var iframeelement = window.setInterval(isVisible, 500);

</script>


<div id="iframeelement">

</div>




<?php echo $language->get('text_faq'); ?>




<div id="delete_button_main" style="margin-top: 20px;">
    <a href="#" onclick="$('#delete_button').toggle('slow'); $('#delete_button_main').hide('slow'); return false;" class="markbuttono  sc_button" style=""><?php echo $language->get('text_delete_settings_tables'); ?></a>
</div>


<div id="delete_button" style="margin-top: 20px; display: none;">

<div style="margin-top: 20px;">
    <a href="#" onclick="
		$.ajax({
			url: '<?php echo $url_delete_all_settings; ?>',
			dataType: 'html',
			beforeSend: function()
			{
               $('#id_delete_all_settings').html('<?php echo $language->get('text_loading_main'); ?>');
			},
			success: function(json) {
				$('#id_delete_all_settings').html(json);
				//setTimeout('delayer()', 2000);
			},
			error: function(json) {
			$('#id_delete_all_settings').html('error');
			}
		}); return false;" class="mbutton button_purple  sc_button" style=""><?php echo $url_delete_all_settings_text; ?></a>
</div>
<div id="id_delete_all_settings"></div>


<div style="margin-top: 10px;">
    <a href="#" onclick="
		$.ajax({
			url: '<?php echo $url_delete_all_tables; ?>',
			dataType: 'html',
			beforeSend: function()
			{
               $('#id_delete_all_tables').html('<?php echo $language->get('text_loading_main'); ?>');
			},
			success: function(json) {
				$('#id_delete_all_tables').html(json);
				//setTimeout('delayer()', 2000);
			},
			error: function(json) {
			$('#id_delete_all_tables').html('error');
			}
		}); return false;" class="mbutton button_purple sc_button" style=""><?php echo $language->get('url_delete_all_tables_text'); ?></a>
</div>
<div id="id_delete_all_tables"></div>



<div id="delete_button_bottom" style="margin-top: 20px;">
    <a href="#" onclick="$('#delete_button').toggle('slow'); $('#delete_button_main').show('slow'); return false;" class="markbuttono  sc_button" style=""><?php echo $language->get('text_delete_settings_tables_hide'); ?></a>
</div>


</div>


</div>


<div id="tab-install">

<?php

?>
<div style="margin-bottom: 5px;">
    <a href="#" id="sc_install_common" onclick="
		$.ajax({
			url: '<?php echo $url_create; ?>',
			dataType: 'html',
			beforeSend: function()
			{
               $('#create_tables').html('<?php echo $language->get('text_loading_main'); ?>');
			},
			success: function(json) {
				$('#create_tables').html(json);
				setTimeout('delayer()', 2000);
			},
			error: function(json) {
			$('#create_tables').html('error');
			}
		}); return false;" class="markbuttono widthbutton sc_button <?php
   if (count($settings_install) > 0 && isset($settings_install['ascp_install_1']) && !$settings_install['ascp_install_1']) {
   ?> asc_blinking <?php
   }
   ?>" style=""><?php echo $url_create_text; ?></a>
</div>
<!--
<div>
    <a href="#" onclick="
		$.ajax({
			url: '<?php echo $url_delete; ?>',
			dataType: 'html',
			beforeSend: function()
			{
               $('#create_tables').html('<?php echo $language->get('text_loading_main'); ?>');
			},
			success: function(json) {
				$('#create_tables').html(json);
				setTimeout('delayer()', 2000);
			},
			error: function(json) {
			$('#create_tables').html('error');
			}
		}); return false;" class="markbuttono sc_button" style=""><?php echo $url_delete_text; ?></a>
</div>
-->


<div class="margintop5px">
<a href="<?php echo $url_adapter; ?>" class="markbutton widthbutton sc_button"  style="clear:both; "><div><img src="view/image/seocms/sc_menu_a.png" ></div>
<div style=""><?php echo $language->get('entry_adapter'); ?></div></a>
</div>

<div id="create_tables" style="color: green; font-weight: bold;"></div>
<?php if (isset($text_update) && $text_update!='' ) { ?>
<div style="font-size: 18px; color: red;"><?php echo $text_update; ?></div>

<script>

$(document).ready(function(){

	$('#sc_install').click();

	setTimeout(function() {
	   // $('#sc_install_common').click();
	}, 1000);

});




</script>


<?php } ?>

</div>


 </div>

 </form>
</div>
<script type="text/javascript">
	 form_submit = function() {
		$('#form').submit();
		return false;
	}
	$('.blog_save').bind('click', form_submit);
</script>

<script type="text/javascript">
	$('#tabs a').tabs();
</script>

<script type="text/javascript">
function image_upload(field, thumb) {
	$('#dialog').remove();

	$('#content').prepend('<div id="dialog" style="padding: 3px 0px 0px 0px;"><iframe src="index.php?route=common/filemanager&token=<?php echo $token; ?>&field=' + encodeURIComponent(field) + '" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');

	$('#dialog').dialog({
		title: '<?php echo $language->get('text_image_manager'); ?>',
		close: function (event, ui) {
			if ($('#' + field).attr('value')) {
				$.ajax({
					url: 'index.php?route=common/filemanager/image&token=<?php echo $token; ?>&image=' + encodeURIComponent($('#' + field).val()),
					dataType: 'text',
					success: function(data) {
						$('#' + thumb).replaceWith('<img src="' + data + '" alt="" id="' + thumb + '" />');
					}
				});
			}
		},
		bgiframe: false,
		width: 800,
		height: 400,
		resizable: false,
		modal: false
	});
};
</script>



<script type="text/javascript">

var array_position_type_row = Array();
array_position_type_row.push(0);
<?php
 foreach ($ascp_settings['position_type'] as $indx => $position_type) {
?>
array_position_type_row.push('<?php echo $indx; ?>');
<?php
}
?>

var position_type_row = <?php echo $position_type_row + 1; ?>;

function addpositionType() {

	var aindex = -1;
	for(i = 0; i < array_position_type_row.length; i++) {
	 flg = jQuery.inArray(i, array_position_type_row);
	 if (flg == -1) {
	  aindex = i;
	 }
	}
	if (aindex == -1) {
	  aindex = array_position_type_row.length;
	}
	position_type_row = aindex;
	array_position_type_row.push(aindex);

    html  = '<tbody id="position_type_row' + position_type_row + '">';
	html += '  <tr>';
    html += '  <td class="left">';
	html += ' 	<input type="text" name="ascp_settings[position_type]['+ position_type_row +'][type_id]" value="column_'+ position_type_row +'" size="20">';
    html += '  </td>';

 	html += '  <td class="right">';
 	<?php foreach ($languages as $lang) { ?>

	html += '	<div style="margin-bottom: 3px;">';
	html += '		<input type="text" name="ascp_settings[position_type]['+ position_type_row +'][title][<?php echo $lang['language_id']; ?>]" value="" style="width: 300px;"><img src="<?php echo $lang['image']; ?>" title="<?php echo $lang['name']; ?>" >';
	html += '	</div>';

	<?php } ?>
    html += '  </td>';
    html += '  <td class="left"><a onclick="$(\'#position_type_row'+position_type_row+'\').remove(); array_position_type_row.remove(position_type_row);" class="markbutton button_purple nohref sc_button"><?php echo $button_remove; ?></a></td>';




	html += '  </tr>';
	html += '</tbody>';

	$('#position_types tfoot').before(html);

	position_type_row++;
}
</script>






</div>

</div>
</div>


<script type="text/javascript">

function odd_even() {
var kz = 0;
$('table tr').each(function(i,elem) {
$(this).removeClass('odd');
$(this).removeClass('even');
	if ($(this).is(':visible')) {
		kz++;
		if (kz % 2 == 0) {
			$(this).addClass('odd');
		}
	}
});


}


$(document).ready(function(){
	odd_even();

	$('.htabs a').click(function() {
		odd_even();
	});

	$('.vtabs a').click(function() {
		odd_even();
	});

});
</script>

</div>
<?php echo $footer; ?>
