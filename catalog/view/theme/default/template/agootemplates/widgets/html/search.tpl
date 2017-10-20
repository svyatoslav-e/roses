<div id="cmswidget-<?php echo $cmswidget; ?>" class="cmswidget">
	<?php echo $box_begin; ?>
	<div id="content_search" class="content_search">
       <!--
		<input type="text" name="filter_name" value="<?php echo $text_for_search; ?>" onclick="this.value = '';"  onkeydown="this.style.color = '000000'" class="form-control input-lg" style="margin-bottom: 5px;">
        -->
  	<div class="content_search input-group">
  		<input type="text" name="filter_name" value="<?php echo $text_for_search; ?>" placeholder="<?php echo $text_for_search; ?>" onclick="this.value = '';"  onkeydown="this.style.color = '000000'" class="form-control input-lg" />
  		<span class="input-group-btn">
    		<button type="button" id="button-search_blog" class="btn btn-default btn-lg button"><i class="fa fa-search"></i></button>
  		</span>
	</div>


        <div id="search_other" style="margin-top: 5px;">
		<select name="filter_blog_id" class="ascp_select_search">
			<option value="0"><?php echo $text_blog; ?></option>
			<?php  if (!empty($blogies)) {
				foreach ($blogies as $blog_1) {
			?>
			<?php if (isset($filter_blog_id) && $blog_1['blog_id'] == $filter_blog_id) { ?>
			<option value="<?php echo $blog_1['blog_id']; ?>" selected="selected"><?php echo $blog_1['name']; ?></option>
			<?php } else { ?>
			<option value="<?php echo $blog_1['blog_id']; ?>"><?php echo $blog_1['name']; ?></option>
			<?php } ?>
			<?php foreach ($blog_1['children'] as $blog_2) { ?>
			<?php if (isset($filter_blog_id) && $blog_2['blog_id'] == $filter_blog_id) { ?>
			<option value="<?php echo $blog_2['blog_id']; ?>" selected="selected">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $blog_2['name']; ?></option>
			<?php } else { ?>
			<option value="<?php echo $blog_2['blog_id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $blog_2['name']; ?></option>
			<?php } ?>
			<?php foreach ($blog_2['children'] as $blog_3) { ?>
			<?php if (isset($filter_blog_id) && $blog_3['blog_id'] == $filter_blog_id) { ?>
			<option value="<?php echo $blog_3['blog_id']; ?>" selected="selected">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $blog_3['name']; ?></option>
			<?php } else { ?>
			<option value="<?php echo $blog_3['blog_id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $blog_3['name']; ?></option>
			<?php } ?>
			<?php } ?>
			<?php } ?>
			<?php } ?>
			<?php } ?>
		</select>
		<br>
		<input type="checkbox" name="filter_sub_blog" value="1" id="sub_blog" checked="checked" />
		<label for="sub_blog"><?php echo $language->get('text_for_childcategory');?></label>
		<br>
		<input type="checkbox" name="filter_description" value="1" id="description" checked="checked" />
		<label for="description"><?php echo $language->get('text_for_desc');?></label>
		</div>

	</div>

	<!--
	<div class="buttons">
		<div class="left">
			<a id="button-search_blog" class="button btn btn-primary">
				<div><?php echo $language->get('text_for_search');?></div>
			</a>
		</div>
	</div>
	-->

	<script type="text/javascript">
		$('#content_search input[name=\'filter_name\']').keydown(function(e) {
			if (e.keyCode == 13) {
				$('#button-search_blog').trigger('click');
			}
		});

		$('#button-search_blog').bind('click', function() {
			var url = '<?php echo $blog_search["href"]; ?>';

			var filter_name = $('#content_search input[name=\'filter_name\']').prop('value');

			if (filter_name) {
				url += '&filter_name=' + encodeURIComponent(filter_name);
			}

			var filter_blog_id = $('#content_search select[name=\'filter_blog_id\']').prop('value');

			if (filter_blog_id > 0) {
				url += '&filter_blog_id=' + encodeURIComponent(filter_blog_id);
			}

			var filter_sub_blog = $('#content_search input[name=\'filter_sub_blog\']:checked').prop('value');

			if (filter_sub_blog) {
				url += '&filter_sub_blog=true';
			}

			var filter_description = $('#content_search input[name=\'filter_description\']:checked').prop('value');

			if (filter_description) {
				url += '&filter_description=true';
			}

			location = url;
		});

	</script>
	<?php echo $html; ?>
<?php if (isset($settings_widget['reserved']) && $settings_widget['reserved']!='') {
echo html_entity_decode($settings_widget['reserved'], ENT_QUOTES, 'UTF-8');
} ?>
	<?php echo $box_end; ?>
</div>
<?php if (isset($settings_widget['anchor']) && $settings_widget['anchor']!='') { ?>
<script>
	<?php if (isset($settings_widget['doc_ready']) && $settings_widget['doc_ready']) { ?>
	$(document).ready(function(){
	<?php  } ?>

		var prefix = '<?php echo $prefix;?>';
		var cmswidget = '<?php echo $cmswidget; ?>';
		var heading_title = '<?php echo $heading_title; ?>';
		var data = $('#cmswidget-<?php echo $cmswidget; ?>').html($('#cmswidget-<?php echo $cmswidget; ?>').clone());
		<?php echo $settings_widget['anchor']; ?>;
		delete data;
		delete prefix;
		delete cmswidget;

	<?php if (isset($settings_widget['doc_ready']) && $settings_widget['doc_ready']) { ?>
	});
	<?php  } ?>

</script>
<?php  } ?>