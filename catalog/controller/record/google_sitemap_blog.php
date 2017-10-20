<?php
/* All rights reserved belong to the module, the module developers http://opencartadmin.com */
// http://opencartadmin.com © 2011-2016 All Rights Reserved
// Distribution, without the author's consent is prohibited
// Commercial license
class ControllerRecordGoogleSitemapBlog extends Controller
{
	protected $data;
	protected $languages;
	protected $config_language_id;
	protected $config_language_code;
	protected $config_language_original;
	protected $google_sitemap_blog_language_status;
	protected $cache;
	protected $expire;
	protected $seolink;
	protected $image_status;
	protected $page_status;

	public function __construct($registry)
	{
		parent::__construct($registry);
		$this->config->set("blog_work", true);
		$this->seolink = array();
		if ($this->config->get('ascp_settings_sitemap') != '') {
			$this->data['ascp_settings_sitemap'] = $this->config->get('ascp_settings_sitemap');
		} else {
			$this->data['ascp_settings_sitemap'] = Array();
		}
		if (!isset($this->data['ascp_settings_sitemap']['google_sitemap_blog_language_status']) || !$this->data['ascp_settings_sitemap']['google_sitemap_blog_language_status']) {
			$this->google_sitemap_blog_language_status = false;
		} else {
			$this->google_sitemap_blog_language_status = true;
		}
		if (!isset($this->data['ascp_settings_sitemap']['google_sitemap_blog_cache_status']) || !$this->data['ascp_settings_sitemap']['google_sitemap_blog_cache_status']) {
			$this->cache = false;
		} else {
			$this->cache = true;
		}
		if (!isset($this->data['ascp_settings_sitemap']['google_sitemap_blog_image_status']) || !$this->data['ascp_settings_sitemap']['google_sitemap_blog_image_status']) {
			$this->image_status = false;
		} else {
			$this->image_status = true;
		}
		if (!isset($this->data['ascp_settings_sitemap']['google_sitemap_blog_page_status']) || !$this->data['ascp_settings_sitemap']['google_sitemap_blog_page_status']) {
			$this->page_status = false;
		} else {
			$this->page_status = true;
		}
		if (!isset($this->data['ascp_settings_sitemap']['google_sitemap_blog_cache_expire']) || $this->data['ascp_settings_sitemap']['google_sitemap_blog_cache_expire'] == '') {
			$this->expire = 360000;
		} else {
			$this->expire = $this->data['ascp_settings_sitemap']['google_sitemap_blog_cache_expire'];
		}

		if (!$this->config->get('config_image_popup_width') || $this->config->get('config_image_popup_width')=='') {
        	$this->config->set('config_image_popup_width', '120');
		}
		if (!$this->config->get('config_image_popup_height') || $this->config->get('config_image_popup_height')=='') {
        	$this->config->set('config_image_popup_height', '220');
		}

		if ($this->config->get('ascp_settings') != '') {
			$this->data['settings_general'] = $this->config->get('ascp_settings');
		} else {
			$this->data['settings_general'] = Array();
		}
		if (!$this->config->get('ascp_customer_group_id')) {
			$this->config->set('ascp_customer_group_id', $this->customer_group_id);
		}
		if (!$this->config->get('ascp_customer_groups')) {
			$this->cont('record/customer');
			$this->data = $this->controller_record_customer->customer_groups($this->data);
			$this->config->set('ascp_customer_groups', $this->data['customer_groups']);
		} else {
			$this->data['customer_groups'] = $this->config->get('ascp_customer_groups');
		}
		if (!$this->google_sitemap_blog_language_status) {
			$sql_language = " AND language_id = '" . $this->config->get('config_language_id') . "'";
		} else {
			$sql_language = '';
		}
		$sql        = "SELECT * FROM " . DB_PREFIX . "language WHERE status = '1' " . $sql_language . "ORDER BY `code`='" . $this->config->get('config_language') . "' DESC";
		$query_lang = $this->db->query($sql);
		foreach ($query_lang->rows as $result_lang) {
			$this->languages[$result_lang['code']] = $result_lang;
		}
		$this->config_language_id       = $this->config->get('config_language_id');
		$this->config_language_code     = $this->config->get('config_language');
		$this->config_language_original = $this->registry->get('language');
		if (!$this->registry->get('admin_work')) {
			/*
			if (!defined('DIR_CATALOG')) {
			define('DIR_CATALOG', DIR_APPLICATION);
			}
			*/
			$this->dir_catalog = DIR_APPLICATION;
		}

		if ($this->registry->get('admin_work')) {
			require_once($this->dir_catalog . 'controller/common/seoblog.php');
			$seoBlog  = new ControllerCommonSeoBlog($this->registry);
			$seo_type = $this->config->get('config_seo_url_type');
			if (!$seo_type) {
				$seo_type = 'seo_url';
			}
			require_once($this->dir_catalog . 'controller/common/' . $seo_type . '.php');
			$classSeo = 'ControllerCommon' . str_replace('_', '', $seo_type);
			$seoUrl   = new $classSeo($this->registry);
			$this->config->set('config_ssl', HTTPS_CATALOG);
			$this->config->set('config_url', HTTP_CATALOG);
			$this->url = new Url(HTTP_CATALOG, $this->config->get('config_secure') ? HTTPS_CATALOG : HTTP_CATALOG);
			$this->url->addRewrite($seoUrl);
			$this->url->addRewrite($seoBlog);
		} else {
         	$this->cont('record/addrewrite');
		}
	}
	public function get_sitemap_content()
	{
		if ($this->config->get('google_sitemap_blog_status')) {
			$cache  = new sitemapCache($this->expire);
			$output = '<?xml version="1.0" encoding="UTF-8"?>';
			$output .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">';
			$this->load->model('catalog/product', array(), $this->dir_catalog);
			$this->load->model('tool/image');
			$output .= '<url>';
			$output .= '<loc>' . $this->config->get('config_url') . '</loc>';
			$output .= '<changefreq>always</changefreq>';
			$output .= '<priority>1.0</priority>';
			$output .= '</url>';
			if ($this->page_status) {
				$cache_file    = 'blog.sitemap.products.' . (int) $this->config->get('config_store_id') . '.' . (int) $this->config->get('config_language_id');
				$product_cache = $cache->get($cache_file);
				if (!isset($product_cache) || !$this->cache) {
					$product_output = '';
					foreach ($this->languages as $code => $lang) {
						if ($this->google_sitemap_blog_language_status) {
							$this->switchLanguage($this->languages[$code]['language_id'], $code);
						}
						$products = $this->model_catalog_product->getProducts();
						foreach ($products as $product) {
							$url = str_replace('&', '&amp;', str_replace('&amp;', '&', $this->url->link('product/product', 'product_id=' . $product['product_id'])));
							if (!isset($this->seolink[$url])) {
								$product_output .= '<url>';
								$product_output .= '<loc>' . rawurldecode($url) . '</loc>';
								$product_output .= '<lastmod>' . substr(max($product['date_added'], $product['date_modified']), 0, 10) . '</lastmod>';
								$product_output .= '<changefreq>weekly</changefreq>';
								$product_output .= '<priority>1.0</priority>';
								if ($product['image'] && $this->image_status) {
									$product_output .= '<image:image>';
									$product_output .= '<image:loc>' . $this->model_tool_image->resize($product['image'], $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height')) . '</image:loc>';
									$product_output .= '<image:caption>' . $product['name'] . '</image:caption>';
									$product_output .= '<image:title>' . $product['name'] . '</image:title>';
									$product_output .= '</image:image>';
								}
								$product_output .= '</url>';
							}
							$this->seolink[$url] = $url;
						}
					}
					$cache->set($cache_file, $product_output);
					$output .= $product_output;
				} else {
					$output .= $product_cache;
				}
				$this->load->model('catalog/category', $this->dir_catalog);
				$cache_file       = 'blog.sitemap.categories.' . (int) $this->config->get('config_store_id') . '.' . (int) $this->config->get('config_language_id');
				$categories_cache = $cache->get($cache_file);
				if (!isset($categories_cache) || !$this->cache) {
					$categories_output = $this->getCategories(0);
					$cache->set($cache_file, $categories_output);
					$output .= $categories_output;
				} //!isset($categories_cache)
				else {
					$output .= $categories_cache;
				}
				$this->load->model('catalog/manufacturer', $this->dir_catalog);
				$cache_file         = 'blog.sitemap.manufacturer.' . (int) $this->config->get('config_store_id') . '.' . (int) $this->config->get('config_language_id');
				$manufacturer_cache = $cache->get($cache_file);
				if (!isset($manufacturer_cache) || !$this->cache) {
					$manufacturers_output = '';
					$url                  = '';
					$manufacturers        = $this->model_catalog_manufacturer->getManufacturers();
					foreach ($manufacturers as $manufacturer) {
						foreach ($this->languages as $code => $lang) {
							if ($this->google_sitemap_blog_language_status) {
								$this->switchLanguage($this->languages[$code]['language_id'], $code);
							}
							if (SC_VERSION < 20) {
								$url = str_replace('&', '&amp;', str_replace('&amp;', '&', $this->url->link('product/manufacturer/product', 'manufacturer_id=' . $manufacturer['manufacturer_id'])));
							} else {
								$url = str_replace('&', '&amp;', str_replace('&amp;', '&', $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $manufacturer['manufacturer_id'])));
							}
							if (!isset($this->seolink[$url])) {
								$manufacturers_output .= '<url>';
								$manufacturers_output .= '<loc>' . rawurldecode($url) . '</loc>';
								$manufacturers_output .= '<changefreq>weekly</changefreq>';
								$manufacturers_output .= '<priority>0.7</priority>';
								$manufacturers_output .= '</url>';
							}
							$this->seolink[$url] = $url;
						}
					} //$manufacturers as $manufacturer
					$cache->set($cache_file, $manufacturers_output);
					$output .= $manufacturers_output;
				} //!isset($manufacturer_cache)
				else {
					$output .= $manufacturer_cache;
				}
				$this->load->model('catalog/information', $this->dir_catalog);
				$cache_file        = 'blog.sitemap.information.' . (int) $this->config->get('config_store_id') . '.' . (int) $this->config->get('config_language_id');
				$information_cache = $cache->get($cache_file);
				if (!isset($information_cache) || !$this->cache) {
					$information_output = '';
					$url                = '';
					$informations       = $this->model_catalog_information->getInformations();
					foreach ($informations as $information) {
						foreach ($this->languages as $code => $lang) {
							if ($this->google_sitemap_blog_language_status) {
								$this->switchLanguage($this->languages[$code]['language_id'], $code);
							}
							$url = str_replace('&', '&amp;', str_replace('&amp;', '&', $this->url->link('information/information', 'information_id=' . $information['information_id'])));
							if (!isset($this->seolink[$url])) {
								$information_output .= '<url>';
								$information_output .= '<loc>' . rawurldecode($url) . '</loc>';
								$information_output .= '<changefreq>weekly</changefreq>';
								$information_output .= '<priority>0.5</priority>';
								$information_output .= '</url>';
							}
							$this->seolink[$url] = $url;
						}
					} //$informations as $information
					$cache->set($cache_file, $information_output);
					$output .= $information_output;
				} //!isset($information_cache)
				else {
					$output .= $information_cache;
				}
			}
			$output .= $this->getascp($output);
			$this->switchLanguage($this->config_language_id, $this->config_language_code);
			$this->registry->set('language', $this->config_language_original);
			$output .= '</urlset>';
			return $output;
		} //$this->config->get('google_sitemap_status')
	}
	public function index()
	{
		$output = $this->get_sitemap_content();
		$this->response->addHeader('Content-Type: application/xml');
		$this->response->setOutput($output);
	}
	public function gen_sitemap()
	{
		$token = $this->session->data['token'];
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->request->post['token'] == $token) {
			$this->load->language('seocms/google_sitemap_blog');
			$output = $this->get_sitemap_content();
			file_put_contents(str_replace("../", "", $this->request->post['path']), $output);
			$html = $this->language->get('succes_create_file');
		} else {
			$html = $this->language->get('error_permission');
		}
		$this->response->setOutput($html);
	}


		public function switchLanguage($language_id, $code)
		{
			if ($code != '') {
				$this->session->data['language'] = $code;
				setcookie('language', $code, time() + 60 * 60 * 24 * 30, '/', $this->request->server['HTTP_HOST']);
				$this->config->set('config_language_id', $language_id);
				$this->config->set('config_language', $code);

				if (SC_VERSION > 21) {
                    $language_construct = $code;
				} else {
					$language_construct = $this->langcode_all[$code]['directory'];
				}

				$language = new Language($language_construct);

				if (SC_VERSION > 15) {
					if (SC_VERSION > 21) {
						//$language->load($code);
					} else {
						//$language->load('default');
						//$language->load($language_construct);
					}
				} else {
					//$language->load($this->langcode_all[$code]['filename']);
				}
				$this->registry->set('language', $language);
				$this->session->data['language_old'] = $code;
			}
		}


	public function getascp()
	{
		$output       = '';
		$url          = '';
		$cache_status = true;
		$cache        = new sitemapCache($this->expire);
		$this->load->model('record/record', $this->dir_catalog);
		$this->load->model('record/blog', $this->dir_catalog);
		$cache_file    = 'blog.sitemap.records.' . (int) $this->config->get('config_store_id') . '.' . (int) $this->config->get('config_language_id');
		$records_cache = $cache->get($cache_file);
		if (!isset($records_cache) || !$this->cache) {
			$records_output = '';
			if (!$this->registry->get('admin_work')) {
				if (SC_VERSION > 15) {
					$this->load->controller('common/seoblog');
				} else {
					$this->getChild('common/seoblog');
				}
			}
			foreach ($this->languages as $code => $lang) {
				if ($this->google_sitemap_blog_language_status) {
					$this->switchLanguage($this->languages[$code]['language_id'], $code);
				}
				$records = $this->model_record_record->getRecords();
				if ($records) {
					foreach ($records as $record) {
						if (in_array('index', explode(',', $record['index_page']))) {
							$url = str_replace('&', '&amp;', str_replace('&amp;', '&', $this->url->link('record/record', 'record_id=' . $record['record_id'])));
							if (!isset($this->seolink[$url])) {
								$records_output .= '<url>';
								$records_output .= '<loc>' . rawurldecode($url) . '</loc>';
								$records_output .= '<lastmod>' . substr(max($record['date_available'], $record['date_modified']), 0, 10) . '</lastmod>';
								$records_output .= '<changefreq>weekly</changefreq>';
								$records_output .= '<priority>1.0</priority>';
								if ($record['image'] && $this->image_status) {
									$records_output .= '<image:image>';
									$records_output .= '<image:loc>' . $this->model_tool_image->resize($record['image'], $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height')) . '</image:loc>';
									$records_output .= '<image:caption>' . $record['name'] . '</image:caption>';
									$records_output .= '<image:title>' . $record['name'] . '</image:title>';
									$records_output .= '</image:image>';
								}
								$records_output .= '</url>';
							}
							$this->seolink[$url] = $url;
						}
					}
				}
			}
			$cache->set($cache_file, $records_output);
			$output .= $records_output;
		} else {
			$output .= $records_cache;
		}
		$cache_file    = 'blog.sitemap.blogies.' . (int) $this->config->get('config_store_id') . '.' . (int) $this->config->get('config_language_id');
		$blogies_cache = $cache->get($cache_file);
		if (!isset($blogies_cache) || !$this->cache) {
			if (!$this->registry->get('admin_work')) {
				if (SC_VERSION > 15) {
					$this->load->controller('common/seoblog');
				} else {
					$this->getChild('common/seoblog');
				}
			}
			$blogies_output = $this->getBlogies(0);
			$cache->set($cache_file, $blogies_output);
			$output .= $blogies_output;
		} else {
			$output .= $blogies_cache;
		}
		$this->switchLanguage($this->config_language_id, $this->config_language_code);
		return $output;
	}
	protected function getCategories($parent_id, $current_path = '')
	{
		$output   = '';
		$array_of = array();
		$url      = '';
		$results  = $this->model_catalog_category->getCategories($parent_id);
		if ($results) {
			foreach ($results as $result) {
				foreach ($this->languages as $code => $lang) {
					if ($this->google_sitemap_blog_language_status) {
						$this->switchLanguage($this->languages[$code]['language_id'], $code);
					}
					if (!$current_path) {
						$new_path = $result['category_id'];
					} else {
						$new_path = $current_path . '_' . $result['category_id'];
					}
					$url = str_replace('&', '&amp;', str_replace('&amp;', '&', $this->url->link('product/category', 'path=' . $new_path)));
					if (!isset($this->seolink[$url])) {
						$output .= '<url>';
						$output .= '<loc>' . rawurldecode($url) . '</loc>';
						$output .= '<lastmod>' . substr(max($result['date_added'], $result['date_modified']), 0, 10) . '</lastmod>';
						$output .= '<changefreq>weekly</changefreq>';
						$output .= '<priority>0.7</priority>';
						$output .= '</url>';
						if (!isset($array_of[$result['category_id']]) || $array_of[$result['category_id']] != $new_path) {
							$output .= $this->getCategories($result['category_id'], $new_path);
							$array_of[$result['category_id']] = $new_path;
						}
					}
					$this->seolink[$url] = $url;
				}
			} //$results as $result
		} //$results
		return $output;
	}
	public function getBlogies($parent_id, $current_path = '')
	{
		$output   = '';
		$url      = '';
		$array_of = array();
		$results  = $this->model_record_blog->getBlogies($parent_id);
		foreach ($results as $result) {
			if (in_array('index', explode(',', $result['index_page']))) {
				foreach ($this->languages as $code => $lang) {
					if ($this->google_sitemap_blog_language_status) {
						$this->switchLanguage($this->languages[$code]['language_id'], $code);
					}
					if ($current_path == '') {
						$new_path = $result['blog_id'];
					} else {
						$new_path = $current_path . '_' . $result['blog_id'];
					}
					$url = str_replace('&', '&amp;', str_replace('&amp;', '&', $this->url->link('record/blog', 'blog_id=' . $new_path)));
					if (!isset($this->seolink[$url])) {
						$output .= '<url>';
						$output .= '<loc>' . rawurldecode($url) . '</loc>';
						$output .= '<lastmod>' . substr(max($result['date_added'], $result['date_modified']), 0, 10) . '</lastmod>';
						$output .= '<changefreq>weekly</changefreq>';
						$output .= '<priority>0.7</priority>';
						$output .= '</url>';
						if (!isset($array_of[$result['blog_id']]) || $array_of[$result['blog_id']] != $new_path) {
							$output .= $this->getBlogies($result['blog_id'], $new_path);
							$array_of[$result['blog_id']] = $new_path;
						}
					}
					$this->seolink[$url] = $url;
				}
			}
		} //$results as $result
		return $output;
	}
	public function cont($cont)
	{
		$file  = DIR_APPLICATION . 'controller/' . $cont . '.php';
		$class = 'Controller' . preg_replace('/[^a-zA-Z0-9]/', '', $cont);
		if (file_exists($file)) {
			include_once($file);
			$this->registry->set('controller_' . str_replace('/', '_', $cont), new $class($this->registry));
		} else {
			trigger_error('Error: Could not load controller ' . $cont . '!');
			exit();
		}
	}
}
class sitemapCache
{
	public $expire = 360000;
	public function __construct($expire)
	{
		$files        = glob(DIR_CACHE . 'cache.blog.*');
		$this->expire = $expire;
		if ($files) {
			foreach ($files as $file) {
				$time = substr(strrchr($file, '.'), 1);
				if ($time < time()) {
					if (file_exists($file)) {
						unlink($file);
					}
				}
			}
		}
	}
	public function get($key)
	{
		$files = glob(DIR_CACHE . 'cache.' . preg_replace('/[^A-Z0-9\._-]/i', '', $key) . '.*');
		if ($files) {
			$cache = file_get_contents($files[0]);
			return unserialize($cache);
		}
	}
	public function set($key, $value)
	{
		$this->delete($key);
		$file   = DIR_CACHE . 'cache.' . preg_replace('/[^A-Z0-9\._-]/i', '', $key) . '.' . (time() + $this->expire);
		$handle = fopen($file, 'w');
		fwrite($handle, serialize($value));
		fclose($handle);
	}
	public function delete($key)
	{
		$files = glob(DIR_CACHE . 'cache.' . preg_replace('/[^A-Z0-9\._-]/i', '', $key) . '.*');
		if ($files) {
			foreach ($files as $file) {
				if (file_exists($file)) {
					unlink($file);
				}
			}
		}
	}
}

