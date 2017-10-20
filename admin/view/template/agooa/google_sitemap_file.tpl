<script>

  $.ajax({
					url: '<?php echo $url_gen_sitemap; ?>',
					type: 'post',
					data:  {path: '<?php echo $path; ?>', token: '<?php echo $token; ?>'},
					dataType: 'html',
					beforeSend: function()
					{

                      $('#sitemap_loading').html('<?php echo $text_loading_generator; ?>');
                      $('#sitemap_loading').show();
                      $('.genbutton_').hide();

					},
					success: function(html) {
						if (html) {
							$('#sitemap_loading').html(html);
							$('.genbutton_').show();
							setTimeout(function(){ $('#sitemap_loading').html('').hide(); }, 3000);
						}

					}
	});

</script>