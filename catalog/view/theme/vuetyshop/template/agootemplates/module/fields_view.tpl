<div class="width100">
<?php
	foreach ($comment['fields'] as $af_name =>$field) {

		if (!isset($field['field_public'])) {
			$field['field_public'] = true;
		}

		if($field['value']!="" && $field['field_public'] && $field['value']!="0") {

	         if (isset($field['field'][$config_language_id]['field_class_out']) && $field['field'][$config_language_id]['field_class_out']!='') {
	         	$class_out = $field['field'][$config_language_id]['field_class_out'];
	         } else {
	         	$class_out = "";
	         }

			if (!isset($field['field'][$config_language_id]['field_template_out']) || $field['field'][$config_language_id]['field_template_out']=='') {

				$field['field'][$config_language_id]['field_template_out'] ='
				<div class="marginbottom2">
					  <div class="floatleft marginright5">
					  {IMAGE}
					  </div>
				      <div>
				      <ins class="field_title">{DESCRIPTION}</ins>
				      <ins class="'.$class_out.' marginbottom2">{FIELD}</ins>
				      </div>
			    </div>
			    ';
			}

			if (isset($field['field']) && $field['field'][$config_language_id]['field_template_out']!='') {

				$field_html = $field['field'][$config_language_id]['field_template_out'];

				if (isset($field['field_type']) && $field['field_type']=='rating') {
					if ($theme_stars) {
							$field_html = str_replace('{FIELD}', '<img style="border: 0px;"  title="'.$field['value'].'" alt="'.$field['value'].'" src="catalog/view/theme/'.$theme_stars.'/image/blogstars-'.$field['value'].'.png">', $field_html);

					}
				} else {
					$field_html = str_replace('{FIELD}', $field['value'], $field_html);
				}

				if (isset($field['field_image']) &&  $field['field_image']!='') {
					 $field_html = str_replace('{IMAGE}', '<img src="'.$http_image.$field['field_image'].'" title="'.$field['field_description'][$config_language_id].'" alt="'.$field['field_description'][$config_language_id].'">', $field_html);
				} else {
			 		$field_html = str_replace('{IMAGE}', '',$field_html);
				}

				if (isset($field['field_description']) &&  $field['field_description'][$config_language_id]!='' ) {
			 		$field_html = str_replace('{DESCRIPTION}',$field['field_description'][$config_language_id], $field_html);
				} else {
			 		$field_html = str_replace('{DESCRIPTION}', '',$field_html);
				}

 				echo html_entity_decode($field_html, ENT_QUOTES, 'UTF-8') ;
			}
		}
	}
?>
</div>