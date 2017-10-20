	<div style="width: 100%;">
		<a href="#" onclick="
				$.ajax({
					url: '<?php echo $url_script_reviews; ?>',
					dataType: 'html',
					type: 'POST',
					data: {
		                layout_route: 'record/record'
		            },
					beforeSend: function()
					{
		               $('#create_scripts').html('<?php echo $language->get('text_loading_main'); ?>');
					},
					success: function(json) {
						$('#create_scripts').html(json);
						//setTimeout('delayer()', 2000);
					},
					error: function(json) {
					$('#create_scripts').html('Error');
					}
				}); return false;" class="scenarybutton sc_button "  style="clear:both;">

		<div style=""><i class="<?php if (SC_VERSION < 20) { ?>glyphicon glyphicon-th-large<?php } else { ?>fa fa-bars<?php } ?>"></i>&nbsp;&nbsp;&nbsp;<?php echo $language->get('text_url_script_reviews_records'); ?></div>
		</a>
	</div>


	<div style="width: 100%;">
		<a href="#" onclick="
				$.ajax({
					url: '<?php echo $url_script_reviews; ?>',
					dataType: 'html',
					type: 'POST',
					data: {
		                layout_route: 'product/product'
		            },
					beforeSend: function()
					{
		               $('#create_scripts').html('<?php echo $language->get('text_loading_main'); ?>');
					},
					success: function(json) {
						$('#create_scripts').html(json);
						//setTimeout('delayer()', 2000);
					},
					error: function(json) {
					$('#create_scripts').html('Error');
					}
				}); return false;" class="scenarybutton sc_button"  style="clear:both;">
		<div style=""><i class="<?php if (SC_VERSION < 20) { ?>glyphicon glyphicon-th-list<?php } else { ?>fa fa fa-th<?php } ?>"></i>&nbsp;&nbsp;&nbsp;<?php echo $language->get('text_url_script_reviews_products'); ?></div>
		</a>
	</div>
