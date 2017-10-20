<?php
class ControllerFeedOcjGoogleSitemap extends Controller {
	public function index() {
		if ($this->config->get('google_sitemap_status')) {
			$output  = '<?xml version="1.0" encoding="UTF-8"?>';
			$output .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">';
			$output .= "\n";

			$this->load->model('catalog/product');
			$this->load->model('tool/image');

			$products = $this->model_catalog_product->getProducts();

			foreach ($products as $product) {
				$output .= "<url>\n";
				$output .= "  <loc>" . $this->url->link('product/product', 'product_id=' . $product['product_id']) . "</loc>\n";
				$output .= "  <changefreq>weekly</changefreq>\n";
				$output .= "  <priority>1.0</priority>\n";
				if ($product['image']) {
					$output .= "  <image:image>\n";
					$output .= '    <image:loc>' . $this->model_tool_image->resize(
						$product['image'],
						$this->config->get('config_image_popup_width'),
						$this->config->get('config_image_popup_height'))
						. "</image:loc>\n";
					$output .= '    <image:caption>' . $product['name'] . "</image:caption>\n";
					$output .= '    <image:title>' . $product['name'] . "</image:title>\n";
					$output .= "  </image:image>\n";
				}
				$output .= "</url>\n";
			}

			$this->load->model('catalog/category');
			$output .= $this->getCategories(0);

			$this->load->model('catalog/manufacturer');
			$manufacturers = $this->model_catalog_manufacturer->getManufacturers();
			foreach ($manufacturers as $manufacturer) {
				$output .= "<url>\n";
				$output .= '  <loc>' . $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $manufacturer['manufacturer_id']) . "</loc>\n";
				$output .= "  <changefreq>weekly</changefreq>\n";
				$output .= "  <priority>0.7</priority>\n";
				$output .= "</url>\n";
			}

			$this->load->model('catalog/information');
			$informations = $this->model_catalog_information->getInformations();
			foreach ($informations as $information) {
				$output .= "<url>\n";
				$output .= '  <loc>' . $this->url->link('information/information', 'information_id=' . $information['information_id']) . "</loc>\n";
				$output .= "  <changefreq>weekly</changefreq>\n";
				$output .= "  <priority>0.5</priority>\n";
				$output .= "</url>\n";
			}

			$output .= "</urlset>\n";

			$this->response->addHeader('Content-Type: application/xml');
			$this->response->setOutput($output);
		}
	}

	protected function getCategories($parent_id, $current_path = '') {
		$output = '';

		$results = $this->model_catalog_category->getAllCategories();

		foreach ($results as $result) {
			// if (!$current_path) {
			// 	$new_path = $result['category_id'];
			// } else {
			// 	$new_path = $current_path . '_' . $result['category_id'];
			// }

			$output .= "<url>\n";
			$output .= "  <loc>" . $this->url->link('product/category', 'category_id=' . $result['category_id']) . "</loc>\n";
			$output .= "  <changefreq>weekly</changefreq>\n";
			$output .= "  <priority>0.7</priority>\n";
			$output .= "</url>\n";

			// $output .= $this->getCategories($result['category_id'], $new_path);
		}

		return $output;
	}
}
