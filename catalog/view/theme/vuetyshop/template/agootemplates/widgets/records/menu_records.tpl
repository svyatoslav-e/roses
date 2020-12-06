<?php
if (count($records) > 0) {
?>
<ul id="cmswidget-<?php echo $cmswidget; ?>" style="display: none;" class="cmswidget">
<?php
//echo $box_begin;
?>
<?php
if (count($records) > 0) {
	$first_record = $records[0];
	foreach ($records as $record) {
?>
<li>

					<?php if ($record['thumb'] && isset($settings_widget['avatar_status']) && $settings_widget['avatar_status']) { ?>
						<div class="floatleft">
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
<a <?php if (!$record['active']) echo 'href="'.$record['href'].'"'; ?> class="<?php if ($record['active']) echo 'active'; if (!$record['active'])	echo 'pass'; ?>">
<?php echo $record['name'];?> <?php if ($record['settings_comment']['status']) { ?>
						<?php if (isset ($record['settings']['view_comments']) && $record['settings']['view_comments'] ) { ?>
						(<?php echo $record['comments']; ?>)
						<?php } ?>
						<?php } ?>
					</a>
						</li>
<?php
	}
}
?>
<?php
//echo $box_end;
?>
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
<?php  } ?>
<?php if (isset($settings_widget['reserved']) && $settings_widget['reserved']!='') {
echo html_entity_decode($settings_widget['reserved'], ENT_QUOTES, 'UTF-8');
} ?>
