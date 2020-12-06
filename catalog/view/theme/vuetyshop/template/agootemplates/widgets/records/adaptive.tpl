<?php if ($records) { ?>
<div id="cmswidget-<?php echo $cmswidget; ?>" class="cmswidget">
<?php echo $box_begin; ?>
   <div class="seocmspro_content blog-content">
			<?php if ($records) { ?>
			<div class="record_columns">
			<style>
			 .record_columns .column_width_<?php echo $cmswidget; ?> {
			 	width: <?php if (isset ($settings_widget['block_records_width']) && $settings_widget['block_records_width']!='' ) {
			 	 echo $settings['block_records_width'].'; padding-right: 5px;';
			 	} else {
			 	 echo '100%; min-width: 100%;';
			 	}
			 	?>
			 }
			</style>

	<?php foreach ($records as $record) { ?>
			<div class="content-records column_width_<?php echo $cmswidget; ?>">
					<div class="divider100 ascp_divider margintop2"></div>


                        <?php if (isset($settings_widget['title_status']) && $settings_widget['title_status'] && (!isset($settings_widget['title_status']) || $settings_widget['title_position']=='before')) { ?>
                        <div class="name marginbottom5">
						<h2 class="ascp-list-title-widget"><a href="<?php echo $record['href']; ?>" class="ascp-list-title-widget modal_<?php echo $cmswidget; ?> <?php if (isset($settings_widget['modal_status']) && $settings_widget['modal_status']) {
echo 'colorbox_modal';
 } ?>" data-cmswidget="<?php echo $cmswidget; ?>" data-template_modal="<?php
						 if (isset($settings_widget['template_modal']) && $settings_widget['template_modal']!='') {
							 	echo $settings_widget['template_modal'];
						 } else {
								echo '';
						 }
						?>"><?php echo $record['name']; ?></a></h2>
						</div>
						<?php } ?>


                   <?php if ((isset ($settings_widget['images_view']) && $settings_widget['images_view'])  ||
                   (isset($settings_widget['avatar_status']) && $settings_widget['avatar_status'])) { ?>
					<div class="image blog-image <?php if (isset($settings_widget['title_status']) && $settings_widget['title_status'] && (isset($settings_widget['title_position']) && $settings_widget['title_position']=='after')) { ?>  <?php } ?>">
					<?php if ($record['thumb'] && isset($settings_widget['avatar_status']) && $settings_widget['avatar_status']) { ?>
						<div class="image marginright2 marginbottom2 <?php if (isset($settings_widget['title_status']) && $settings_widget['title_status'] && (isset($settings_widget['images_position']) && $settings_widget['images_position']=='after')) { ?> blog-image <?php } ?>">
							<?php if (isset ($settings_widget['blog_small_colorbox']) && $settings_widget['blog_small_colorbox']) { ?>
							<a href="<?php echo $record['popup']; ?>" title="<?php echo $record['name']; ?>" class="imagebox" rel="imagebox">
								<img src="<?php echo $record['thumb']; ?>" class="img-responsive" title="<?php echo $record['name']; ?>" alt="<?php echo $record['name']; ?>" >
							</a>
							<?php } else { ?>
							<a href="<?php echo $record['href']; ?>" title="<?php echo $record['name']; ?>" class="modal_<?php echo $cmswidget; ?> <?php if (isset($settings_widget['modal_status']) && $settings_widget['modal_status']) {
echo 'colorbox_modal';
 } ?>" data-cmswidget="<?php echo $cmswidget; ?>" data-template_modal="<?php
						 if (isset($settings_widget['template_modal']) && $settings_widget['template_modal']!='') {
							 	echo $settings_widget['template_modal'];
						 } else {
								echo '';
						 }
						?>">
								<img src="<?php echo $record['thumb']; ?>" class="img-responsive" title="<?php echo $record['name']; ?>" alt="<?php echo $record['name']; ?>" />
							</a>
							<?php } ?>
						</div>
						<?php } ?>

						<?php if (isset ($settings_widget['images_view']) && $settings_widget['images_view'] ) { $number_hide = 1; ?>
   						<?php foreach ($record['images'] as $numi => $images) { ?>
						<div class="image blog-image blog-image-thumb <?php if (isset($settings_widget['images_number']) && isset($settings_widget['images_number_hide']) && $settings_widget['images_number_hide'] && $settings_widget['images_number']!='' && $number_hide > $settings_widget['images_number']  ) { ?> asc_displaynone  <?php } ?>">

							<div class="asc_gallery_min">
							<a class="imagebox" rel="imagebox" title="<?php echo $images['title']; ?>" href="<?php echo $images['popup']; ?>">
								<img class="img-responsive" alt="<?php echo $images['title']; ?>" title="<?php echo $images['title']; ?>" src="<?php echo $images['thumb']; ?>">

								<?php if (isset($settings_widget['images_number']) && isset($settings_widget['images_number_hide']) && $settings_widget['images_number_hide'] && $settings_widget['images_number']!='' && $number_hide == $settings_widget['images_number'] && (count($record['images'])-$number_hide)!=0 ) { ?>
								<div class="asc_gallery_more">
									<div>
										<div><?php echo "+".(count($record['images'])-$number_hide);  ?></div>
									</div>
								</div>
								<?php } ?>

                            </a>
                            </div>

						</div>
                        <?php $number_hide++; } ?>
						<?php } ?>

					</div>

                    <?php } ?>

                        <?php if (isset($settings_widget['title_status']) && $settings_widget['title_status'] && (isset($settings_widget['title_status']) && $settings_widget['title_position']=='after')) { ?>
                        <div class="name marginbottom5">
						<h2 class="ascp-list-title-widget"><a href="<?php echo $record['href']; ?>" class="ascp-list-title-widget modal_<?php echo $cmswidget; ?> <?php if (isset($settings_widget['modal_status']) && $settings_widget['modal_status']) {
echo 'colorbox_modal';
 } ?>" data-cmswidget="<?php echo $cmswidget; ?>" data-template_modal="<?php
						 if (isset($settings_widget['template_modal']) && $settings_widget['template_modal']!='') {
							 	echo $settings_widget['template_modal'];
						 } else {
								echo '';
						 }
						?>"><?php echo $record['name']; ?></a></h2>
						</div>
						<?php } ?>


                    <?php if (isset($settings_widget['description_status']) && $settings_widget['description_status'] ) { ?>
					<div class="description record_description"><?php echo $record['description']; ?>&nbsp;

					<?php if (!empty($record['attribute_groups'])) { ?>
					<div class="sc-attribute">
							<?php foreach ($record['attribute_groups'] as $attribute_group) { ?>
							<div class="sc_attribute_group_name"><?php echo $attribute_group['name']; ?></div>
								<?php foreach ($attribute_group['attribute'] as $attribute) { ?>
									<span class="sc_attribute_name"><?php echo $attribute['name']; ?></span>
									<span class="sc_attribute_text"><?php echo html_entity_decode($attribute['text'], ENT_QUOTES, 'UTF-8'); ?></span>
								<?php } ?>
							<?php } ?>
					</div>
					<?php } ?>


					<?php if (isset($settings_general['further']))
						echo str_replace('{URL}', $record['href'], str_replace('{TITLE}', $record['name'], $settings_general['further']));
					?>

						</div>
                    <?php } ?>

					<div class="divider100"></div>

					<?php
					if (
					(isset($settings_widget['author_status']) && $settings_widget['author_status'] &&  $record['author']!='') ||
                    (isset ($settings_widget['view_date']) && $settings_widget['view_date'] ) ||
                    (isset ($settings_widget['view_comments']) && $settings_widget['view_comments'] ) ||
                    (isset ($settings_widget['view_viewed']) && $settings_widget['view_viewed'] ) ||
                    (isset ($settings_widget['category_status']) && $settings_widget['category_status'] ) ||
                    (isset ($settings_widget['view_share']) && $settings_widget['view_share'] ) ||
                    (isset ($settings_widget['view_rating']) && $settings_widget['view_rating'] )
					)
					{ ?>
                    <div class="blog_bottom">
					       	<ul class="ascp_horizont ascp_list_info ul55">

									<?php  if ($userLogged)  { ?>
									<li>
										<a class="zametki" target="_blank" href="<?php echo $admin_path; ?>index.php?route=catalog/record/update&token=<?php echo $token; ?>&record_id=<?php echo $record['record_id']; ?>"><?php echo $language->get('text_edit');?></a>
									</li>
									<?php } ?>

									<?php if (isset ($settings_widget['view_date']) && $settings_widget['view_date'] ) { ?>
									<?php if ($record['date_available']) { ?>
									<li  class="blog-data-record">
									<?php echo $record['date_available']; ?>
									</li>
									<?php } ?>
									<?php } ?>


									<?php if (isset($settings_widget['author_status']) && $settings_widget['author_status'] &&  $record['author']!='') { ?>
									<li class="blog-author-record">
									<?php echo $text_author;?><?php echo $record['author']; ?>
									</li>
									<?php } ?>

									<?php if (isset ($settings_widget['view_comments']) && $settings_widget['view_comments'] ) { ?>
									<?php if ($record['settings_comment']['status']) { ?>
									<li  class="blog-comments-record">
									<?php echo $text_comments; ?> <?php echo $record['comments']; ?>
									</li>
									<?php } ?>
									<?php } ?>

									<?php if (isset ($settings_widget['view_viewed']) && $settings_widget['view_viewed'] ) { ?>
									<li class="blog-viewed-record">
									<?php echo $text_viewed; ?> <?php echo $record['viewed']; ?>
									</li>
									<?php } ?>


									<?php if (isset ($settings_widget['category_status']) && $settings_widget['category_status'] ) { ?>
									<li class="blog-category-record"><?php echo $language->get('text_category_record');?><a href="<?php echo $record['blog_href']; ?>"><?php echo $record['blog_name']; ?></a>
									</li>
									<?php } ?>

		                 </ul>

		                <ul class="ascp_horizont ascp_list_info ul45">

									<?php if (isset ($settings_widget['view_share']) && $settings_widget['view_share'] ) { ?>
									<li class="floatright">
										<?php
										  $in 	= Array('{TITLE}','{URL}','{DESCRIPTION}');
										  $out 	= Array($record['name'], $record['href'], strip_tags($record['description']));
										  $box_share = str_replace($in, $out, $box_share_list);
										  echo $box_share;
										?>
									</li>
									<?php } ?>

									<?php if (isset ($settings_widget['view_rating']) && $settings_widget['view_rating'] ) { ?>
									<?php if ($record['rating']) { ?>
										<?php if ($theme_stars) { ?>
										<li class="floatright">
											<img class="img-responsive" style="border: 0px;"  title="<?php echo $record['rating']; ?>" alt="<?php echo $record['rating']; ?>" src="catalog/view/theme/<?php echo $theme_stars; ?>/image/blogstars-<?php echo $record['rating']; ?>.png">
										</li>
										<?php } ?>
									<?php } ?>
									<?php } ?>

							</ul>
                    </div>
					<div class="divider100"></div>
		 		<?php } ?>
	</div>
	<?php } ?>


</div>

			<?php if (isset ($settings_widget['category_button']) && $settings_widget['category_button'] ) { ?>
			<?php
				reset($records);
				foreach ($records as $num => $record) {
				 $category[$record['blog_name']]= $record['blog_href'];
				}

			?>
			<div class="marginbottom5 textalignright">
				<?php foreach ($category as $name => $href) { ?>
				<div class="textcatbutton floatright marginleft5">
					<a href="<?php echo $href; ?>" class="button btn btn-primary"><?php echo $language->get('text_all_begin'); ?><?php echo utf8_strtolower($name); ?><?php echo $language->get('text_all_end'); ?></a>
				</div>
				<?php } ?>
			</div>
			<?php } ?>
           <div class="divider100"></div>



<?php if ((isset ($settings_widget['limit']) && $settings_widget['limit']) || (isset ($settings_widget['sort']) && $settings_widget['sort'])) { ?>
<div class="divider100 borderbottom2 margintop2"></div>
			<div class="record-filter textalignright margintop5">
		       <ul class="ascp_horizont">
				<?php if (isset ($settings_widget['limit']) && $settings_widget['limit'] ) { ?>
				<li>
					<b><?php echo $text_limit; ?></b>
					<select onchange="location = this.value;">
						<?php foreach ($limits as $limits) { ?>
						<?php if ($limits['value'] == $limit) { ?>
						<option value="<?php echo $limits['href']; ?>" selected="selected"><?php echo $limits['text']; ?></option>
						<?php } else { ?>
						<option value="<?php echo $limits['href']; ?>"><?php echo $limits['text']; ?></option>
						<?php } ?>
						<?php } ?>
					</select>
				</li>
				<?php } ?>
				<?php if (isset ($settings_widget['sort']) && $settings_widget['sort'] ) { ?>
				<li>
					<b><?php echo $text_sort; ?></b>
					<select onchange="location = this.value;">
						<?php foreach ($sorts as $sorts) { ?>
						<?php if ($sorts['value'] == $sort . '-' . $order) { ?>
						<option value="<?php echo $sorts['href']; ?>" selected="selected"><?php echo $sorts['text']; ?></option>
						<?php } else { ?>
						<option value="<?php echo $sorts['href']; ?>"><?php echo $sorts['text']; ?></option>
						<?php } ?>
						<?php } ?>
					</select>
				</li>
				<?php } ?>

				</ul>
			</div>
			<div class="divider100"></div>
<?php } ?>

            <?php if (isset ($settings_widget['pagination']) && $settings_widget['pagination'] ) { ?>
			<div class="pagination margintop5"><?php echo $pagination; ?></div>
            <?php } ?>

			<?php } ?>

		</div>
<?php if (isset($settings_widget['reserved']) && $settings_widget['reserved']!='') {
echo html_entity_decode($settings_widget['reserved'], ENT_QUOTES, 'UTF-8');
} ?>
<?php echo $box_end; ?>
</div>

<?php if (isset($settings_widget['reserved']) && $settings_widget['reserved']!='') {
	echo html_entity_decode($settings_widget['reserved'], ENT_QUOTES, 'UTF-8');
} ?>

<?php if (isset($settings_widget['anchor']) && $settings_widget['anchor']!='') { ?>
<script>
	<?php if (isset($settings_widget['doc_ready']) && $settings_widget['doc_ready']) { ?>
	$(document).ready(function(){
	<?php  } ?>
		var prefix = '<?php echo $prefix;?>';
		var cmswidget = '<?php echo $cmswidget; ?>';
		var heading_title = '<?php echo $heading_title; ?>';
	    var records = '<?php echo count($records); ?>';
	    var total = '<?php echo $total; ?>';
		var data = $('#cmswidget-<?php echo $cmswidget; ?>').html($('#cmswidget-<?php echo $cmswidget; ?>').clone());
		<?php echo $settings_widget['anchor']; ?>;
		delete records;
		delete total;
		delete data;
		delete prefix;
		delete cmswidget;
	<?php if (isset($settings_widget['doc_ready']) && $settings_widget['doc_ready']) { ?>
	});
	<?php  } ?>
</script>
<?php  } ?>

<?php } ?>