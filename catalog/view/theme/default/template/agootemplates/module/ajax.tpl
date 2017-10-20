<span id="ajaxwidget-<?php echo $cmswidget; ?>" class="cmswidget">
</span>
<script>
$.ajax({
   type: 'POST',
   url: '<?php echo $href_url;?>',
   data: { ajax_file: '<?php echo $ajax_file; ?>', sc_ajax: '3', cmswidget: '<?php echo $cmswidget; ?>' },
   dataType: 'html',
   beforeSend: function () {
    $('#ajaxwidget-<?php echo $cmswidget; ?>').html('Loading...<img src="catalog/view/theme/default/image/aloading16.png" alt="">');
  },
   success: function(msg_<?php echo $cmswidget; ?>){
    $('#ajaxwidget-<?php echo $cmswidget; ?>').replaceWith(msg_<?php echo $cmswidget; ?>);
  }
});
</script>