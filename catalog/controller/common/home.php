<?php
class ControllerCommonHome extends Controller {
	public function index() {
		$this->document->setTitle($this->config->get('config_meta_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));
		$this->document->setKeywords($this->config->get('config_meta_keyword'));

		if (isset($this->request->get['route'])) {
			$this->document->addLink(HTTP_SERVER, 'canonical');
		}

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$data['decorative'] = $this->url->link('product/category', 'path=61');
		$data['shrubbery'] = $this->url->link('product/category', 'path=62');
		$data['fruit'] = $this->url->link('product/category', 'path=60');
		$data['roses'] = $this->url->link('product/category', 'path=59');


		$data['decorative_text'] = $this->language->get('decorative_text');
		$data['shrubbery_text'] = $this->language->get('shrubbery_text');
		$data['fruit_text'] = $this->language->get('fruit_text');
		$data['roses_text'] = $this->language->get('roses_text');

        $data['insta'] = $this->language->get('insta');
		

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/home.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/common/home.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/common/home.tpl', $data));
		}
	}
}

