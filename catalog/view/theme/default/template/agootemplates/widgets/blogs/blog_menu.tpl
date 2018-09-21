<ul id="cmswidget-<?php echo $cmswidget; ?>" style="display: none;" class="cmswidget">
<?php
//echo $box_begin;
?>
<?php
if (count($categories_blogs) > 0) {
	$blogs_first = $categories_blogs[0];
    $href_active = '';
	foreach ($categories_blogs as $blogs) {
		$childs = false;;
		foreach ($categories_blogs as $blogs_child) {
		  if ($blogs['blog_id'] == $blogs_child['parent_id']) {
		   $childs = true;
		  }
		}
		for ($i = 0; $i < $blogs['flag_start']; $i++) {

		if ($blogs['act']) {
			$href_active = $blogs['href'];
		}

?>
<li <?php if ($i >= $blogs['flag_end']) { echo 'class="dropdown"'; } ?>><a <?php if (!$blogs['act']) echo 'href="'.$blogs['href'].'"'; ?> <?php if ($i >= $blogs['flag_end']) { echo ''; } ?>  <?php if ($childs) { ?> data-toggle="dropdown" <?php } ?> class="<?php if ($childs) { echo 'dropdown-toggle'; } ?> <?php if ($blogs['act']) echo 'active'; if ($blogs['active'] == 'pass') echo 'sc_pass'; ?>">
<?php if (isset($settings_widget['thumb_status']) && $settings_widget['thumb_status'] && $blogs['thumb']) { ?>
   	<img src="<?php echo $blogs['thumb']; ?>" title="<?php echo $blogs['name']; ?>" alt="<?php echo $blogs['name']; ?>">
<?php } ?>
<?php echo $blogs['name'];?>
</a>
<?php if ($i >= $blogs['flag_end']) { ?>
<div class="dropdown-menu"><div class="dropdown-inner"><ul class="list-unstyled">
<?php } ?>
<?php  for ($m = 0; $m < $blogs['flag_end']; $m++) { ?>
<?php 		if ($blogs['flag_start'] <= $m) { ?>
</ul></div>

<a class="see-all" <?php if ($href_active != $blogs_first['href']) echo 'href="'.$blogs_first['href'].'"'; ?>><?php echo $language->get('text_all_begin'); ?><?php echo utf8_strtolower($blogs_first['name']); ?><?php echo $language->get('text_all_end'); ?></a>
</div>
<?php } ?>
</li>
<?php 	}
   	  }
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
	var data = $('#cmswidget-<?php echo $cmswidget; ?>');
	<?php echo $settings_widget['anchor']; ?>;
 	delete data;
	delete prefix;
	delete cmswidget;
	<?php if (isset($settings_widget['doc_ready']) && $settings_widget['doc_ready']) { ?>
	});
	<?php  } ?>
</script>
<?php  } ?>
<?php if (isset($settings_widget['reserved']) && $settings_widget['reserved']!='') {
echo html_entity_decode($settings_widget['reserved'], ENT_QUOTES, 'UTF-8');
} ?>
