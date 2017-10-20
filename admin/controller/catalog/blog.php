<?php
/* All rights reserved belong to the module, the module developers http://opencartadmin.com */
// http://opencartadmin.com © 2011-2016 All Rights Reserved
// Distribution, without the author's consent is prohibited
// Commercial license
class ControllerCatalogBlog extends Controller
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
		$this->data['tab_general']  = $this->language->get('tab_general');
		$this->data['tab_list']     = $this->language->get('tab_list');

        $this->cont('agooa/adminmenu');
        $this->data['agoo_menu'] = $this->controller_agooa_adminmenu->index();
        if ($this->config->get('asc_cnt_cnt')!='fec00258b41bb6fb92a7feb8ccb0bed9') {
        $this->model_setting_setting->editSetting('ascp_version_model', Array('ascp_version_model'=>$this->language->get('blog_version_model')." &copy;"));
        }

        $this->config->set("blog_work", true);

		$this->getList();
	}
//**********************************************************************************************************************************************************************************
	public function insert()
	{
		$this->config->set("blog_work", false);
		$this->cache->delete('blog');
		 $this->config->set("blog_work", true);


		$this->language->load('seocms/catalog/blog');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('catalog/blog');
		$this->cache->delete('blog');
		$this->cache->delete('record');
		$this->cache->delete('blogsrecord');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_blog->addBlog($this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
           if (!isset($this->request->post['button_apply']) || !$this->request->post['button_apply']) {
				if (SC_VERSION < 20) {
					$this->redirect($this->url->link('catalog/blog', 'token=' . $this->session->data['token'], 'SSL'));
				} else {
					$this->response->redirect($this->url->link('catalog/blog', 'token=' . $this->session->data['token'], 'SSL'));
				}
			}
		}
		$this->getForm();
	}
//**********************************************************************************************************************************************************************************
	public function update()
	{
		$this->config->set("blog_work", false);
		$this->cache->delete('blog');
		 $this->config->set("blog_work", true);


		$this->language->load('seocms/catalog/blog');
		$this->cache->delete('blog');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('catalog/blog');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

			$this->model_catalog_blog->editBlog($this->request->get['blog_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			if (!isset($this->request->post['button_apply']) || !$this->request->post['button_apply']) {
				if (SC_VERSION < 20) {
					$this->redirect($this->url->link('catalog/blog', 'token=' . $this->session->data['token'], 'SSL'));
				} else {
					$this->response->redirect($this->url->link('catalog/blog', 'token=' . $this->session->data['token'], 'SSL'));
				}
			}
		}

		$this->getForm();
	}
//**********************************************************************************************************************************************************************************
	public function delete()
	{
		$this->config->set("blog_work", false);
		$this->cache->delete('blog');
		 $this->config->set("blog_work", true);


		$this->language->load('seocms/catalog/blog');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('catalog/blog');
		$this->cache->delete('blog');
		$this->cache->delete('record');
		$this->cache->delete('blogsrecord');
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $blog_id) {
				$this->model_catalog_blog->deleteBlog($blog_id);
			}
			$this->session->data['success'] = $this->language->get('text_success');
			if (SC_VERSION < 20) {
				$this->redirect($this->url->link('catalog/blog', 'token=' . $this->session->data['token'], 'SSL'));
			} else {
				$this->response->redirect($this->url->link('catalog/blog', 'token=' . $this->session->data['token'], 'SSL'));
			}
		}
		$this->getList();
	}
//**********************************************************************************************************************************************************************************
	private function getList()
	{
		if (file_exists(DIR_APPLICATION . 'view/stylesheet/seocmspro.css')) {
			$this->document->addStyle('view/stylesheet/seocmspro.css');
		}
		if (file_exists(DIR_APPLICATION . 'view/javascript/blog/seocmspro.js')) {
			$this->document->addScript('view/javascript/blog/seocmspro.js');
		}
		$this->load->model('catalog/blog');
		$this->language->load('seocms/catalog/blog');
		$this->data['heading_title']    = $this->language->get('heading_title');
		$this->data['url_back']         = $this->url->link('module/blog', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_back_text']    = $this->language->get('url_back_text');
		$this->data['url_modules']      = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_options']      = $this->url->link('module/blog', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_schemes']      = $this->url->link('module/blog/schemes', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_widgets']      = $this->url->link('module/blog/widgets', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_modules_text'] = $this->language->get('url_modules_text');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->data['breadcrumbs']   = array();
		$this->data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);
		$this->data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('catalog/blog', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);
		$this->data['insert']        = $this->url->link('catalog/blog/insert', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['delete']        = $this->url->link('catalog/blog/delete', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['categories']    = array();
		$results                     = $this->model_catalog_blog->getCategories(0);
		$this->load->model('tool/image');
		$no_image = '';
		if (file_exists(DIR_IMAGE . 'no_image.jpg')) {
			$no_image = 'no_image.jpg';
		}
		if (file_exists(DIR_IMAGE . 'no_image.png')) {
			$no_image = 'no_image.png';
		}
		foreach ($results as $result) {
			$action   = array();
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('catalog/blog/update', 'token=' . $this->session->data['token'] . '&blog_id=' . $result['blog_id'], 'SSL')
			);
			if (isset($result['image']) && $result['image'] != '' && file_exists(DIR_IMAGE . $result['image'])) {
				$image = $this->model_tool_image->resize($result['image'], 40, 40);
			} else {
				$image = $this->model_tool_image->resize($no_image, 40, 40);
			}
			$this->data['categories'][] = array(
				'blog_id' => $result['blog_id'],
				'name' => $result['name'],
				'image' => $image,
				'sort_order' => $result['sort_order'],
				'selected' => isset($this->request->post['selected']) && in_array($result['blog_id'], $this->request->post['selected']),
				'action' => $action
			);
		}
		$this->data['heading_title']     = $this->language->get('heading_title');
		$this->data['text_no_results']   = $this->language->get('text_no_results');
		$this->data['column_name']       = $this->language->get('column_name');
		$this->data['column_sort_order'] = $this->language->get('column_sort_order');
		$this->data['column_action']     = $this->language->get('column_action');
		$this->data['button_insert']     = $this->language->get('button_insert');
		$this->data['button_delete']     = $this->language->get('button_delete');
		$this->data['url_blog']          = $this->url->link('catalog/blog', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_record']        = $this->url->link('catalog/record', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_comment']       = $this->url->link('catalog/comment', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_blog_text']     = $this->language->get('url_blog_text');
		$this->data['url_record_text']   = $this->language->get('url_record_text');
		$this->data['url_comment_text']  = $this->language->get('url_comment_text');
		$this->data['url_create_text']   = $this->language->get('url_create_text');
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
		$this->template         = 'catalog/blog_list.tpl';
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

//**********************************************************************************************************************************************************************************

	private function get_access ($data)
	{
		 $this->config->set("blog_work", true);

		$this->data = $data;


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

	    $this->data['customer_groups_blog'] = $this->data['customer_groups'];

	    if ($this->data['blog_id']) {
		    $this->data['blog_access'] = $this->model_catalog_blog->getBlogAccess($this->data['blog_id']);
	    }

	    return $this->data;
	}
//**********************************************************************************************************************************************************************************

	public function blog_access()
	{
		 $this->config->set("blog_work", true);



		if (!$this->validateDelete()) {
		 return;
		}

		if (isset($this->request->get['group'])) {
			$group = $this->request->get['group'];
		} else {
			$group = false;
		}

    	if (isset($this->request->get['blog_id'])) {
			$blog_id = $this->request->get['blog_id'];
		} else {
			$blog_id = false;
		}

    	if (isset($this->request->get['ch']) && $this->request->get['ch']=='1') {
			$check = $this->request->get['ch'];
		} else {
			$check = false;
		}

		$this->load->model('catalog/record');
		$results = $this->model_catalog_record->getRecordsByBlogId($blog_id);

		foreach ($results as $num => $record) {
          $this->model_catalog_record->setRecordAccessGroup($record['record_id'] ,$group, $check);
		}

        /*
        echo $group." -> ".$blog_id;
        print_r($results);
         */
	    //return $group;

	}

//**********************************************************************************************************************************************************************************
	private function getForm()
	{
		$this->config->set("blog_work", true);

        $this->data['ascp_settings'] = $this->config->get('ascp_settings');

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
		$no_image = 'no_image.jpg';
		if (file_exists(DIR_IMAGE . 'no_image.jpg')) {
			$no_image = 'no_image.jpg';
		}
		if (file_exists(DIR_IMAGE . 'no_image.png')) {
			$no_image = 'no_image.png';
		}
		$this->language->load('module/blog');
		$this->language->load('seocms/catalog/blog');



		$this->data['blog_version'] = 'PRO.*';
		$this->data['oc_version']   = str_pad(str_replace(".", "", VERSION), 7, "0");
		$this->load->model('setting/setting');
		$settings_admin = $this->model_setting_setting->getSetting('ascp_version', 'ascp_version');
		foreach ($settings_admin as $key => $value) {
			$this->data['blog_version'] = $value;
		}

        $this->cont('agooa/adminmenu');
        $this->data['agoo_menu'] = $this->controller_agooa_adminmenu->index();

		$this->data['url_modules']                = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_options']                = $this->url->link('module/blog', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_schemes']                = $this->url->link('module/blog/schemes', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_widgets']                = $this->url->link('module/blog/widgets', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_modules_text']           = $this->language->get('url_modules_text');
		$this->data['url_back_text']              = $this->language->get('url_back_text');
		$this->data['text_none']                  = $this->language->get('text_none');
		$this->data['text_default']               = $this->language->get('text_default');
		$this->data['text_image_manager']         = $this->language->get('text_image_manager');
		$this->data['text_browse']                = $this->language->get('text_browse');
		$this->data['text_clear']                 = $this->language->get('text_clear');
		$this->data['text_enabled']               = $this->language->get('text_enabled');
		$this->data['text_disabled']              = $this->language->get('text_disabled');
		$this->data['text_percent']               = $this->language->get('text_percent');
		$this->data['text_amount']                = $this->language->get('text_amount');
		$this->data['text_yes']                   = $this->language->get('text_yes');
		$this->data['text_no']                    = $this->language->get('text_no');
		$this->data['entry_name']                 = $this->language->get('entry_name');
		$this->data['entry_customer_group']       = $this->language->get('entry_customer_group');
		$this->data['entry_short_path']           = $this->language->get('entry_short_path');
		$this->data['entry_meta_keyword']         = $this->language->get('entry_meta_keyword');
		$this->data['entry_meta_description']     = $this->language->get('entry_meta_description');
		$this->data['entry_description']          = $this->language->get('entry_description');
		$this->data['entry_store']                = $this->language->get('entry_store');
		$this->data['entry_keyword']              = $this->language->get('entry_keyword');
		$this->data['entry_parent']               = $this->language->get('entry_parent');
		$this->data['entry_image']                = $this->language->get('entry_image');
		$this->data['entry_top']                  = $this->language->get('entry_top');
		$this->data['entry_column']               = $this->language->get('entry_column');
		$this->data['entry_sort_order']           = $this->language->get('entry_sort_order');
		$this->data['entry_status']               = $this->language->get('entry_status');
		$this->data['entry_layout']               = $this->language->get('entry_layout');
		$this->data['button_save']                = $this->language->get('button_save');
		$this->data['button_apply']               = $this->language->get('button_apply');
		$this->data['button_cancel']              = $this->language->get('button_cancel');
		$this->data['tab_gen']                    = $this->language->get('tab_gen');
		$this->data['tab_data']                   = $this->language->get('tab_data');
		$this->data['tab_design']                 = $this->language->get('tab_design');
		$this->data['tab_options']                = $this->language->get('tab_options');
		$this->data['url_back']                   = $this->url->link('module/blog', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_blog']                   = $this->url->link('catalog/blog', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_record']                 = $this->url->link('catalog/record', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_comment']                = $this->url->link('catalog/comment', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_blog_text']              = $this->language->get('url_blog_text');
		$this->data['url_record_text']            = $this->language->get('url_record_text');
		$this->data['url_comment_text']           = $this->language->get('url_comment_text');
		$this->data['url_create_text']            = $this->language->get('url_create_text');
		$this->data['entry_what']                 = $this->language->get('entry_what');
		$this->data['entry_small_dim']            = $this->language->get('entry_small_dim');
		$this->data['entry_big_dim']              = $this->language->get('entry_big_dim');
		$this->data['entry_blog_num_comments']    = $this->language->get('entry_blog_num_comments');
		$this->data['entry_blog_num_records']     = $this->language->get('entry_blog_num_records');
		$this->data['entry_blog_num_desc']        = $this->language->get('entry_blog_num_desc');
		$this->data['entry_blog_num_desc_words']  = $this->language->get('entry_blog_num_desc_words');
		$this->data['entry_blog_num_desc_pred']   = $this->language->get('entry_blog_num_desc_pred');
		$this->data['entry_blog_template']        = $this->language->get('entry_blog_template');
		$this->data['entry_blog_template_record'] = $this->language->get('entry_blog_template_record');
		$this->data['entry_devider']              = $this->language->get('entry_devider');
		$this->data['tab_general']                = $this->language->get('tab_general');
		$this->data['tab_list']                   = $this->language->get('tab_list');
		$this->data['url_blog']                   = $this->url->link('catalog/blog', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_record']                 = $this->url->link('catalog/record', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_comment']                = $this->url->link('catalog/comment', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_blog_text']              = $this->language->get('url_blog_text');
		$this->data['url_record_text']            = $this->language->get('url_record_text');
		$this->data['url_comment_text']           = $this->language->get('url_comment_text');
		$this->data['url_create_text']            = $this->language->get('url_create_text');
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
		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		if (isset($this->error['name'])) {
			$this->data['error_name'] = $this->error['name'];
		} else {
			$this->data['error_name'] = array();
		}
		if (isset($this->error['keyword'])) {
			$this->data['error_keyword'] = $this->error['keyword'];
		} else {
			$this->data['error_keyword'] = array();
		}



		$this->data['breadcrumbs']   = array();
		$this->data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);
		$this->data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('catalog/blog', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);



		if (!isset($this->request->get['blog_id'])) {
			$this->data['action'] = $this->url->link('catalog/blog/insert', 'token=' . $this->session->data['token'], 'SSL');
		} else {
			$this->data['action'] = $this->url->link('catalog/blog/update', 'token=' . $this->session->data['token'] . '&blog_id=' . $this->request->get['blog_id'], 'SSL');
		}

		if (!isset($this->request->get['blog_id'])) {
			$this->data['blog_id'] = false;
		} else {
			$this->data['blog_id'] = $this->request->get['blog_id'];
		}

		$this->data = $this->get_access($this->data);


		$this->data['cancel'] = $this->url->link('catalog/blog', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['token']  = $this->session->data['token'];
		if (isset($this->request->get['blog_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$blog_info             = $this->model_catalog_blog->getBlog($this->request->get['blog_id']);
			$this->data['keyword'] = $this->model_catalog_blog->getBlogKeywords($this->request->get['blog_id']);
		}

		if ((!isset($blog_info) || empty($blog_info)) && $this->data['blog_id']) {
			$blog_info = $this->model_catalog_blog->getBlog($this->request->get['blog_id']);
		}

		if ((!isset($this->data['keyword']) || $this->data['keyword']=='') && $this->data['blog_id']) {
			$this->data['keyword'] = $this->model_catalog_blog->getBlogKeywords($this->request->get['blog_id']);
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

		if (isset($this->request->post['blog_description'])) {
			$this->data['blog_description'] = $this->request->post['blog_description'];
		} elseif (isset($this->request->get['blog_id'])) {
			$this->data['blog_description'] = $this->model_catalog_blog->getBlogDescriptions($this->request->get['blog_id']);
		} else {
			$this->data['blog_description'] = array();
		}
		$categories = $this->model_catalog_blog->getCategories(0);
		if (!empty($blog_info)) {
			foreach ($categories as $key => $blog) {
				if ($blog['blog_id'] == $blog_info['blog_id']) {
					unset($categories[$key]);
				}
			}
		}
		$this->data['categories'] = $categories;
		if (isset($this->request->post['parent_id'])) {
			$this->data['parent_id'] = $this->request->post['parent_id'];
		} elseif (!empty($blog_info)) {
			$this->data['parent_id'] = $blog_info['parent_id'];
		} else {
			$this->data['parent_id'] = 0;
		}
		$this->load->model('setting/store');
		$this->data['stores'] = $this->model_setting_store->getStores();
		if (isset($this->request->post['blog_store'])) {
			$this->data['blog_store'] = $this->request->post['blog_store'];
		} elseif (isset($this->request->get['blog_id'])) {
			$this->data['blog_store'] = $this->model_catalog_blog->getBlogStores($this->request->get['blog_id']);
		} else {
			$this->data['blog_store'] = array(
				0
			);
		}
		if (isset($this->request->post['keyword'])) {
			$this->data['keyword'] = $this->request->post['keyword'];
		} elseif (!empty($this->data['keyword'])) {
			$this->data['keyword'] = $this->data['keyword'];
		} else {
			$this->data['keyword'] = '';
		}
		if (isset($this->request->post['image'])) {
			$this->data['image'] = $this->request->post['image'];
		} elseif (!empty($blog_info)) {
			$this->data['image'] = $blog_info['image'];
		} else {
			$this->data['image'] = '';
		}
		$this->load->model('tool/image');
		if (!empty($blog_info) && $blog_info['image'] && file_exists(DIR_IMAGE . $blog_info['image'])) {
			$this->data['thumb'] = $this->model_tool_image->resize($blog_info['image'], 100, 100);
		} else {
			$this->data['thumb'] = $this->model_tool_image->resize($no_image, 100, 100);
		}
		$this->data['no_image'] = $this->model_tool_image->resize($no_image, 100, 100);
		if (isset($this->request->post['top'])) {
			$this->data['top'] = $this->request->post['top'];
		} elseif (!empty($blog_info)) {
			$this->data['top'] = $blog_info['top'];
		} else {
			$this->data['top'] = 0;
		}
		if (isset($this->request->post['column'])) {
			$this->data['column'] = $this->request->post['column'];
		} elseif (!empty($blog_info)) {
			$this->data['column'] = $blog_info['column'];
		} else {
			$this->data['column'] = 1;
		}
		if (isset($this->request->post['sort_order'])) {
			$this->data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($blog_info)) {
			$this->data['sort_order'] = $blog_info['sort_order'];
		} else {
			$this->data['sort_order'] = '';
		}
		if (isset($this->request->post['status'])) {
			$this->data['status'] = $this->request->post['status'];
		} elseif (!empty($blog_info)) {
			$this->data['status'] = $blog_info['status'];
		} else {
			$this->data['status'] = 1;
		}

		if (isset($this->request->post['category_status'])) {
			$this->data['category_status'] = $this->request->post['category_status'];
		} elseif (!empty($blog_info) && isset($blog_info['category_status'])) {
			$this->data['category_status'] = $blog_info['category_status'];
		} else {
			$this->data['category_status'] = 1;
		}
		if (isset($this->request->post['view_date'])) {
			$this->data['view_date'] = $this->request->post['view_date'];
		} elseif (!empty($blog_info) && isset($blog_info['view_date'])) {
			$this->data['view_date'] = $blog_info['view_date'];
		} else {
			$this->data['view_date'] = 1;
		}

        if (file_exists(DIR_APPLICATION.'model/sale/customer_group.php')) {
        	$this->load->model('sale/customer_group');
			$model_customer = 'model_sale_customer_group';
		} else {
			$this->load->model('customer/customer_group');
			$model_customer = 'model_customer_customer_group';
		}
		$this->data['customer_groups'] = $this->$model_customer->getCustomerGroups();



		if (isset($this->request->post['customer_group_id'])) {
			$this->data['customer_group_id'] = $this->request->post['customer_group_id'];
		} elseif (!empty($blog_info) && isset($blog_info['customer_group_id'])) {
			$this->data['customer_group_id'] = $blog_info['customer_group_id'];
		} else {
			$this->data['customer_group_id'] = (int) $this->config->get('config_customer_group_id');
		}
		if (isset($this->request->post['blog_design'])) {
			$this->data['blog_design'] = $this->request->post['blog_design'];
		} elseif (!empty($blog_info)) {
			if (isset($blog_info['design']))
				$this->data['blog_design'] = unserialize($blog_info['design']);
			else
				$this->data['blog_design'] = Array();
		} else {
			$this->data['blog_design'] = Array();
		}
		if (!isset($this->data['blog_design']['visual_editor'])) {
			$this->data['blog_design']['visual_editor'] = 1;
		}
		if (!isset($this->data['blog_design']['category_status'])) {
			$this->data['blog_design']['category_status'] = 0;
		}
		if (!isset($this->data['blog_design']['view_date'])) {
			$this->data['blog_design']['view_date'] = 1;
		}
		if (!isset($this->data['blog_design']['view_captcha'])) {
			$this->data['blog_design']['view_captcha'] = 1;
		}
		if (!isset($this->data['blog_design']['next_status'])) {
			$this->data['blog_design']['next_status'] = 1;
		}
		if (!isset($this->data['blog_design']['status_pagination'])) {
			$this->data['blog_design']['status_pagination'] = 1;
		}
		if (!isset($this->data['blog_design']['order'])) {
			$this->data['blog_design']['order'] = 'latest';
		}

		if (!isset($this->data['blog_design']['view_share'])) {
			$this->data['blog_design']['view_share'] = 1;
		}
		if (!isset($this->data['blog_design']['view_viewed'])) {
			$this->data['blog_design']['view_viewed'] = 1;
		}
		if (!isset($this->data['blog_design']['view_rating'])) {
			$this->data['blog_design']['view_rating'] = 1;
		}
		if (!isset($this->data['blog_design']['view_comments'])) {
			$this->data['blog_design']['view_comments'] = 1;
		}

		if (!isset($this->data['blog_design']['title_status'])) {
			$this->data['blog_design']['title_status'] = 1;
		}
		if (!isset($this->data['blog_design']['image_adaptive_resize'])) {
			$this->data['blog_design']['image_adaptive_resize'] = 1;
		}
		if (!isset($this->data['blog_design']['images_adaptive_resize'])) {
			$this->data['blog_design']['images_adaptive_resize'] = 1;
		}
		if (!isset($this->data['blog_design']['image_status'])) {
			$this->data['blog_design']['image_status'] = 1;
		}
		if (!isset($this->data['blog_design']['image_category_adaptive_resize'])) {
			$this->data['blog_design']['image_category_adaptive_resize'] = 1;
		}

		if (!isset($this->data['blog_design']['image_gallery_status'])) {
			$this->data['blog_design']['image_gallery_status'] = 1;
		}
		if (!isset($this->data['blog_design']['image_product_status'])) {
			$this->data['blog_design']['image_product_status'] = 1;
		}

		if (!isset($this->data['blog_design']['images_number_hide'])) {
			$this->data['blog_design']['images_number_hide'] = 1;
		}

		if (!isset($this->data['blog_design']['image_record_status'])) {
			$this->data['blog_design']['image_record_status'] = 1;
		}

		if (!isset($this->data['blog_design']['image_gallery_adaptive_resize'])) {
			$this->data['blog_design']['image_gallery_adaptive_resize'] = 1;
		}

		if (!isset($this->data['blog_design']['image_record_adaptive_resize'])) {
			$this->data['blog_design']['image_record_adaptive_resize'] = 1;
		}

		if (!isset($this->data['blog_design']['records_more'])) {
			$this->data['blog_design']['records_more'] = 1;
		}

		if (isset($this->request->post['index_page'])) {
			$this->data['index_page'] = $this->request->post['index_page'];
		} elseif (!empty($blog_info)) {
			if (isset($blog_info['index_page'])) {
				$this->data['index_page'] =  explode(',',$blog_info['index_page']);
			} else {
				$this->data['index_page'] = Array();
			}

		} else {
			$this->data['index_page'][] = 'index';
			$this->data['index_page'][] = 'follow';
		}
        if (isset($this->request->get['blog_id'])) {
			$this->data['blog_layout'] = $this->model_catalog_blog->getBlogLayouts($this->request->get['blog_id']);
		} else {
			$this->data['blog_layout'] = false;
		}

		$this->load->model('design/layout');
		$this->data['layouts'] = $this->model_design_layout->getLayouts();
		$this->data['this']    = $this;
		$this->template        = 'catalog/blog_form.tpl';
		$this->children        = array(
			'common/header',
			'common/footer'
		);
		if (!isset($blog_info['name']))
			$blog_info['name'] = '';
		$this->data['heading_title']                 = $this->language->get('heading_title') . ' :: ' . $blog_info['name'];
		$this->data['registry']                      = $this->registry;
		$this->data['language']                      = $this->language;
		$this->data['config']                        = $this->config;
		$this->data['block_records_width_templates'] = array(
			$this->language->get('entry_block_records_width_templates_2') => '49%',
			$this->language->get('entry_block_records_width_templates_3') => '32%',
			$this->language->get('entry_block_records_width_templates_4') => '24%',
			$this->language->get('entry_block_records_width_templates_5') => '19%',
			$this->language->get('entry_value_templates_clear') => ""
		);

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
//**********************************************************************************************************************************************************************************
	private function validateForm()
	{
		$this->config->set("blog_work", true);
		if (!$this->user->hasPermission('modify', 'catalog/blog')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

        $handle = fopen(DIR_APPLICATION.'controller/module/blog.php', "r");
		$section = fread($handle, 6027);
		fclose($handle);
	    if (md5($section)!='37d987f3fbace83648a79251972c434a') {
        	$this->language->load('module/blog');
        	$this->load->model('setting/setting');
        	$this->model_setting_setting->editSetting('ascp_version_model', Array('ascp_version_model'=>$this->language->get('blog_version_model')." &copy;"));
			$this->model_setting_setting->editSetting('asc_cnt', Array('asc_cnt_cnt'=>md5('(c)')));
        } else {
        	$this->language->load('module/blog');
        	$this->load->model('setting/setting');
        	$rev_knil= $this->language->get('text_rev_knil');
        	$this->model_setting_setting->editSetting('ascp_version_model', Array('ascp_version_model'=>$this->language->get('blog_version_model')));
			$this->model_setting_setting->editSetting('asc_cnt', Array('asc_cnt_cnt'=>md5($rev_knil)));
        }

        $seo_url = array();
		foreach ($this->request->post['keyword'] as $language_id => $value) {
			if (isset($seo_url[$value])) {
             $this->error['keyword'][$language_id] = $this->language->get('error_keyword');
			}
	       if ($value!='') {
	          	$seo_url[$value] = $language_id;
	       }
		}


		foreach ($this->request->post['blog_description'] as $language_id => $value) {
			if ((utf8_strlen($value['name']) < 2) || (utf8_strlen($value['name']) > 255)) {
				$this->error['name'][$language_id] = $this->language->get('error_name');
			}
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
//**********************************************************************************************************************************************************************************
	private function validateDelete()
	{
		$this->config->set("blog_work", true);
		if (!$this->user->hasPermission('modify', 'catalog/blog')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
//**********************************************************************************************************************************************************************************
	public function cont($cont)
	{
		$file  = DIR_CATALOG . 'controller/' . $cont . '.php';
		if (file_exists($file)) {
           $this->cont_loading($cont, $file);
		} else {
			$file  = DIR_APPLICATION . 'controller/' . $cont . '.php';
            if (file_exists($file)) {
             	$this->cont_loading($cont, $file);
            } else {
				trigger_error('Error: Could not load controller ' . $cont . '!');
				exit();
			}
		}
	}
//**********************************************************************************************************************************************************************************
	private function cont_loading ($cont, $file)
	{
			$class = 'Controller' . preg_replace('/[^a-zA-Z0-9]/', '', $cont);
			include_once($file);
			$this->registry->set('controller_' . str_replace('/', '_', $cont), new $class($this->registry));
	}
}
