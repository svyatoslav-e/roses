<?php
/* All rights reserved belong to the module, the module developers http://opencartadmin.com */
// http://opencartadmin.com © 2011-2016 All Rights Reserved
// Distribution, without the author's consent is prohibited
// Commercial license
class ControllerFeedGoogleSitemapBlog extends Controller
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
		$this->load->language('feed/google_sitemap_blog');
		$this->data['tab_general']      = $this->language->get('tab_general');
		$this->data['tab_list']         = $this->language->get('tab_list');
		$this->data['url_modules_text'] = $this->language->get('url_modules_text');
		if (file_exists(DIR_APPLICATION . 'view/stylesheet/seocmspro.css')) {
			$this->document->addStyle('view/stylesheet/seocmspro.css');
		}
		if (file_exists(DIR_APPLICATION . 'view/javascript/blog/seocmspro.js')) {
			$this->document->addScript('view/javascript/blog/seocmspro.js');
		}
		$this->data['url_modules']      = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_options']      = $this->url->link('module/blog', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_schemes']      = $this->url->link('module/blog/schemes', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_widgets']      = $this->url->link('module/blog/widgets', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_back']         = $this->url->link('module/blog', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_back_text']    = $this->language->get('url_back_text');
		$this->data['url_blog']         = $this->url->link('catalog/blog', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_sitemap']      = $this->url->link('feed/google_sitemap_blog', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_sitemap_file'] = $this->url->link('feed/google_sitemap_blog/gen_sitemap', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['url_comment']      = $this->url->link('catalog/comment', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_record']       = $this->url->link('catalog/record', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_blog_text']    = $this->language->get('url_blog_text');
		$this->data['url_sitemap_text'] = $this->language->get('url_sitemap_text');
		$this->data['url_comment_text'] = $this->language->get('url_comment_text');
		$this->data['url_create_text']  = $this->language->get('url_create_text');
		$this->data['url_record_text']  = $this->language->get('url_record_text');

		$this->data['text_loading']  = $this->language->get('text_loading');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

			$this->model_setting_setting->editSetting('google_sitemap_blog', $this->request->post);
			$this->model_setting_setting->editSetting('ascp_settings_sitemap', $this->request->post);
            $this->config->set("blog_work", false);
            $this->cache->delete('blog');
			$this->session->data['success'] = $this->language->get('text_success');

			if (SC_VERSION < 20) {
				//$this->redirect($this->url->link('extension/feed', 'token=' . $this->session->data['token'], 'SSL'));
			} else {
				//$this->response->redirect($this->url->link('extension/feed', 'token=' . $this->session->data['token'], 'SSL'));
			}
		}


		if (isset($this->request->post['ascp_settings_sitemap'])) {
			$this->data['ascp_settings_sitemap'] = $this->request->post['ascp_settings_sitemap'];
		} else {
			$this->data['ascp_settings_sitemap'] = $this->config->get('ascp_settings_sitemap');
		}

		$this->data['heading_title']   = $this->language->get('heading_title');
		$this->data['text_enabled']    = $this->language->get('text_enabled');
		$this->data['text_disabled']   = $this->language->get('text_disabled');
		$this->data['entry_status']    = $this->language->get('entry_status');
		$this->data['entry_language_status']    = $this->language->get('entry_language_status');
		$this->data['entry_inter_status']    = $this->language->get('entry_inter_status');
		$this->data['entry_inter_tag']    = $this->language->get('entry_inter_tag');
		$this->data['entry_file_sitemap']    = $this->language->get('entry_file_sitemap');
		$this->data['entry_inter_route']    = $this->language->get('entry_inter_route');
		$this->data['entry_data_feed'] = $this->language->get('entry_data_feed');

		$this->data['entry_cache_status'] = $this->language->get('entry_cache_status');
		$this->data['entry_image_status'] = $this->language->get('entry_image_status');
		$this->data['entry_page_status'] = $this->language->get('entry_page_status');
		$this->data['entry_cache_expire'] = $this->language->get('entry_cache_expire');

		$this->data['button_save']     = $this->language->get('button_save');
		$this->data['button_cancel']   = $this->language->get('button_cancel');
		$this->data['tab_general']     = $this->language->get('tab_general');
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
		$this->data['breadcrumbs']   = array();
		$this->data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);
		$this->data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_feed'),
			'href' => $this->url->link('extension/feed', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);
		$this->data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('feed/google_sitemap_blog', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);
		$this->data['action']        = $this->url->link('feed/google_sitemap_blog', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['cancel']        = $this->url->link('extension/feed', 'token=' . $this->session->data['token'], 'SSL');

        $this->cont('agooa/adminmenu');
        $this->data['agoo_menu'] = $this->controller_agooa_adminmenu->index();


		if (isset($this->request->post['google_sitemap_blog_status'])) {
			$this->data['google_sitemap_blog_status'] = $this->request->post['google_sitemap_blog_status'];
		} else {
			$this->data['google_sitemap_blog_status'] = $this->config->get('google_sitemap_blog_status');
		}

		if (!isset($this->data['ascp_settings_sitemap']['google_sitemap_blog_language_status'])) {
			$this->data['ascp_settings_sitemap']['google_sitemap_blog_language_status'] = true;
		}

		if (!isset($this->data['ascp_settings_sitemap']['google_sitemap_blog_cache_status'])) {
			$this->data['ascp_settings_sitemap']['google_sitemap_blog_cache_status'] = true;
		}

		if (!isset($this->data['ascp_settings_sitemap']['google_sitemap_blog_image_status'])) {
			$this->data['ascp_settings_sitemap']['google_sitemap_blog_image_status'] = true;
		}

		if (!isset($this->data['ascp_settings_sitemap']['google_sitemap_blog_page_status'])) {
			$this->data['ascp_settings_sitemap']['google_sitemap_blog_page_status'] = true;
		}

		if (!isset($this->data['ascp_settings_sitemap']['google_sitemap_blog_cache_expire'])) {
			$this->data['ascp_settings_sitemap']['google_sitemap_blog_cache_expire'] = 360000;
		}

		if (!isset($this->data['ascp_settings_sitemap']['google_sitemap_blog_inter_tag']) || $this->data['ascp_settings_sitemap']['google_sitemap_blog_inter_tag']=='') {
			$this->data['ascp_settings_sitemap']['google_sitemap_blog_inter_tag'] = '</urlset>';
		}

		if (!isset($this->data['ascp_settings_sitemap']['google_sitemap_blog_file_sitemap']) || $this->data['ascp_settings_sitemap']['google_sitemap_blog_file_sitemap']=='') {
			$this->data['ascp_settings_sitemap']['google_sitemap_blog_file_sitemap'] = 'sitemap.xml';
		}

		if (!isset($this->data['ascp_settings_sitemap']['google_sitemap_blog_inter_route']) || $this->data['ascp_settings_sitemap']['google_sitemap_blog_inter_route']=='') {
			$this->data['ascp_settings_sitemap']['google_sitemap_blog_inter_route'] = 'feed/google_sitemap';
		}

		$this->data['data_feed'] = HTTP_CATALOG . 'index.php?route=record/google_sitemap_blog';
		$this->data['data_feed_file_sitemap'] = HTTP_CATALOG .$this->data['ascp_settings_sitemap']['google_sitemap_blog_file_sitemap'];


		$this->template          = 'feed/google_sitemap_blog.tpl';
		$this->children          = array(
			'common/header',
			'common/footer'
		);
		$this->data['registry']  = $this->registry;
		$this->data['language']  = $this->language;
		$this->data['config']    = $this->config;
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
	private function validate()
	{
		if (!$this->user->hasPermission('modify', 'feed/google_sitemap_blog')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	public function gen_sitemap() {

		$this->load->language('feed/google_sitemap_blog');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate() && $this->request->post['file_sitemap']!='') {
            $sitemap_html = '';
	     	$html = $this->request->post['file_sitemap'];

			$path = str_replace("//", "/", "../".$this->request->post['file_sitemap']);


			if (mkdirs($path)) {

				$this->template = 'agooa/google_sitemap_file.tpl';
                $this->data['path'] = str_replace("//", "/", $this->request->post['file_sitemap']);
                $this->data['token'] = $this->session->data['token'];
                $this->data['url_gen_sitemap'] = ($this->config->get('config_secure') ? HTTPS_CATALOG : HTTP_CATALOG ).'index.php?route=record/google_sitemap_blog/gen_sitemap';
                $this->data['text_loading_generator']  = $this->language->get('text_loading_generator');
		        if (SC_VERSION < 20) {
					$html = $this->render();
				} else {
					$html = $this->load->view($this->template , $this->data);
				}

			} else {
       	    	$html = $this->language->get('error_create_file');
			}

	    } else {
	    	$html = $this->language->get('error_permission');
	    }

   	    $this->response->setOutput($html);

	}

/***************************************/
	public function cont($cont)
	{
		$file  = DIR_CATALOG . 'controller/' . $cont . '.php';
		if (file_exists($file)) {
     		$this->cont_loading($cont, $file);
     		return true;
		} else {
			$file  = DIR_APPLICATION . 'controller/' . $cont . '.php';
            if (file_exists($file)) {
             	$this->cont_loading($cont, $file);
             	return true;
            } else {
				trigger_error('Error: Could not load controller ' . $cont . '!');
            	return false;
			}
		}
	}
	private function cont_loading ($cont, $file)
	{
			$class = 'Controller' . preg_replace('/[^a-zA-Z0-9]/', '', $cont);
			include_once($file);
			$this->registry->set('controller_' . str_replace('/', '_', $cont), new $class($this->registry));
	}
/***************************************/




}
require_once(DIR_SYSTEM . 'helper/seocmsprofunc.php');