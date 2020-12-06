<?php if ($comment_status) { ?>
<div id="cmswidget-<?php echo $cmswidget; ?>" class="cmswidget">
<?php echo $box_begin; ?>
<div>
<?php
echo  html_entity_decode($mark_info['description'], ENT_QUOTES, 'UTF-8');
?>
</div>
	<div class="container_reviews" id="<?php echo $prefix;?>container_reviews_<?php echo $mark;?>_<?php echo $mark_id;?>">
		<noindex>
			<div class="container_reviews_vars acr<?php echo $cmswidget; ?>" style="display: none">
				<div class="mark" data-text="<?php echo $mark; ?>"></div>
				<div class="mark_id" data-text="<?php echo $mark_id; ?>"></div>
				<div class="theme" data-text="<?php echo $theme; ?>"></div>
				<div class="exec" data-text="<?php if (isset($settings_widget['handler']) && $settings_widget['handler']!='') { echo "$('#comment').comments(acr, acc);"; }  ?>"></div>
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
		<style>
		.<?php echo $prefix;?>voted {
		display: none;
		}
		</style>

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
				<label class="floatright">
				<input id="<?php echo $prefix;?>comments_signer" class="comments_signer" data-cmswidget="<?php echo $cmswidget; ?>" type="checkbox" <?php if (isset($signer_status) && $signer_status) echo 'checked'; ?>/>
				<a class="textdecoration_none comments_signer hrefajax" data-cmswidget="<?php echo $cmswidget; ?>">
				<?php echo $language->get('text_signer'); ?>
				</a>
				</label>
			</form>
		</div>
		<?php } ?>

<!--		<a class="textdecoration_none leavereview" href="<?php echo $href; ?>#<?php echo $prefix;?>comment-title"><ins class="hrefajax textdecoration_none"><?php echo $language->get('text_write_review'); ?>&nbsp;&darr;</ins></a> -->

		<div class="width100 overflowhidden lineheight1">&nbsp;</div>
		<div id="<?php echo $prefix;?>div_comment_<?php echo $mark_id; ?>" >
			<div id="<?php echo $prefix;?>comment_<?php echo $mark_id; ?>" >
				<?php  echo $html_comment; ?>
			</div>
			<div id="<?php echo $prefix;?>comment-title">
				<a href="#"  id="<?php echo $prefix;?>comment_id_reply_0" data-cmswidget="<?php echo $cmswidget; ?>" class="comment_reply comment_buttons form_reply">
				<ins id="<?php echo $prefix;?>reply_0" class="hrefajax text_write_review"><?php echo $language->get('text_write'); ?></ins>
				</a>
			</div>
			<div class="<?php echo $prefix;?>comment_work" id="<?php echo $prefix;?>comment_work_0"></div>
			<div id="<?php echo $prefix;?>reply_comments" style="display:none">
				<div id="<?php echo $prefix;?>comment_work_" class="<?php echo $prefix;?>form_customer_pointer width100 margintop10">
					<?php if (isset($customer_id) && !$customer_id)   { ?>
					<div id="form_customer_none" style="display:none;"></div>
					<div class="form_customer <?php echo $prefix;?>form_customer" id="<?php echo $prefix;?>form_customer" style="display:none;">
						<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
							<div class="form_customer_content">
								<a href="#" style="float: right;"  class="hrefajax"  onclick="$('.<?php echo $prefix;?>form_customer').hide(); return false;"><?php echo $language->get('hide_block'); ?></a>
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
								<a href="<?php echo $register; ?>" class="marginleft10"><?php echo $language->get('error_register'); ?></a>
								<?php if ($redirect) { ?>
								<input type="hidden" name="redirect" value="<?php echo $redirect; ?>#tabs" />
								<?php } ?>
							</div>
						</form>
					</div>
					<?php } ?>
					<form id="<?php echo $prefix;?>form_work_">
						<div class="seocmspro_customer_name width100 overflowhidden">
						  <?php if (isset($settings_widget['avatar_status']) && $settings_widget['avatar_status']) { ?>
						  <div class="seocmspro_load_avatar seocmspro_avatar"><img src="<?php echo $avatar_customer; ?>" style="width:<?php echo $avatar_width; ?>px ; height:<?php echo $avatar_height; ?>px ; "></div>
						  <?php } ?>
						<div class="seocmspro_author">
						<b><ins class="color_entry_name"><?php   echo $language->get('entry_name'); ?></ins></b>
						<br>
						<input type="text" name="name"  onblur="if (this.value==''){this.value='<?php echo $text_login; ?>'}" onfocus="if (this.value=='<?php echo $text_login; ?>') this.value='';"  value="<?php echo $text_login; ?>" <?php
							if (isset($customer_id) && $customer_id) {
							 //echo 'readonly="readonly" style="background-color:#DDD; color: #555;"';
							}
							?>>
						<?php
							if (isset($customer_id) && !$customer_id)   {
							 ?>
						<ins><a href="#" class="textdecoration_none hrefajax" data-cmswidget="<?php echo $cmswidget; ?>"><ins class="hrefajax customer_enter" data-cmswidget="<?php echo $cmswidget; ?>"><?php echo $language->get('text_customer_enter'); ?></ins></a>
						<?php echo $text_welcome; ?>
						</ins>
						<?php   }   ?>
                         </div>
						</div>
						<div class=" bordernone width100 overflowhidden margintop5 lineheight1"></div>

						<?php include(realpath(dirname(__FILE__)).'/../../module/fields.tpl'); ?>

						<?php  if (isset($settings_widget['comment_must']) && $settings_widget['comment_must'])   {   ?>
						<b><ins class="color_entry_name"><?php echo $language->get('entry_comment');  ?></ins></b>
						<span class="blog_require">*</span>

						<div class="ascp_bbode">
							<textarea name="text" id="<?php echo $prefix;?>editor_" class="blog-record-textarea <?php echo $prefix;?>editor blog-textarea_height"></textarea>
						</div>

                        <?php if (isset($settings_widget['help_view']) && $settings_widget['help_view']) { ?>
						<div class="help_text">
						<span class="text_note"><?php echo $language->get('text_note'); ?></span>
						</div>
						<?php  } ?>
						<?php  } ?>



						<div class="bordernone width100 overflowhidden margintop5 lineheight1"></div>
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
							<div  class="bordernone width100 overflowhidden lineheight1"></div>
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
						<div class="bordernone width100 overflowhidden margintop5 lineheight1"></div>
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
                		<b><?php echo $language->get('text_signer_answer'); ?></b>
                		</label><br>
						   <?php echo $language->get('text_signer_answer_email'); ?>
						   <input type="text" name="email_ghost" value="<?php if (isset($email_ghost) && $email_ghost!='') echo $email_ghost; ?>" />
						<?php } ?>
						<?php } ?>

					<?php if (SC_VERSION < 20) { ?>
						<div class="buttons">
							<div class="left"><a class="button button-comment" id="<?php echo $prefix;?>button-comment-0"><span><?php echo $language->get('button_write'); ?></span></a></div>
						</div>
					<?php } else { ?>

   				<div class="buttons">

                    <button type="button" id="<?php echo $prefix;?>button-comment-0" data-loading-text="" class="btn btn-primary button button-comment"><i class="fa fa-pencil-square-o"></i> <?php echo $language->get('button_write'); ?></button>

                </div>



					<?php } ?>


     					</form>
				</div>
			</div>
		</div>
		<?php } ?>
		<div class="overflowhidden">&nbsp;</div>
	</div>
<?php if (isset($settings_widget['reserved']) && $settings_widget['reserved']!='') {
echo html_entity_decode($settings_widget['reserved'], ENT_QUOTES, 'UTF-8');
} ?>

<?php echo $box_end; ?>
 </div>

<script>
<?php if (isset($settings_widget['doc_ready']) && $settings_widget['doc_ready']) { ?>
$(document).ready(function(){
<?php } ?>

 if (typeof(tab_selector)==='undefined') {
  tab_selector = '#tab-review';
 }

 var url = location.href, idx = url.indexOf("#")
  hash = idx != -1 ? url.substring(idx+1) : "";

			if (hash!='') {
				if ($('a[href=\''+tab_selector+'\']').length) {
				     offset_top_tab = $('a[href=\''+tab_selector+'\']').offset().top;
				} else {
				 	 offset_top_tab = '';
				}
			}

		<?php if (isset($settings_widget['anchor']) && $settings_widget['anchor']!='') { ?>
		    var prefix = '<?php echo $prefix;?>';
		    var cmswidget = '<?php echo $cmswidget; ?>';
			var heading_title = '<?php echo $heading_title; ?>';
			var data = $('#cmswidget-<?php echo $cmswidget; ?>').html($('#cmswidget-<?php echo $cmswidget; ?>').clone());

			if (hash!='') {
				if ($('a[href=\''+tab_selector+'\']').length) {
                    var offset_tmp = $('#cmswidget-<?php echo $cmswidget; ?>').offset().top;
                    if (typeof($('#'+hash).offset())!='undefined') {
				    	offset_top =  ($('#'+hash).offset().top) - offset_tmp;
				    } else {
				    	offset_top = 0;
				    }
				} else {
				 	 offset_top = '';
				}
			}


			<?php echo $settings_widget['anchor']; ?>;


			delete data;
			delete prefix;
			delete cmswidget;

	   <?php  } ?>



<?php if (isset($settings_widget['doc_ready']) && $settings_widget['doc_ready']) { ?>
});
<?php } ?>

$(document).ready(function(){
 //$('#<?php echo $prefix;?>comment_id_reply_0').click();
});

$(window).load(function() {

<?php
  if (isset($this->data['settings_general']['get_pagination']))
	$get_pagination = $this->data['settings_general']['get_pagination'];
  else
	$get_pagination = 'tracking';
?>

      if (hash!='') {
			$('a[href=\''+tab_selector+'\']').trigger('click');

			<?php if (isset($this->request->get[$get_pagination])) { ?>
				offset_top = 1;
			<?php  } ?>

			if (offset_top!='') {
		        $(tab_selector).show();
			    $('html, body').animate({scrollTop: offset_top+offset_top_tab }, 500, function() {
				});
			}

		}

});

</script>
<?php } ?>