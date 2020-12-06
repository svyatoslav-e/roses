<?php
if (count($records) > 0) {
?>
<ul id="cmswidget-<?php echo $cmswidget; ?>" class="cmswidget">
	<?php
		// prepare categories
		foreach ($records as $num => $record) {
		 $cat[$record['blog_id']][$record['record_id']] = $record;
		}

		foreach ($cat as $cat_id => $rec_id) {
			$blog_info = $cat[$cat_id][key($rec_id)]['category'];
		  	$cat[$cat_id]['sort'] = $blog_info['sort_order'];
		  	$cat[$cat_id]['blog_info'] = $blog_info;
		}

		//sorting categories by order
		usort($cat, 'compareblogs');

		foreach ($cat as $cat_id => $rec_id) {
			$blog_info = $cat[$cat_id]['blog_info'];
			$blog_href = $cat[$cat_id][key($rec_id)]['blog_href'];
			$blog_link = $cat[$cat_id][key($rec_id)]['blog_href'];
		?>
           	<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="<?php echo $blog_link; ?>"><?php echo $blog_info['name']; ?></a>
				<div class="dropdown-menu">
					<div class="dropdown-inner">
					<ul class="list-unstyled">
						<?php
						if ($rec_id) {
		 					foreach ($rec_id as $nm => $record) {
								if ((string)$nm!='sort' && (string)$nm!='blog_info') {
							 ?>
							 <li>
								<a <?php if (!$record['active']) echo 'href="'.$record['href'].'"'; ?> class="blog-title  <?php if ($record['active']) echo 'active'; if (!$record['active'])	echo 'pass'; ?>"><?php echo $record['name']; ?></a>


			<div class="content-records column_width_<?php echo $cmswidget; ?>">

                        <?php if (isset($settings_widget['title_status']) && $settings_widget['title_status'] ) { ?>
                        <div class="name marginbottom5">
						<h2><a href="<?php echo $record['href']; ?>" class="ascp-list-title-widget modal_<?php echo $cmswidget; ?>"><?php echo $record['name']; ?></a></h2>
						</div>
						<?php } ?>


                   <?php if ((isset ($settings_widget['images_view']) && $settings_widget['images_view'])  || (isset($settings_widget['avatar_status']) && $settings_widget['avatar_status'])) { ?>
					<div class="image blog-image">
					<?php if ($record['thumb'] && isset($settings_widget['avatar_status']) && $settings_widget['avatar_status']) { ?>
						<div>
							<?php if (isset ($settings_widget['blog_small_colorbox']) && $settings_widget['blog_small_colorbox']) { ?>
							<a href="<?php echo $record['popup']; ?>" title="<?php echo $record['name']; ?>" class="imagebox" rel="imagebox">
								<img src="<?php echo $record['thumb']; ?>"  title="<?php echo $record['name']; ?>" alt="<?php echo $record['name']; ?>" >
							</a>
							<?php } else { ?>
							<a href="<?php echo $record['href']; ?>" title="<?php echo $record['name']; ?>" class="modal_<?php echo $cmswidget; ?>">
								<img src="<?php echo $record['thumb']; ?>" title="<?php echo $record['name']; ?>" alt="<?php echo $record['name']; ?>" />
							</a>
							<?php } ?>
						</div>
						<?php } ?>

						<?php if (isset ($settings_widget['images_view']) && $settings_widget['images_view'] ) { ?>
   						<?php foreach ($record['images'] as $numi => $images) { ?>
						<div class="image blog-image blog-image-thumb">
							<a class="imagebox" rel="imagebox" title="<?php echo $images['title']; ?>" href="<?php echo $images['popup']; ?>">
							<img alt="<?php echo $images['title']; ?>" title="<?php echo $images['title']; ?>" src="<?php echo $images['thumb']; ?>">
							</a>
						</div>
                        <?php } ?>
						<?php } ?>
					</div>
                    <?php } ?>

                    <?php if (isset ($settings_widget['description_status']) && $settings_widget['description_status'] ) { ?>
					<div class="description record_description"><?php echo $record['description']; ?>&nbsp;
					<?php if (isset($settings_general['further']))
						echo str_replace('{URL}', $record['href'], str_replace('{TITLE}', $record['name'], $settings_general['further']));
					?>
					</div>
                    <?php } ?>


                    <div class="blog_bottom">
					       	<ul class="ascp_horizont ascp_list_info ul55">
									<?php if (isset ($settings_widget['view_date']) && $settings_widget['view_date'] ) { ?>
									<?php if ($record['date_available']) { ?>
									<li  class="blog-data-record">
									<?php echo $record['date_available']; ?>
									</li>
									<?php } ?>
									<?php } ?>

									<?php if (isset ($settings_widget['author_status']) && $settings_widget['author_status'] &&  $record['author']!='') { ?>
									<li class="blog-author-record">
									<?php echo $text_author;?><?php echo $record['author']; ?>
									</li>
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

									<?php if (isset ($settings_widget['view_comments']) && $settings_widget['view_comments'] ) { ?>
									<?php if ($record['settings_comment']['status']) { ?>
									<li  class="blog-comments-record">
									<?php echo $text_comments; ?> <?php echo $record['comments']; ?>
									</li>
									<?php } ?>
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
											<img style="border: 0px;"  title="<?php echo $record['rating']; ?>" alt="<?php echo $record['rating']; ?>" src="catalog/view/theme/<?php echo $theme_stars; ?>/image/blogstars-<?php echo $record['rating']; ?>.png">
										</li>
										<?php } ?>
									<?php } ?>
									<?php } ?>

							</ul>
                    </div>

	</div>

							</li>
							<?php
							}
						}
						?>

					</ul>
				  </div>
		             <?php if (isset ($settings_widget['category_button']) && $settings_widget['category_button'] ) { ?>
		              	<a class="see-all" href="<?php echo $blog_link; ?>"><?php echo $language->get('text_all_begin'); ?><?php echo utf8_strtolower($blog_info['name']); ?><?php echo $language->get('text_all_end'); ?></a>
		             <?php } ?>

				</div>
				<?php }	?>
         	</li>
		<?php }	?>
</ul>

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
	var data = $('#cmswidget-<?php echo $cmswidget; ?>');
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

<?php
}
?>
<?php if (isset($settings_widget['reserved']) && $settings_widget['reserved']!='') {
echo html_entity_decode($settings_widget['reserved'], ENT_QUOTES, 'UTF-8');
} ?>