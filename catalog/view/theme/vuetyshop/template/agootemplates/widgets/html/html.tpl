<?php if ((isset($html) && $html!='' )
			|| (isset($html_modal) && $html_modal!='')
			|| (isset($settings_widget['reserved']) && $settings_widget['reserved']!='')
			|| (isset($settings_widget['box_begin']) && $settings_widget['box_begin']!='')
			|| (isset($settings_widget['box_end']) && $settings_widget['box_end']!='')
		  ) { ?>
<div id="cmswidget-<?php echo $cmswidget; ?>" class="cmswidget">
	<?php echo $box_begin; ?>
	<?php if (isset($settings_widget['modal_status']) && $settings_widget['modal_status']) { ?>
	<a href="#" onclick="modal_html_<?php echo $cmswidget; ?>(); return false;" class="<?php if (isset($settings_widget['modal_a_class']) && $settings_widget['modal_a_class']!='') { echo $settings_widget['modal_a_class']; } ?>"><?php
    if (isset($html_modal) && $html_modal!='') {    	echo $html_modal;
    } else {
		echo $heading_title;
	}
	?></a>
	<?php } ?>
    <section id="cmswidget-section-<?php echo $cmswidget; ?>" <?php if (isset($settings_widget['modal_status']) && $settings_widget['modal_status']) { ?>style="display: none;"<?php } ?>>
		<?php echo $html; ?>
		<?php if (isset($settings_widget['reserved']) && $settings_widget['reserved']!='') {  echo html_entity_decode($settings_widget['reserved'], ENT_QUOTES, 'UTF-8'); } ?>
	</section>
	<?php echo $box_end; ?>
</div>

<?php if (isset($settings_widget['modal_status']) && $settings_widget['modal_status']) { ?>
<script>
modal_html_<?php echo $cmswidget; ?> = function() {
	<?php if ($imagebox == 'colorbox') { ?>

	$.colorbox.close();
	var html_<?php echo $cmswidget; ?> = $('#cmswidget-section-<?php echo $cmswidget; ?>');
	// var colorboxInterval;
	// var colorboxtimeout;

	$.colorbox({
<?php if (isset($settings_widget['modal_cb_width']) && $settings_widget['modal_cb_width']!='') { ?>
		 width: "<?php echo $settings_widget['modal_cb_width']; ?>",
<?php } ?>
<?php if (isset($settings_widget['modal_cb_height']) && $settings_widget['modal_cb_height']!='') { ?>
		 height: "<?php echo $settings_widget['modal_cb_height']; ?>",
<?php } ?>

<?php if (isset($settings_widget['modal_cb_maxwidth']) && $settings_widget['modal_cb_maxwidth']!='') { ?>
		 maxWidtht: "<?php echo $settings_widget['modal_cb_maxwidth']; ?>",
<?php } ?>
<?php if (isset($settings_widget['modal_cb_maxheight']) && $settings_widget['modal_cb_maxheight']!='') { ?>
		 maxHeight: "<?php echo $settings_widget['modal_cb_maxheight']; ?>",
<?php } ?>

<?php if (isset($settings_widget['modal_cb_innerwidth']) && $settings_widget['modal_cb_innerwidth']!='') { ?>
		 innerWidth: "<?php echo $settings_widget['modal_cb_innerwidth']; ?>",
<?php } ?>
<?php if (isset($settings_widget['modal_cb_innerheight']) && $settings_widget['modal_cb_innerheight']!='') { ?>
		 innerHeight: "<?php echo $settings_widget['modal_cb_innerheight']; ?>",
<?php } ?>

<?php if (isset($settings_widget['modal_cb_initialwidth']) && $settings_widget['modal_cb_initialwidth']!='') { ?>
		 initialWidth: "<?php echo $settings_widget['modal_cb_initialwidth']; ?>",
<?php } ?>
<?php if (isset($settings_widget['modal_cb_initialheight']) && $settings_widget['modal_cb_initialheight']!='') { ?>
		 initialHeight: "<?php echo $settings_widget['modal_cb_initialheight']; ?>",
<?php } ?>

<?php if (isset($settings_widget['modal_cb_opacity']) && $settings_widget['modal_cb_opacity']!='') { ?>
		 opacity: "<?php echo $settings_widget['modal_cb_opacity']; ?>",
<?php } ?>

<?php if (isset($settings_widget['modal_cb_scrolling']) && $settings_widget['modal_cb_scrolling']) { ?>
		 scrolling: true,
<?php } else { ?>
         scrolling: false,
<?php } ?>

<?php if (isset($settings_widget['modal_cb_reposition']) && $settings_widget['modal_cb_reposition']) { ?>
		 reposition: true,
<?php } else { ?>
         reposition: false,
<?php } ?>

<?php if (isset($settings_widget['modal_cb_fixed']) && $settings_widget['modal_cb_fixed']) { ?>
		 fixed: true,
<?php } else { ?>
         fixed: false,
<?php } ?>

		 onOpen: function(){
		 },
		 onLoad: function(){		 	html_<?php echo $cmswidget; ?>.show();		 },
	     onComplete: function () {

<?php if (isset($settings_widget['modal_cb_resize']) && $settings_widget['modal_cb_resize']) { ?>
		 $(this).colorbox.resize();
<?php } ?>
			// colorboxInterval = setInterval( function() { }, 2000 );
	        },
		 onClosed: function(){
			// clearInterval(colorboxtimeout);
			html_<?php echo $cmswidget; ?>.hide();
		 },

<?php if (isset($settings_widget['modal_cb_title']) && $settings_widget['modal_cb_title']) { ?>
		 title: "<?php echo $heading_title; ?>",
<?php } ?>

		 inline: true,
		 href: html_<?php echo $cmswidget; ?>
	 });

	 return false;
    <?php } ?>
}
</script>
<?php } ?>


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
<?php } ?>