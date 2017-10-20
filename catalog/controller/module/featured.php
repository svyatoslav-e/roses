<?php
class ControllerModuleFeatured extends Controller {
	public function index($setting) {
		$this->load->language('module/featured');

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_tax'] = $this->language->get('text_tax');

		$data['button_cart'] = $this->language->get('button_cart');
		$data['button_wishlist'] = $this->language->get('button_wishlist');
		$data['button_compare'] = $this->language->get('button_compare');
        $data['button_view_more'] = $this->language->get('button_view_more');

		//my 
		$data['button_view_all'] = $this->language->get('button_view_all');

		$this->load->model('catalog/product');

		$this->load->model('tool/image');

		$data['indicator'] =  rand (5, 126);

		$data['products'] = array();

		if (!$setting['limit']) {
			$setting['limit'] = 4;
		}

		$bestsellers = $this->model_catalog_product->getBestSeller(20);

		$data['best']=$bestsellers;


		$datenow = date ("Y-m-d H:m:s");

		

		if (!empty($setting['product'])) {
			$products = array_slice($setting['product'], 0, (int)$setting['limit']);

			// print_r($products);

			foreach ($products as $product_id) {
				$product_info = $this->model_catalog_product->getProduct($product_id);



				if ($product_info) {


				if (in_array($product_info['product_id'], $bestsellers)){
                  $bestseller = true;
				}else{
                  $bestseller = false;
				}

					if ($product_info['image']) {
						$image = $this->model_tool_image->resize($product_info['image'], $setting['width'], $setting['height']);
					} else {
						$image = $this->model_tool_image->resize('placeholder.png', $setting['width'], $setting['height']);
					}

					if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
						$price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')));
					} else {
						$price = false;
					}

					if ((float)$product_info['special']) {
						$special = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')));
					} else {
						$special = false;
					}

					if ($this->config->get('config_tax')) {
						$tax = $this->currency->format((float)$product_info['special'] ? $product_info['special'] : $product_info['price']);
					} else {
						$tax = false;
					}

					if ($this->config->get('config_review_status')) {
						$rating = $product_info['rating'];
					} else {
						$rating = false;
					}

					$data['products'][] = array(
						'product_id'  => $product_info['product_id'],
						'bestseller'  => $bestseller,
					    'come'        => floor ((strtotime($datenow) - strtotime($product_info['date_available'])) / 86400),
						'thumb'       => $image,
						'cid'	  => $this->model_catalog_product->getRowValue('product_to_category', 'category_id', 'product_id='.$product_info['product_id']),
						'name'        => $product_info['name'],
						'description' =>$data['button_view_more'].utf8_substr(strip_tags(html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')),
						'price'       => $price,
						'special'     => $special,
						'tax'         => $tax,
						'rating'      => $rating,
						'href'        => $this->url->link('product/product', 'product_id=' . $product_info['product_id'])
					);



				}
			}


		}


// 		$categories = $this->model_catalog_product->getCategories($product_id);
// if ($categories)
//    $categories_info = $this->model_catalog_category->getCategory($categories[0]['category_id']);
// $this->data['category_title'] = $categories_info['name'];

		if ($data['products']) {
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/featured.tpl')) {
				return $this->load->view($this->config->get('config_template') . '/template/module/featured.tpl', $data);
			} else {
				return $this->load->view('default/template/module/featured.tpl', $data);
			}
		}




	}
}

