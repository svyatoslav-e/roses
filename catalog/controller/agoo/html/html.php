<?php
/* All rights reserved belong to the module, the module developers http://opencartadmin.com */
// http://opencartadmin.com © 2011-2016 All Rights Reserved
// Distribution, without the author's consent is prohibited
// Commercial license
class ControllerAgooHtmlHtml extends Controller
{
	private $error = array();
	protected $data;

	public function index($data)
	{
		$this->data = $data;
		$this->language->load('agoo/html/html');
		$this->data['type'] = 'html';
		$html_flag_work     = false;
		$this->load->model('record/blog');
		if (isset($this->data['thislist']['search']) && !empty($this->data['thislist']['search'])) {
			if (isset($this->request->get['filter_name']) && $this->request->get['filter_name'] != '') {
				$this->data['text_for_search'] = $this->db->escape($this->request->get['filter_name']);
			} else {
				$this->data['text_for_search'] = $this->language->get('text_for_search');
			}
			$this->data['blogies'] = array();
			$blogies_1             = $this->model_record_blog->getBlogies(0);
			foreach ($blogies_1 as $blog_1) {
				$level_2_data = array();
				$blogies_2    = $this->model_record_blog->getBlogies($blog_1['blog_id']);
				foreach ($blogies_2 as $blog_2) {
					$level_3_data = array();
					$blogies_3    = $this->model_record_blog->getBlogies($blog_2['blog_id']);
					foreach ($blogies_3 as $blog_3) {
						$level_3_data[] = array(
							'blog_id' => $blog_3['blog_id'],
							'name' => $blog_3['name']
						);
					}
					$level_2_data[] = array(
						'blog_id' => $blog_2['blog_id'],
						'name' => $blog_2['name'],
						'children' => $level_3_data
					);
				}
				$this->data['blogies'][] = array(
					'blog_id' => $blog_1['blog_id'],
					'name' => $blog_1['name'],
					'children' => $level_2_data
				);
			}
			$this->data['text_blog'] = $this->language->get('text_blog');
			if (isset($this->data['settings_general']['blog_search']) && $this->data['settings_general']['blog_search']) {
				$blog_info = $this->model_record_blog->getBlog($this->data['settings_general']['blog_search']);
				if ($blog_info) {
					$this->data['blog_search'] = array(
						'text' => $blog_info['name'],
						'href' => $this->url->link('record/blog', 'blog_id=' . $blog_info['blog_id'])
					);
				}
			}
		}
		$categories = array();
		$blogs      = array();
		if (isset($this->data['thislist']['categories']) && !empty($this->data['thislist']['categories'])) {
			if ($this->data['route'] == 'product/category' && isset($this->request->get['path'])) {
				$categor                     = explode('_', (string) $this->request->get['path']);
				$categories[]['category_id'] = end($categor);
			}
			if ($this->data['route'] == 'product/product' && isset($this->request->get['product_id'])) {
				$categories = $this->model_record_blog->getCategoriesByProduct($this->request->get['product_id']);
			}
			foreach ($this->data['thislist']['categories'] as $num => $cat_id) {
				if (!empty($categories)) {
					foreach ($categories as $cat_num => $cat_cat_id) {
						if ($cat_id == $cat_cat_id['category_id']) {
							$html_flag_work = true;
						}
					}
				}
			}
		}

		if (isset($this->data['thislist']['blogs']) && !empty($this->data['thislist']['blogs'])) {
			if ($this->data['route'] == 'record/blog' && isset($this->request->get['blog_id'])) {
				$categor            = explode('_', (string) $this->request->get['blog_id']);
				$blogs[]['blog_id'] = end($categor);
			}
			if ($this->data['route'] == 'record/record' && isset($this->request->get['record_id'])) {
				$this->load->model('record/blog');
				$blogs = $this->model_record_blog->getBlogiesByRecord($this->request->get['record_id']);
			}

			foreach ($this->data['thislist']['blogs'] as $num => $cat_id) {
				foreach ($blogs as $cat_num => $cat_cat_id) {
					if ($cat_id == $cat_cat_id['blog_id']) {

						$html_flag_work = true;
					}
				}
			}
		} else {
			if (!isset($this->data['thislist']['categories']) && empty($this->data['thislist']['categories'])) {

				$html_flag_work = true;
			}
		}


		if ((!isset($this->data['thislist']['blogs']) ||  empty($this->data['thislist']['blogs'])) && (!isset($this->data['thislist']['categories']) ||  empty($this->data['thislist']['categories']))) {
			$html_flag_work = true;
		}

        if (isset($this->data['thislist']['html_modal'][$this->config->get('config_language_id')]) && $this->data['thislist']['html_modal'][$this->config->get('config_language_id')]!='') {
			$this->data['html_modal'] = html_entity_decode($this->data['thislist']['html_modal'][$this->config->get('config_language_id')], ENT_QUOTES, 'UTF-8');
		} else {
        	$this->data['html_modal'] = '';
		}

		if ($html_flag_work) {
			$class_widget                = $this->data['type'] . '_widget';
			$this->data                  = $this->$class_widget($this->data);
			$this->data['html_template'] = $this->data['template'];
		} else {
			$this->data['html_template'] = '';
		}

		return $this->data;
	}
	private function html_widget($data)
	{
		$this->data         = $data;
		$this->data['html'] = html_entity_decode($this->data['thislist']['html'][$this->config->get('config_language_id')], ENT_QUOTES, 'UTF-8');
		$html_name          = "html." . md5(serialize($this->data['thislist'])) . "." . $this->config->get('config_language_id') . ".php";
		$file               = DIR_CACHE . $html_name;
		$this->deletecache('html');
		if (!file_exists($file) || (isset($this->data['settings_general']['cache_widgets']) && !$this->data['settings_general']['cache_widgets'])) {
			$handle = fopen($file, 'w');
			fwrite($handle, $this->data['html']);
			fclose($handle);
		}
		if (file_exists($file)) {
			$this->data['mark'] = "Mark";
			extract($this->data);
			ob_start();
			require($file);
			$this->output = ob_get_contents();
			ob_end_clean();
		}
		$this->data['html'] = $this->output;
		if (isset($this->data['thislist']['title_list_latest'][$this->config->get('config_language_id')]))
			$this->data['heading_title'] = $this->data['thislist']['title_list_latest'][$this->config->get('config_language_id')];
		else
			$this->data['heading_title'] = '';
		if (isset($this->data['thislist']['template']) && $this->data['thislist']['template'] != '') {
			$this->data['template'] = '/template/agootemplates/widgets/html/' . $this->data['thislist']['template'];
		} else {
			$this->data['template'] = '/template/agootemplates/widgets/html/html.tpl';
		}
		return $this->data;
	}
	private function deletecache($key)
	{
		$files = glob(DIR_CACHE . preg_replace('/[^A-Z0-9\._-]/i', '', $key) . '.*');
		if ($files) {
			foreach ($files as $file) {
				if (file_exists($file)) {
					$file_time    = filemtime($file);
					$date_current = date("d-m-Y H:i:s");
					$date_diff    = (strtotime($date_current) - ($file_time)) / 60;
					if ($date_diff > 5) {
						unlink($file);
					}
				}
			}
		}
	}
}
