<?php

/*
 * Fast Sitemap [xml]
 * by dub(nix)
 */

class ControllerFeedFastSitemap extends Controller {

	private $options;

	public function index() {

		$options = array(
				 'lid' => (int)$this->config->get('config_language_id'),
				 'sid' => (int)$this->config->get('config_store_id'),
			'cache_st' => (int)$this->config->get('f_s_cache_status')
			);

		$output  = '<?xml version="1.0" encoding="UTF-8"?>';
		$output .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
		
		$output .= '<url>';
		$output .= '<loc>' . HTTP_SERVER . '</loc>';
		$output .= '<changefreq>monthly</changefreq>';
		$output .= '<priority>1.0</priority>';
		$output .= '</url>';

		$this->load->model('sitemap/fast_sitemap');

		$informations = $this->model_sitemap_fast_sitemap->getInformations($options);

		foreach ($informations as $information) {
			$output .= '<url>';
			$output .= '<loc>' . $this->url->link('information/information', 'information_id=' . $information['information_id']) . '</loc>';
			$output .= '<changefreq>weekly</changefreq>';
			$output .= '<priority>0.5</priority>';
			$output .= '</url>';
		}

		$products = $this->model_sitemap_fast_sitemap->getProducts($options);

		foreach ($products as $product) {
			$output .= '<url>';
			$output .= '<loc>' . $this->url->link('product/product', 'product_id=' . $product['product_id']) . '</loc>';
			$output .= '<lastmod>' . substr(max($product['date_added'], $product['date_modified']), 0, 10) . '</lastmod>';
			$output .= '<changefreq>weekly</changefreq>';
			$output .= '<priority>1.0</priority>';
			$output .= '</url>';
		}

		$manufacturers = $this->model_sitemap_fast_sitemap->getManufacturers($options);

		foreach ($manufacturers as $manufacturer) {
			$output .= '<url>';
			$output .= '<loc>' . $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $manufacturer['manufacturer_id']) . '</loc>';
			$output .= '<changefreq>weekly</changefreq>';
			$output .= '<priority>0.7</priority>';
			$output .= '</url>';
		}

		$categories = $this->model_sitemap_fast_sitemap->getCategories($options);

		foreach ($categories as $category) {
			$output .= '<url>';
			$output .= '<loc>' . $this->url->link('product/category', 'path=' . $category['category_id']) . '</loc>';
			$output .= '<lastmod>' . substr(max($category['date_added'], $category['date_modified']), 0, 10) . '</lastmod>';
			$output .= '<changefreq>weekly</changefreq>';
			$output .= '<priority>0.7</priority>';
			$output .= '</url>';
		}

		$output .= '</urlset>';

		$this->response->addHeader('Content-Type: application/xml');
		$this->response->setOutput($output);

	}

}

?>