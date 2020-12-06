<?php if (isset($fields) && !empty($fields)) {	?>
<div class="marginbottom5">
	<?php if (!$fields_view) { ?>
	<a href="#" class="hrefajax" onclick="$('.addfields').toggle(); return false;"><?php echo $language->get('entry_addfields_begin');  ?><ins class="lowercase"><?php
		$i=0;
		foreach   ($fields as $af_name => $field) {
			$i++;
			if (isset($field['field_description'][$config_language_id])) {
				echo str_replace('?','',$field['field_description'][$config_language_id]);
				if (count($fields)!=$i) echo ", ";
			}
		}
		?></ins></a>
	<?php } ?>
</div>

<div class="width100 addfields" style="<?php if (!$fields_view) echo 'display: none;'; ?>">
<?php
	foreach ($fields as $af_name =>$field) {

			if (isset($field['field'][$config_language_id]['field_class_in']) && $field['field'][$config_language_id]['field_class_in']!='') {
				$class_in = $field['field'][$config_language_id]['field_class_in'];
			} else {
				$class_in = '';
			}

			if ($class_in!='') {
				$field_class = $class_in;
			} else {
				$field_class = 'blog-record';
			}

			if (isset($field['field_must']) && $field['field_must']=="1") {
			 	$field_class.=' borderleft3pxred';
			}

			if (!isset($field['field_public'])) {
				$field['field_public'] = true;
			}

			if (!isset($field['field'][$config_language_id]['field_template_in']) || $field['field'][$config_language_id]['field_template_in']=='') {

				$field['field'][$config_language_id]['field_template_in'] ='
				<div class="marginbottom2">
					  <div class="floatleft marginright5">
					  {IMAGE}
					  </div>
				      <div class="floatleft">
				      	{REQUIRE}
				      	<ins class="field_title">{DESCRIPTION}</ins>
				      	<div>
				      		{FIELD}
				      	</div>
				      </div>
				      <div class="clearboth"> </div>
			    </div>
			    ';
			}


			if(!$field['field_public']) {
				$field['field_description'][$config_language_id].= $language->get('text_unpublic');
			}

			if (isset($field['field'][$config_language_id]['field_template_in']) && $field['field'][$config_language_id]['field_template_in']!='') {

				 $field_html = $field['field'][$config_language_id]['field_template_in'];
				 $field_text ='';

				if (isset($field['field_type']) && $field['field_type']=='rating') {
			            if (isset($settings_widget['visual_rating']) && $settings_widget['visual_rating']) {
			                       $field_text = '
								    <input type="hidden" name="af['.$field['field_name'].']" value="">
								    <input type="radio" class="visual_star" name="af['.$field['field_name'].']" alt="#8c0000"  value="1" >
								    <input type="radio" class="visual_star" name="af['.$field['field_name'].']" alt="#8c4500"  value="2" >
								    <input type="radio" class="visual_star" name="af['.$field['field_name'].']" alt="#b6b300"  value="3" >
								    <input type="radio" class="visual_star" name="af['.$field['field_name'].']" alt="#698c00"  value="4" >
								    <input type="radio" class="visual_star" name="af['.$field['field_name'].']" alt="#008c00"  value="5" >
								   <span id="hover-test" ></span>
								';

						} else {
						$field_text  = '
									<ins class="color_bad">'.$language->get('entry_bad').'</ins></span>&nbsp;
									    <input type="hidden" name="af['.$field['field_name'].']" value="">
									    <input type="radio"  name="af['.$field['field_name'].']" value="1">
									    <ins class="blog-ins_rating" style="">1</ins>
									    <input type="radio"  name="af['.$field['field_name'].']" value="2">
									    <ins class="blog-ins_rating" >2</ins>
									    <input type="radio"  name="af['.$field['field_name'].']" value="3">
									    <ins class="blog-ins_rating" >3</ins>
									    <input type="radio"  name="af['.$field['field_name'].']" value="4">
									    <ins class="blog-ins_rating" >4</ins>
									    <input type="radio"  name="af['.$field['field_name'].']" value="5">
									    <ins class="blog-ins_rating" >5</ins>
									   &nbsp;&nbsp; <span><ins  class="color_good">'.$language->get('entry_good').'
									 </ins>
									';
						}
				}

				if (isset($field['field'][$config_language_id]['field_class_in']) && $field['field'][$config_language_id]['field_class_in']!='') {
					$class = $field['field'][$config_language_id]['field_class_in'];
				} else {
					$class = '';
				}

				if ($class!='') {
					$field_class = $class;
				} else {
					$field_class = 'blog-record';
				}
				if ($field['field_must']=="1") {
				 	$field_class.=' borderleft3pxred';
				}

				if (isset($field['field_type']) && $field['field_type']=='text') {
					$field_text = '<input type="text" name="af['.$field['field_name'].']" class="form-control sc-form-control '.$field_class.'">';
				}

				if ($class!='') {
					$field_class = $class;
				} else {
					$field_class = 'blog-record-textarea';
				}

				if ($field['field_must']=="1") {
					$field_class.=' borderleft3pxred';
				}
				if (isset($field['field_type']) && $field['field_type']=='textarea') {
					$field_text = '<textarea name="af['.$field['field_name'].']" cols="40" rows="1" class="form-control sc-form-control '.$field_class.'"></textarea>';
				}


				if (isset($field['field_type']) && $field['field_type']=='select') {
					if ((isset($field['field_type']) && $field['field_type']=='select') || !isset($field['field_type'])) {
						if (isset($field['field_value'][$config_language_id]) && $field['field_value'][$config_language_id]!='') {

							if ($class!='') {
									$field_class = $class;
							} else {
									$field_class = 'blog-record-select';
							}

							if (isset($field['field_must']) && $field['field_must']=="1") {
									$field_class.=' borderleft3pxred';
							}

							$select_array = explode('|', (string)$field['field_value'][$config_language_id]);
				               $select_text ='';
				                foreach ($select_array as $num => $select_value) {
				                 $select_value = html_entity_decode($select_value, ENT_QUOTES, 'UTF-8');
				                 $select_text.= '<option>'.$select_value.'</option>';
							 }

				            $field_text = '<select name="af['.$field['field_name'].']" class="'.$field_class.'">'.$select_text.'</select>';

				  		}
				 	}
				}

				$field_html = str_replace('{FIELD}', $field_text, $field_html);

				if ($field['field_image']!='') {
					$field_html = str_replace('{IMAGE}', '<img src="'.$http_image.$field['field_image'].'" title="'.strip_tags($field['field_description'][$config_language_id]).'" alt="'.strip_tags($field['field_description'][$config_language_id]).'">', $field_html);
				} else {
					$field_html = str_replace('{IMAGE}', '',$field_html);
				}

				if ($field['field_description'][$config_language_id]!='') {
					$field_html = str_replace('{DESCRIPTION}',$field['field_description'][$config_language_id], $field_html);
				} else {
					$field_html = str_replace('{DESCRIPTION}', '',$field_html);
				}

				if (isset($field['field_must']) && $field['field_must'])  {
					$field_html = str_replace('{REQUIRE}', '<span class="blog_require '.$class.'">*</span>', $field_html);
				} else {
					$field_html = str_replace('{REQUIRE}', '',$field_html);
				}

	 			echo html_entity_decode($field_html, ENT_QUOTES, 'UTF-8') ;
		 	}
  }
?>
</div>
<?php  }  ?>