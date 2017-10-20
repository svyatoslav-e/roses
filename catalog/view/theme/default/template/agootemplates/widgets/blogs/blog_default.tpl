<div id="cmswidget-<?php echo $cmswidget; ?>" class="cmswidget">
<?php echo $box_begin; ?>
      <ul class="box-category nav nav-tabs nav-stacked">
<?php
if (count($categories_blogs) > 0) {
	if (!function_exists('buildTreeList')) {
		function buildTreeList($data, $del="") {
		?>
	  	        <ul class="nav nav-tabs nav-stacked padding_<?php echo $data[0]['level']; ?>">
		          <?php foreach ($data as $child) { ?>
		          <li>
		            <?php if ($child['act']) { ?>
		            <a href="<?php echo $child['href']; ?>" class="active">
					<?php if (isset($settings_widget['thumb_status']) && $settings_widget['thumb_status'] && $child['thumb']) { ?>
					   	<img src="<?php echo $child['thumb']; ?>" title="<?php echo $child['name']; ?>" alt="<?php echo $child['name']; ?>">
					<?php } ?>
		            <?php echo $del.$child['name']; ?></a>
		            <?php } else { ?>
		            <a href="<?php echo $child['href']; ?>">
					<?php if (isset($settings_widget['thumb_status']) && $settings_widget['thumb_status'] && $child['thumb']) { ?>
					   	<img src="<?php echo $child['thumb']; ?>" title="<?php echo $child['name']; ?>" alt="<?php echo $child['name']; ?>">
					<?php } ?>
		            <?php echo $del.$child['name']; ?></a>
		            <?php } ?>

		          <?php
		                  if (isset($child["children"]) && count($child["children"]) > 0) {
		            			buildTreeList($child["children"], $del); //recursive
					      }
		          ?>
		          </li>
		          <?php } ?>
		        </ul>
		<?php
		}
	}

	if (!function_exists('makeTreeRecursive')) {
		function makeTreeRecursive($d, $r = 0, $pk = 'parent_id', $k = 'blog_id', $c = 'children') {
		  $m = array();
		  foreach ($d as $e) {
			isset($m[$e[$pk]]) ? false : $m[$e[$pk]] = array();
			isset($m[$e[$k]]) ? false : $m[$e[$k]] = array();
		    $m[$e[$pk]][] = array_merge($e, array($c => &$m[$e[$k]]));
		  }
		  return $m[$r];
		}
	}
	$categories = makeTreeRecursive($categories_blogs);
?>
<?php
     foreach ($categories as $category) { ?>
      <li>
        <?php if ($category['act']) { ?>
        <a href="<?php echo $category['href']; ?>" class="active">
			<?php if (isset($settings_widget['thumb_status']) && $settings_widget['thumb_status'] && $category['thumb']) { ?>
			   	<img src="<?php echo $category['thumb']; ?>" title="<?php echo $category['name']; ?>" alt="<?php echo $category['name']; ?>">
			<?php } ?>
        <?php echo $category['name']; ?></a>
        <?php } else { ?>
        <a href="<?php echo $category['href']; ?>">
		<?php if (isset($settings_widget['thumb_status']) && $settings_widget['thumb_status'] && $category['thumb']) { ?>
		   	<img src="<?php echo $category['thumb']; ?>" title="<?php echo $category['name']; ?>" alt="<?php echo $category['name']; ?>">
		<?php } ?>
        <?php echo $category['name']; ?></a>
        <?php } ?>
        <?php if ($category['children']) { ?>
          <?php buildTreeList($category['children']);  ?>
        <?php } ?>
      </li>
      <?php }  } ?>
   	</ul>
<?php if (isset($settings_widget['reserved']) && $settings_widget['reserved']!='') {
echo html_entity_decode($settings_widget['reserved'], ENT_QUOTES, 'UTF-8');
} ?>
<?php echo $box_end; ?>
</div>
<style>
ul.box-category ul  {	border: none;
	padding: 0px;
}
.box-category > li > ul ul {
    padding: 0px;
    padding-left: 9px;
}
</style>

<?php if (isset($settings_widget['anchor']) && $settings_widget['anchor']!='') { ?>
<script>
	<?php if (isset($settings_widget['doc_ready']) && $settings_widget['doc_ready']) { ?>
	$(document).ready(function(){
	<?php  } ?>
	var prefix = '<?php echo $prefix;?>';
	var cmswidget = '<?php echo $cmswidget; ?>';
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