 <table class="mynotable" style="margin-bottom:20px; background: white; vertical-align: center;">

	<tr>
	  <td><?php echo $language->get('entry_widget_status'); ?></td>
	  <td>
	  <div class="input-group"><select class="form-control" name="ascp_settings[avatar_widget_status]">
	      <?php if (isset($ascp_settings['avatar_widget_status']) && $ascp_settings['avatar_widget_status']) { ?>
	      <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
	      <option value="0"><?php echo $text_disabled; ?></option>
	      <?php } else { ?>
	      <option value="1"><?php echo $text_enabled; ?></option>
	      <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
	      <?php } ?>
	    </select></div></td>
	</tr>

  <tr>
     <td class="left" style="width: 220px;"><?php echo $language->get('entry_avatar_dimension'); ?></td>
     <td class="left">


				     <div class="sc_table">

				     <div class="input-group">
      <input type="text" class="form-control" name="ascp_settings[avatar_width]" value="<?php if (isset($ascp_settings['avatar_width'])) echo $ascp_settings['avatar_width']; ?>" size="3" />
				      </div>
				<div>
				x
				</div>
				      <div class="input-group">
      <input type="text" class="form-control" name="ascp_settings[avatar_height]" value="<?php if (isset($ascp_settings['avatar_width'])) echo $ascp_settings['avatar_height']; ?>" size="3" />
				      </div>

				      </div>


    </td>
    </tr>


    <tr>
      <td><?php echo $language->get('entry_avatar_default'); ?></td>
      <td valign="top"><div class="image form-group" data-toggle="image">
      <?php if (SC_VERSION > 15) { ?>
      <a href="" id="thumb-image" data-toggle="image" class="img-thumbnail">
       <?php } ?>
      <img src="<?php echo $avatar_default; ?>" alt="" id="thumb" data-placeholder="<?php echo $no_image; ?>"/>
      <?php if (SC_VERSION > 15) { ?>
      </a>
      <?php } ?>
        <input type="hidden" name="ascp_settings[avatar_default]" value="<?php  if (isset($ascp_settings['avatar_default'])) echo $ascp_settings['avatar_default']; ?>" id="image" />
        <br>
       <?php if (SC_VERSION < 20) { ?>
	      <a onclick="image_upload('image', 'thumb');"><?php echo $language->get('text_browse'); ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="$('#thumb').attr('src', '<?php echo $no_image; ?>'); $('#image').attr('value', '');"><?php echo $language->get('text_clear'); ?></a>
       <?php } ?>
        </div>

        </td>
    </tr>


    <tr>
      <td><?php echo $language->get('entry_avatar_admin'); ?></td>
      <td valign="top"><div class="image form-group" data-toggle="image">
      <?php if (SC_VERSION > 15) { ?>
      <a href="" id="thumb-admin" data-toggle="image" class="img-thumbnail">
       <?php } ?>
      <img src="<?php echo $avatar_admin; ?>" alt="" id="thumb_admin" data-placeholder="<?php echo $no_image; ?>" />
      <?php if (SC_VERSION > 15) { ?>
      </a>
      <?php } ?>
        <input type="hidden" name="ascp_settings[avatar_admin]" value="<?php  if (isset($ascp_settings['avatar_admin'])) echo $ascp_settings['avatar_admin']; ?>" id="image_admin" />
        <br>
       <?php if (SC_VERSION < 20) { ?>
	      <a onclick="image_upload('image_admin', 'thumb_admin');"><?php echo $language->get('text_browse'); ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="$('#thumb_admin').attr('src', '<?php echo $no_image; ?>'); $('#thumb_admin').attr('value', '');"><?php echo $language->get('text_clear'); ?></a>
       <?php } ?>
        </div>

        </td>
    </tr>


    <tr>
      <td><?php echo $language->get('entry_avatar_buyproduct'); ?></td>
      <td valign="top"><div class="image form-group" data-toggle="image">
      <?php if (SC_VERSION > 15) { ?>
      <a href="" id="thumb-buyproduct" data-toggle="image" class="img-thumbnail">
       <?php } ?>
      <img src="<?php echo $avatar_buyproduct; ?>" alt="" id="thumb_buyproduct" data-placeholder="<?php echo $no_image; ?>" />
      <?php if (SC_VERSION > 15) { ?>
      </a>
      <?php } ?>
        <input type="hidden" name="ascp_settings[avatar_buyproduct]" value="<?php  if (isset($ascp_settings['avatar_buyproduct'])) echo $ascp_settings['avatar_buyproduct']; ?>" id="image_buyproduct" />
        <br>
       <?php if (SC_VERSION < 20) { ?>
       <a onclick="image_upload('image_buyproduct', 'thumb_buyproduct');"><?php echo $language->get('text_browse'); ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="$('#thumb_buyproduct').attr('src', '<?php echo $no_image; ?>'); $('#image_buyproduct').attr('value', '');"><?php echo $language->get('text_clear'); ?></a></div></td>
        <?php } ?>
        </div>

        </td>
    </tr>


    <tr>
      <td><?php echo $language->get('entry_avatar_buy'); ?></td>
      <td valign="top"><div class="image form-group" data-toggle="image">
      <?php if (SC_VERSION > 15) { ?>
      <a href="" id="thumb-buy" data-toggle="image" class="img-thumbnail">
       <?php } ?>
      <img src="<?php echo $avatar_buy; ?>" alt="" id="thumb_buy" data-placeholder="<?php echo $no_image; ?>" />
      <?php if (SC_VERSION > 15) { ?>
      </a>
      <?php } ?>
         <input type="hidden" name="ascp_settings[avatar_buy]" value="<?php  if (isset($ascp_settings['avatar_buy'])) echo $ascp_settings['avatar_buy']; ?>" id="image_buy" />
       <br>
       <?php if (SC_VERSION < 20) { ?>
        <a onclick="image_upload('image_buy', 'thumb_buy');"><?php echo $language->get('text_browse'); ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="$('#thumb_buy').attr('src', '<?php echo $no_image; ?>'); $('#image_buy').attr('value', '');"><?php echo $language->get('text_clear'); ?></a></div></td>
        <?php } ?>
        </div>

        </td>
    </tr>


    <tr>
      <td><?php echo $language->get('entry_avatar_reg'); ?></td>
      <td valign="top"><div class="image form-group" data-toggle="image">
      <?php if (SC_VERSION > 15) { ?>
      <a href="" id="thumb-reg" data-toggle="image" class="img-thumbnail">
       <?php } ?>
      <img src="<?php echo $avatar_reg; ?>" alt="" id="thumb_reg" data-placeholder="<?php echo $no_image; ?>" />
      <?php if (SC_VERSION > 15) { ?>
      </a>
      <?php } ?>
         <input type="hidden" name="ascp_settings[avatar_reg]" value="<?php  if (isset($ascp_settings['avatar_reg'])) echo $ascp_settings['avatar_reg']; ?>" id="image_reg" />
       <br>
       <?php if (SC_VERSION < 20) { ?>
        <a onclick="image_upload('image_reg', 'thumb_reg');"><?php echo $language->get('text_browse'); ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="$('#thumb_reg').attr('src', '<?php echo $no_image; ?>'); $('#image_reg').attr('value', '');"><?php echo $language->get('text_clear'); ?></a></div></td>
        <?php } ?>
        </div>

        </td>
    </tr>
   </table>
