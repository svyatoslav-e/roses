<?php echo $header; ?>
<div class="container-fluid breadcrumb-wrapper">
	<div class="row">
		<div class="container">
			<ul class="breadcrumb">
				<?php foreach ($breadcrumbs as $breadcrumb) { ?>
				<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
				<?php } ?>
			</ul>
		</div>
	</div>
</div>
<div class="container">
	<div class="row">
			<!--<div class="breadcrumb">
			<span xmlns:v="http://rdf.data-vocabulary.org/#">
			<?php $i=0; foreach ($breadcrumbs as $breadcrumb) { $i++; ?>
			<span typeof="v:Breadcrumb">
			<?php echo $breadcrumb['separator']; ?><?php if (count($breadcrumbs)!= $i) { ?><a href="<?php echo $breadcrumb['href']; ?>" rel="v:url" property="v:title"><?php } else { ?><a href="<?php echo $breadcrumb['href']; ?>#" rel="v:url" property="v:title"><?php } ?><?php echo $breadcrumb['text']; ?></a>
			</span>
			<?php } ?>
			</span>
		</div>-->
<?php echo $column_left; ?>
<?if ($column_left) {?>
<? $class = 'col-xs-12 col-md-9'?>
<?}?>
<div id="content" class="<?=$class; ?>"><?php echo $content_top; ?>


		<!-- <h1 class="blog-heading_title-n"><?php echo $heading_title; ?></h1> -->

	    <div class="row">

			<?php if ($records) { ?>
			<div class="col-xs-12 item_news">
				<?php foreach ($records as $record) { ?>
				<div class="col-xs-12 col-md-6">
                   <div class="row">


					<?php if ($record['thumb']) { ?>

					<div class="col-xs-12">
						<div class="record_item">
							<a href="<?php echo $record['href']; ?>" title="<?php echo $record['name']; ?>">
								<img src="<?php echo $record['thumb']; ?>" title="<?php echo $record['name']; ?>" alt="<?php echo $record['name']; ?>" class="img-responsive"/>
							</a>
						
						</div>
					</div>
					 <div class="name col-xs-12">
						<h2 class="ascp-list-title"><a href="<?php echo $record['href']; ?>" class="ascp-list-title"><?php echo $record['name']; ?></a></h2>
                        <div class="description record_description"><?php echo $record['description']; ?>
                        </div>
                        <?php if (isset($settings_general['further']))
						echo str_replace('{URL}', $record['href'], str_replace('{TITLE}', $record['name'], $settings_general['further']));
					?>
						</div>
					

					<?php } ?>
                    <div class="blog_bottom col-xs-12">
					       	<ul class="ascp_horizont ascp_list_info ul55">

									<?php  if ($userLogged)  { ?>
									<li>
										<a class="zametki" target="_blank" href="<?php echo $admin_path; ?>index.php?route=catalog/record/update&token=<?php echo $token; ?>&record_id=<?php echo $record['record_id']; ?>"><?php echo $language->get('text_edit');?></a>
									</li>
									<?php } ?>

									<?php if (isset ($record['settings_blog']['view_date']) && $record['settings_blog']['view_date'] ) { ?>
									<?php if ($record['date_available']) { ?>
									<li  class="blog-data-record">
									<?php echo $record['date_available']; ?>
									</li>
									<?php } ?>
									<?php } ?>


									<?php if (isset ($record['settings_blog']['view_viewed']) && $record['settings_blog']['view_viewed'] ) { ?>
									<li class="blog-viewed-record">
									<?php echo $text_viewed; ?> <?php echo $record['viewed']; ?>
									</li>
									<?php } ?>

									<?php if (isset ($record['settings_blog']['category_status']) && $record['settings_blog']['category_status'] ) { ?>
									<li class="blog-category-record"><?php echo $language->get('text_category_record');?><a href="<?php echo $record['blog_href']; ?>"><?php echo $record['blog_name']; ?></a>
									</li>
									<?php } ?>

									<?php if (isset ($record['settings_blog']['author_status']) && $record['settings_blog']['author_status'] &&  $record['author']!='') { ?>
									<li class="blog-author-record"><?php echo $text_author;?><a href="<?php echo $record['author_search_link']; ?>"><?php echo $record['author']; ?></a>
									</li>
									<?php } ?>

									<?php if (isset ($record['settings_blog']['view_comments']) && $record['settings_blog']['view_comments'] ) { ?>
									<?php if ($record['settings_comment']['status']) { ?>
									<li  class="blog-comments-record">
									<?php echo $text_comments; ?> <?php echo $record['comments']; ?>
									</li>
									<?php } ?>
									<?php } ?>


		                 </ul>

		                <ul class="ascp_horizont ascp_list_info ul45">


									<?php if (isset ($record['settings_blog']['view_share']) && $record['settings_blog']['view_share'] ) { ?>
									<li class="floatright">
									<!-- <div class="share blog-share_container"> -->
										<?php
										  $in 	= Array('{TITLE}','{URL}','{DESCRIPTION}');
										  $out 	= Array($record['name'], $record['href'], strip_tags($record['description']));
										  $box_share = str_replace($in, $out, $box_share_list);
										  echo $box_share;
										?>
									<!-- </div> -->
									</li>
									<?php } ?>


									<?php if (isset ($record['settings_blog']['view_rating']) && $record['settings_blog']['view_rating'] ) { ?>
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
                </div>
	<?php } ?>
</div>


<?php if (isset ($settings_blog['block_records_width']) && $settings_blog['block_records_width']!='' && $settings_blog['block_records_width']!='100%') { ?>
	<div class="record-grid textalignright margintop5 floatleft">

			<a onclick="records_grid(); return false;" class="floatleft">
				<ins id="ascp_list" class="ascp_list_grid ascp_list"></ins>
			</a>
			<a onclick="records_grid('<?php echo $settings_blog['block_records_width'];?>'); return false;" class="floatleft marginleft5">

				<ins id="ascp_grid" class="ascp_list_grid ascp_grid_active"></ins>
			</a>

	</div>
<?php } ?>

			<?php if ((isset ($settings_blog['status_order']) && $settings_blog['status_order']) ||  (isset ($settings_blog['status_pagination']) && $settings_blog['status_pagination']) || (!isset ($settings_blog['status_pagination'])) ) { ?>

			<div class="col-xs-12">
		       <ul class="ascp_horizont">
				<?php if ((isset ($settings_blog['status_pagination']) && $settings_blog['status_pagination']) || (!isset ($settings_blog['status_pagination'])) ) { ?>
					<li>
						<b><?php echo $text_limit; ?></b>
						<select onchange="location = this.value;" class="form-control" >
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

                   <?php if (isset ($settings_blog['status_order']) && $settings_blog['status_order']) { ?>
					<li>
						<b><?php echo $text_sort; ?></b>
						<select onchange="location = this.value;" class="form-control" >
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

			<?php if ((isset ($settings_blog['status_pagination']) && $settings_blog['status_pagination']) || (!isset ($settings_blog['status_pagination'])) ) { ?>
				<?php if (isset($settings_blog['records_more']) && $settings_blog['records_more'] && $entry_records_more!='') { ?>
					<div id="records_more"><a onclick="records_more(); return false;" class="records_more button btn btn-primary"><?php echo $entry_records_more; ?></a></div>
				<?php } ?>
			<div class="pagination margintop5"><?php echo $pagination; ?></div>
			<?php } ?>

            <?php } ?>

			<?php } ?>


			<?php if ((isset($settings_blog['status_continue']) && $settings_blog['status_continue']) && (isset($categories) && !$categories) && (isset($records) && !$records)) { ?>
			<div class="content"><?php echo $text_empty; ?></div>
			<div class="buttons">
				<div class="right"><a href="<?php echo $continue; ?>" class="button"><span><?php echo $button_continue; ?></span></a></div>
			</div>
			<?php } ?>

    </div>
	<?php echo $content_bottom; ?>
 </div>
 	</div>
 	<?php echo $column_right; ?>
</div>

<?php echo $footer; ?>