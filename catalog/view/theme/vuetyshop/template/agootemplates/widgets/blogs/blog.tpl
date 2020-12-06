<div id="cmswidget-<?php echo $cmswidget; ?>" class="cmswidget">
<?php echo $box_begin; ?>
	  <div class="box-ul">
		<?php
		if (count($categories_blogs)>0) {
			foreach ($categories_blogs as $blogs) {				for ($i=0; $i<$blogs['flag_start']; $i++) {
		?>				<ul class="nav nav-stacked padding_<?php  echo $blogs['level'];?>" style="<?php if(!$blogs['display']) echo 'display:none;' ?>">
					<li><a href="<?php if($blogs['act']) echo $blogs['href']."#"; else echo $blogs['href']; ?>" class="<?php if($blogs['act']) echo 'active'; if(!$blogs['act']) echo 'pass'; ?>">
						<?php if (isset($settings_widget['thumb_status']) && $settings_widget['thumb_status'] && $blogs['thumb']) { ?>
			            	<img src="<?php echo $blogs['thumb']; ?>" title="<?php echo $blogs['name']; ?>" alt="<?php echo $blogs['name']; ?>">
						<?php } ?>
					<?php echo $blogs['name']; if ($blogs['count']>0 && isset($settings_widget['counting']) && $settings_widget['counting']) echo  " (".$blogs['count'].")"; ?></a>
				<?php
					for ($m=0; $m<$blogs['flag_end']; $m++) {
				?> 	</li>
				</ul>
		<?php
					}
				}
			}
		}
		?>
		</div>
<?php if (isset($settings_widget['reserved']) && $settings_widget['reserved']!='') {
echo html_entity_decode($settings_widget['reserved'], ENT_QUOTES, 'UTF-8');
} ?>
<?php echo $box_end; ?>
</div>

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