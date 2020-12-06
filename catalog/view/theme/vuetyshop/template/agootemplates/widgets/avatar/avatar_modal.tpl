<div id="cmswidget-<?php echo $cmswidget; ?>" class="cmswidget">
	<a href="#" onclick="modal_<?php echo $cmswidget; ?>(); return false;" id="avatar_menu" class="modal_<?php echo $cmswidget; ?>"><?php echo $language->get('url_avatar_text'); ?></a>
</div>

<script>
	<?php if (isset($settings_widget['doc_ready']) && $settings_widget['doc_ready']) { ?>
	$(document).ready(function(){
	<?php  } ?>

		var cmswidget = '<?php echo $cmswidget; ?>';
		var prefix = '<?php echo $prefix;?>';
		var data = $('#cmswidget-<?php echo $cmswidget; ?>').html($('#cmswidget-<?php echo $cmswidget; ?>').clone());

	    <?php if (isset($settings_widget['anchor']) && $settings_widget['anchor']!='') { ?>
		<?php echo $settings_widget['anchor']; ?>;
        <?php  } ?>

		avatarload = function() {

			 var url_str = '<?php echo $link; ?>'+'&sc_ajax=1';
			 $('.error').remove();
			 $('.success').remove();
			 $.ajax({
			            type: 'POST',
			            url: url_str,
			            data: {
			                cmswidget: '<?php echo $cmswidget; ?>',
			                layout_id: '<?php echo $layout_id; ?>',
			                url: '<?php echo $url; ?>',
			                sc_ajax: '1'
			            },
			            dataType: 'html',
			            async: 'false',
			            beforeSend: function () {
			              $('#avatar_widget-<?php echo $cmswidget; ?>').html('<?php echo $language->get('text_loading'); ?>...<img src="catalog/view/theme/default/image/aloading16.png" class="loading" style="padding-left: 5px;" />');
			            },
			            success: function (data) {

			                 $('#avatar_widget-<?php echo $cmswidget; ?>').html(data);
							 $('.seocmspro_load_avatar img').attr('src', $('#avatar-image img').attr('src') );
			            },
			            complete: function (data) {

			            }
			     });
			}


		delete data;
		delete prefix;
		delete cmswidget;

	<?php if (isset($settings_widget['doc_ready']) && $settings_widget['doc_ready']) { ?>
	});
	<?php  } ?>

</script>

<span style="display: none;">

<div id="avatar_widget-<?php echo $cmswidget; ?>">
<script>
<?php if (isset($settings_widget['doc_ready']) && $settings_widget['doc_ready']) { ?>
$(document).ready(function(){
<?php  } ?>

avatarload();

<?php if (isset($settings_widget['doc_ready']) && $settings_widget['doc_ready']) { ?>
	});
<?php  } ?>
</script>
</div>

</span>



<script>
<?php if (isset($settings_widget['doc_ready']) && $settings_widget['doc_ready']) { ?>
$(document).ready(function(){
<?php  } ?>
<?php echo $prefix;?>resize = function() {

var <?php echo $prefix;?>_height = $('#cboxLoadedContent').height();

var <?php echo $prefix;?>_width = $('#cboxLoadedContent').width();

var <?php echo $prefix;?>height_modal = $('#cboxLoadedContent > div').height();
var <?php echo $prefix;?>width_modal = $('#cboxLoadedContent > div').width();

 if (<?php echo $prefix;?>_height != <?php echo $prefix;?>height_modal  || <?php echo $prefix;?>_width != <?php echo $prefix;?>width_modal) {
    if (<?php echo $prefix;?>height_modal !=0 && <?php echo $prefix;?>_height!= null) {
    	if (<?php echo $prefix;?>width_modal !=0 && <?php echo $prefix;?>_width!= null) {
   			//alert(<?php echo $prefix;?>_height+' - '+ <?php echo $prefix;?>height_modal);
   			$("#cboxLoadedContent > div > div").css( { "margin" : "0", "padding" : "10px" } );
   			$(this).colorbox.resize();

   	}
   }
 }
}

modal_<?php echo $cmswidget; ?> = function() {

	$.colorbox.close();
	var my_avatar = $('#avatar_widget-<?php echo $cmswidget; ?>');
	var colorboxInterval;
	var colorboxtimeout;
	$.colorbox({
	 width: "auto",
	 height: "auto",
	 scrolling: true,
	 returnFocusOther: true,
	 reposition: false,
	 fixed: false,
	 maxHeight: "100%",
	 innerHeight: "100%",
	 opacity: 0.5,
	 onOpen: function(){
	 },
	 onLoad: function(){
	 },
     onComplete: function () {	    $('#colorbox').css('z-index','800');
	    $('#cboxOverlay').css('z-index','800');
	    $('#cboxOverlay').css('opacity','0.4');
	    $('#cboxWrapper').css('z-index','800');
        $("#cboxLoadedContent > div > div").css( { "margin" : "0", "padding" : "10px" } );
        $(this).colorbox.resize();
		colorboxInterval = setInterval( function() {
               <?php echo $prefix;?>resize()
			 }, 2000 );
        },

	 onClosed: function(){
			 clearInterval(colorboxtimeout);
	 },

	 title: "<?php echo $heading_title; ?>",
	 inline:true,
	 href: my_avatar

	 });

	 return false;

}

<?php if (isset($settings_widget['doc_ready']) && $settings_widget['doc_ready']) { ?>
	});
<?php  } ?>
</script>
<?php if (isset($settings_widget['reserved']) && $settings_widget['reserved']!='') {
echo html_entity_decode($settings_widget['reserved'], ENT_QUOTES, 'UTF-8');
} ?>

