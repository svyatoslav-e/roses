<table class="mynotable" style="margin-bottom:20px; background: white; vertical-align: center;">

	<tr>
	  <td><?php echo $language->get('entry_widget_status'); ?></td>
	  <td>
	  <div class="input-group"><select class="form-control" name="ascp_settings[latest_widget_status]">
	      <?php if (isset($ascp_settings['latest_widget_status']) && $ascp_settings['latest_widget_status']) { ?>
	      <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
	      <option value="0"><?php echo $text_disabled; ?></option>
	      <?php } else { ?>
	      <option value="1"><?php echo $text_enabled; ?></option>
	      <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
	      <?php } ?>
	    </select></div></td>
	</tr>



				          <tr>
				              <td style="width: 220px;"><?php echo $language->get('entry_cache_pages'); ?></td>
				              <td>
				              <div class="input-group">
					              <select class="form-control" name="ascp_settings[cache_pages]">
					                  <?php if (isset($ascp_settings['cache_pages']) && $ascp_settings['cache_pages']) { ?>
					                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
					                  <option value="0"><?php echo $text_disabled; ?></option>
					                  <?php } else { ?>
					                  <option value="1"><?php echo $text_enabled; ?></option>
					                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
					                  <?php } ?>
					               </select>
				                </div>
				                </td>
				            </tr>


				          <tr>
				            <td><?php echo $language->get('entry_blog_search'); ?>

				            <?php
				            if (!empty($categories) && (!isset($ascp_settings['blog_search']) || $ascp_settings['blog_search']==0))  {
                              $end_categories = end($categories);
                              $ascp_settings['blog_search'] = $end_categories['blog_id'];
							}
				            ?>

				            </td>
				            <td>
				            <div class="input-group">
				            <select class="form-control" name="ascp_settings[blog_search]">
				             	<option value="0"></option>

							<?php foreach ($categories as $cat) { ?>
				              	<option value="<?php echo $cat['blog_id']; ?>" <?php if (isset($ascp_settings['blog_search']) && $ascp_settings['blog_search'] == $cat['blog_id']) { ?> selected="selected" <?php } ?>><?php echo $cat['name']; ?></option>
				            <?php } ?>
				              </select>
				              </div>
				              </td>
				          </tr>

				    <tr>
				     <td class="left"><?php echo $language->get('entry_end_url_record'); ?></td>
				     <td class="left">
				     <div class="input-group">
				      <input class="form-control template" type="text" name="ascp_settings[end_url_record]" value="<?php  if (isset($ascp_settings['end_url_record'])) echo $ascp_settings['end_url_record']; ?>" size="20" />
				      </div>
				     </td>
				    </tr>



				    <tr class="pro">
				     <td class="left"><?php echo $entry_small_dim; ?></td>
				     <td class="left">

				     <div class="sc_table">

                      <div class="input-group">
				      <input class="form-control" type="text" name="ascp_settings[blog_small][width]" value="<?php if (isset($ascp_settings['blog_small']['width'])) echo $ascp_settings['blog_small']['width']; ?>" size="3" />
				      </div>

		   				<div>
						x
						</div>

				      <div class="input-group">
				      <input class="form-control" type="text" name="ascp_settings[blog_small][height]" value="<?php if (isset($ascp_settings['blog_small']['height'])) echo $ascp_settings['blog_small']['height']; ?>" size="3" />
                      </div>

                     </div>
				     </td>
				    </tr>

				    <tr class="pro">
				     <td class="left"><?php echo $entry_small_dim; ?></td>
				     <td class="left">
				     <div class="sc_table">

                     <div class="input-group">
				      <input class="form-control" type="text" name="ascp_settings[blog_small][width]" value="<?php if (isset($ascp_settings['blog_small']['width'])) echo $ascp_settings['blog_small']['width']; ?>" size="3" />
				      </div>
				<div>
				x
				</div>
				      <div class="input-group">
				      <input class="form-control" type="text" name="ascp_settings[blog_small][height]" value="<?php if (isset($ascp_settings['blog_small']['height'])) echo $ascp_settings['blog_small']['height']; ?>" size="3" />
                      </div>

                      </div>
				     </td>
				    </tr>

				    <tr class="pro">
				     <td class="left"><?php echo $entry_big_dim; ?></td>
				     <td class="left">
				     <div class="sc_table">

				     <div class="input-group">
				      <input class="form-control" type="text" name="ascp_settings[blog_big][width]" value="<?php  if (isset($ascp_settings['blog_big']['width'])) echo $ascp_settings['blog_big']['width']; ?>" size="3" />
				      </div>
				<div>
				x
				</div>
				      <div class="input-group">
				      <input class="form-control" type="text" name="ascp_settings[blog_big][height]" value="<?php if (isset($ascp_settings['blog_big']['height'])) echo $ascp_settings['blog_big']['height']; ?>" size="3" />
				      </div>

				      </div>
				     </td>
				    </tr>

				    <tr class="pro">
				     <td class="left"><?php echo $entry_blog_num_records; ?></td>
				     <td class="left">
				     <div class="input-group">
				      <input class="form-control" type="text" name="ascp_settings[blog_num_records]" value="<?php  if (isset($ascp_settings['blog_num_records'])) echo $ascp_settings['blog_num_records']; ?>" size="3" />
				      </div>
				     </td>
				    </tr>

				    <tr class="pro">
				     <td class="left"><?php echo $entry_blog_num_desc; ?></td>
				     <td class="left">
				     <div class="input-group">
				      <input class="form-control" type="text" name="ascp_settings[blog_num_desc]" value="<?php  if (isset($ascp_settings['blog_num_desc'])) echo $ascp_settings['blog_num_desc']; ?>" size="3" />
				      </div>
				     </td>
				    </tr>

				    <tr class="pro">
				     <td class="left"><?php echo $entry_blog_num_desc_words; ?></td>
				     <td class="left">
				     <div class="input-group">
				      <input class="form-control" type="text" name="ascp_settings[blog_num_desc_words]" value="<?php  if (isset($ascp_settings['blog_num_desc_words'])) echo $ascp_settings['blog_num_desc_words']; ?>" size="3" />
				      </div>
				     </td>
				    </tr>

				    <tr class="pro">
				     <td class="left"><?php echo $entry_blog_num_desc_pred; ?></td>
				     <td class="left">
				     <div class="input-group">
				      <input class="form-control" type="text" name="ascp_settings[blog_num_desc_pred]" value="<?php  if (isset($ascp_settings['blog_num_desc_pred'])) echo $ascp_settings['blog_num_desc_pred']; ?>" size="3" />
				      </div>
				     </td>
				    </tr>


				         <tr class="pro">
				              <td><?php echo $language->get('entry_category_status'); ?></td>
				              <td>
				              <div class="input-group">
				              <select class="form-control" name="ascp_settings[category_status]">
				                  <?php if ( isset($ascp_settings['category_status']) && $ascp_settings['category_status']) { ?>
				                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
				                  <option value="0"><?php echo $text_disabled; ?></option>
				                  <?php } else { ?>
				                  <option value="1"><?php echo $text_enabled; ?></option>
				                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
				                  <?php } ?>
				                </select>
				                </div>
				                </td>
				            </tr>

				         <tr class="pro">
				              <td><?php echo $language->get('entry_og'); ?></td>
				              <td>
				              <div class="input-group">
				              <select class="form-control" name="ascp_settings[og]">
				                  <?php if (isset($ascp_settings['og']) && $ascp_settings['og']) { ?>
				                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
				                  <option value="0"><?php echo $text_disabled; ?></option>
				                  <?php } else { ?>
				                  <option value="1"><?php echo $text_enabled; ?></option>
				                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
				                  <?php } ?>
				                </select>
				                </div>
				                </td>
				            </tr>


					<tr class="pro">
						<td class="left">
							<?php echo $language->get('entry_box_share_record'); ?>
						</td>
							<td>
								 <div class="input-group"><span class="input-group-addon"></span>
								<textarea class="form-control" name="ascp_settings[box_share]" rows="3" cols="50" ><?php if (isset($ascp_settings['box_share'])) { echo $ascp_settings['box_share']; } else { echo ''; } ?></textarea>
								</div>
							</td>
					</tr>

					<tr class="pro">
						<td class="left">
							<?php echo $language->get('entry_box_share_blog'); ?>
						</td>
							<td>
								<div class="input-group"><span class="input-group-addon"></span>
								<textarea class="form-control" name="ascp_settings[box_share_list]" rows="3" cols="50" ><?php if (isset($ascp_settings['box_share_list'])) { echo $ascp_settings['box_share_list']; } else { echo ''; } ?></textarea>
								</div>
							</td>
					</tr>







				    <tr class="pro">
				     <td class="left"><?php echo $language->get('entry_multifile_ext'); ?></td>
				     <td class="left">
				     	<div class="input-group">
				      		<input class="form-control" type="text" class="form-control" name="ascp_settings[multifile_ext]" value="<?php  if (isset($ascp_settings['multifile_ext'])) echo $ascp_settings['multifile_ext']; ?>"/>
				      	</div>
				     </td>
				    </tr>


				    <tr class="pro">
				     <td class="left"><?php echo $language->get('entry_multifile_size'); ?></td>
				     <td class="left">
				      <div class="input-group">
				      	<input class="form-control" type="text" class="form-control" name="ascp_settings[multifile_size]" value="<?php  if (isset($ascp_settings['multifile_size'])) echo $ascp_settings['multifile_size']; ?>" size="3" />
				      </div>
				     </td>
				    </tr>

				    <tr class="pro">
				     <td class="left"><?php echo $language->get('entry_multifile_num'); ?></td>
				     <td class="left">
				      <div class="input-group">
				      	<input class="form-control" type="text" class="form-control" name="ascp_settings[multifile_num]" value="<?php  if (isset($ascp_settings['multifile_num'])) echo $ascp_settings['multifile_num']; ?>" size="3" />
				      </div>
				     </td>
				    </tr>

				          <tr class="pro">
				              <td><?php echo $language->get('entry_comp_url'); ?></td>
				              <td>
				              <div class="input-group">
				              <select class="form-control" name="ascp_comp_url">
				                  <?php if (isset($ascp_comp_url) && $ascp_comp_url) { ?>
				                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
				                  <option value="0"><?php echo $text_disabled; ?></option>
				                  <?php } else { ?>
				                  <option value="1"><?php echo $text_enabled; ?></option>
				                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
				                  <?php } ?>
				                </select>
				                </div>
				                </td>
				            </tr>

				          <tr class="pro">
				              <td><?php echo $language->get('entry_safe_loading'); ?></td>
				              <td>
				              <div class="input-group">
				              <select class="form-control" name="ascp_settings[safe_loading]">
				                  <?php if (isset($ascp_settings['safe_loading']) && $ascp_settings['safe_loading']) { ?>
				                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
				                  <option value="0"><?php echo $text_disabled; ?></option>
				                  <?php } else { ?>
				                  <option value="1"><?php echo $text_enabled; ?></option>
				                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
				                  <?php } ?>
				                </select>
				                </div>
				                </td>
				           </tr>

</table>