<?php

/*
 * Fast Sitemap [xml]
 * by dub(nix)
 */

class ControllerFeedFastSitemap extends Controller {
	private $error = array(); 

	public function index() {
		$this->language->load('feed/fast_sitemap');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('fast_sitemap', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('extension/feed', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_cache_status'] = $this->language->get('entry_cache_status');
		$this->data['entry_data_feed'] = $this->language->get('entry_data_feed');
		$this->data['bt_clear_cache'] = $this->language->get('bt_clear_cache');
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_feed'),
			'href'      => $this->url->link('extension/feed', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('feed/fast_sitemap', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

		$this->data['action'] = $this->url->link('feed/fast_sitemap', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['cancel'] = $this->url->link('extension/feed', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['clear_cache'] = $this->url->link('feed/fast_sitemap/clear_cache', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['fast_sitemap_status'])) {
			$this->data['fast_sitemap_status'] = $this->request->post['fast_sitemap_status'];
		} else {
			$this->data['fast_sitemap_status'] = $this->config->get('fast_sitemap_status');
		}
		if (isset($this->request->post['f_s_cache_status'])) {
			$this->data['f_s_cache_status'] = $this->request->post['f_s_cache_status'];
		} else {
			$this->data['f_s_cache_status'] = $this->config->get('f_s_cache_status');
		}

		$this->data['data_feed'] = HTTP_CATALOG . 'index.php?route=feed/fast_sitemap';

		$this->template = 'feed/fast_sitemap.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	public function clear_cache() {
		$this->language->load('feed/fast_sitemap');

		$json = array();

		if ($this->cache->get('fast_sitemap')) {
			$this->cache->delete('fast_sitemap');
			$text_success = $this->language->get('text_cache_success');
		} else {
			$text_success = $this->language->get('text_cache_empty');
		}

		$json['success'] = '<b>' . $text_success . '</b>';

		$this->response->setOutput(json_encode($json));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'feed/fast_sitemap')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}
?>