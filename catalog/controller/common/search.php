<?php
class ControllerCommonSearch extends Controller {
	public function index() {
		$this->load->language('common/search');

		$data['text_search'] = $this->language->get('text_search');
    $data['text_label'] = $this->language->get('text_label');
    $data['text_empty'] = $this->language->get('text_empty');
    $data['text_search'] = $this->language->get('text_search');
    $data['text_keyword'] = $this->language->get('text_keyword');
    $data['text_category'] = $this->language->get('text_category');
    $data['text_sub_category'] = $this->language->get('text_sub_category');
    $data['text_quantity'] = $this->language->get('text_quantity');
    $data['text_manufacturer'] = $this->language->get('text_manufacturer');
    $data['text_model'] = $this->language->get('text_model');
    $data['text_price'] = $this->language->get('text_price');
    $data['text_tax'] = $this->language->get('text_tax');
    $data['text_points'] = $this->language->get('text_points');
    $data['text_compare'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));
    $data['text_sort'] = $this->language->get('text_sort');
    $data['text_limit'] = $this->language->get('text_limit');
    $data['text_close_search'] = $this->language->get('text_close_search');

    $data['entry_search'] = $this->language->get('entry_search');
    $data['entry_description'] = $this->language->get('entry_description');

    $data['button_search'] = $this->language->get('button_search');
    $data['button_cart'] = $this->language->get('button_cart');
    $data['button_wishlist'] = $this->language->get('button_wishlist');
    $data['button_compare'] = $this->language->get('button_compare');
    $data['button_list'] = $this->language->get('button_list');
    $data['button_grid'] = $this->language->get('button_grid');

		if (isset($this->request->get['search'])) {
			$data['search'] = $this->request->get['search'];
		} else {
			$data['search'] = '';
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/search.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/common/search.tpl', $data);
		} else {
			return $this->load->view('default/template/common/search.tpl', $data);
		}
	}
}