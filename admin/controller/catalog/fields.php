<?php
/* All rights reserved belong to the module, the module developers http://opencartadmin.com */
// http://opencartadmin.com © 2011-2016 All Rights Reserved
// Distribution, without the author's consent is prohibited
// Commercial license
class ControllerCatalogFields extends Controller
{
	private $error = array();
	protected $data;
	public function index()
	{

		$this->config->set("blog_work", true);


		$this->language->load('module/blog');
		$this->data['oc_version'] = str_pad(str_replace(".", "", VERSION), 7, "0");
		$this->load->model('setting/setting');
		$this->data['blog_version']       = '*';
		$this->data['blog_version_model'] = 'PRO';
		$settings_admin                   = $this->model_setting_setting->getSetting('ascp_version', 'ascp_version');
		foreach ($settings_admin as $key => $value) {
			$this->data['blog_version'] = $value;
		}
		$settings_admin_model = $this->model_setting_setting->getSetting('ascp_version_model', 'ascp_version_model');
		foreach ($settings_admin_model as $key => $value) {
			$this->data['blog_version_model'] = $value;
		}
		$this->data['blog_version'] = $this->data['blog_version'] . ' ' . $this->data['blog_version_model'];
		$this->language->load('seocms/catalog/fields');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->data['tab_general']      = $this->language->get('tab_general');
		$this->data['tab_list']         = $this->language->get('tab_list');
		$this->data['url_modules_text'] = $this->language->get('url_modules_text');
		$this->load->model('catalog/fields');
		$this->cont('agooa/adminmenu');
		$this->data['agoo_menu'] = $this->controller_agooa_adminmenu->index();
		$this->getList();
	}
	public function insert()
	{
		$this->language->load('seocms/catalog/fields');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('catalog/fields');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			if (!$this->model_catalog_fields->addField($this->request->post)) {
				$this->session->data['success'] = $this->language->get('text_success');
				$url                            = '';
				if (SC_VERSION < 20) {
					$this->redirect($this->url->link('catalog/fields', 'token=' . $this->session->data['token'], 'SSL'));
				} else {
					$this->response->redirect($this->url->link('catalog/fields', 'token=' . $this->session->data['token'], 'SSL'));
				}
			} else {
				$this->session->data['error_warning_form'] = $this->language->get('error_warning_form');
			}
		}
		$this->getForm();
	}
	public function update()
	{
		$this->language->load('seocms/catalog/fields');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('catalog/fields');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_fields->editField($this->request->get['field_id'], $this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
			$url                            = '';
			if (SC_VERSION < 20) {
			} else {
			}
		}
		$this->getForm();
	}
	public function delete()
	{
		$this->language->load('seocms/catalog/fields');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('catalog/fields');
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $field_id) {
				$this->model_catalog_fields->deleteField($field_id);
			}
			$this->session->data['success'] = $this->language->get('text_success');
			$url                            = '';
			if (SC_VERSION < 20) {
				$this->redirect($this->url->link('catalog/fields', 'token=' . $this->session->data['token'], 'SSL'));
			} else {
				$this->response->redirect($this->url->link('catalog/fields', 'token=' . $this->session->data['token'], 'SSL'));
			}
		}
		$this->getList();
	}
	public function copy()
	{
		$this->language->load('seocms/catalog/fields');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('catalog/fields');
		if (isset($this->request->post['selected']) && $this->validateCopy()) {
			foreach ($this->request->post['selected'] as $field_id) {
				$this->model_catalog_fields->copyField($field_id);
			}
			$this->session->data['success'] = $this->language->get('text_success');
			$url                            = '';
			if (SC_VERSION < 20) {
				$this->redirect($this->url->link('catalog/fields', 'token=' . $this->session->data['token'], 'SSL'));
			} else {
				$this->response->redirect($this->url->link('catalog/fields', 'token=' . $this->session->data['token'], 'SSL'));
			}
		}
		$this->getList();
	}
	private function getFields()
	{
		$fields = array();
		$this->load->model('catalog/fields');
		$fields = $this->model_catalog_fields->getFieldsDesc();
		return $fields;
	}
	private function getList()
	{
		if (file_exists(DIR_APPLICATION . 'view/stylesheet/seocmspro.css')) {
			$this->document->addStyle('view/stylesheet/seocmspro.css');
		}
		if (file_exists(DIR_APPLICATION . 'view/javascript/blog/seocmspro.js')) {
			$this->document->addScript('view/javascript/blog/seocmspro.js');
		}
		$this->data['url_modules']   = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_options']   = $this->url->link('module/blog', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_schemes']   = $this->url->link('module/blog/schemes', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_widgets']   = $this->url->link('module/blog/widgets', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_back']      = $this->url->link('module/blog', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_back_text'] = $this->language->get('url_back_text');
		$url                         = '';
		if (file_exists(DIR_IMAGE . 'no_image.jpg')) {
			$no_image = 'no_image.jpg';
		}
		if (file_exists(DIR_IMAGE . 'no_image.png')) {
			$no_image = 'no_image.png';
		}
		$this->data['breadcrumbs']   = array();
		$this->data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);
		$this->data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('catalog/field', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);
		$this->data['insert']        = $this->url->link('catalog/fields/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['copy']          = $this->url->link('catalog/fields/copy', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete']        = $this->url->link('catalog/fields/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['fields_list']   = $this->getFields();
		$this->load->model('tool/image');
		$this->data['fields'] = array();
		foreach ($this->data['fields_list'] as $result) {
			$action = array();
			if (isset($result['field_id'])) {
				$action[] = array(
					'text' => $this->language->get('text_edit'),
					'href' => $this->url->link('catalog/fields/update', 'token=' . $this->session->data['token'] . '&field_id=' . $result['field_id'], 'SSL')
				);
			} else {
				$action[] = array(
					'text' => $this->language->get('button_insert'),
					'href' => $this->url->link('catalog/fields/insert', 'token=' . $this->session->data['token'] . '&field_name=' . $result['field_name'], 'SSL')
				);
			}
			if (isset($result['field_image']) && $result['field_image'] && file_exists(DIR_IMAGE . $result['field_image'])) {
				$image = $this->model_tool_image->resize($result['field_image'], 40, 40);
			} else {
				$image = $this->model_tool_image->resize($no_image, 40, 40);
			}
			$this->data['fields'][] = array(
				'field_id' => (isset($result['field_id']) ? $result['field_id'] : ''),
				'field_name' => (isset($result['field_name']) ? $result['field_name'] : ''),
				'field_description' => (isset($result['field_description']) ? $result['field_description'] : ''),
				'field_type' => (isset($result['field_type']) ? $result['field_type'] : ''),
				'field_order' => (isset($result['field_order']) ? $result['field_order'] : ''),
				'field_must' => (isset($result['field_must']) && $result['field_must'] ? $this->language->get('text_yes') : $this->language->get('text_no')),
				'field_image' => $image,
				'selected' => isset($this->request->post['selected']) && in_array($result['field_id'], $this->request->post['selected']),
				'action' => $action
			);
		}
		$this->data['heading_title']      = $this->language->get('heading_title');
		$this->data['text_enabled']       = $this->language->get('text_enabled');
		$this->data['text_disabled']      = $this->language->get('text_disabled');
		$this->data['text_no_results']    = $this->language->get('text_no_results');
		$this->data['text_image_manager'] = $this->language->get('text_image_manager');
		$this->data['column_image']       = $this->language->get('column_image');
		$this->data['column_name']        = $this->language->get('column_name');
		$this->data['column_status']      = $this->language->get('column_status');
		$this->data['column_action']      = $this->language->get('column_action');
		$this->data['button_copy']        = $this->language->get('button_copy');
		$this->data['button_insert']      = $this->language->get('button_insert');
		$this->data['button_delete']      = $this->language->get('button_delete');
		$this->data['url_blog']           = $this->url->link('catalog/blog', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_fields']         = $this->url->link('catalog/fields', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_comment']        = $this->url->link('catalog/comment', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_record']         = $this->url->link('catalog/record', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_record_text']    = $this->language->get('url_record_text');
		$this->data['url_blog_text']      = $this->language->get('url_blog_text');
		$this->data['url_fields_text']    = $this->language->get('url_fields_text');
		$this->data['url_comment_text']   = $this->language->get('url_comment_text');
		$this->data['url_create_text']    = $this->language->get('url_create_text');
		$this->data['token']              = $this->session->data['token'];
		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
		$this->data['this']     = $this;
		$this->template         = 'catalog/fields_list.tpl';
		$this->children         = array(
			'common/header',
			'common/footer'
		);
		$this->data['registry'] = $this->registry;
		$this->data['language'] = $this->language;
		$this->data['config']   = $this->config;
		if (SC_VERSION < 20) {
			$this->data['column_left'] = '';
			$html                      = $this->render();
		} else {
			$this->data['header']      = $this->load->controller('common/header');
			$this->data['menu']        = $this->load->controller('common/menu');
			$this->data['footer']      = $this->load->controller('common/footer');
			$this->data['column_left'] = $this->load->controller('common/column_left');
			$html                      = $this->load->view($this->template, $this->data);
		}
		$this->response->setOutput($html);
	}
	private function getForm()
	{

		$this->config->set("blog_work", true);


		$this->language->load('module/blog');
		$this->data['oc_version'] = str_pad(str_replace(".", "", VERSION), 7, "0");
		$this->load->model('setting/setting');
		$this->data['blog_version']       = '*';
		$this->data['blog_version_model'] = 'PRO';
		$settings_admin                   = $this->model_setting_setting->getSetting('ascp_version', 'ascp_version');
		foreach ($settings_admin as $key => $value) {
			$this->data['blog_version'] = $value;
		}
		$settings_admin_model = $this->model_setting_setting->getSetting('ascp_version_model', 'ascp_version_model');
		foreach ($settings_admin_model as $key => $value) {
			$this->data['blog_version_model'] = $value;
		}
		$this->data['blog_version']     = $this->data['blog_version'] . ' ' . $this->data['blog_version_model'];
		$this->data['tab_general']      = $this->language->get('tab_general');
		$this->data['tab_list']         = $this->language->get('tab_list');
		$this->data['url_modules_text'] = $this->language->get('url_modules_text');
		$this->cont('agooa/adminmenu');
		$this->data['agoo_menu'] = $this->controller_agooa_adminmenu->index();
		if (file_exists(DIR_APPLICATION . 'view/stylesheet/seocmspro.css')) {
			$this->document->addStyle('view/stylesheet/seocmspro.css');
		}
		if (file_exists(DIR_APPLICATION . 'view/javascript/jquery/tabs.js')) {
			$this->document->addScript('view/javascript/jquery/tabs.js');
		} else {
			if (file_exists(DIR_APPLICATION . 'view/javascript/blog/tabs/tabs.js')) {
				$this->document->addScript('view/javascript/blog/tabs/tabs.js');
			}
		}
		if (file_exists(DIR_APPLICATION . 'view/javascript/blog/seocmspro.js')) {
			$this->document->addScript('view/javascript/blog/seocmspro.js');
		}
		if (!file_exists(DIR_APPLICATION . 'view/javascript/ckeditor/ckeditor.js')) {
			if (file_exists(DIR_APPLICATION . 'view/javascript/blog/ckeditor/ckeditor.js')) {
				$this->document->addScript('view/javascript/blog/ckeditor/ckeditor.js');
			}
		} else {
			$this->document->addScript('view/javascript/ckeditor/ckeditor.js');
		}
		if (file_exists(DIR_IMAGE . 'no_image.jpg')) {
			$no_image = 'no_image.jpg';
		}
		if (file_exists(DIR_IMAGE . 'no_image.png')) {
			$no_image = 'no_image.png';
		}
		$this->data['config_language'] = $this->config->get('config_language');
		$this->data['no_image']        = '';
		$this->language->load('seocms/catalog/fields');
		$this->data['url_record_text']          = $this->language->get('url_record_text');
		$this->data['url_record']               = $this->url->link('catalog/record', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_modules']              = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_options']              = $this->url->link('module/blog', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_schemes']              = $this->url->link('module/blog/schemes', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_widgets']              = $this->url->link('module/blog/widgets', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_back']                 = $this->url->link('module/blog', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_back_text']            = $this->language->get('url_back_text');
		$this->data['heading_title']            = $this->language->get('heading_title');
		$this->data['text_enabled']             = $this->language->get('text_enabled');
		$this->data['text_disabled']            = $this->language->get('text_disabled');
		$this->data['text_none']                = $this->language->get('text_none');
		$this->data['text_yes']                 = $this->language->get('text_yes');
		$this->data['text_no']                  = $this->language->get('text_no');
		$this->data['text_select_all']          = $this->language->get('text_select_all');
		$this->data['text_unselect_all']        = $this->language->get('text_unselect_all');
		$this->data['text_blog_plus']           = $this->language->get('text_blog_plus');
		$this->data['text_blog_minus']          = $this->language->get('text_blog_minus');
		$this->data['text_default']             = $this->language->get('text_default');
		$this->data['text_image_manager']       = $this->language->get('text_image_manager');
		$this->data['text_browse']              = $this->language->get('text_browse');
		$this->data['text_clear']               = $this->language->get('text_clear');
		$this->data['text_option']              = $this->language->get('text_option');
		$this->data['text_option_value']        = $this->language->get('text_option_value');
		$this->data['text_select']              = $this->language->get('text_select');
		$this->data['text_none']                = $this->language->get('text_none');
		$this->data['text_percent']             = $this->language->get('text_percent');
		$this->data['text_amount']              = $this->language->get('text_amount');
		$this->data['url_back']                 = $this->url->link('module/blog', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_back_text']            = $this->language->get('url_back_text');
		$this->data['url_blog']                 = $this->url->link('catalog/blog', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_field']                = $this->url->link('catalog/field', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_fields']               = $this->url->link('catalog/fields', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_comment']              = $this->url->link('catalog/comment', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_blog_text']            = $this->language->get('url_blog_text');
		$this->data['url_field_text']           = $this->language->get('url_field_text');
		$this->data['url_fields_text']          = $this->language->get('url_fields_text');
		$this->data['url_comment_text']         = $this->language->get('url_comment_text');
		$this->data['url_create_text']          = $this->language->get('url_create_text');
		$this->data['entry_name']               = $this->language->get('entry_name');
		$this->data['entry_meta_description']   = $this->language->get('entry_meta_description');
		$this->data['entry_meta_keyword']       = $this->language->get('entry_meta_keyword');
		$this->data['entry_description']        = $this->language->get('entry_description');
		$this->data['entry_sdescription']       = $this->language->get('entry_sdescription');
		$this->data['entry_store']              = $this->language->get('entry_store');
		$this->data['entry_keyword']            = $this->language->get('entry_keyword');
		$this->data['entry_model']              = $this->language->get('entry_model');
		$this->data['entry_date_available']     = $this->language->get('entry_date_available');
		$this->data['entry_comment_status_reg'] = $this->language->get('entry_comment_status_reg');
		$this->data['entry_comment_status_now'] = $this->language->get('entry_comment_status_now');
		$this->data['entry_option_points']      = $this->language->get('entry_option_points');
		$this->data['entry_subtract']           = $this->language->get('entry_subtract');
		$this->data['entry_weight_class']       = $this->language->get('entry_weight_class');
		$this->data['entry_weight']             = $this->language->get('entry_weight');
		$this->data['entry_dimension']          = $this->language->get('entry_dimension');
		$this->data['entry_length']             = $this->language->get('entry_length');
		$this->data['entry_image']              = $this->language->get('entry_image');
		$this->data['entry_download']           = $this->language->get('entry_download');
		$this->data['entry_blog']               = $this->language->get('entry_blog');
		$this->data['entry_related']            = $this->language->get('entry_related');
		$this->data['entry_customer_group_v']   = $this->language->get('entry_customer_group_v');
		$this->data['entry_customer_group']     = $this->language->get('entry_customer_group');
		$this->data['entry_attribute']          = $this->language->get('entry_attribute');
		$this->data['entry_text']               = $this->language->get('entry_text');
		$this->data['entry_option']             = $this->language->get('entry_option');
		$this->data['entry_option_value']       = $this->language->get('entry_option_value');
		$this->data['entry_required']           = $this->language->get('entry_required');
		$this->data['entry_sort_order']         = $this->language->get('entry_sort_order');
		$this->data['entry_status']             = $this->language->get('entry_status');
		$this->data['entry_comment_status']     = $this->language->get('entry_comment_status');
		$this->data['entry_customer_group']     = $this->language->get('entry_customer_group');
		$this->data['entry_date_start']         = $this->language->get('entry_date_start');
		$this->data['entry_date_end']           = $this->language->get('entry_date_end');
		$this->data['entry_priority']           = $this->language->get('entry_priority');
		$this->data['entry_tag']                = $this->language->get('entry_tag');
		$this->data['entry_customer_group']     = $this->language->get('entry_customer_group');
		$this->data['entry_reward']             = $this->language->get('entry_reward');
		$this->data['entry_layout']             = $this->language->get('entry_layout');
		$this->data['button_save']              = $this->language->get('button_save');
		$this->data['button_cancel']            = $this->language->get('button_cancel');
		$this->data['button_add_attribute']     = $this->language->get('button_add_attribute');
		$this->data['button_add_option']        = $this->language->get('button_add_option');
		$this->data['button_add_option_value']  = $this->language->get('button_add_option_value');
		$this->data['button_add_special']       = $this->language->get('button_add_special');
		$this->data['button_add_image']         = $this->language->get('button_add_image');
		$this->data['button_remove']            = $this->language->get('button_remove');
		$this->data['tab_general']              = $this->language->get('tab_general');
		$this->data['tab_data']                 = $this->language->get('tab_data');
		$this->data['tab_attribute']            = $this->language->get('tab_attribute');
		$this->data['tab_option']               = $this->language->get('tab_option');
		$this->data['tab_special']              = $this->language->get('tab_special');
		$this->data['tab_image']                = $this->language->get('tab_image');
		$this->data['tab_links']                = $this->language->get('tab_links');
		$this->data['tab_reward']               = $this->language->get('tab_reward');
		$this->data['tab_design']               = $this->language->get('tab_design');
		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
		if (isset($this->session->data['error_warning_form'])) {
			$this->data['error_warning_form'] = $this->session->data['error_warning_form'];
			unset($this->session->data['error_warning_form']);
		} else {
			$this->data['error_warning_form'] = '';
		}
		if (isset($this->error['name'])) {
			$this->data['error_name'] = $this->error['name'];
		} else {
			$this->data['error_name'] = array();
		}
		if (isset($this->error['meta_description'])) {
			$this->data['error_meta_description'] = $this->error['meta_description'];
		} else {
			$this->data['error_meta_description'] = array();
		}
		if (isset($this->error['description'])) {
			$this->data['error_description'] = $this->error['description'];
		} else {
			$this->data['error_description'] = array();
		}
		if (isset($this->error['sdescription'])) {
			$this->data['error_sdescription'] = $this->error['sdescription'];
		} else {
			$this->data['error_sdescription'] = array();
		}
		if (isset($this->error['model'])) {
			$this->data['error_model'] = $this->error['model'];
		} else {
			$this->data['error_model'] = '';
		}
		if (isset($this->error['date_available'])) {
			$this->data['error_date_available'] = $this->error['date_available'];
		} else {
			$this->data['error_date_available'] = '';
		}
		if (isset($this->error['date_end'])) {
			$this->data['error_date_end'] = $this->error['date_end'];
		} else {
			$this->data['error_date_end'] = '';
		}
		$url                         = '';
		$this->data['breadcrumbs']   = array();
		$this->data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);
		$this->data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('catalog/fields', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);
		if (!isset($this->request->get['field_id'])) {
			$this->data['action'] = $this->url->link('catalog/fields/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('catalog/fields/update', 'token=' . $this->session->data['token'] . '&field_id=' . $this->request->get['field_id'] . $url, 'SSL');
		}
		$this->data['cancel'] = $this->url->link('catalog/fields', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['token']  = $this->session->data['token'];
		if (isset($this->request->get['field_id'])) {
			$field_info = $this->model_catalog_fields->getField($this->request->get['field_id']);
		}
		$this->load->model('localisation/language');
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		foreach ($this->data['languages'] as $code => $language) {
			if (!isset($language['image'])) {
            	$this->data['languages'][$code]['image'] = "language/".$code."/".$code.".png";
			} else {
                $this->data['languages'][$code]['image'] = "view/image/flags/".$language['image'];
			}
			if (!file_exists(DIR_APPLICATION.$this->data['languages'][$code]['image'])) {
				$this->data['languages'][$code]['image'] = "view/image/seocms/sc_1x1.png";
			}
		}

		if (isset($this->request->post['field_name'])) {
			$this->data['field_name'] = $this->request->post['field_name'];
		} elseif (isset($this->request->get['field_name'])) {
			$this->data['field_name'] = $this->request->get['field_name'];
		} elseif (!empty($field_info)) {
			$this->data['field_name'] = $field_info['field_name'];
		} else {
			$this->data['field_name'] = '';
		}
		if (isset($this->request->post['field_type'])) {
			$this->data['field_type'] = $this->request->post['field_type'];
		} elseif (!empty($field_info)) {
			$this->data['field_type'] = $field_info['field_type'];
		} else {
			$this->data['field_type'] = '';
		}
		if (isset($this->request->post['field_must'])) {
			$this->data['field_must'] = $this->request->post['field_must'];
		} elseif (!empty($field_info)) {
			$this->data['field_must'] = $field_info['field_must'];
		} else {
			$this->data['field_must'] = '0';
		}
		if (isset($this->request->post['field_description'])) {
			$this->data['field_description'] = $this->request->post['field_description'];
		} elseif (isset($this->request->get['field_id'])) {
			$this->data['field_description'] = $this->model_catalog_fields->getFieldDescriptions($this->request->get['field_id']);
		} else {
			$this->data['field_description'] = array();
		}
		if (!empty($field_info)) {
			$this->data['field_image'] = $field_info['field_image'];
		} else {
			$this->data['field_image'] = '';
		}
		$this->load->model('tool/image');
		if (!empty($field_info) && $field_info['field_image'] && file_exists(DIR_IMAGE . $field_info['field_image'])) {
			$this->data['thumb'] = $this->model_tool_image->resize($field_info['field_image'], 100, 100);
		} else {
			$this->data['thumb'] = $this->data['no_image'] = $this->model_tool_image->resize($no_image, 100, 100);
		}
		if (isset($this->request->post['field_order'])) {
			$this->data['field_order'] = $this->request->post['field_order'];
		} elseif (!empty($field_info)) {
			$this->data['field_order'] = $field_info['field_order'];
		} else {
			$this->data['field_order'] = '';
		}
		if (isset($this->request->post['field_status'])) {
			$this->data['field_status'] = $this->request->post['field_status'];
		} else if (!empty($field_info)) {
			$this->data['field_status'] = $field_info['field_status'];
		} else {
			$this->data['field_status'] = 1;
		}
		if (isset($this->request->post['field_public'])) {
			$this->data['field_public'] = $this->request->post['field_public'];
		} else if (!empty($field_info)) {
			$this->data['field_public'] = $field_info['field_public'];
		} else {
			$this->data['field_public'] = 1;
		}
		$this->data['this']     = $this;
		$this->template         = 'catalog/fields_form.tpl';
		$this->children         = array(
			'common/header',
			'common/footer'
		);
		$this->data['registry'] = $this->registry;
		$this->data['language'] = $this->language;
		$this->data['config']   = $this->config;
		if (SC_VERSION < 20) {
			$this->data['column_left'] = '';
			$html                      = $this->render();
		} else {
			$this->data['header']      = $this->load->controller('common/header');
			$this->data['menu']        = $this->load->controller('common/menu');
			$this->data['footer']      = $this->load->controller('common/footer');
			$this->data['column_left'] = $this->load->controller('common/column_left');
			$html                      = $this->load->view($this->template, $this->data);
		}
		$this->response->setOutput($html);
	}
	private function validateForm()
	{
		if (!$this->user->hasPermission('modify', 'catalog/fields')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		$this->request->post['field_name'] = preg_replace("/[^a-zA-Z0-9_\s]/", "", $this->request->post['field_name']);
		if ($this->request->post['field_name'] == '') {
			$this->error['warning'] = $this->language->get('error_name');
		}
		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
	private function validateDelete()
	{
		if (!$this->user->hasPermission('modify', 'catalog/fields')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
	private function validateCopy()
	{
		if (!$this->user->hasPermission('modify', 'catalog/fields')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
	public function autocomplete()
	{
		$this->data['this'] = $this;
		$json               = array();
		if (isset($this->request->get['value'])) {
			if (isset($this->request->get['value'])) {
				$value = $this->request->get['value'];
			} else {
				$value = '';
			}
			$fields_info = $this->getFields();
			foreach ($fields_info as $num => $result) {
				$json[] = array(
					'name' => strip_tags(html_entity_decode($result['field_name'], ENT_QUOTES, 'UTF-8'))
				);
			}
		}
		$this->response->setOutput(json_encode($json));
	}
	public function cont($cont)
	{
		$file = DIR_CATALOG . 'controller/' . $cont . '.php';
		if (file_exists($file)) {
			$this->cont_loading($cont, $file);
		} else {
			$file = DIR_APPLICATION . 'controller/' . $cont . '.php';
			if (file_exists($file)) {
				$this->cont_loading($cont, $file);
			} else {
				trigger_error('Error: Could not load controller ' . $cont . '!');
				exit();
			}
		}
	}
	private function cont_loading($cont, $file)
	{
		$class = 'Controller' . preg_replace('/[^a-zA-Z0-9]/', '', $cont);
		include_once($file);
		$this->registry->set('controller_' . str_replace('/', '_', $cont), new $class($this->registry));
	}
}
