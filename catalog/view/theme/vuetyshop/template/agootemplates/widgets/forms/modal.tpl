<?php if ($comment_status) { ?>
<div id="cmswidget-<?php echo $cmswidget; ?>" class="cmswidget">
<?php echo $box_begin; ?>
	<?php if (isset($settings_widget['modal_status']) && $settings_widget['modal_status']) { ?>
	<a href="#" onclick="modal_html_<?php echo $cmswidget; ?>(); return false;" class="<?php if (isset($settings_widget['modal_a_class']) && $settings_widget['modal_a_class']!='') { echo $settings_widget['modal_a_class']; } ?>"><?php
    if (isset($html_modal) && $html_modal!='') {
    	echo $html_modal;
    } else {
		echo $heading_title;
	}
	?></a>
	<?php } ?>
<?php if (isset($settings_widget['reserved']) && $settings_widget['reserved']!='') {
echo html_entity_decode($settings_widget['reserved'], ENT_QUOTES, 'UTF-8');
} ?>
<?php echo $box_end; ?>
</div>

<div style="display:none;">
	<div id="<?php echo $prefix;?>icomments_<?php echo $mark_id; ?>" class="cmswidget">
		<div>
			<div class="container_reviews" id="<?php echo $prefix;?>container_reviews_<?php echo $mark;?>_<?php echo $mark_id;?>">
		<noindex>
			<div class="container_reviews_vars acr<?php echo $cmswidget; ?>" style="display: none">
				<div class="mark" data-text="<?php echo $mark; ?>"></div>
				<div class="mark_id" data-text="<?php echo $mark_id; ?>"></div>
				<div class="theme" data-text="<?php echo $theme; ?>"></div>
				<div class="exec" data-text="<?php if (isset($settings_widget['handler']) && $settings_widget['handler']!='') { echo $settings_widget['handler']; }  ?>"></div>
				<div class="visual_editor" data-text="<?php echo $visual_editor; ?>"></div>
				<div class="ascp_widgets_position" data-text="<?php echo $ascp_widgets_position;?>"></div>
				<div class="thislist" data-text="<?php echo base64_encode(serialize($thislist)); ?>"></div>
				<div class="text_wait" data-text="<?php echo $text_wait; ?>"></div>
				<div class="visual_rating" data-text="<?php echo $settings_widget['visual_rating']; ?>"></div>
				<div class="signer" data-text="<?php echo $settings_widget['signer']; ?>"></div>
				<div class="imagebox" data-text="<?php echo $imagebox; ?>"></div>
				<div class="prefix" data-text="<?php echo $prefix;?>"></div>
			</div>
  		</noindex>

				<?php  { ?>
				<?php if (isset($settings_widget['visual_editor']) && $settings_widget['visual_editor']) { ?>
				<script>
					if (typeof WBBLANG !=="undefined"){
					CURLANG = WBBLANG['<?php echo $lang_code;?>'] || WBBLANG['en'] || CURLANG;
					}
				</script>
				<?php } ?>
				<?php if (isset($settings_widget['signer']) && $settings_widget['signer']) { ?>
		<div id="<?php echo $prefix;?>record_signer" class="floatright width70 textright" style="position:relative;">
			<div id="<?php echo $prefix;?>js_signer"  class="width100 zindex11000 textleft" style="display:none; position: absolute;"></div>
					<form id="<?php echo $prefix;?>form_signer">
						<label>
						<input id="<?php echo $prefix;?>comments_signer" data-cmswidget="<?php echo $cmswidget; ?>" class="comments_signer" type="checkbox" <?php if (isset($signer_status) && $signer_status) echo 'checked'; ?>/>
						<a class="textdecoration_none comments_signer hrefajax" data-cmswidget="<?php echo $cmswidget; ?>">
						<?php echo $language->get('text_signer'); ?>
						</a>
						</label>
					</form>
				</div>
		<div class="width100 overflowhidden lineheight1">&nbsp;</div>
				<?php } ?>

				<div id="<?php echo $prefix;?>div_comment_<?php echo $mark_id; ?>" class="<?php if ($record['sdescription']!='') {?>floatleft width50<?php } ?>" >
					<div id="<?php echo $prefix;?>comment_<?php echo $mark_id; ?>" >
						<?php  echo $html_comment; ?>
					</div>
					<div id="<?php echo $prefix;?>comment-title" style="display:none;">
						<a href="#"  id="<?php echo $prefix;?>comment_id_reply_0" data-cmswidget="<?php echo $cmswidget; ?>" class="comment_reply comment_buttons"></a>
					</div>
					<div class="<?php echo $prefix;?>comment_work" id="<?php echo $prefix;?>comment_work_0"></div>
					<div id="<?php echo $prefix;?>reply_comments" style="display:none">
						<div id="<?php echo $prefix;?>comment_work_" class="<?php echo $prefix;?>form_customer_pointer width100">
							<?php if (isset($customer_id) && !$customer_id)   { ?>
							<div id="form_customer_none" style="display:none;"></div>
							<div class="form_customer <?php echo $prefix;?>form_customer" id="<?php echo $prefix;?>form_customer" style="display:none;">
								<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
									<div class="form_customer_content">
										<a href="#" style="float: right;"  class="hrefajax"  onclick="$('.<?php echo $prefix;?>form_customer').hide(); return false;"><?php echo $hide_block; ?></a>
										<!-- <p><?php echo $text_i_am_returning_customer; ?></p> -->
										<b><?php echo $entry_email; ?></b><br />
										<input type="text" name="email" value="<?php echo $email; ?>" />
										<br />
										<br />
										<b><?php echo $entry_password; ?></b><br />
										<input type="password" name="password" value="<?php echo $password; ?>" />
										<br />
										<a href="<?php echo $forgotten; ?>"><?php echo $text_forgotten; ?></a><br />
										<br />
										<input type="submit" value="<?php echo $button_login; ?>" class="button btn btn-primary" />
										<a href="<?php echo $register; ?>" class="marginleft10"><?php echo $error_register; ?></a>
										<?php if ($redirect) { ?>
										<input type="hidden" name="redirect" value="<?php echo $redirect; ?>#tabs" />
										<?php } ?>
									</div>
								</form>
							</div>
							<?php } ?>
							<form id="<?php echo $prefix;?>form_work_">

								<div class="seocmspro_customer_name width100 overflowhidden" <?php  if (isset($settings_widget['name_status']) && !$settings_widget['name_status'])   {   ?>style="display: none;"<?php } ?>>
								  <?php if (isset($settings_widget['avatar_status']) && $settings_widget['avatar_status']) { ?>
								  <div class="seocmspro_load_avatar seocmspro_avatar"><img src="<?php echo $avatar_customer; ?>" style="width:<?php echo $avatar_width; ?>px ; height:<?php echo $avatar_height; ?>px ; "></div>
								  <?php } ?>
								<div class="seocmspro_author" <?php  if (isset($settings_widget['name_status']) && !$settings_widget['name_status'])   {   ?>style="display: none;"<?php } ?>>
								<b><ins class="color_entry_name"><?php   echo $entry_name; ?></ins></b>
								<br>
								<input type="text" name="name"  onblur="if (this.value==''){this.value='<?php echo $text_login; ?>'}" onfocus="if (this.value=='<?php echo $text_login; ?>') this.value='';"  value="<?php echo $text_login; ?>" <?php
									if (isset($customer_id) && $customer_id) {
									 //echo 'readonly="readonly" style="background-color:#DDD; color: #555;"';
									}
									?>>

								<?php  if (isset($customer_id) && !$customer_id)   { ?>
								<div><a href="#" class="textdecoration_none hrefajax" data-cmswidget="<?php echo $cmswidget; ?>"><ins class="hrefajax customer_enter" data-cmswidget="<?php echo $cmswidget; ?>"><?php echo $text_customer_enter; ?></ins></a>
								<?php echo $text_welcome; ?>
								</div>
								<?php } ?>

		                         </div>
								</div>

								<?php include(realpath(dirname(__FILE__)).'/../../module/fields.tpl'); ?>

								<?php  if (isset($settings_widget['comment_must']) && $settings_widget['comment_must'])   {   ?>
								<b><ins class="color_entry_name"><?php echo $language->get('entry_comment');  ?></ins></b>
								<span class="blog_require">*</span>
								<br>
								<textarea name="text" id="<?php echo $prefix;?>editor_" class="blog-record-textarea <?php echo $prefix;?>editor blog-textarea_height" cols="40"></textarea>
		                        <?php if (isset($settings_widget['help_view']) && $settings_widget['help_view']) { ?>
								<div class="help_text">
								<span class="text_note"><?php echo $language->get('text_note'); ?></span>
								</div>
								<?php  } ?>
								<?php  } ?>
								<div class="bordernone overflowhidden width100  margintop5 lineheight1"></div>
								<?php if (isset($settings_widget['rating']) && $settings_widget['rating']) { ?>
								<b><ins class="color_entry_name"><?php echo $language->get('entry_rating_review'); ?></ins></b>&nbsp;&nbsp;
								<?php if (isset($settings_widget['visual_rating']) && $settings_widget['visual_rating']) { ?>
								<div style="height: 25px;">
									<input type="radio" class="visual_star" name="rating" alt="#8c0000" title="<?php echo $language->get('entry_bad'); ?> 1" value="1" >
									<input type="radio" class="visual_star" name="rating" alt="#8c4500" title="<?php echo $language->get('entry_bad'); ?> 2" value="2" >
									<input type="radio" class="visual_star" name="rating" alt="#b6b300" title="<?php echo $language->get('entry_bad'); ?> 3" value="3" >
									<input type="radio" class="visual_star" name="rating" alt="#698c00" title="<?php echo $language->get('entry_good'); ?> 4" value="4" >
									<input type="radio" class="visual_star" name="rating" alt="#008c00" title="<?php echo $language->get('entry_good'); ?> 5" value="5" >
									<div class="floatleft"  style="padding-top: 5px; "><b><ins class="color_entry_name marginleft10"><span id="hover-test" ></span></ins></b></div>
									<div  class="bordernone overflowhidden width100  lineheight1"></div>
								</div>
								<?php } else { ?>
								<span><ins class="color_bad"><?php echo $language->get('entry_bad'); ?></ins></span>&nbsp;
								<input type="radio"  name="rating" value="1" >
								<ins class="blog-ins_rating" style="">1</ins>
								<input type="radio"  name="rating" value="2" >
								<ins class="blog-ins_rating" >2</ins>
								<input type="radio"  name="rating" value="3" >
								<ins class="blog-ins_rating" >3</ins>
								<input type="radio"  name="rating" value="4" >
								<ins class="blog-ins_rating" >4</ins>
								<input type="radio"  name="rating" value="5" >
								<ins class="blog-ins_rating" >5</ins>
								&nbsp;&nbsp; <span><ins  class="color_good"><?php echo $language->get('entry_good'); ?></ins></span>
								<?php } ?>
								<?php } else {?>
								<input type="radio" name="rating" value="5" checked style="display:none;">
								<?php } ?>
								<div class="bordernone overflowhidden width100  margintop5 lineheight1"></div>
								<?php if ($captcha_status) { ?>
								<?php if (isset($settings_widget['help_view']) && $settings_widget['help_view']) { ?>
								<div class="ascp_captcha_title help_text"><?php echo $language->get('entry_captcha_title'); ?>&nbsp;&darr;</div>
								<div class="ascp_entry_captcha help_text"><?php echo $language->get('entry_captcha'); ?></div>
		                        <?php  } ?>
								<div class="captcha_status"></div>
								<?php  } ?>


								<?php if (isset($settings_widget['signer_answer']) && $settings_widget['signer_answer']) { ?>
		                          <?php if (isset($customer_id) && $customer_id) { ?>
									<label>
									<input id="signer_answer" name="signer_answer" data-cmswidget="<?php echo $cmswidget; ?>" type="checkbox" checked/>
									<a class="textdecoration_none hrefajax" data-cmswidget="<?php echo $cmswidget; ?>">
									<?php echo $language->get('text_signer_answer'); ?>
									</a>
									</label>
		                		<?php } else { ?>
		                		<label>
		                		<?php echo $language->get('text_signer_answer'); ?>
		                		</label><br>
								   <?php echo $language->get('text_signer_answer_email'); ?>
								   <input type="text" name="email_ghost" value="<?php if (isset($email_ghost) && $email_ghost!='') echo $email_ghost; ?>" />
								<?php } ?>
								<?php } ?>

								<div class="buttons">
									<div class="left"><a class="button button-comment btn btn-primary" id="<?php echo $prefix;?>button-comment-0"><i class="fa fa-pencil-square-o"></i> <?php echo $language->get('button_write'); ?></a></div>
								</div>
							</form>
						</div>
					</div>
				</div>

				<?php if (isset($record['sdescription']) && $record['sdescription']!='') { ?>
				<div class="tel_description floatleft width50">
					<?php echo html_entity_decode($record['sdescription'], ENT_QUOTES, 'UTF-8'); ?>
				</div>
				<?php }	?>

				<?php } ?>
				<div class="overflowhidden clearboth lineheight1">&nbsp;</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">

<?php echo $prefix;?>resize = function() {

var <?php echo $prefix;?>_height = $('#cboxLoadedContent').height();

var <?php echo $prefix;?>_width = $('#cboxLoadedContent').width();

var <?php echo $prefix;?>height_modal = $('#cboxLoadedContent > div').height();
var <?php echo $prefix;?>width_modal = $('#cboxLoadedContent > div').width();

 if (<?php echo $prefix;?>_height != <?php echo $prefix;?>height_modal  || <?php echo $prefix;?>_width != <?php echo $prefix;?>width_modal) {
    if (<?php echo $prefix;?>height_modal !=0 && <?php echo $prefix;?>_height!= null) {
    	if (<?php echo $prefix;?>width_modal !=0 && <?php echo $prefix;?>_width!= null) {
   			$("#cboxLoadedContent > div > div").css( { "margin" : "10px", "padding" : "20px" } );
   			$(this).colorbox.resize();
   	}
   }
 }
}

modal_html_<?php echo $cmswidget; ?> = function() {
	$('#<?php echo $prefix;?>comment_id_reply_0').click();
	<?php if ($imagebox=='colorbox') { ?>

	$.colorbox.close();
	var my_form = $('#<?php echo $prefix;?>icomments_<?php echo $mark_id; ?>');
	var colorboxInterval;
	var colorboxtimeout;

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
	 onLoad: function(){
	 },
     onComplete: function () {
	    $('#colorbox').css('z-index','800');
	    $('#cboxOverlay').css('z-index','800');
	    $('#cboxOverlay').css('opacity','0.4');
	    $('#cboxWrapper').css('z-index','800');
        $("#cboxLoadedContent > div > div").css( { "margin" : "10px", "padding" : "20px" } );

<?php if (isset($settings_widget['modal_cb_resize']) && $settings_widget['modal_cb_resize']) { ?>
		$(this).colorbox.resize();
		colorboxInterval = setInterval( function() {
               <?php echo $prefix;?>resize()
			 }, 2000 );
<?php } ?>

        },
	 onClosed: function(){
<?php if (isset($settings_widget['modal_cb_resize']) && $settings_widget['modal_cb_resize']) { ?>
		clearInterval(colorboxtimeout);
<?php } ?>

	 },
<?php if (isset($settings_widget['modal_cb_title']) && $settings_widget['modal_cb_title']) { ?>
		 title: "<?php echo $heading_title; ?>",
<?php } ?>
	 inline:true,
	 href: my_form

	 });

	 return false;

    <?php } ?>
}


<?php if (isset($settings_widget['anchor']) && $settings_widget['anchor']!='') { ?>
<?php if (isset($settings_widget['doc_ready']) && $settings_widget['doc_ready']) { ?>
$(document).ready(function(){
<?php } ?>

		    var prefix = '<?php echo $prefix;?>';
            var cmswidget = '<?php echo $cmswidget; ?>';
			var heading_title = '<?php echo $heading_title; ?>';
			var total = '<?php echo $comment_total; ?>';

			<?php  if (isset($mark_info['url'])) { ?>
			var name = '<?php echo str_replace("'", "", $mark_info['name']); ?>';
			var url = '<?php echo $mark_info['url']; ?>';
			<?php } ?>

			<?php  if (isset($mark_info['product_info']['url'])) { ?>
			var product_name = '<?php echo str_replace("'", "", $mark_info['product_info']['name']); ?>';
			var product_url = '<?php echo $mark_info['product_info']['url']; ?>';
			<?php } ?>


			var data = $('#cmswidget-<?php echo $cmswidget; ?>').html($('#cmswidget-<?php echo $cmswidget; ?>').clone());
			<?php echo $settings_widget['anchor']; ?>;

			delete data;
			delete prefix;
			delete cmswidget;
			delete total;

			<?php  if (isset($mark_info['product_info']['url'])) { ?>
			delete product_name;
			delete product_url;
			<?php } ?>

			<?php  if (isset($mark_info['url'])) { ?>
			delete name;
			delete url;
			<?php } ?>

<?php if (isset($settings_widget['doc_ready']) && $settings_widget['doc_ready']) { ?>
});
<?php } ?>
<?php } ?>
</script>


<style>
	#colorbox, #cboxOverlay, #cboxWrapper {
	z-index: 800;
	}
</style>
<?php } ?>