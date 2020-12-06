<div id="cmswidget-<?php echo $cmswidget; ?>" class="cmswidget">
<?php echo $box_begin; ?>
<?php
	$document->addStyle('catalog/view/javascript/jquery/owl-carousel/owl.carousel.css');
	$document->addScript('catalog/view/javascript/jquery/owl-carousel/owl.carousel.min.js');
?>
<div id="slideshow<?php echo $cmswidget; ?>" class="owl-carousel" style="opacity: 1;" style="position: relative;">
 <?php foreach ($records as $record) {
	foreach ($record['images'] as $banner) { ?>
  <div class="item">

    <?php if ($banner['title'] && isset($settings_widget['title_status']) && $settings_widget['title_status']) { ?>
     <?php if ($banner['url']) { ?>
     <a href="<?php echo $banner['url']; ?>">
     <?php } ?>
     <div class="slideshow_title_<?php echo $cmswidget; ?>" style="position: absolute;">
      <?php echo $banner['title']; ?>
     </div>
     <?php if ($banner['url']) { ?>
     </a>
     <?php } ?>
    <?php } ?>

     <?php if ($banner['description'] && isset($settings_widget['description_status']) && $settings_widget['description_status']) { ?>
     <?php if ($banner['url']) { ?>
     <a href="<?php echo $banner['url']; ?>">
     <?php } ?>
     <div class="slideshow_description_<?php echo $cmswidget; ?>" style="position: absolute;">
      <?php echo $banner['description']; ?>
     </div>
     <?php if ($banner['url']) { ?>
     </a>
     <?php } ?>
     <?php } ?>


    <?php if ($banner['url']) { ?>
    <a href="<?php echo $banner['url']; ?>">
    <img src="<?php echo $banner['thumb']; ?>" alt="<?php echo $banner['title']; ?>" class="img-responsive" /></a>
    <?php } else { ?>
    <img src="<?php echo $banner['thumb']; ?>" alt="<?php echo $banner['title']; ?>" class="img-responsive" />
    <?php } ?>

  </div>
  <?php } ?>
  <?php } ?>
<?php if (isset($settings_widget['reserved']) && $settings_widget['reserved']!='') {
echo html_entity_decode($settings_widget['reserved'], ENT_QUOTES, 'UTF-8');
} ?>
<?php echo $box_end; ?>
</div>
<script type="text/javascript"><!--
$('#slideshow<?php echo $cmswidget; ?>').owlCarousel({
	items: 6,
	autoPlay: 3000,
	singleItem: true,
	navigation: true,
	navigationText: ['<i class="fa fa-chevron-left fa-5x"></i>', '<i class="fa fa-chevron-right fa-5x"></i>'],
	pagination: true
});
--></script>
</div>
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