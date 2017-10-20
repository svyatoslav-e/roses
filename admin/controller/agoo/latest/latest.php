<?php
/* All rights reserved belong to the module, the module developers http://opencartadmin.com */
// http://opencartadmin.com © 2011-2016 All Rights Reserved
// Distribution, without the author's consent is prohibited
// Commercial license
class ControllerAgooLatestLatest extends Controller
{
	private $error = array();
	protected  $data;
	private $module_files = Array(	'agootemplates/blog/adaptive.tpl',
									'agootemplates/blog/blog.tpl',
									'agootemplates/blog/blog_null.tpl',
									'agootemplates/blog/isotope.tpl',
									'agootemplates/blog/search.tpl',
									'agootemplates/record/empty.tpl',
									'agootemplates/record/isotope.tpl',
									'agootemplates/record/product.tpl',
									'agootemplates/record/record.tpl');

	public function index($data)
	{
		$this->data = $data;
		$this->config->set("blog_work", true);

        $this->data['latest_template'] = 'agoo/latest/latest.tpl';
       	$this->language->load('agoo/latest/latest');

		if (isset($this->data['id'])) {
           	$this->load->model('catalog/blog');
        	$this->load->model('catalog/record');
			$this->data['categories'] = $this->model_catalog_blog->getCategories(0);
			if (isset($this->request->post['record_blog'])) {
				$this->data['record_blog'] = $this->request->post['record_blog'];
			} elseif (isset($this->request->get['record_id'])) {
				$this->data['record_blog'] = $this->model_catalog_record->getRecordCategories($this->request->get['record_id']);
			} else {
				$this->data['record_blog'] = array();
			}
		}

        if (!isset($this->data['id'])) {
         $this->data['id'] = false;
        }
		if (isset($this->data['id']) && !isset($this->data['ascp_widgets'][$this->data['id']]['anchor'])) {
			$this->data['ascp_widgets'][$this->data['id']]['anchor'] = '';
		}



		$this->data['positions'] = array(
		'content_top' => $this->language->get('entry_position_content_top') ,
		'content_bottom' => $this->language->get('entry_position_content_bottom'),
		'column_left' => $this->language->get('entry_position_column_left'),
		'column_right' => $this->language->get('entry_position_column_right'),
		'header' => $this->language->get('entry_position_header'),
		'footer' => $this->language->get('entry_position_footer')
		);

		if (!isset($this->data['ascp_widgets'][$this->data['id']]['category_button'])) {
			$this->data['ascp_widgets'][$this->data['id']]['category_button'] = true;
		}


		$this->data['block_records_width_templates'] = array(
		$this->language->get('entry_block_records_width_templates_2') => '49%',
		$this->language->get('entry_block_records_width_templates_3') => '32%',
		$this->language->get('entry_block_records_width_templates_4') => '24%',
		$this->language->get('entry_block_records_width_templates_5') => '19%',
		$this->language->get('entry_value_templates_clear') => ""
		);

if (SC_VERSION > 15) {
$this->data['ascp_widgets'][$this->data['id']]['anchor_templates'] = array(

$this->language->get('entry_anchor_templates_menu') => "$('#cmswidget-'+cmswidget).remove();
data = $(data).html();
$('#menu ul:first').append(data);",

$this->language->get('entry_anchor_templates_menu_1') => "$('#cmswidget-'+cmswidget).remove();
data = $(data).html();
$('#menu ul:first > li:nth-child(1)').after(data);",

$this->language->get('entry_anchor_templates_tab') =><<<EOF
$('#cmswidget-'+cmswidget).remove();
data = $(data).html();
$('.nav-tabs').append ('<li><a data-toggle=\'tab\' href=\'#tab-html-'+cmswidget+'\'>'+heading_title+'</a></li>');
$('.tab-content:first').append($(data).html());
EOF
,

$this->language->get('entry_anchor_templates_footer') => "$('#cmswidget-'+cmswidget).remove();
$(data).find('div, li, a').removeClass();
data = $(data).html();
$('footer .row ul:first').append(data);",

$this->language->get('entry_anchor_templates_footer_1') => "$('#cmswidget-'+cmswidget).remove();
$(data).find('div, li, a').removeClass();
data = $(data).html();
$('footer .row > div:nth-child(2) > ul:first > li:nth-child(2)').after(data);",

$this->language->get('entry_anchor_templates_sitemap') => "$('#cmswidget-'+cmswidget).remove();
$(data).find('div, ul, li, a').removeClass();
data = $(data).html();
$('#content > .row > div:nth-child(2) > ul').append(data);",

$this->language->get('entry_anchor_templates_html') => "$('#cmswidget-'+cmswidget).remove();
data = $(data).html();
$('".$this->language->get('text_anchor_templates_selector')."').html(data);",

$this->language->get('entry_anchor_templates_prepend') => "$('#cmswidget-'+cmswidget).remove();
data = $(data).html();
$('".$this->language->get('text_anchor_templates_selector')."').prepend(data);",

$this->language->get('entry_anchor_templates_append') => "$('#cmswidget-'+cmswidget).remove();
data = $(data).html();
$('".$this->language->get('text_anchor_templates_selector')."').append(data);",

$this->language->get('entry_anchor_templates_before') => "$('#cmswidget-'+cmswidget).remove();
data = $(data).html();
$('".$this->language->get('text_anchor_templates_selector')."').before(data);",

$this->language->get('entry_anchor_templates_after') => "$('#cmswidget-'+cmswidget).remove();
data = $(data).html();
$('".$this->language->get('text_anchor_templates_selector')."').after(data);",

$this->language->get('entry_anchor_templates_clear') => ""
);
} else {

$this->data['ascp_widgets'][$this->data['id']]['anchor_templates'] = array(

$this->language->get('entry_anchor_templates_menu') => "$('#cmswidget-'+cmswidget).remove();
data = $(data).html();
$('#menu ul:first').append(data);",

$this->language->get('entry_anchor_templates_menu_1') => "$('#cmswidget-'+cmswidget).remove();
data = $(data).html();
$('#menu ul:first > li:nth-child(1)').after(data);",

$this->language->get('entry_anchor_templates_tab') =><<<EOF
$('#cmswidget-'+cmswidget).remove();
data = $(data).html();
$('#tabs').append ('<a href=\'#tab-html-'+cmswidget+'\'>'+heading_title+'</a>');
$('#tab-description').after(data);
$('#tabs a').each(function() {
   var obj = $(this);
   $(obj.attr('href')).hide();
   $(obj).unbind( 'click' );
});
$('#tabs a').tabs();
EOF
,

$this->language->get('entry_anchor_templates_footer') => "$('#cmswidget-'+cmswidget).remove();
$(data).find('div, li, a').removeClass();
data = $(data).html();
$('#footer .column ul:first').append(data);",

$this->language->get('entry_anchor_templates_footer_1') => "$('#cmswidget-'+cmswidget).remove();
$(data).find('div, li, a').removeClass();
data = $(data).html();
$('#footer .column:nth-child(2) > ul:first > li:nth-child(2)').after(data);",

$this->language->get('entry_anchor_templates_sitemap') => "$('#cmswidget-'+cmswidget).remove();
$(data).find('div, ul, li, a').removeClass();
data = $(data).html();
$('.sitemap-info > .right > ul:first').append(data);",

$this->language->get('entry_anchor_templates_html') => "$('#cmswidget-'+cmswidget).remove();
data = $(data).html();
$('".$this->language->get('text_anchor_templates_selector')."').html(data);",

$this->language->get('entry_anchor_templates_prepend') => "$('#cmswidget-'+cmswidget).remove();
data = $(data).html();
$('".$this->language->get('text_anchor_templates_selector')."').prepend(data);",

$this->language->get('entry_anchor_templates_append') => "$('#cmswidget-'+cmswidget).remove();
data = $(data).html();
$('".$this->language->get('text_anchor_templates_selector')."').append(data);",

$this->language->get('entry_anchor_templates_before') => "$('#cmswidget-'+cmswidget).remove();
data = $(data).html();
$('".$this->language->get('text_anchor_templates_selector')."').before(data);",

$this->language->get('entry_anchor_templates_after') => "$('#cmswidget-'+cmswidget).remove();
data = $(data).html();
$('".$this->language->get('text_anchor_templates_selector')."').after(data);",

$this->language->get('entry_anchor_templates_clear') => ""
);


}

if (SC_VERSION > 15) {
$this->data['ascp_widgets'][$this->data['id']]['box_begin_templates'] = array(

$this->language->get('entry_box_begin_templates_tab') => '<div id="tab-html-{CMSWIDGET}" class="tab-pane">
	<div class="box" style="display: block">
		<div class="box-content bordernone">
',
$this->language->get('entry_box_begin_templates_empty') => '<div>',
$this->language->get('entry_anchor_templates_clear') => ""
);
} else {

$this->data['ascp_widgets'][$this->data['id']]['box_begin_templates'] = array(
$this->language->get('entry_box_begin_templates_tab') => '<div id="tab-html-{CMSWIDGET}" class="tab-content">
	<div class="box" style="display: block">
		<div class="box-content bordernone">
',
$this->language->get('entry_box_begin_templates_empty') => '<div>',
$this->language->get('entry_anchor_templates_clear') => ""
);

}


if (SC_VERSION > 15) {
$this->data['ascp_widgets'][$this->data['id']]['box_end_templates'] = array(
$this->language->get('entry_box_end_templates_tab') => '		</div>
	</div>
</div>',
$this->language->get('entry_box_end_templates_empty') => '</div>',
$this->language->get('entry_anchor_templates_clear') => ""
);
} else {

$this->data['ascp_widgets'][$this->data['id']]['box_end_templates'] = array(
$this->language->get('entry_box_end_templates_tab') => '		</div>
	</div>
</div>',
$this->language->get('entry_box_end_templates_empty') => '</div>',
$this->language->get('entry_anchor_templates_clear') => ""
);

}


        return $this->data;
	}


	public function settings($data)
	{
		$this->data = $data;
		$this->config->set("blog_work", true);

       	$this->language->load('agoo/latest/latest');

		if (!isset($this->data['ascp_settings']['multifile_ext'])) {
			$this->data['ascp_settings']['multifile_ext'] = 'jpg,png,gif,jpeg';
		}

		if (!isset($this->data['ascp_settings']['multifile_num'])) {
			$this->data['ascp_settings']['multifile_num'] = '100';
		}

		if (!isset($this->data['ascp_settings']['multifile_size'])) {
			$this->data['ascp_settings']['multifile_size'] = '9000';
		}

		if (!isset($this->data['ascp_settings']['og'])) {
			$this->data['ascp_settings']['og'] = '1';
		}

		if (!isset($this->data['ascp_settings']['latest_widget_status'])) {
			$this->data['ascp_settings']['latest_widget_status'] = true;
		}

		$this->data['header'] 	= '';
		$this->data['menu'] 	= '';
		$this->data['footer'] 	= '';
		$this->data['column_left'] 	= '';

		$this->template = 'agoo/latest/settings.tpl';
        $this->data['language'] = $this->language;

        if (SC_VERSION < 20) {
			$html = $this->render();
		} else {
			$html = $this->load->view($this->template, $this->data);
		}

        $this->data['widgets']['latest']['code'] = 'latest';
        $this->data['widgets']['latest']['name'] = $this->language->get('text_widget_latest_settings');
        $this->data['widgets']['latest']['order'] = $this->language->get('order_latest');
        $this->data['widgets']['latest']['html'] = $html;

	    return $this->data;

	}


	public function widget_services($data)
	{
		$this->data = $data;
		$this->config->set("blog_work", true);
       	$this->language->load('agoo/latest/latest');


		$this->template = 'agoo/latest/widget_services.tpl';


		$this->data['header'] 	= '';
		$this->data['menu'] 	= '';
		$this->data['footer'] 	= '';
		$this->data['column_left'] 	= '';
        $this->data['language'] = $this->language;

        if (SC_VERSION < 20) {
			$html = $this->render();
		} else {
			$html = $this->load->view($this->template, $this->data);
		}
        $this->data['widget_services']['latest'] = $html;

	    return $this->data;

	}



	public function adapter_button($data)
	{
		$this->data = $data;
		$this->config->set("blog_work", true);

       	$this->language->load('agoo/latest/latest');


		foreach ($this->data['adapter'] as $id => $adapter) {

			$action               = array(
				'text' => $this->language->get('text_adapter_edit'),
				'href' => $this->url->link('catalog/adapter/update', 'token=' . $this->session->data['token'] . '&adapter_theme=' . $adapter['adapter_name'] , 'SSL')
			);

			$this->data['adapter'][$id]['action'][] = $action;
		}

	    return $this->data;
	}



	public function adapter_form($data)
	{
		$this->data = $data;
		$this->config->set("blog_work", true);
       	$this->language->load('agoo/latest/latest');

        if (!isset($this->request->get['widget']) || $this->request->get['widget']=='') {
        	$this->data = $this->run($this->data);
        }

	    return $this->data;
	}


	public function adapter_update($data)
	{
		$this->data = $data;
		$this->config->set("blog_work", true);
       	$this->language->load('agoo/latest/latest');

		if (!isset($this->request->get['widget']) || $this->request->get['widget']=='') {
			if ($this->editTheme($this->request->get['adapter_theme'], $this->request->post)) {
				$this->session->data['success'] = $this->language->get('text_success');
			} else {
				$this->session->data['error_warning'] = $this->language->get('text_error_warning');
			}
		}

	    return $this->data;
	}



   	public function run($data)
	{
		$this->data = $data;

		if (isset($this->request->post['replace_breadcrumb'])) {
			$this->data['replace_breadcrumb'][$this->data['theme']] = $this->request->post['replace_breadcrumb'];
		} else {
			$this->data['replace_breadcrumb'][$this->data['theme']] = false;
		}
		if (isset($this->request->post['replace_breadcrumb_name'])) {
			$this->data['replace_breadcrumb_name'][$this->data['theme']] = $this->request->post['replace_breadcrumb_name'];
		} else {
			$this->data['replace_breadcrumb_name'][$this->data['theme']] = '.breadcrumb';
		}
		if (isset($this->request->post['replace_main_name'])) {
			$this->data['replace_main_name'][$this->data['theme']] = $this->request->post['replace_main_name'];
		} else {
			$this->data['replace_main_name'][$this->data['theme']] = '<?php echo $text_message; ?>';
		}

		if (!isset($this->request->get['source']) || $this->request->get['source'] == '') {
			$this->data['replace_main_name'][$this->data['theme']] = '<?php echo $description; ?>';
		}

		$this->data['replace_main_name']['shoppica']        = '';
		$this->data['replace_main_name']['shoppica2']       = '';
		$this->data['replace_breadcrumb']['METROPOLITEN']   = true;
		$this->data['replace_breadcrumb']['default2']       = true;
		$this->data['replace_breadcrumb']['journal']        = true;
		$this->data['replace_breadcrumb']['journal2']       = true;
		$this->data['replace_breadcrumb']['juicyblue']      = true;
		$this->data['replace_breadcrumb']                   = $this->data['replace_breadcrumb'][$this->data['theme']];
		$this->data['replace_breadcrumb_name']['oxy']       = '.breadcrumbs';
		$this->data['replace_breadcrumb_name']['vista']     = '.breadcrumbs';
		$this->data['replace_breadcrumb_name']['shoppica']  = '#breadcrumbs';
		$this->data['replace_breadcrumb_name']['shoppica2'] = '#breadcrumbs';
		$this->data['replace_breadcrumb_name']['kubera']    = '';
		$this->data['replace_breadcrumb_name']              = $this->data['replace_breadcrumb_name'][$this->data['theme']];
		$this->data['file_theme'][$this->data['theme']]                   = 'information/information.tpl';

		if (isset($this->request->get['source']) && $this->request->get['source'] != '') {
			$this->data['file_theme'][$this->data['theme']] = 'common/success.tpl';
		}

		$this->data['file_theme']['shoppica2']         = 'information/information.tpl';
		$this->data['file_theme']['shoppica']          = 'information/information.tpl';
		$this->data['file_theme']                      = $this->data['file_theme'][$this->data['theme']];
		$this->data['replace_main_name']['moneymaker'] = '<?php echo $description; ?>';
		$this->data['replace_main_name']               = $this->data['replace_main_name'][$this->data['theme']];

		if (file_exists(DIR_CATALOG . 'view/theme/' . $this->data['theme'] . '/template/' . $this->data['file_theme'])) {
			$success_file = DIR_CATALOG . 'view/theme/' . $this->data['theme'] . '/template/' . $this->data['file_theme'];
			$success      = $this->data['success_data'] = file_get_contents($success_file);
		} else {
			$this->data['file_theme'] = 'common/success.tpl';
			if (file_exists(DIR_CATALOG . 'view/theme/' . $this->data['theme'] . '/template/' . $this->data['file_theme'])) {
				$success_file = DIR_CATALOG . 'view/theme/' . $this->data['theme'] . '/template/' . $this->data['file_theme'];
				$success      = $this->data['success_data'] = file_get_contents($success_file);
			} else {
				if (file_exists(DIR_CATALOG . 'view/theme/default/template/' . $this->data['file_theme'])) {
					$success_file = DIR_CATALOG . 'view/theme/default/template/' . $this->data['file_theme'];
					$success      = $this->data['success_data'] = file_get_contents($success_file);
				}
			}
		}

		if ($this->data['success_data'] != '') {
			$time_start = microtime(true);
			$this->load->library('parser/simple_html_dom');
			$html                                = str_get_html($success, true, true, DEFAULT_TARGET_CHARSET, false);
			$html                                = str_get_html($html->outertext, true, true, DEFAULT_TARGET_CHARSET, false);
			$this->data['success_id'][$this->data['theme']]    = array();
			$this->data['success_class'][$this->data['theme']] = array();
			$this->data['success_tag'][$this->data['theme']]   = array(
				'script'
			);
			$this->data['success_id']            = $this->data['success_id'][$this->data['theme']];
			$this->data['success_class']         = $this->data['success_class'][$this->data['theme']];
			$this->data['success_tag']           = $this->data['success_tag'][$this->data['theme']];

			foreach ($html->find(0) as $element) {
				if ($element->id != '')
					$this->data['success_id'][] = $element->id;
				if ($element->class != '') {
					$element->class = preg_replace('/<\?(.*)\?>/', ' ', $element->class);
					$element->class = preg_replace('/\s{2,}/', ' ', trim($element->class));
					$pos            = strpos($element->class, ' ');
					if ($pos === false) {
						$class_array = Array(
							$element->class
						);
					} else {
						$class_array = explode(" ", $element->class);
					}
					foreach ($class_array as $classic) {
						if ($classic != '')
							$this->data['success_class'][$classic][] = $classic;
					}
				}
				if ($element->tag != '' && $element->tag != 'root')
					$this->data['success_tag'][$element->tag] = $element->tag;
			}
			$this->data['remove_tag'][$this->data['theme']]         = Array(
				'script'
			);
			$this->data['remove_class'][$this->data['theme']]       = Array(
				'buttons'
			);
			$this->data['remove_id'][$this->data['theme']]          = Array();
			$this->data['remove_class']['moneymaker'] = Array(
				'pagination_buttons'
			);
			$this->data['remove_class']['shoppica']   = Array(
				's_submit',
				'buttons'
			);
			$this->data['remove_class']['shoppica2']  = Array(
				's_submit',
				'buttons'
			);
			$new                                      = $html->outertext;
			$new                                      = preg_replace('/ {2,}/', ' ', $new);
			$new                                      = preg_replace('~(?:\r?\n){2,}~', "\n\r", $new);
			$healthy                                  = array(
				"<div",
				"/div>",
				"<?php echo \$text_message; ?>",
				"{BREADCRUMB}",
				"\t"
			);
			$yummy                                    = array(
				"\r\n<div",
				"/div>\r\n",
				"\r\n{CONTENT}\r\n",
				"\r\n{BREADCRUMB}\r\n",
				""
			);
			$newcontent                               = str_replace($healthy, $yummy, $new);
			$time_end                                 = microtime(true);
			$time                                     = $time_end - $time_start;
			$this->data['time']                       = sprintf("%05.5f sec.", $time);
		}
        $this->data['template']          = 'catalog/adapter_form.tpl';

		if (isset($this->request->get['adapter_theme'])) {
			$this->data['action'] = $this->url->link('catalog/adapter/update', 'token=' . $this->session->data['token'] . '&adapter_theme=' . $this->request->get['adapter_theme'], 'SSL');
		} else {
			$this->data['action'] = $this->url->link('catalog/adapter/update', 'token=' . $this->session->data['token'] . '&adapter_id=' . $this->request->get['adapter_id'] . $url, 'SSL');
		}

		return $this->data;
	}

	public function editTheme($adapter_theme, $post)
	{
		if (isset($post['success_file']) && $post['success_file'] != '')
			$success_data = html_entity_decode($post['success_file'], ENT_QUOTES, 'UTF-8');
		else
			$success_data = '';
		if (isset($post['replace_breadcrumb']) && $post['replace_breadcrumb'] != '')
			$replace_breadcrumb = $post['replace_breadcrumb'];
		else
			$replace_breadcrumb = false;
		if (isset($post['replace_breadcrumb_name']) && $post['replace_breadcrumb_name'] != '')
			$replace_breadcrumb_name = html_entity_decode($post['replace_breadcrumb_name'], ENT_QUOTES, 'UTF-8');
		else
			$replace_breadcrumb_name = '';
		if (isset($post['replace_main_name']) && $post['replace_main_name'] != '')
			$replace_main_name = html_entity_decode($post['replace_main_name'], ENT_QUOTES, 'UTF-8');
		else
			$replace_main_name = '';
		if (isset($post['selected_tag']) && is_array($post['selected_tag']))
			$selected_tag = $post['selected_tag'];
		else
			$selected_tag = array();
		if (isset($post['selected_id']) && is_array($post['selected_id']))
			$selected_id = $post['selected_id'];
		else
			$selected_id = array();
		if (isset($post['selected_class']) && is_array($post['selected_class']))
			$selected_class = $post['selected_class'];
		else
			$selected_class = array();
		$this->load->library('parser/simple_html_dom');
		$html = str_get_html($success_data, true, true, DEFAULT_TARGET_CHARSET, false);
		$html = str_get_html($html->outertext, true, true, DEFAULT_TARGET_CHARSET, false);
		foreach ($selected_tag as $tag) {
			$html = str_get_html($html->innertext, true, true, DEFAULT_TARGET_CHARSET, false);
			$b    = $html->find($tag);
			if ($b) {
				foreach ($b as $a) {
					$a->outertext = '';
				}
			}
		}
		foreach ($selected_id as $id) {
			$html = str_get_html($html->innertext, true, true, DEFAULT_TARGET_CHARSET, false);
			$b    = $html->find('#' . $id);
			if ($b) {
				foreach ($b as $a) {
					$a->outertext = '';
				}
			}
		}
		foreach ($selected_class as $class) {
			$k = 0;
			foreach ($class as $num => $classic) {
				$html = str_get_html($html->innertext, true, true, DEFAULT_TARGET_CHARSET, false);
				$b    = $html->find('.' . $classic, $num - $k);
				if ($b) {
					$b->outertext = '';
					$k++;
				}
			}
		}
		if ($replace_breadcrumb && $replace_breadcrumb_name != '') {
			$html = str_get_html($html->innertext, true, true, DEFAULT_TARGET_CHARSET, false);
			$b    = $html->find($replace_breadcrumb_name, 0);
			if ($b)
				$b->outertext = html_entity_decode('{BREADCRUMB}', ENT_QUOTES, 'UTF-8');
		}
		$html_new = $html->outertext;
		if ($replace_main_name && $replace_main_name != '') {
			$healthy  = array(
				$replace_main_name
			);
			$yummy    = array(
				"{CONTENT}"
			);
			$html_new = str_replace($healthy, $yummy, $html_new);
		}
		$this->data['html']  = $html_new;
		$this->data['theme'] = $adapter_theme;
		return $this->saveTheme($this->data);
	}

	private function saveTheme($data)
	{
		$this->data = $data;
		$this->load->library('parser/simple_html_dom');
		$save_flag = false;
		foreach ($this->module_files as $module_file) {
			$module_file_content = DIR_CATALOG . 'view/theme/default/template/' . $module_file;
			if (file_exists($module_file_content)) {
				$content                = file_get_contents($module_file_content);
				$html                   = str_get_html($content, true, true, DEFAULT_TARGET_CHARSET, false);
				$html                   = str_get_html($html->outertext, true, true, DEFAULT_TARGET_CHARSET, false);
				$breadcrumb             = $html->find('.breadcrumb', 0);
				$seocmspro_content      = $html->find('.seocmspro_content', 0);
				$this->data['html_new'] = $this->data['html'];
				if ($breadcrumb && $breadcrumb != '') {
					$healthy                = array(
						'{BREADCRUMB}'
					);
					$yummy                  = array(
						$breadcrumb
					);
					$this->data['html_new'] = str_replace($healthy, $yummy, $this->data['html_new']);
					$save_flag              = true;
				}
				if ($seocmspro_content && $seocmspro_content != '') {
					$healthy                = array(
						'{CONTENT}'
					);
					$yummy                  = array(
						$seocmspro_content
					);
					$this->data['html_new'] = str_replace($healthy, $yummy, $this->data['html_new']);
					$save_flag              = true;
				}
				if ($save_flag) {
					$path = DIR_CATALOG . 'view/theme/' . $this->data['theme'] . '/template/' . $module_file;
					if (mkdirs($path)) {
						file_put_contents($path, $this->data['html_new']);
					} else {
						$save_flag = false;
					}
				}
				unset($html);
			}
		}
		return $save_flag;
	}



	public function createTables($data)
	{

$sql[0] = "
CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "blog` (
  `blog_id` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(255) COLLATE utf8_general_ci DEFAULT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `top` tinyint(1) NOT NULL,
  `column` int(3) NOT NULL,
  `sort_order` int(3) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`blog_id`),
  KEY `sort_order` (`sort_order`),
  KEY `parent_id` (`parent_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1;
";

$sql[1] = "
CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "blog_description` (
  `blog_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `description` text COLLATE utf8_general_ci NOT NULL,
  `meta_description` varchar(255) COLLATE utf8_general_ci NOT NULL,
  `meta_keyword` varchar(255) COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`blog_id`,`language_id`),
  KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
";

$sql[2] = "
CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "blog_to_layout` (
  `blog_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `layout_id` int(11) NOT NULL,
  PRIMARY KEY (`blog_id`,`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
";

$sql[3] = "
CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "blog_to_store` (
  `blog_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  PRIMARY KEY (`blog_id`,`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
";

$sql[5] = "
CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "record` (
  `record_id` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(255) COLLATE utf8_general_ci DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `comment` text COLLATE utf8_general_ci NOT NULL,
  `comment_status` tinyint(1) NOT NULL,
  `comment_status_reg` tinyint(1) NOT NULL,
  `comment_status_now` tinyint(1) NOT NULL,
  `date_available` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_end` datetime NOT NULL DEFAULT '2033-03-03 00:00:00',
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `viewed` int(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`record_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1 ;
";

$sql[6] = "
CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "record_attribute` (
  `record_id` int(11) NOT NULL,
  `attribute_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `text` text COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`record_id`,`attribute_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
";

$sql[7] = "
CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "record_description` (
  `record_id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_general_ci NOT NULL,
  `description` text COLLATE utf8_general_ci NOT NULL,
  `meta_description` varchar(255) COLLATE utf8_general_ci NOT NULL,
  `meta_keyword` varchar(255) COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`record_id`,`language_id`),
  KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1 ;
";

$sql[9] = "
CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "record_image` (
  `record_image_id` int(11) NOT NULL AUTO_INCREMENT,
  `record_id` int(11) NOT NULL,
  `image` varchar(255) COLLATE utf8_general_ci DEFAULT NULL,
  `sort_order` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`record_image_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1 ;
";


$sql[12] = "
CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "record_related` (
  `record_id` int(11) NOT NULL,
  `related_id` int(11) NOT NULL,
  PRIMARY KEY (`record_id`,`related_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
";

$sql[15] = "
CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "record_tag` (
  `record_tag_id` int(11) NOT NULL AUTO_INCREMENT,
  `record_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `tag` varchar(32) COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`record_tag_id`),
  KEY `record_id` (`record_id`),
  KEY `language_id` (`language_id`),
  KEY `tag` (`tag`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1 ;
";

$sql[16] = "
CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "record_to_blog` (
  `record_id` int(11) NOT NULL,
  `blog_id` int(11) NOT NULL,
  PRIMARY KEY (`record_id`,`blog_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
";

$sql[17] = "
CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "record_to_download` (
  `record_id` int(11) NOT NULL,
  `download_id` int(11) NOT NULL,
  PRIMARY KEY (`record_id`,`download_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
";

$sql[18] = "
CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "record_to_layout` (
  `record_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `layout_id` int(11) NOT NULL,
  PRIMARY KEY (`record_id`,`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
";

$sql[19] = "
CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "record_to_store` (
  `record_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`record_id`,`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
";

$sql[21] = "
CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "record_product_related` (
  `record_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`record_id`,`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
";


		foreach ($sql as $qsql) {
			$query = $this->db->query($qsql);
		}


		$not_found_id = $this->layout_module('error/not_found', $this->language->get('text_not_found'));
		$this->layout_module('record/blog',$this->language->get('text_layout_blog'));
		$this->layout_module('record/record',$this->language->get('text_layout_record'));


		$r = $this->db->query("DESCRIBE " . DB_PREFIX . "blog_description `meta_title`");
		if ($r->num_rows == 0) {
			$msql = "ALTER TABLE `" . DB_PREFIX . "blog_description` ADD `meta_title` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL AFTER `description`";
			$query = $this->db->query($msql);
		}
		$r = $this->db->query("DESCRIBE " . DB_PREFIX . "blog_description `meta_h1`");
		if ($r->num_rows == 0) {
			$msql = "ALTER TABLE `" . DB_PREFIX . "blog_description` ADD `meta_h1` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL AFTER `description`";
			$query = $this->db->query($msql);
		}
		$r = $this->db->query("DESCRIBE " . DB_PREFIX . "record_description `meta_title`");
		if ($r->num_rows == 0) {
			$msql = "ALTER TABLE `" . DB_PREFIX . "record_description` ADD `meta_title` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL AFTER `description`";
			$query = $this->db->query($msql);
		}
		$r = $this->db->query("DESCRIBE " . DB_PREFIX . "record_description `meta_h1`");
		if ($r->num_rows == 0) {
			$msql = "ALTER TABLE `" . DB_PREFIX . "record_description` ADD `meta_h1` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL AFTER `description`";
			$query = $this->db->query($msql);
		}

		$r = $this->db->query("DESCRIBE " . DB_PREFIX . "record `date_available`");
		if ($r->num_rows > 0 && $r->row['Type'] == 'date') {
			$msql = "ALTER TABLE `" . DB_PREFIX . "record` CHANGE `date_available` `date_available` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' ";
			$query = $this->db->query($msql);
		}
		$r = $this->db->query("DESCRIBE " . DB_PREFIX . "record_related `record_id`");
		if ($r->num_rows != 0) {
			$msql = "ALTER TABLE `" . DB_PREFIX . "record_related` CHANGE `record_id` `pointer_id` INT( 11 ) NOT NULL  ";
			$query = $this->db->query($msql);
		}
		$r = $this->db->query("DESCRIBE " . DB_PREFIX . "record_related `pointer`");
		if ($r->num_rows == 0) {
			$msql = "ALTER TABLE `" . DB_PREFIX . "record_related` ADD `pointer` VARCHAR( 128 ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL AFTER `related_id` ";
			$query = $this->db->query($msql);
			$msql = "UPDATE `" . DB_PREFIX . "record_related` SET `pointer` = 'record_id'";
			$query = $this->db->query($msql);
		}

		$r = $this->db->query("SHOW KEYS FROM `" . DB_PREFIX . "record_related`  WHERE Key_name ='PRIMARY'");
		if ($r->num_rows != 0) {
			$msql = "ALTER TABLE `" . DB_PREFIX . "record_related`  DROP PRIMARY KEY ";
			$query = $this->db->query($msql);
		}


		$r = $this->db->query("SHOW KEYS FROM `" . DB_PREFIX . "record_related`");
		if ($r->num_rows == 0) {
			$msql = "ALTER TABLE `" . DB_PREFIX . "record_related`  ADD INDEX `pointer` ( `pointer_id` , `pointer` ) ";
			$query = $this->db->query($msql);
			$msql = "ALTER TABLE `" . DB_PREFIX . "record_related`  ADD INDEX `related` ( `related_id` , `pointer` ) ";
			$query = $this->db->query($msql);
		}


		$r = $this->db->query("DESCRIBE " . DB_PREFIX . "record_product_related `product_id`");
		if ($r->num_rows != 0) {
			$msql = "SELECT * FROM `" . DB_PREFIX . "record_product_related`";
			$query = $this->db->query($msql);
			if (count($query->rows) > 0) {
				foreach ($query->rows as $blog_id) {
					$msql = "SELECT * FROM `" . DB_PREFIX . "record_related` WHERE `pointer_id`='" . $blog_id['product_id'] . "' AND pointer='product_id'";
					$query_1 = $this->db->query($msql);
					if (count($query_1->rows) <= 0) {
						$this->db->query("DELETE FROM " . DB_PREFIX . "record_related WHERE pointer_id = '" . $blog_id['record_id'] . "' AND related_id = '" . $blog_id['product_id'] . "' AND pointer='product_id'");
						$this->db->query("DELETE FROM " . DB_PREFIX . "record_related WHERE pointer_id = '" . $blog_id['product_id'] . "' AND related_id = '" . $blog_id['record_id'] . "' AND pointer='product_id'");
						$this->db->query("INSERT INTO " . DB_PREFIX . "record_related SET pointer_id = '" . $blog_id['record_id'] . "', related_id = '" . $blog_id['product_id'] . "' , pointer='product_id'");
						$this->db->query("INSERT INTO " . DB_PREFIX . "record_related SET pointer_id = '" . $blog_id['product_id'] . "', related_id = '" . $blog_id['record_id'] . "' , pointer='product_id'");
					}
				}
				$msql = "DROP TABLE `" . DB_PREFIX . "record_product_related`";
				$query = $this->db->query($msql);
			}
		}

		$r = $this->db->query("SHOW KEYS FROM `" . DB_PREFIX . "blog` WHERE Key_name ='sort_order'");
		if ($r->num_rows == 0) {
			$msql = "ALTER TABLE `" . DB_PREFIX . "blog`  ADD INDEX (`sort_order`)";
			$query = $this->db->query($msql);
		}
		$r = $this->db->query("SHOW KEYS FROM `" . DB_PREFIX . "blog` WHERE Key_name ='parent_id'");
		if ($r->num_rows == 0) {
			$msql = "ALTER TABLE `" . DB_PREFIX . "blog`  ADD INDEX (`parent_id`)";
			$query = $this->db->query($msql);
		}

  		$r = $this->db->query("DESCRIBE  " . DB_PREFIX . "record_image `options`");
		if ($r->num_rows == 0) {
			$msql = "ALTER TABLE `" . DB_PREFIX . "record_image` ADD `options` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `image`";
			$query = $this->db->query($msql);
		}

		$r = $this->db->query("DESCRIBE " . DB_PREFIX . "record `comment`");
		if ($r->num_rows == 0) {
			$msql = "ALTER TABLE `" . DB_PREFIX . "record` ADD `comment`  text COLLATE utf8_general_ci NOT NULL AFTER `status`";
			$query = $this->db->query($msql);
		}

		$r = $this->db->query("DESCRIBE  " . DB_PREFIX . "record `date_end`");
		if ($r->num_rows == 0) {
			$msql = "ALTER TABLE `" . DB_PREFIX . "record` ADD `date_end` DATETIME NOT NULL DEFAULT '2030-11-11 00:00:00' AFTER `date_available`";
			$query = $this->db->query($msql);
		}
		$r = $this->db->query("DESCRIBE " . DB_PREFIX . "record `date_available`");
		if ($r->num_rows == 0) {
			$msql = "ALTER TABLE `" . DB_PREFIX . "record` CHANGE `date_available` `date_available` DATETIME NOT NULL";
			$query = $this->db->query($msql);
		}

		$r = $this->db->query("DESCRIBE  " . DB_PREFIX . "record_description `sdescription`");
		if ($r->num_rows == 0) {
			$msql = "ALTER TABLE `" . DB_PREFIX . "record_description` ADD `sdescription` text COLLATE utf8_general_ci NOT NULL AFTER `name`";
			$query = $this->db->query($msql);
		}

		$r = $this->db->query("DESCRIBE " . DB_PREFIX . "blog `design`");
		if ($r->num_rows == 0) {
			$msql = "ALTER TABLE `" . DB_PREFIX . "blog` ADD `design` text COLLATE utf8_general_ci NOT NULL AFTER `image`";
			$query = $this->db->query($msql);
		}

		$r = $this->db->query("DESCRIBE " . DB_PREFIX . "record `blog_main`");
		if ($r->num_rows == 0) {
			$msql = "ALTER TABLE `" . DB_PREFIX . "record` ADD `blog_main` INT(11) NOT NULL AFTER `record_id`, ADD INDEX ( `blog_main` ) ";
			$query = $this->db->query($msql);
		}

		$r = $this->db->query("DESCRIBE " . DB_PREFIX . "record `blog_main`");
		if ($r->num_rows > 0 && $r->row['Type'] == 'tinyint(1)') {
			$msql = "ALTER TABLE `" . DB_PREFIX . "record` CHANGE `blog_main` `blog_main` INT(11) NOT NULL";
			$query = $this->db->query($msql);
		}

		$r = $this->db->query("DESCRIBE " . DB_PREFIX . "blog `customer_group_id`");
		if ($r->num_rows == 0) {
			$msql = "ALTER TABLE `" . DB_PREFIX . "blog` ADD `customer_group_id` INT(2) NOT NULL AFTER `status`";
			$query = $this->db->query($msql);
			$msql = "UPDATE `" . DB_PREFIX . "blog` SET `customer_group_id`=" . (int) $this->config->get('config_customer_group_id') . " ";
			$query = $this->db->query($msql);
		}

		$r = $this->db->query("DESCRIBE " . DB_PREFIX . "blog `index_page`");
		if ($r->num_rows == 0) {
			$msql = "ALTER TABLE `" . DB_PREFIX . "blog` ADD `index_page` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL AFTER `status`";
			$query = $this->db->query($msql);
			$msql = "UPDATE `" . DB_PREFIX . "blog` SET `index_page`='index,follow' ";
			$query = $this->db->query($msql);
		}

		$r = $this->db->query("DESCRIBE " . DB_PREFIX . "record `index_page`");
		if ($r->num_rows == 0) {
			$msql = "ALTER TABLE `" . DB_PREFIX . "record` ADD `index_page` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL AFTER `status`";
			$query = $this->db->query($msql);
			$msql = "UPDATE `" . DB_PREFIX . "record` SET `index_page`='index,follow' ";
			$query = $this->db->query($msql);
		}

		$r = $this->db->query("DESCRIBE " . DB_PREFIX . "record `customer_group_id`");
		if ($r->num_rows == 0) {
			$msql = "ALTER TABLE `" . DB_PREFIX . "record` ADD `customer_group_id` INT(2) NOT NULL AFTER `status`";
			$query = $this->db->query($msql);
			$msql = "UPDATE `" . DB_PREFIX . "record` SET `customer_group_id`=" . (int) $this->config->get('config_customer_group_id') . " ";
			$query = $this->db->query($msql);
		}

		$r = $this->db->query("DESCRIBE `" . DB_PREFIX . "record` `customer_id`");
		if ($r->num_rows == 0) {
			$msql = "ALTER TABLE `" . DB_PREFIX . "record` ADD `customer_id` INT(11) NOT NULL DEFAULT '0' AFTER `customer_group_id`";
			$query = $this->db->query($msql);
		}

		$r = $this->db->query("DESCRIBE " . DB_PREFIX . "record `author`");
		if ($r->num_rows == 0) {
			$msql = "ALTER TABLE `" . DB_PREFIX . "record` ADD `author`VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '' AFTER `customer_id`";
			$query = $this->db->query($msql);
		}

        if (file_exists(DIR_APPLICATION.'model/sale/customer_group.php')) {
        	$this->load->model('sale/customer_group');
			$model_customer = 'model_sale_customer_group';
		} else {
			$this->load->model('customer/customer_group');
			$model_customer = 'model_customer_customer_group';
		}
		$this->data['customer_groups'] = $this->$model_customer->getCustomerGroups();


       array_push($this->data['customer_groups'], array( 'customer_group_id' => -1,  'name' => $this->language->get('text_group_reg') ));
       array_push($this->data['customer_groups'], array( 'customer_group_id' => -2,  'name' => $this->language->get('text_group_order') ));
       array_push($this->data['customer_groups'], array( 'customer_group_id' => -3,  'name' => $this->language->get('text_group_order_this')));


		if (!$this->table_exists(DB_PREFIX . "blog_access")) {

			$sql_blog_access = "
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "blog_access` (
			  `blog_id` int(11) NOT NULL,
			  `customer_group_id` int(11) NOT NULL,
			  KEY (`blog_id`),
			  KEY (`customer_group_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
			";
			$query = $this->db->query($sql_blog_access);

			$msql = "SELECT * FROM `" . DB_PREFIX . "blog`";
			$query = $this->db->query($msql);

           	foreach ($query->rows as $blogs) {
           	    foreach ($this->data['customer_groups'] as $num=>$groups) {
					$msql_1 = "INSERT INTO `" . DB_PREFIX . "blog_access` (`blog_id`, `customer_group_id`) VALUES  ('" . $blogs['blog_id'] . "', '" . $groups['customer_group_id'] . "')";
					$query_1 = $this->db->query($msql_1);
				}
			}

		}

		if (!$this->table_exists(DB_PREFIX . "record_access")) {

			$sql_record_access = "
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "record_access` (
			  `record_id` int(11) NOT NULL,
			  `customer_group_id` int(11) NOT NULL,
			  KEY (`record_id`),
			  KEY (`customer_group_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
			";
			$query = $this->db->query($sql_record_access);

			$msql = "SELECT * FROM `" . DB_PREFIX . "record`";
			$query = $this->db->query($msql);

           	foreach ($query->rows as $records) {
           	    foreach ($this->data['customer_groups'] as $num=>$groups) {
					$msql_1 = "INSERT INTO `" . DB_PREFIX . "record_access` (`record_id`, `customer_group_id`) VALUES  ('" . $records['record_id'] . "', '" . $groups['customer_group_id'] . "')";
					$query_1 = $this->db->query($msql_1);
				}
			}

		}

		// $this->script_hook();

       return $data;

	}

	private function script_hook()
	{
        $this->language->load('module/blog');
        $this->load->model('localisation/language');
        $this->load->model('setting/store');
        $this->load->model('setting/setting');

		$languages = $this->model_localisation_language->getLanguages();
		$stores = $this->model_setting_store->getStores();

        $not_found_id = $this->layout_module('error/not_found', $this->language->get('text_not_found'));

		$ascp_widgets        = $this->model_setting_setting->getSetting('ascp_widgets');

		if (!is_array($ascp_widgets)) {
			unset($ascp_widgets);
		}

        if (isset($ascp_widgets['ascp_widgets'])) {
        	$this->data['ascp_widgets'] = $ascp_widgets['ascp_widgets'];
        } else {
        	$this->data['ascp_widgets'] = Array();
        }

        if ($this->data['ascp_widgets'] == false) {
	        $this->data['ascp_widgets'] = Array();
        }

         $found= false;
         foreach ($this->data['ascp_widgets'] as $num => $val) {
          if (isset($val['type']) && $val['type']=='hook') {
           $found= true;
          break;
          }
         }

         if (!$found) {
		  $ar = Array(
		   'remove' => '',
           'type' => 'hook',
           'store' => Array ('0' => '0'),
           'customer_groups' => Array
                (
                    '0' =>  $this->config->get('config_customer_group_id'),
                    '1' => '-1',
                    '2' => '-2',
                    '3' => '-3'
                )
        	);

		foreach ($stores as $num => $store) {
		 $ar['store'][] = $store['store_id'];
		}

		foreach ($languages as $language) {
			$title_list_latest = $this->language->get('text_url_for_module');
			$ar['title_list_latest'][$language['language_id']] = $title_list_latest;
		}

       	 $ascp_widgets['ascp_widgets'] = $this->data['ascp_widgets'];

      	 $id_new = 1;
      	 foreach($ascp_widgets['ascp_widgets'] as $id => $massa) {
	       if (!isset($ascp_widgets['ascp_widgets'][$id_new])) {
	          break;
	       }
           $id_new++;
      	 }

         $ascp_widgets['ascp_widgets'][$id_new] = $ar;

       	 $this->model_setting_setting->editSetting('ascp_widgets', $ascp_widgets);
        }


		$blog_module        = $this->model_setting_setting->getSetting('blog_module');

        if (isset($blog_module['blog_module'])) {
         $this->data['blog_module'] = $blog_module['blog_module'];
        } else {
         $this->data['blog_module'] = Array();
        }

        if ($this->data['blog_module'] == false) {
	        $this->data['blog_module'] = Array();
        }

		$ascp_widgets        = $this->model_setting_setting->getSetting('ascp_widgets');
        if (isset($ascp_widgets['ascp_widgets'])) {
          $this->data['ascp_widgets'] = $ascp_widgets['ascp_widgets'];
        } else {
          $this->data['ascp_widgets'] = Array();
        }

        if ($this->data['ascp_widgets'] == false) {
	        $this->data['ascp_widgets'] = Array();
        }

         $found_hook= '';
         foreach ($this->data['ascp_widgets'] as $num => $val) {
          if (isset($val['type']) && $val['type']=='hook') {
           $found_hook = $num;
          break;
          }
         }

         $found= false;
         $found_scheme = '';
         foreach ($this->data['blog_module'] as $num => $val) {
          if (isset($val['what']) && $val['what']== $found_hook) {
           $found= true;
           $found_scheme = $num;
          break;
          }
         }

        $ar = Array();
        if (!$found && $found_hook!='') {
           $ar = Array(
		   'url_template' => '0',
           'url' => '',
           'position' => 'content_top',
           'status' => '1',
           'sort_order' => '0',
           'what' => $found_hook,
           'layout_id' => Array('0'=> $not_found_id)
        	);

       	 $blog_module['blog_module'] = $this->data['blog_module'];

      	 $id_new = 1;
      	 foreach($blog_module['blog_module'] as $id => $massa) {
	             if (!isset($blog_module['blog_module'][$id_new])) {
	                break;
	             }
           $id_new++;
      	 }

         $blog_module['blog_module'][$id_new] = $ar;

       	 $this->model_setting_setting->editSetting('blog_module', $blog_module);
        }

	}

	private function table_exists($tableName)
	{
		$found= false;
		$like   = addcslashes($tableName, '%_\\');
		$result = $this->db->query("SHOW TABLES LIKE '" . $this->db->escape($like) . "';");
		$found  = $result->num_rows > 0;
		return $found;
	}

	private function layout_module($route ='error/not_found', $name = 'not_found') {
		$this->language->load('module/blog');
		if (!isset($not_found_id)) {

				$msql = "SELECT * FROM `" . DB_PREFIX . "layout_route` WHERE `route`='".$route."';";
				$query = $this->db->query($msql);

				if (count($query->rows) <= 0) {

					$msql = "SELECT * FROM `" . DB_PREFIX . "layout` WHERE name = '" . $name  . "' LIMIT 1;";
					$query = $this->db->query($msql);
					if (count($query->rows) <= 0) {
						$msql = "INSERT INTO `" . DB_PREFIX . "layout` (`name`) VALUES  ('" . $name  . "');";
						$query = $this->db->query($msql);
						$not_found_id = $this->db->getLastId();
                    } else {
                    	$not_found_id =$query->row['layout_id'];
                    }

					$msql = "INSERT INTO `" . DB_PREFIX . "layout_route` (`route`, `layout_id`) VALUES  ('".$route."'," . $not_found_id . ");";
					$query = $this->db->query($msql);
				} else {
					$not_found_id = $query->row['layout_id'];
				}

		}
        return $not_found_id;
	}


}
