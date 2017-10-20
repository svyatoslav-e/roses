<?php
/* All rights reserved belong to the module, the module developers http://opencartadmin.com */
// http://opencartadmin.com © 2011-2016 All Rights Reserved
// Distribution, without the author's consent is prohibited
// Commercial license
if (!class_exists('ControllerModuleBlog')) {
	class ControllerModuleBlog extends Controller
	{
		protected $data;
		protected $customer_group_id;
		protected $customer_id;
		protected $theme_directory;

		public function __construct($registry)
		{
			parent::__construct($registry);
			if (version_compare(phpversion(), '5.3.0', '<') == true) {
				exit('PHP5.3+ Required');
			}
			if (SC_VERSION > 15) {
				$get_Customer_GroupId = 'getGroupId';
			} else {
				$get_Customer_GroupId = 'getCustomerGroupId';
			}
			if ($this->customer->isLogged()) {
				$this->customer_group_id = $this->customer->$get_Customer_GroupId();
				$this->customer_id       = $this->customer->getId();
			} else {
				$this->customer_group_id = $this->config->get('config_customer_group_id');
				$this->customer_id       = false;
			}
			if ($this->config->get('ascp_settings') != '') {
				$this->data['settings_general'] = $this->config->get('ascp_settings');
			} else {
				$this->data['settings_general'] = Array();
			}
			if (!$this->config->get('ascp_customer_groups')) {
				$this->cont('record/customer');
				$this->data = $this->controller_record_customer->customer_groups($this->data);
				$this->config->set('ascp_customer_groups', $this->data['customer_groups']);
			} else {
				$this->data['customer_groups'] = $this->config->get('ascp_customer_groups');
			}

			if (isset($this->data['settings_general']['safe_loading']) && $this->data['settings_general']['safe_loading']) {
				$this->cont('common/seoblog');
				$this->controller_common_seoblog->router();
			}
			if (!class_exists('ControllerCommonSeoBlog') &&
				(class_exists('ControllerCommonSeoUrl') ||
				 class_exists('ControllerCommonSeoPro') ||
				 class_exists('ControllerStartupSeoUrl') ||
				 class_exists('ControllerStartupSeoPro'))
				 && !$this->registry->get('admin_work')
				 ) {
				$this->cont('record/addrewrite');
			}

		}



		public function index($arg)
		{
			$loader_old = $this->registry->get('load');
			$this->load->library('agoo/loader');
			$agooloader = new agooLoader($this->registry);
			$this->registry->set('load', $agooloader);
			$ajax_file_cached = false;

			$this->config->set("blog_work", true);

			$this->language->load('seocms/module');
			$this->language->load('seocms/blog');

			if (isset($this->request->post['ajax_file'])) {
				$this->request->get['ajax_file'] = $this->request->post['ajax_file'];
			}
			if (isset($this->request->post['sc_ajax'])) {
				$this->request->get['sc_ajax'] = $this->request->post['sc_ajax'];
			}
			if (isset($this->request->post['cmswidget'])) {
				$this->request->get['cmswidget'] = $this->request->post['cmswidget'];
			}
			$html = "";
			if (!isset($this->data['settings_general']['colorbox_theme'])) {
				$this->data['settings_general']['colorbox_theme'] = 0;
			}
			if (isset($this->data['settings_general']['get_pagination']))
				$get_pagination = $this->data['settings_general']['get_pagination'];
			else
				$get_pagination = 'tracking';
			$this->data['config_language_id'] = $this->config->get('config_language_id');
			$this->data['config_template']    = $this->config->get('config_template');
			$this->data['theme_stars']        = $this->getThemeStars('image/blogstars-1.png');
			$this->data['http_image']         = getHttpImage($this);
			$this->data                       = $this->ColorboxLoader($this->data['settings_general']['colorbox_theme'], $this->data);
			$this->load->model('setting/setting');
			if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
				$settings_admin = $this->model_setting_setting->getSetting('ascp_admin', 'ascp_admin_https_admin_path');
			} else {
				$settings_admin = $this->model_setting_setting->getSetting('ascp_admin', 'ascp_admin_http_admin_path');
			}
			foreach ($settings_admin as $key => $value) {
				$this->data['admin_path'] = $value;
			}
			if (SC_VERSION > 15) {
				$arg['position'] = $this->registry->get('blog_position');
			}
			$position_widget_block = $this->data['position'] = $arg['position'];

			$this->data['button_continue'] = $this->language->get('button_continue');
			$this->data['text_limit']      = $this->language->get('text_limit');
			$this->data['text_sort']       = $this->language->get('text_sort');
			$template                      = '';
			if (isset($this->request->get['blog_id'])) {
				$parts                   = explode('_', (string) $this->request->get['blog_id']);
				$this->data['blog_path'] = $this->request->get['blog_id'];
			} else {
				$parts                   = array();
				$this->data['blog_path'] = 0;
			}
			if (isset($parts[0])) {
				$this->data['blog_id'] = $parts[0];
			} else {
				$this->data['blog_id'] = 0;
			}
			if (isset($parts[1])) {
				$this->data['child_id'] = $parts[1];
			} else {
				$this->data['child_id'] = 0;
			}
			if (isset($this->request->get['route'])) {
				$this->data['route'] = $route = $this->request->get['route'];
			} else {
				$this->data['route'] = $route = 'common/home';
			}
			$this->load->model('catalog/category');
			$this->load->model('catalog/product');
			$this->load->model('catalog/information');
			$this->load->model('design/bloglayout');
			$layout_id = false;
			if ($route == 'product/category' && isset($this->request->get['path'])) {
				$path        = explode('_', (string) $this->request->get['path']);
				$category_id = end($path);
				$layout_id   = $this->model_catalog_category->getCategoryLayoutId(end($path));
			}
			if ($route == 'product/product' && isset($this->request->get['product_id'])) {
				$layout_id = $this->model_catalog_product->getProductLayoutId($this->request->get['product_id']);
			}
			if ($route == 'information/information' && isset($this->request->get['information_id'])) {
				$layout_id = $this->model_catalog_information->getInformationLayoutId($this->request->get['information_id']);
			}
			if ($route == 'record/blog' && isset($this->request->get['blog_id'])) {
				$path      = explode('_', (string) $this->request->get['blog_id']);
				$layout_id = $this->model_design_bloglayout->getBlogLayoutId(end($path));
			}
			if ($route == 'record/record' && isset($this->request->get['record_id'])) {
				$layout_id = $this->model_design_bloglayout->getRecordLayoutId($this->request->get['record_id']);
			}
			if (!$layout_id) {
				$layout_id = $this->model_design_layout->getLayout($route);
			}
			if (!$layout_id) {
				$layout_id = $this->config->get('config_layout_id');
			}
			$this->data['lang_code'] = $this->config->get('config_language');
			if (!$this->registry->has('blog_position_' . $position_widget_block)) {
				$this->registry->set('blog_position_' . $position_widget_block, 0);
			} else {
				$pos = $this->registry->get('blog_position_' . $position_widget_block);
				$this->registry->set('blog_position_' . $position_widget_block, $pos + 1);
			}
			$position_widget         = $this->registry->get('blog_position_' . $position_widget_block);
			$this->data['position']  = $position_widget;
			$this->data['layout_id'] = $layout_id;
			$module_data             = array();
			if (SC_VERSION < 20) {
				$this->load->model('setting/extension');
				$extensions = $this->model_setting_extension->getExtensions('module');
			} else {
				$this->load->model('extension/extension');
				$extensions = $this->model_extension_extension->getExtensions('module');
			}
			foreach ($extensions as $extension) {
				$modules = $this->config->get($extension['code'] . '_module');
				if ($modules) {
					foreach ($modules as $num => $module) {
						if (isset($module['layout_id']) && $module['layout_id'] == $layout_id && $extension['code'] == 'blog' && $module['position'] == $position_widget_block && $module['status']) {
							if ($extension['code'] != '') {
								$module_data[] = array(
									'code' => $extension['code'],
									'setting' => $module,
									'sort_order' => $module['sort_order']
								);
							}
						}
					}
				}
			}
			if (isset($module_data) && is_array($module_data)) {
				usort($module_data, 'commd');
			}
			$type                           = "none";
			$this->data['heading_title']    = '';
			$this->data['categories_blogs'] = Array();
			$this->data['ascp_widgets']     = $this->config->get('ascp_widgets');

			if (!class_exists('User')) {
				loadlibrary('user');
			}
			if (SC_VERSION > 21) {
				$user_str = 'Cart\User';
			} else {
				$user_str = 'User';
			}
			$this->user = new $user_str($this->registry);

			if ($this->user->isLogged()) {
				$this->data['userLogged'] = true;
				$this->data['token']      = $this->session->data['token'];
			} else {
				$this->data['userLogged'] = false;
			}
			if (!isset($module_data[$position_widget])) {
				$this->registry->set('blog_position_' . $position_widget_block, 0);
				$position_widget = 0;
			}
			$url_end                    = "";


			$this->data['request_get']  = $this->request->get;
			$this->data['get_original'] = $get = $this->request->get;
            // $this->data['request_get']  = array();
			foreach ($get as $get_key => $get_val) {
				if (is_array($get_val)) {
					unset($get[$get_key]);
				} else {
					if ($get_key != 'route' && $get_key != 'prefix' && $get_key != '_route_' && $get_key != 'wpage' && $get_key != 'wsort' && $get_key != 'worder' && $get_key != 'ajax_file' && $get_key != 'wlimit' && $get_key != 'cmswidget' && $get_key != $get_pagination) {
						$url_end .= "&" . $get_key . "=" . $get_val;
					}
				}
			}
			if (isset($this->request->get[$get_pagination])) {
				$tracking = $this->request->get[$get_pagination];
			} else {
				$tracking = '';
			}
			if ($tracking != '') {
				$parts = explode('_', trim(utf8_strtolower($tracking)));
				foreach ($parts as $num => $val) {
					if (strpos($val, '-') === false) {
						$getquery = $val;
						$getpar   = $val;
					} else {
						list($getquery, $getpar) = explode("-", $val);
					}
					$this->data['request_get'][$getquery] = $getpar;
				}
			}
			if (isset($this->data['request_get']['wpage']) && isset($this->data['request_get']['cmswidget']) && $this->data['request_get']['cmswidget'] == $module_data[$position_widget]['setting']['what']) {
				$page = $this->data['request_get']['wpage'];
				if ($page > 1) {
					$paging = " " . $this->language->get('text_blog_page') . " " . $page;
				} else {
					$paging = '';
				}
				$title_page = $this->document->getTitle();
				$this->document->setTitle($title_page . $paging);
				$description_page = $this->document->getDescription();
				$this->document->setDescription($description_page . $paging);
			} else {
				$page = 1;
			}
			$this->data['url'] = $this->url->link($route, $url_end);
			if (isset($module_data[$position_widget]['setting']['what'])) {
				$this->data['type'] = $type = $this->data['ascp_widgets'][$module_data[$position_widget]['setting']['what']]['type'];
			}
			if (isset($module_data[$position_widget]['setting']['what']) && isset($this->data['ascp_widgets'][$module_data[$position_widget]['setting']['what']])) {
				$thislist = $this->data['ascp_widgets'][$module_data[$position_widget]['setting']['what']];
			} else {
				$thislist = null;
			}
			$this->data['thislist']        = $thislist;
			$this->data['settings']        = $thislist;
			$this->data['settings_widget'] = $this->data['settings'];
			if (isset($this->data['settings_widget']['anchor']) && $this->data['settings_widget']['anchor'] != '') {
				$this->data['settings_widget']['anchor'] = html_entity_decode($this->data['settings_widget']['anchor'], ENT_QUOTES, 'UTF-8');
			}
			$this->registry->set('thislist', serialize($this->data['settings']));
			if (isset($module_data[$position_widget])) {
				$this->registry->set('ascp_widgets_position', $module_data[$position_widget]['setting']['what']);
			}
			$this->cont('record/customer');
			$this->data = $this->controller_record_customer->customer_groups($this->data);
			if (!isset($this->data['thislist']['customer_groups'])) {
				$this->data['thislist']['customer_groups'] = array();
			}
			$this->data['customer_intersect'] = array_intersect($this->data['thislist']['customer_groups'], $this->data['customer_groups']);

            if (isset($this->data['settings_general']['avatar_widget_status']) && $this->data['settings_general']['avatar_widget_status']) {
            	$this->data = $this->avatar_customer($this->data);
            }

			if (isset($this->data['thislist']['store']) && in_array($this->config->get('config_store_id'), $this->data['thislist']['store'])) {
				if (isset($this->data['thislist']['customer_groups']) && !empty($this->data['customer_intersect'])) {
					if (((isset($this->data['thislist']['visual_editor']) && isset($this->data['thislist']['comment_must']) && $this->data['thislist']['comment_must'] && $this->data['thislist']['visual_editor'])) || !isset($this->data['thislist']['visual_editor'])) {
						$this->data['visual_editor'] = true;
						$scriptfile                  = 'view/javascript/wysibb/jquery.wysibb.min.js';
						if (file_exists(DIR_APPLICATION . $scriptfile)) {
							$this->document->addScript('catalog/' . $scriptfile);
						}
						$scriptfile = 'view/javascript/wysibb/lang/' . $this->config->get('config_language') . '.js';
						if (file_exists(DIR_APPLICATION . $scriptfile)) {
							$this->document->addScript('catalog/' . $scriptfile);
						}
						$scriptfile = 'view/javascript/wysibb/theme/default/wbbtheme.css';
						if (file_exists(DIR_APPLICATION . $scriptfile)) {
							$this->document->addStyle('catalog/' . $scriptfile);
						}
						$scriptfile = 'view/javascript/blog/blog.bbimage.js';
						if (file_exists(DIR_APPLICATION . $scriptfile)) {
							$this->document->addScript('catalog/' . $scriptfile);
						}
						$scriptfile = 'view/javascript/blog/rating/jquery.rating.js';
						if (file_exists(DIR_APPLICATION . $scriptfile)) {
							$this->document->addScript('catalog/' . $scriptfile);
						}
						$scriptfile = 'view/javascript/blog/rating/jquery.rating.css';
						if (file_exists(DIR_APPLICATION . $scriptfile)) {
							$this->document->addStyle('catalog/' . $scriptfile);
						}
					} else {
						$this->data['visual_editor'] = false;
					}
					if (SC_VERSION > 15) {
						$get_Customer_GroupId = 'getGroupId';
					} else {
						$get_Customer_GroupId = 'getCustomerGroupId';
					}
					if (isset($this->data['settings_general']['cache_widgets']) && $this->data['settings_general']['cache_widgets']) {
						$hasha             = md5(serialize($_GET). serialize($this->request->post). serialize($this->data['thislist']) . (int)$layout_id . (int)$this->data['userLogged'] . (int)$this->config->get('config_language_id') . (int)($this->config->get('config_store_id')));
						$hash_cache        = md5($hasha . (int)$this->data['customer_id']);
						$cache_name        = 'blog.module.view.' . $type . '.' . (int) $this->config->get('config_store_id') . '.' . (int) $this->config->get('config_language_id') . (int) $this->customer->$get_Customer_GroupId() . '.' . $hasha;
						$module_view_cache = $this->cache->get($cache_name);
					} else {
						$hash_cache = 0;
					}
					if (isset($module_data[$position_widget])) {
						$cmswidget = $this->data['cmswidget'] = $module_data[$position_widget]['setting']['what'];
					} else {
						$cmswidget = false;
					}
					$this->data['prefix'] = 'ascpw' . $this->data['cmswidget'];
					$scriptfile           = 'view/javascript/blog/blog.comment.js';
					if (file_exists(DIR_APPLICATION . $scriptfile)) {
						$this->document->addScript('catalog/' . $scriptfile);
					}

					require_once(DIR_SYSTEM . 'library/iblog.php');
					$this->data['agoo_widgets'] = iBlog::searchdir(DIR_APPLICATION . "controller/agoo", 'DIRS');
					foreach ($this->data['agoo_widgets'] as $nm => $agoo_widget) {
						if (!empty($module_data) && $type == $agoo_widget) {
							if (file_exists(DIR_APPLICATION . "controller/agoo/" . $agoo_widget . "/" . $agoo_widget . ".php")) {
								$this->cont('agoo/' . $agoo_widget . '/' . $agoo_widget);
								$controller_agoo = 'controller_agoo_' . $agoo_widget . '_' . $agoo_widget;
								if (method_exists($this->registry->get($controller_agoo), 'loading'))
									$this->data = $this->$controller_agoo->loading($this->data);
							}
						}
					}

					if (isset($this->request->get['ajax_file']) && $this->request->get['ajax_file'] != '' && $this->data['cmswidget'] != $this->request->get['cmswidget']) {
						return;
					}
					if (isset($this->request->get['ajax_file']) && $this->request->get['ajax_file'] != '' && $this->data['cmswidget'] == $this->request->get['cmswidget']) {
						$ajax_file_cached = $this->ajax_file();
					}
					if ((isset($this->request->get['sc_ajax']) && $this->request->get['sc_ajax'] == 1) || (isset($this->request->post['sc_ajax']) && $this->request->post['sc_ajax'] == 1)) {
						if (isset($this->request->get['cmswidget']) && $this->data['cmswidget'] == $this->request->get['cmswidget']) {
							$this->data['cmswidget'] = $this->request->get['cmswidget'];
						}
						if (isset($this->request->post['cmswidget']) && $this->data['cmswidget'] == $this->request->post['cmswidget']) {
							$this->data['cmswidget'] = $this->request->post['cmswidget'];
						}
						$this->data['ajax'] = true;
					} else {
						$this->data['ajax'] = false;
					}
					if ((!isset($module_view_cache[$hash_cache]) || (isset($this->data['settings_widget']['cached']) && $this->data['settings_widget']['cached'] == 0)) || $ajax_file_cached) {
						$this->data['type'] = false;
						foreach ($this->data['agoo_widgets'] as $nm => $agoo_widget) {
							if (!empty($module_data) && $type == $agoo_widget) {
								if (file_exists(DIR_APPLICATION . "controller/agoo/" . $agoo_widget . "/" . $agoo_widget . ".php")) {
									$this->cont('agoo/' . $agoo_widget . '/' . $agoo_widget);
									$controller_agoo = 'controller_agoo_' . $agoo_widget . '_' . $agoo_widget;
									$this->data      = $this->$controller_agoo->index($this->data);
									if (isset($this->data[$agoo_widget . '_template'])) {
										$template = $this->data[$agoo_widget . '_template'];
									}
								}
							}
						}
						if (!empty($module_data) && ($type == 'latest' || $type == 'records' || $type == 'reviews' || $type == 'related')) {
							$sort  = "sort";
							$order = "DESC";
							if (isset($this->data['settings']['order'])) {
								$sort = $this->data['settings']['order'];
							}
							if (isset($this->data['settings']['order_ad'])) {
								$order = $this->data['settings']['order_ad'];
							}
							if (isset($this->data['request_get']['wsort']) && isset($this->data['request_get']['cmswidget']) && $this->data['request_get']['cmswidget'] == $module_data[$position_widget]['setting']['what']) {
								$sort = $this->data['request_get']['wsort'];
							} else {
							}
							if (isset($this->data['request_get']['worder']) && isset($this->data['request_get']['cmswidget']) && $this->data['request_get']['cmswidget'] == $module_data[$position_widget]['setting']['what']) {
								$order = $this->data['request_get']['worder'];
							} else {
							}
							$this->data['wpage'] = $page;
							$thislist            = $this->data['settings'];
							if (!isset($this->data['settings']['number_per_widget']) || $this->data['settings']['number_per_widget'] == '') {
								$thislist['number_per_widget'] = 5;
							}
							if (isset($this->data['request_get']['wlimit']) && isset($this->data['request_get']['cmswidget']) && $this->data['request_get']['cmswidget'] == $module_data[$position_widget]['setting']['what']) {
								$thislist['number_per_widget'] = $this->data['request_get']['wlimit'];
							}
							$thislist['paging'] = $this->data['thislist']['paging'] = $this->data['settings']['paging'] = array(
								'start' => ($page - 1) * $thislist['number_per_widget']
							);
							$limit              = $thislist['number_per_widget'];
						}
						if (!empty($module_data) && ($type == 'latest' || $type == 'records' || $type == 'related')) {
							$this->data['type'] = $type;
							$data_records       = $this->getBlogsRecords($this->data['settings'], $type);
							$this->data         = array_merge($this->data, $data_records);
							$cmswidget_end      = '';
							$url_end            = "";


							foreach ($this->data['request_get'] as $get_key => $get_val) {
								if (is_array($get_val)) {
									unset($get[$get_key]);
								} else {
									if ($get_key != 'route' && $get_key != 'ajax_file' && $get_key != 'prefix' && $get_key != '_route_' && $get_key != 'wpage' && $get_key != 'wsort' && $get_key != 'worder' && $get_key != 'wlimit' && $get_key != 'cmswidget' && $get_key != $get_pagination) {
										$url_end .= "&" . (string) $get_key . "=" . (string) $get_val;
									}
									if ($get_key == 'wsort' || $get_key == 'worder' || $get_key == 'wlimit') {
										$cmswidget_end .= "_" . (string) $get_key . "-" . (string) $get_val;
									}
								}
							}
							$link_end_string = $get_pagination . '=cmswidget-' . $cmswidget . '_wpage-{page}' . $cmswidget_end . '#cmswidget-' . $cmswidget;
							$link_url        = $this->url->link($route, $url_end);
							$url_razdel      = '&amp;';
							if (strpos($link_url, '?') === false) {
								$url_razdel = '?';
							}
							$link_url .= urldecode($url_razdel . $link_end_string);
							if (!isset($this->data['total'])) {
								$this->data['total'] = 0;
							}



							if (isset($thislist['pagination']) && $thislist['pagination']) {
								$pagination               = new Pagination();
								$pagination->total        = $this->data['total'];
								$pagination->page         = $page;
								$pagination->limit        = $limit;
								$pagination->text         = $this->language->get('text_pagination');
								$pagination->url          = $link_url;
								$this->data['pagination'] = $pagination->render();
							}
							if (isset($thislist['sort']) && $thislist['sort']) {
								$this->data['sorts']   = array();
								$this->data['sorts'][] = array(
									'text' => $this->language->get('text_sort_asc'),
									'value' => 'sort-asc',
									'href' => $this->url->link($route, $url_end . '&' . $get_pagination . '=cmswidget-' . $cmswidget . '_wsort-sort_worder-ASC' . '#cmswidget-' . $cmswidget)
								);
								$this->data['sorts'][] = array(
									'text' => $this->language->get('text_sort_desc'),
									'value' => 'sort-desc',
									'href' => $this->url->link($route, $url_end . '&' . $get_pagination . '=cmswidget-' . $cmswidget . '_wsort-sort_worder-DESC' . '#cmswidget-' . $cmswidget)
								);
								$this->data['sorts'][] = array(
									'text' => $this->language->get('text_date_added_asc'),
									'value' => 'latest-asc',
									'href' => $this->url->link($route, $url_end . '&' . $get_pagination . '=cmswidget-' . $cmswidget . '_wsort-latest_worder-ASC' . '#cmswidget-' . $cmswidget)
								);
								$this->data['sorts'][] = array(
									'text' => $this->language->get('text_date_added_desc'),
									'value' => 'latest-desc',
									'href' => $this->url->link($route, $url_end . '&' . $get_pagination . '=cmswidget-' . $cmswidget . '_wsort-latest_worder-DESC' . '#cmswidget-' . $cmswidget)
								);
								$this->data['sorts'][] = array(
									'text' => $this->language->get('text_rating_desc'),
									'value' => 'rating-desc',
									'href' => $this->url->link($route, $url_end . '&' . $get_pagination . '=cmswidget-' . $cmswidget . '_wsort-rating_worder-DESC' . '#cmswidget-' . $cmswidget)
								);
								$this->data['sorts'][] = array(
									'text' => $this->language->get('text_rating_asc'),
									'value' => 'rating-asc',
									'href' => $this->url->link($route, $url_end . '&' . $get_pagination . '=cmswidget-' . $cmswidget . '_wsort-rating_worder-ASC' . '#cmswidget-' . $cmswidget)
								);
								$this->data['sorts'][] = array(
									'text' => $this->language->get('text_comments_desc'),
									'value' => 'comments-desc',
									'href' => $this->url->link($route, $url_end . '&' . $get_pagination . '=cmswidget-' . $cmswidget . '_wsort-comments_worder-DESC' . '#cmswidget-' . $cmswidget)
								);
								$this->data['sorts'][] = array(
									'text' => $this->language->get('text_comments_asc'),
									'value' => 'comments-asc',
									'href' => $this->url->link($route, $url_end . '&' . $get_pagination . '=cmswidget-' . $cmswidget . '_wsort-comments_worder-ASC' . '#cmswidget-' . $cmswidget)
								);
								$this->data['sorts'][] = array(
									'text' => $this->language->get('text_popular_desc'),
									'value' => 'popular-desc',
									'href' => $this->url->link($route, $url_end . '&' . $get_pagination . '=cmswidget-' . $cmswidget . '_wsort-popular_worder-DESC' . '#cmswidget-' . $cmswidget)
								);
								$this->data['sorts'][] = array(
									'text' => $this->language->get('text_popular_asc'),
									'value' => 'popular-asc',
									'href' => $this->url->link($route, $url_end . '&' . $get_pagination . '=cmswidget-' . $cmswidget . '_wsort-popular_worder-ASC' . '#cmswidget-' . $cmswidget)
								);
								$this->data['sort']    = $sort;
								$this->data['order']   = $order;
							}
							if (isset($thislist['limit']) && $thislist['limit']) {
								$this->data['limits']   = array();
								$this->data['limits'][] = array(
									'text' => $limit,
									'value' => $limit,
									'href' => $this->url->link($route, $url_end . '&' . $get_pagination . '=cmswidget-' . $cmswidget . $cmswidget_end . '#cmswidget-' . $cmswidget)
								);
								$this->data['limits'][] = array(
									'text' => 25,
									'value' => 25,
									'href' => $this->url->link($route, $url_end . '&' . $get_pagination . '=cmswidget-' . $cmswidget . $cmswidget_end . '_wlimit-25' . '#cmswidget-' . $cmswidget)
								);
								$this->data['limits'][] = array(
									'text' => 50,
									'value' => 50,
									'href' => $this->url->link($route, $url_end . '&' . $get_pagination . '=cmswidget-' . $cmswidget . $cmswidget_end . '_wlimit-50' . '#cmswidget-' . $cmswidget)
								);
								$this->data['limits'][] = array(
									'text' => 100,
									'value' => 100,
									'href' => $this->url->link($route, $url_end . '&' . $get_pagination . '=cmswidget-' . $cmswidget . $cmswidget_end . '_wlimit-100' . '#cmswidget-' . $cmswidget)
								);
								$this->data['limit']    = $limit;
							}
							if (isset($thislist['template']) && $thislist['template'] != '') {
								$template = '/template/agootemplates/widgets/records/' . $thislist['template'];
							} else {
								if ($type == 'latest' || $type == 'related') {
									$template = '/template/agootemplates/widgets/records/adaptive.tpl';
								}
								if ($type == 'records') {
									$template = '/template/agootemplates/widgets/records/adaptive.tpl';
								}
							}
						}
						if (!empty($module_data) && ($type == 'reviews')) {
							$this->data['type'] = $type;
							$data_reviews       = $this->getBlogsReviews($this->data['settings'], $type);
							$this->data         = array_merge($this->data, $data_reviews);
							$url_end            = "";
							foreach ($this->request->get as $get_key => $get_val) {
								if ($get_key != 'route' && $get_key != 'ajax_file' && $get_key != 'prefix' && $get_key != '_route_' && $get_key != 'wpage' && $get_key != 'cmswidget' && $get_key != $get_pagination) {
									$url_end .= "&" . (string) $get_key . "=" . (string) $get_val;
								}
							}
							$link_url = $this->url->link($route, $url_end . '&' . $get_pagination . '=cmswidget-' . $cmswidget . '_wpage-{page}' . '#cmswidget-' . $cmswidget);
							if (!isset($this->data['comment_total'])) {
								$this->data['comment_total'] = 0;
							}
							$pagination               = new Pagination();
							$pagination->total        = $this->data['comment_total'];
							$pagination->page         = $page;
							$pagination->limit        = $thislist['number_per_widget'];
							$pagination->text         = $this->language->get('text_pagination');
							$pagination->url          = $link_url;
							$this->data['pagination'] = $pagination->render();
							if (isset($thislist['template']) && $thislist['template'] != '') {
								$template = '/template/agootemplates/widgets/reviews/' . $thislist['template'];
							} else {
								if ($type == 'reviews') {
									$template = '/template/agootemplates/widgets/reviews/reviews_adaptive.tpl';
								}
							}
						}
						if (!empty($module_data) && ($type == 'treecomments' || $type == 'forms')) {
							if ($this->data['settings_widget']['status']) {
								$this->data['mark']           = false;
								$this->data['comment_status'] = true;
								$this->load->model('record/record');
								$this->load->model('record/blog');
								$this->load->model('record/path');
								$this->load->model('record/treecomments');
								$this->load->model('catalog/product');
								$this->load->model('record/fields');
								$this->data['product_info'] = false;
								if (isset($this->request->get['product_id'])) {
									$thislist['product_id']            = $this->request->get['product_id'];
									$this->data['mark_id']             = $this->request->get['product_id'];
									$this->data['mark']                = 'product_id';
									$route                             = 'product/product';
									$mark_info                         = $this->model_catalog_product->getProduct($this->data['mark_id']);
									$this->data['comment_status']      = true;
									$b_path                            = $this->model_record_path->pathbyproduct($this->data['mark_id']);
									$this->data['mark_info']           = $mark_info;
									$this->data['product_info']        = $this->data['mark_info'];
									$this->data['product_info']['url'] = $this->url->link($route, $this->data['mark'] . '=' . $this->data['mark_info'][$this->data['mark']]);
								} else {
									$thislist['product_id'] = false;
								}
								if (isset($this->data['thislist']['recordid']) && $this->data['thislist']['recordid'] != '') {
									$thislist['record_id']        = $this->data['thislist']['recordid'];
									$this->data['mark_id']        = $this->data['thislist']['recordid'];
									$this->data['mark']           = 'record_id';
									$route                        = 'record/record';
									$this->data['record']         = $this->data['mark_info'] = $mark_info = $record_info = $this->model_record_record->getRecord($this->data['mark_id']);
									$comment_setting              = unserialize($mark_info['comment']);
									$this->data['comment_status'] = $comment_setting['status'];
									$this->load->model('record/path');
									$b_path = $this->model_record_path->pathbyrecord($this->data['mark_id']);
								} else {
									$this->data['record'] = '';
									if (isset($this->request->get['record_id'])) {
										$thislist['record_id']        = $this->request->get['record_id'];
										$this->data['mark_id']        = $this->request->get['record_id'];
										$this->data['mark']           = 'record_id';
										$route                        = 'record/record';
										$mark_info                    = $record_info = $this->model_record_record->getRecord($this->data['mark_id']);
										$comment_setting              = unserialize($mark_info['comment']);
										$this->data['comment_status'] = $comment_setting['status'];
										$this->data['mark_info']      = $record_info;
										$this->load->model('record/path');
										$b_path = $this->model_record_path->pathbyrecord($this->data['mark_id']);
									} else {
										$thislist['record_id'] = false;
									}
								}
								if ($this->data['comment_status']) {
									if (isset($this->data['product_info']) && $this->data['product_info']) {
										$this->data['mark_info']['product_info'] = $this->data['product_info'];
									}
									if (!isset($this->data['mark_info']) || !isset($this->data['mark_info'][$this->data['mark']])) {
										$this->data['mark_info']                      = array();
										$this->data['mark_info'][$this->data['mark']] = false;
										$this->data['mark_info']['url']               = '';
									} else {
										$mark_info_link                 = $this->data['mark'] . '=' . $this->data['mark_info'][$this->data['mark']];
										$this->data['mark_info']['url'] = $this->url->link($route, $mark_info_link);
									}
									$this->language->load('account/login');
									$this->language->load('seocms/signer');
									if (isset($this->data['thislist']['langfile']) && $this->data['thislist']['langfile'] != '') {
										$this->language->load($this->data['thislist']['langfile']);
									}
									$this->data['prefix'] = 'ascpw' . $this->data['cmswidget'] . "_";
									$this->registry->set("prefix", $this->data['prefix']);
									if ($this->data['mark']) {
										$this->data['type'] = $type;
										$this->data['href'] = $this->url->link($route, $this->data['mark'] . '=' . $thislist[$this->data['mark']]);
										if ($this->customer->isLogged()) {
											$this->data['text_login']     = $this->customer->getFirstName() . " " . $this->customer->getLastName();
											$this->data['captcha_status'] = false;
											$this->data['customer_id']    = $this->customer->getId();
										} else {
											$this->data['text_login']                   = $this->language->get('text_anonymus');
											$this->data['captcha_status']               = true;
											$this->data['customer_id']                  = false;
											$this->data['signer_code']                  = 'customer_id';
											$this->data['text_new_customer']            = $this->language->get('text_new_customer');
											$this->data['text_register']                = $this->language->get('text_register');
											$this->data['text_register_account']        = $this->language->get('text_register_account');
											$this->data['text_returning_customer']      = $this->language->get('text_returning_customer');
											$this->data['text_i_am_returning_customer'] = $this->language->get('text_i_am_returning_customer');
											$this->data['text_forgotten']               = $this->language->get('text_forgotten');
											$this->data['entry_email']                  = $this->language->get('entry_email');
											$this->data['entry_password']               = $this->language->get('entry_password');
											$this->data['button_continue']              = $this->language->get('button_continue');
											$this->data['button_login']                 = $this->language->get('button_login');
											$this->data['hide_block']                   = $this->language->get('hide_block');
											$this->data['error_register']               = $this->language->get('error_register');
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
											if (isset($this->request->post['email'])) {
												$this->data['email'] = $this->request->post['email'];
											} else {
												$this->data['email'] = '';
											}
											if (isset($this->request->post['password'])) {
												$this->data['password'] = $this->request->post['password'];
											} else {
												$this->data['password'] = '';
											}
											$this->data['action']    = $this->url->link('account/login', '', 'SSL');
											$this->data['register']  = $this->url->link('account/register', '', 'SSL');
											$this->data['forgotten'] = $this->url->link('account/forgotten', '', 'SSL');
											if (isset($this->request->post['redirect']) && (strpos($this->request->post['redirect'], $this->config->get('config_url')) !== false || strpos($this->request->post['redirect'], $this->config->get('config_ssl')) !== false)) {
												$this->data['redirect'] = $this->request->post['redirect'];
											} elseif (isset($this->session->data['redirect'])) {
												$this->data['redirect'] = $this->session->data['redirect'];
												unset($this->session->data['redirect']);
											} else {
												$this->data['redirect'] = $this->data['href'];
											}
										}
										if ($thislist[$this->data['mark']] && isset($this->data['customer_id'])) {
										}
										$this->load->model('agoo/signer/signer');
										if (isset($_COOKIE['email_subscribe_' . $this->data['mark']])) {
											$email_subscribe = unserialize(base64_decode($_COOKIE['email_subscribe_' . $this->data['mark']]));
											if (isset($email_subscribe[$this->data['mark_id']])) {
												$email_subscribe = $email_subscribe[$this->data['mark_id']];
											} else {
												$email_subscribe = false;
											}
										} else {
											$email_subscribe = false;
										}
										$this->data['signer_status'] = $this->model_agoo_signer_signer->getStatus($thislist[$this->data['mark']], $this->data['customer_id'], $this->data['mark'], $email_subscribe);
										$this->data['text_welcome']  = sprintf($this->language->get('text_welcome'), $this->url->link('account/register', '', 'SSL'));
										$this->data['text_wait']     = $this->language->get('text_wait');
										$this->cont('record/treecomments');
										$mark                       = $this->data['mark'];
										$this->data                 = $this->getMarkReviews($thislist, $type, $this->data['mark']);
										$this->data['mark']         = $mark;
										$this->data['html_comment'] = $this->controller_record_treecomments->comment($this->data['cmswidget']);
										if (isset($thislist['view_captcha']) && $thislist['view_captcha'] == 0) {
											$this->data['captcha_status'] = false;
										}
										if (((isset($this->data['thislist']['visual_editor']) && isset($this->data['thislist']['comment_must']) && $this->data['thislist']['comment_must'] && $this->data['thislist']['visual_editor'])) || !isset($this->data['thislist']['visual_editor'])) {
											$this->data['visual_editor'] = true;
										} else {
											$this->data['visual_editor'] = false;
										}
										if (isset($thislist['fields_view']))
											$this->data['fields_view'] = $thislist['fields_view'];
										else
											$this->data['fields_view'] = 0;
										if (isset($thislist['addfields'])) {
											usort($thislist['addfields'], 'comp_field');
											$this->data['fields'] = $thislist['addfields'];
										} else {
											$this->data['fields'] = array();
										}
										$fields_db = $this->model_record_fields->getFieldsDBlang();
										foreach ($this->data['fields'] as $num => $field) {
											foreach ($fields_db as $num_db => $field_db) {
												if ($field['field_name'] == $field_db['field_name']) {
													foreach ($field_db as $num_1 => $field_1) {
														if (!isset($this->data['fields'][$num][$num_1]) || $field_db[$num_1] == '') {
															$this->data['fields'][$num][$num_1] = $field_1;
														} else {
														}
													}
												}
											}
										}
										usort($this->data['fields'], 'comp_field');
										foreach ($this->data['fields'] as $num => $pole) {
											if (strpos(html_entity_decode($pole['field'][$this->data['config_language_id']]['field_template_in'], ENT_QUOTES, 'UTF-8'), '<?php') !== false) {
												$data['exec']                                                                                = html_entity_decode($pole['field'][$this->data['config_language_id']]['field_template_in'], ENT_QUOTES, 'UTF-8');
												$this->data['fields'][$num]['field'][$this->data['config_language_id']]['field_template_in'] = $this->exec_field($data['exec'], $this->data['mark_info']);
											}
										}
										$this->data['text_signer_answer']       = $this->language->get('text_signer_answer');
										$this->data['text_signer_answer_email'] = $this->language->get('text_signer_answer_email');
										$this->data['text_signer']              = $this->language->get('text_signer');
										$this->data['text_write_review']        = $this->language->get('text_write_review');
										$this->data['text_write']               = $this->language->get('text_write');
										$this->data['hide_block']               = $this->language->get('hide_block');
										$this->data['error_register']           = $this->language->get('error_register');
										$this->data['entry_name']               = $this->language->get('entry_name');
										$this->data['text_customer_enter']      = $this->language->get('text_customer_enter');
										$this->data['entry_comment']            = $this->language->get('entry_comment');
										$this->data['text_note']                = $this->language->get('text_note');
										$this->data['entry_rating_review']      = $this->language->get('entry_rating_review');
										$this->data['entry_bad']                = $this->language->get('entry_bad');
										$this->data['entry_good']               = $this->language->get('entry_good');
										$this->data['entry_captcha_title']      = $this->language->get('entry_captcha_title');
										$this->data['entry_captcha']            = $this->language->get('entry_captcha');
										$this->data['text_voted_blog_plus']     = $this->language->get('text_voted_blog_plus');
										$this->data['text_voted_blog_minus']    = $this->language->get('text_voted_blog_minus');
										$this->data['text_vote_will_reg']       = $this->language->get('text_vote_will_reg');
										$this->data['text_vote_blog_plus']      = $this->language->get('text_vote_blog_plus');
										$this->data['text_vote_blog_minus']     = $this->language->get('text_vote_blog_minus');
										$this->data['text_review_yes']          = $this->language->get('text_review_yes');
										$this->data['text_review_no']           = $this->language->get('text_review_no');
										$this->data['text_review_karma']        = $this->language->get('text_review_karma');
										$this->data['tab_review']               = $this->language->get('tab_review');
										$this->data['text_all']                 = $this->language->get('text_all');
										$this->data['text_admin']               = $this->language->get('text_admin');
										$this->data['text_buyproduct']          = $this->language->get('text_buyproduct');
										$this->data['text_buy']                 = $this->language->get('text_buy');
										$this->data['text_registered']          = $this->language->get('text_registered');
										$this->data['text_buy_ghost']           = $this->language->get('text_buy_ghost');
										$this->data['button_write']             = $this->language->get('button_write');
										$this->data['thislist']                 = $this->data['cmswidget'];
									}
								}
								if (isset($thislist['template']) && $thislist['template'] != '') {
									if ($type == 'treecomments') {
										$template = '/template/agootemplates/widgets/treecomments/' . $thislist['template'];
									}
									if ($type == 'forms') {
										$template = '/template/agootemplates/widgets/forms/' . $thislist['template'];
									}
								} else {
									if ($type == 'treecomments') {
										$template = '/template/agootemplates/widgets/treecomments/rozetka.tpl';
									}
									if ($type == 'forms') {
										$template = '/template/agootemplates/widgets/forms/rozetka.tpl';
									}
								}
							}

					        if (isset($this->data['thislist']['html_modal'][$this->config->get('config_language_id')]) && $this->data['thislist']['html_modal'][$this->config->get('config_language_id')]!='') {
								$this->data['html_modal'] = html_entity_decode($this->data['thislist']['html_modal'][$this->config->get('config_language_id')], ENT_QUOTES, 'UTF-8');
							} else {
					        	$this->data['html_modal'] = '';
							}

						}
						if (!empty($module_data) && $type == 'hook') {
							$this->data['type'] = $type;
							$class_widget       = $type . '_widget';
							$this->data         = $this->$class_widget($this->data);
							$template           = $this->data['template'];
						}
						if (!empty($module_data) && $type == 'avatar') {
							$this->data['type'] = $type;
							$class_widget       = $type . '_widget';
							$this->data         = $this->$class_widget($this->data);
							$template           = $this->data['template'];
						}
						if (isset($this->data['settings']['further'][$this->config->get('config_language_id')]) && $this->data['settings']['further'][$this->config->get('config_language_id')] != '') {
							$this->data['settings_general']['further'] = html_entity_decode($this->data['settings']['further'][$this->config->get('config_language_id')]);
						} else {
							$this->data['settings_general']['further'] = html_entity_decode($this->data['settings_general']['further'][$this->config->get('config_language_id')]);
						}
						if (isset($this->data['settings_widget']['modal_status']) && $this->data['settings_widget']['modal_status']) {
							$class_further = 'modal_' . $this->data['cmswidget'] . ' colorbox_modal';
						} else {
							$class_further = '';
						}
						$this->data['settings_general']['further'] = str_replace('{CLASS}', $class_further, $this->data['settings_general']['further']);
						if (isset($this->data['settings_widget']['template_modal']) && $this->data['settings_widget']['template_modal'] != '') {
							$further_template = 'data-template_modal="' . $this->data['settings_widget']['template_modal'] . '"';
						} else {
							$further_template = '';
						}
						$data_further                              = ' data-cmswidget="' . $this->data['cmswidget'] . '" ' . $further_template;
						$this->data['settings_general']['further'] = str_replace('{DATA}', $data_further, $this->data['settings_general']['further']);
						if (!isset($this->data['request_get']['cmswidget'])) {
							$this->data['request_get']['cmswidget'] = $this->data['cmswidget'];
						}
						if (isset($this->data['settings']['box_begin']) && $this->data['settings']['box_begin'] != '') {
							$this->data['box_begin'] = html_entity_decode($this->data['settings']['box_begin']);
						} else {
							$this->data['box_begin'] = html_entity_decode($this->data['settings_general']['box_begin']);
						}
						if ($this->data['heading_title'] != '') {
							$this->data['box_begin'] = str_replace('{TITLE}', $this->data['heading_title'], $this->data['box_begin']);
						} else {
							$this->data['box_begin'] = str_replace('{TITLE}', '', $this->data['box_begin']);
						}
						if (isset($this->data['cmswidget'])) {
							$this->data['box_begin'] = str_replace('{CMSWIDGET}', $this->data['cmswidget'], $this->data['box_begin']);
						} else {
							$this->data['box_begin'] = str_replace('{CMSWIDGET}', '', $this->data['box_begin']);
						}
						if (isset($this->data['settings']['box_end']) && $this->data['settings']['box_end'] != '') {
							$this->data['box_end'] = html_entity_decode($this->data['settings']['box_end']);
						} else {
							$this->data['box_end'] = html_entity_decode($this->data['settings_general']['box_end']);
						}
						if ($this->data['heading_title'] != '') {
							$this->data['box_end'] = str_replace('{TITLE}', $this->data['heading_title'], $this->data['box_end']);
						} else {
							$this->data['box_end'] = str_replace('{TITLE}', '', $this->data['box_end']);
						}
						if (isset($this->data['cmswidget'])) {
							$this->data['box_end'] = str_replace('{CMSWIDGET}', $this->data['cmswidget'], $this->data['box_end']);
						} else {
							$this->data['box_end'] = str_replace('{CMSWIDGET}', '', $this->data['box_end']);
						}
						if (isset($this->data['settings_general']['box_share_list']) && $this->data['settings_general']['box_share_list'] != '') {
							$this->data['box_share_list'] = html_entity_decode($this->data['settings_general']['box_share_list']);
						} else {
							$this->data['box_share_list'] = '';
						}
						if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
							$config_url = substr($this->config->get('config_ssl'), 0, strpos_offset('/', $this->config->get('config_ssl'), 3) + 1);
						} else {
							$config_url = substr($this->config->get('config_url'), 0, strpos_offset('/', $this->config->get('config_url'), 3) + 1);
						}
						$url                                 = str_replace('&amp;', '&', ltrim($this->request->server['REQUEST_URI'], '/'));
						$this->data['href_url']              = $config_url . $url;
						$this->data['ascp_widgets_position'] = $this->registry->get('ascp_widgets_position');
						if (!empty($module_data) && $type != '') {
							if ($this->data['type']) {
								if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . $template) && is_file(DIR_TEMPLATE . $this->config->get('config_template') . $template)) {
									$this->template = $this->config->get('config_template') . $template;
								} else {
									if (file_exists(DIR_TEMPLATE . 'default' . $template) && is_file(DIR_TEMPLATE . 'default' . $template)) {
										$this->template = 'default' . $template;
									} else {
										$this->template = '';
									}
								}
								$this->data['theme']    = $this->config->get('config_template');
								$this->data['language'] = $this->language;
								$this->data['request']  = $this->request;
								$this->data['document'] = $this->document;
								if ($this->template != '') {
									if (SC_VERSION < 20) {
										$html = $this->render();
									} else {
										if (!is_array($this->data))
											$this->data = array();
										$html = $this->load->view($this->template, $this->data);
									}
									if (isset($this->data['settings']['ajax']) && $this->data['settings']['ajax']) {
										$this->data['html'] = $html;
										$this->data         = $this->ajax_write($this->data);
										$html               = $this->data['html'];
										$ajax_file_new      = $this->data['ajax_file'];
									}
									if (isset($this->data['settings_general']['cache_widgets']) && $this->data['settings_general']['cache_widgets']) {
										$module_view_cache[$hash_cache] = base64_encode($html);
										$this->cache->set($cache_name, $module_view_cache);
									}
								}
							}
						}
					} else {
						if (isset($module_view_cache[$hash_cache])) {
							$html = base64_decode($module_view_cache[$hash_cache]);
						} else {
							$html = '';
						}
					}
					$this->registry->set('load', $loader_old);
					$this->output = $html;
					$this->config->set("blog_work", false);
					if (isset($this->request->get['ajax_file']) && $this->request->get['ajax_file'] != '') {
						if (isset($ajax_file_new) && $this->data['cmswidget'] == $this->request->get['cmswidget']) {
							$this->request->get['ajax_file'] = base64_encode($ajax_file_new);
							$this->ajax_file();
						}
					} else {
						if ($this->data['ajax']) {
							$this->data['header']         = '';
							$this->data['column_left']    = '';
							$this->data['column_right']   = '';
							$this->data['content_top']    = '';
							$this->data['content_bottom'] = '';
							$this->data['footer']         = '';
							if (SC_VERSION < 20) {
								$html = $this->render();
							} else {
								$html = $this->load->view($this->template, $this->data);
							}
							$this->registry->set("blog_output", 1);
							$this->response->setOutput($html);
							$this->response->output();
							$this->registry->set("fblogwork", 0);
							exit();
						}
						if (SC_VERSION > 15) {
							return $html;
						} else {
							return $this->response->setOutput($html);
						}
					}
				}
			}
		}
		public function exec_field($exec, $data)
		{
			$data['data_field'] = $data;
			$data['exec']       = html_entity_decode($exec, ENT_QUOTES, 'UTF-8');
			$html_name          = "exec_field." . md5(serialize($data)) . "." . $this->config->get('config_store_id') . "." . $this->config->get('config_language_id') . ".php";
			$file               = DIR_CACHE . $html_name;
			$handle             = fopen($file, 'w');
			fwrite($handle, $data['exec']);
			fclose($handle);
			if (file_exists($file)) {
				extract($data);
				ob_start();
				require($file);
				$exec = ob_get_contents();
				ob_end_clean();
				unlink($file);
			}
			return $exec;
		}
		private function hook_widget($data)
		{
			$this->data = $data;
			if (isset($this->data['ascp_widgets'][$this->data['cmswidget']]['title_list_latest'][$this->config->get('config_language_id')])) {
				$this->data['heading_title'] = $this->data['ascp_widgets'][$this->data['cmswidget']]['title_list_latest'][$this->config->get('config_language_id')];
			} else {
				$this->data['heading_title'] = '';
			}
			if (isset($this->data['thislist']['template']) && $this->data['thislist']['template'] != '') {
				$this->data['template'] = '/template/agootemplates/widgets/hook/' . $this->data['thislist']['template'];
			} else {
				$this->data['template'] = '/template/agootemplates/widgets/hook/hook.tpl';
			}
			return $this->data;
		}
		protected function ajax_file()
		{
			$ajax_file_cached = false;
			$ajax_file        = DIR_CACHE . base64_decode($this->db->escape($this->request->get["ajax_file"]));
			if (!file_exists($ajax_file)) {
				$ajax_file_cached = true;
			} else {
				ob_start();
				require($ajax_file);
				$ajax_html = ob_get_contents();
				ob_end_clean();
				header('Content-type: text/html; charset=utf-8');
				echo $ajax_html;
				$this->deletecache('ajax');
				exit();
			}
			return $ajax_file_cached;
		}
		protected function ajax_write($data)
		{
			$this->data = $data;
			$html_name  = "ajax." . md5($this->data['href_url'] . serialize($this->data['customer_intersect']) . serialize($this->data['userLogged'])) . "." . $this->data['cmswidget'] . "." . $this->config->get('config_store_id') . "." . $this->config->get('config_language_id') . ".php";
			$file       = DIR_CACHE . $html_name;
			if (!file_exists($file) || (isset($this->data['settings_general']['cache_widgets']) && !$this->data['settings_general']['cache_widgets'])) {
				$handle = fopen($file, 'w');
				fwrite($handle, $this->data['html']);
				fclose($handle);
			}
			$this->data['ajax_file'] = base64_encode($html_name);
			if (strpos($this->data['href_url'], '?') === false) {
				$this->data['href_separator'] = '?';
			} else {
				$this->data['href_separator'] = '&';
			}
			$template = '/template/agootemplates/module/ajax.tpl';
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . $template)) {
				$this->template = $this->config->get('config_template') . $template;
			} else {
				$this->template = 'default' . $template;
			}
			if (SC_VERSION < 20) {
				$this->data['html'] = $this->render();
			} else {
				$this->data['html'] = $this->load->view($this->template, $this->data);
			}
			$this->data['ajax_file'] = $html_name;
			return $this->data;
		}
		public function deletecache($key)
		{
			$files = glob(DIR_CACHE . preg_replace('/[^A-Z0-9\._-]/i', '', $key) . '.*');
			if ($files) {
				foreach ($files as $file) {
					if (file_exists($file)) {
						$file_time    = filemtime($file);
						$date_current = date("d-m-Y H:i:s");
						$date_diff    = (strtotime($date_current) - ($file_time)) / 60;
						if ($date_diff > 5) {
							unlink($file);
						}
					}
				}
			}
		}
		private function avatar_widget($data)
		{
			$this->data = $data;
			if (isset($this->data['ascp_widgets'][$this->data['cmswidget']]['title_list_latest'][$this->config->get('config_language_id')]))
				$this->data['heading_title'] = $this->data['ascp_widgets'][$this->data['cmswidget']]['title_list_latest'][$this->config->get('config_language_id')];
			else
				$this->data['heading_title'] = '';
			$this->load->model('record/avatar');
			$this->data['avatar']    = $this->model_record_avatar->getAvatar($this->data['customer_id']);
			$this->data['link']      = $this->url->link('module/blog/avatar', '', 'SSL');
			$this->data['layout_id'] = $this->data['layout_id'];
			$this->data['url']       = ltrim($this->request->server['REQUEST_URI'], '/');
			if (isset($this->data['thislist']['template']) && $this->data['thislist']['template'] != '') {
				$this->data['template'] = '/template/agootemplates/widgets/avatar/' . $this->data['thislist']['template'];
			} else {
				$this->data['template'] = '/template/agootemplates/widgets/avatar/avatar.tpl';
			}
			return $this->data;
		}
		private function avatar_customer($data)
		{
			$this->data = $data;
			$group      = '';
			if (file_exists(DIR_IMAGE . 'no_image.jpg')) {
				$no_image = 'no_image.jpg';
			}
			if (file_exists(DIR_IMAGE . 'no_image.png')) {
				$no_image = 'no_image.png';
			}
			$this->load->model('record/avatar');
			$this->data['avatar'] = $this->model_record_avatar->getAvatar($this->data['customer_id']);
			if (isset($this->data['thislist']['avatar_width']) && $this->data['thislist']['avatar_width'] != '') {
				$width = $this->data['thislist']['avatar_width'];
			} else {
				if (isset($this->data['settings_general']['avatar_width']) && $this->data['settings_general']['avatar_width'] != '') {
					$width = $this->data['settings_general']['avatar_width'];
				} else {
					$width = '100';
				}
			}
			if (isset($this->data['thislist']['avatar_height']) && $this->data['thislist']['avatar_height'] != '') {
				$height = $this->data['thislist']['avatar_height'];
			} else {
				if (isset($this->data['settings_general']['avatar_height']) && $this->data['settings_general']['avatar_height'] != '') {
					$height = $this->data['settings_general']['avatar_height'];
				} else {
					$height = '100';
				}
			}
			$this->data['avatar_width']  = $width;
			$this->data['avatar_height'] = $height;
			$this->load->model('tool/image');
			if (!isset($this->data['avatar']) || $this->data['avatar'] == '') {
				if (isset($this->data['settings_general']['avatar_buyproduct']) && $this->data['settings_general']['avatar_buyproduct'] != '' && isset($this->data['customer_intersect']) && $group == '-3') {
					$this->data['avatar'] = $this->model_tool_image->resizeme($this->data['settings_general']['avatar_buyproduct'], $this->data['avatar_width'], $this->data['avatar_height']);
				} else {
					if (isset($this->data['settings_general']['avatar_buy']) && $this->data['settings_general']['avatar_buy'] != '' && isset($this->data['customer_intersect']) && $group == '-2') {
						$this->data['avatar'] = $this->model_tool_image->resizeme($this->data['settings_general']['avatar_buy'], $this->data['avatar_width'], $this->data['avatar_height']);
					} else {
						if (isset($this->data['settings_general']['avatar_reg']) && $this->data['settings_general']['avatar_reg'] != '' && isset($this->data['customer_id']) && $this->data['customer_id'] > 0) {
							$this->data['avatar'] = $this->model_tool_image->resizeme($this->data['settings_general']['avatar_reg'], $this->data['avatar_width'], $this->data['avatar_height']);
						} else {
							if (isset($this->data['settings_general']['avatar_default']) && $this->data['settings_general']['avatar_default'] != '') {
								$this->data['avatar'] = $this->model_tool_image->resizeme($this->data['settings_general']['avatar_default'], $this->data['avatar_width'], $this->data['avatar_height']);
							} else {
								$this->data['avatar'] = $this->model_tool_image->resizeme($no_image, $this->data['avatar_width'], $this->data['avatar_height']);
							}
						}
					}
				}
			} else {
				$this->data['avatar'] = $this->model_tool_image->resizeme($this->data['avatar'], $this->data['avatar_width'], $this->data['avatar_height']);
			}
			$this->data['avatar_customer'] = $this->data['avatar'];
			return $this->data;
		}
		private function validate_cmswidget($data)
		{
			$schemes = $this->config->get('blog_module');
			$widgets = $this->config->get('ascp_widgets');
			$valid   = false;
			foreach ($schemes as $num => $scheme) {
				$widget = $scheme['what'];
				if ($widgets[$widget]['type'] == 'avatar' && $scheme['status'] == '1') {
					if (is_array($scheme['layout_id'])) {
						foreach ($scheme['layout_id'] as $nm => $layout_id) {
							if ($data['layout_id'] == $layout_id) {
								$valid = true;
							}
						}
					} else {
						$widget = $scheme['what'];
						if ($widgets[$widget]['type'] == 'avatar' && $scheme['status'] == '1') {
							if ($scheme['layout_id'] == $data['layout_id']) {
								$valid = true;
							}
						}
					}
					if ($scheme['url'] != '') {
						if ($scheme['url_template'] == '1') {
							$pos = utf8_strpos($request_url, trim($module['url']));
							if ($pos === false) {
							} else {
								$valid = true;
							}
						} else {
							if (trim($scheme['url']) == $data['url']) {
								$valid = true;
							}
						}
					}
				}
			}
			return $valid;
		}
		public function avatar()
		{
			if (file_exists(DIR_IMAGE . 'no_image.jpg')) {
				$no_image = 'no_image.jpg';
			}
			if (file_exists(DIR_IMAGE . 'no_image.png')) {
				$no_image = 'no_image.png';
			}
			$this->language->load('seocms/module');
			if (isset($this->request->post['cmswidget'])) {
				$this->data['cmswidget'] = (int) $this->request->post['cmswidget'];
			} else {
				$this->data['cmswidget'] = '';
			}
			if (isset($this->request->post['layout_id'])) {
				$this->data['layout_id'] = (int) $this->request->post['layout_id'];
			} else {
				$this->data['layout_id'] = '';
			}
			if (isset($this->request->post['layout_id'])) {
				$this->data['layout_id'] = (int) $this->request->post['layout_id'];
			} else {
				$this->data['layout_id'] = '';
			}
			if (isset($this->request->post['url'])) {
				$this->data['url'] = $this->request->post['url'];
			} else {
				$this->data['url'] = '';
			}
			$this->data['ascp_widgets'] = $this->config->get('ascp_widgets');
			$this->data['link']         = $this->url->link('module/blog/avatar_upload', '', 'SSL');
			if (isset($this->data['ascp_widgets'][$this->data['cmswidget']]) && isset($this->data['ascp_widgets'][$this->data['cmswidget']])) {
				$this->data['thislist'] = $this->data['ascp_widgets'][$this->data['cmswidget']];
			} else {
				$this->data['thislist'] = null;
			}
			$validate_cmswidget = $this->validate_cmswidget($this->data);
			if (isset($this->data['ascp_widgets'][$this->data['cmswidget']]['title_list_latest'][$this->config->get('config_language_id')]))
				$this->data['heading_title'] = $this->data['ascp_widgets'][$this->data['cmswidget']]['title_list_latest'][$this->config->get('config_language_id')];
			else
				$this->data['heading_title'] = '';
			$this->data = $this->controller_record_customer->customer_groups($this->data, 'customer_groups_avatar');
			if (!isset($this->data['thislist']['customer_groups_avatar'])) {
				$this->data['thislist']['customer_groups_avatar'] = array();
			}
			if (isset($this->data['customer_id']) && !$this->data['customer_id']) {
				$validate_cmswidget = false;
			}
			$this->data['customer_intersect'] = array_intersect($this->data['thislist']['customer_groups_avatar'], $this->data['customer_groups_avatar']);
			if (isset($this->data['thislist']['store']) && in_array($this->config->get('config_store_id'), $this->data['thislist']['store'])) {
				if ($validate_cmswidget && isset($this->data['thislist']['customer_groups_avatar']) && !empty($this->data['customer_intersect'])) {
					if (isset($this->data['thislist']['template_module']) && $this->data['thislist']['template_module'] != '') {
						$template = $this->data['thislist']['template_module'];
					} else {
						$template = 'avatar.tpl';
					}
					if (isset($this->data['thislist']['upload_allowed']) && $this->data['thislist']['upload_allowed'] != '')
						$filetypes = $this->data['thislist']['upload_allowed'];
					else
						$filetypes = $this->config->get('config_upload_allowed');
					$this->data['filetypes'] = $filetypes;
					if (isset($this->data['thislist']['avatar_width']) && $this->data['thislist']['avatar_width'] != '') {
						$width = $this->data['thislist']['avatar_width'];
					} else {
						if (isset($this->data['settings_general']['avatar_width']) && $this->data['settings_general']['avatar_width'] != '') {
							$width = $this->data['settings_general']['avatar_width'];
						} else {
							$width = '100';
						}
					}
					if (isset($this->data['thislist']['avatar_height']) && $this->data['thislist']['avatar_height'] != '') {
						$height = $this->data['thislist']['avatar_height'];
					} else {
						if (isset($this->data['settings_general']['avatar_height']) && $this->data['settings_general']['avatar_height'] != '') {
							$height = $this->data['settings_general']['avatar_height'];
						} else {
							$height = '100';
						}
					}
					$this->data['avatar_width']  = $width;
					$this->data['avatar_height'] = $height;
					$this->load->model('record/avatar');
					$this->data['avatar'] = $this->model_record_avatar->getAvatar($this->data['customer_id']);
					$this->load->model('tool/image');
					if ($this->data['avatar'] == '') {
						if (isset($this->data['settings_general']['avatar_default']) && $this->data['settings_general']['avatar_default'] != '') {
							$this->data['avatar'] = getHttpImage($this) . $this->data['settings_general']['avatar_default'];
						} else {
							$this->data['avatar'] = $this->model_tool_image->resize($no_image, $this->data['avatar_width'], $this->data['avatar_height']);
						}
					} else {
						$this->data['avatar'] = getHttpImage($this) . $this->data['avatar'];
					}
					if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/agootemplates/module/' . $template)) {
						$this->template = $this->config->get('config_template') . '/template/agootemplates/module/' . $template;
					} else {
						if (file_exists(DIR_TEMPLATE . 'default/template/agootemplates/module/' . $template)) {
							$this->template = 'default/template/agootemplates/module/' . $template;
						} else {
							$this->template = 'default/template/agootemplates/module/avatar.tpl';
						}
					}
				} else {
					if (isset($this->data['thislist']['template_module']) && $this->data['thislist']['template_module'] != '') {
						$template = $this->data['thislist']['template_module'];
					} else {
						$template = 'access.tpl';
					}
					if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/agootemplates/module/' . $template)) {
						$this->template = $this->config->get('config_template') . '/template/agootemplates/module/' . $template;
					} else {
						if (file_exists(DIR_TEMPLATE . 'default/template/agootemplates/module/' . $template)) {
							$this->template = 'default/template/agootemplates/module/' . $template;
						} else {
							$this->template = 'default/template/agootemplates/module/access.tpl';
						}
					}
				}
				$this->data['text_wait']    = $this->language->get('text_wait');
				$this->data['theme']        = $this->config->get('config_template');
				$this->data['ascp_widgets'] = $this->config->get('ascp_widgets');
				$this->data['language']     = $this->language;
				if (SC_VERSION < 20) {
					$this->data['html'] = $this->render();
				} else {
					$this->data['html'] = $this->load->view($this->template, $this->data);
				}
				if ((isset($this->request->get['sc_ajax']) && $this->request->get['sc_ajax'] == 1) || (isset($this->request->post['sc_ajax']) && $this->request->post['sc_ajax'] == 1)) {
					return $this->response->setOutput($this->data['html']);
				}
			}
		}
		public function avatar_upload()
		{
			$this->language->load('seocms/module');
			if (isset($this->request->post['action'])) {
				$this->data['action'] = $this->db->escape($this->request->post['action']);
			} else {
				$this->data['action'] = '';
			}
			if ($this->data['action'] != 'delete') {
				if (isset($this->request->post['cmswidget'])) {
					$this->data['cmswidget'] = (int) $this->request->post['cmswidget'];
				} else {
					$this->data['cmswidget'] = '';
				}
				if (isset($this->request->post['layout_id'])) {
					$this->data['layout_id'] = (int) $this->request->post['layout_id'];
				} else {
					$this->data['layout_id'] = '';
				}
				if (isset($this->request->post['url'])) {
					$this->data['url'] = $this->request->post['url'];
				} else {
					$this->data['url'] = '';
				}
				$this->data['ascp_widgets']  = $this->config->get('ascp_widgets');
				$this->data['ascp_settings'] = $this->config->get('ascp_settings');
				if (isset($this->data['ascp_widgets'][$this->data['cmswidget']]) && isset($this->data['ascp_widgets'][$this->data['cmswidget']])) {
					$this->data['thislist'] = $this->data['ascp_widgets'][$this->data['cmswidget']];
				} else {
					$this->data['thislist'] = null;
				}
				$validate_cmswidget = $this->validate_cmswidget($this->data);
				$this->data         = $this->controller_record_customer->customer_groups($this->data, 'customer_groups_avatar');
				if (!isset($this->data['thislist']['customer_groups_avatar'])) {
					$this->data['thislist']['customer_groups_avatar'] = array();
				}
				if (!$this->data['customer_id']) {
					$validate_cmswidget = false;
				}
				$this->data['customer_intersect'] = array_intersect($this->data['thislist']['customer_groups_avatar'], $this->data['customer_groups_avatar']);
				$valid                            = false;
				if (isset($this->data['thislist']['store']) && in_array($this->config->get('config_store_id'), $this->data['thislist']['store'])) {
					if ($validate_cmswidget && isset($this->data['thislist']['customer_groups_avatar']) && !empty($this->data['customer_intersect'])) {
						$valid = true;
					}
				}
				if (isset($this->data['thislist']['title_list_latest'][$this->config->get('config_language_id')])) {
					$this->data['heading_title'] = $this->data['ascp_widgets'][$this->data['cmswidget']]['title_list_latest'][$this->config->get('config_language_id')];
				} else {
					$this->data['heading_title'] = '';
				}
				$json = array();
				if ($valid) {
					if (!empty($this->request->files['file']['name'])) {
						$filename = basename(preg_replace('/[^a-zA-Z0-9\.\-\s+]/', '', html_entity_decode($this->request->files['file']['name'], ENT_QUOTES, 'UTF-8')));
						$ext      = substr(strrchr($filename, '.'), 1);
						if (strlen(trim($filename)) < 7) {
							$filename = substr(md5(sha1(uniqid(mt_rand(), true))), 0, 10) . "." . $ext;
						}
						if ((strlen($filename) < 3) || (strlen($filename) > 64)) {
							$json['error'] = $this->language->get('error_filename');
						}
						$allowed = array();
						if (isset($this->data['thislist']['upload_allowed']) && $this->data['thislist']['upload_allowed'] != '')
							$filetypes = explode(',', $this->data['thislist']['upload_allowed']);
						else
							$filetypes = explode(',', $this->config->get('config_upload_allowed'));
						$this->data['filetypes'] = $filetypes;
						foreach ($filetypes as $filetype) {
							$allowed[] = trim($filetype);
						}
						if (!in_array(substr(strrchr($filename, '.'), 1), $allowed)) {
							$json['error'] = $this->language->get('error_filetype');
						}
						if ($this->request->files['file']['error'] != UPLOAD_ERR_OK) {
							$json['error'] = $this->language->get('error_upload_' . $this->request->files['file']['error']);
						}
					} else {
						$json['error'] = $this->language->get('error_upload');
					}
				} else {
					$json['error'] = $this->language->get('error_upload');
				}
				if (!$json) {
					if (is_uploaded_file($this->request->files['file']['tmp_name']) && file_exists($this->request->files['file']['tmp_name'])) {
						$file          = basename($filename) . '.' . md5(substr(sha1(uniqid(mt_rand(), true)), 0, 10));
						$file_original = basename($filename);
						$avatar_dir    = 'data/avatars/' . (ceil($this->data['customer_id'] / 300)) * 300;
						move_uploaded_file($this->request->files['file']['tmp_name'], DIR_IMAGE . $file);
						$new_filename = $avatar_dir . '/' . $this->data['customer_id'] . "_" . utf8_strtolower($file_original);
						if (isset($this->data['thislist']['avatar_width']) && $this->data['thislist']['avatar_width'] != '') {
							$width = $this->data['thislist']['avatar_width'];
						} else {
							if (isset($this->data['ascp_settings']['avatar_width']) && $this->data['ascp_settings']['avatar_width'] != '') {
								$width = $this->data['ascp_settings']['avatar_width'];
							} else {
								$width = '100';
							}
						}
						if (isset($this->data['thislist']['avatar_height']) && $this->data['thislist']['avatar_height'] != '') {
							$height = $this->data['thislist']['avatar_height'];
						} else {
							if (isset($this->data['ascp_settings']['avatar_height']) && $this->data['ascp_settings']['avatar_height'] != '') {
								$height = $this->data['ascp_settings']['avatar_height'];
							} else {
								$height = '100';
							}
						}
						$this->load->model('tool/image');
						$json['file'] = $avatar_thumb = $this->model_tool_image->resizeavatar($file, $new_filename, $width, $height, true, false);
						if (trim($avatar_thumb) == '') {
							$json['error'] = $this->language->get('error_upload');
						}
						if ($file != '' && file_exists(DIR_IMAGE . $file)) {
							unlink(DIR_IMAGE . $file);
						}
					}
				}
				if (!isset($json['error'])) {
					$this->load->model('record/avatar');
					$this->model_record_avatar->editAvatar($new_filename);
					$json['success'] = $this->language->get('text_upload');
				}
			} else {
				$this->load->model('record/avatar');
				$this->model_record_avatar->removeAvatar();
				$json['error'] = $this->language->get('entry_avatar_delete');
			}
			$this->response->setOutput(json_encode($json));
		}

		public function ColorboxLoader($theme, $data)
		{
			$this->data             = $data;
			$findme                 = 'colorbox';
			$this->data['imagebox'] = '';
			$scripts                = $this->document->getScripts();
			$colorbox_flag          = false;
			foreach ($scripts as $num => $val) {
				if (strpos($val, $findme) !== FALSE) {
					$colorbox_flag = true;
				}
			}
			$findme = 'colorbox.css';
			$styles = $this->document->getStyles();
			foreach ($styles as $num => $val) {
				if (strpos($val['href'], $findme) !== FALSE) {
					$colorbox_flag = true;
				}
			}

			if (!$colorbox_flag) {
				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/header.tpl')) {
					$product_file = file_get_contents(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/header.tpl');
				} else {
					if (file_exists(DIR_TEMPLATE . 'default/template/common/header.tpl')) {
						$product_file = file_get_contents(DIR_TEMPLATE . 'default/template/common/header.tpl');
					} else {
						$product_file = "";
					}
				}
				$pos = strpos($product_file, $findme);
				unset($product_file);
				if ($pos !== false) {
					$colorbox_flag = true;
				}
			}

			if (!$colorbox_flag || $this->config->get('config_template') == 'journal2') {
				$scriptfile = 'view/javascript/blog/colorbox/jquery.colorbox.js';
				if (file_exists(DIR_APPLICATION . $scriptfile)) {
					$this->document->addScript('catalog/' . $scriptfile);
				}
				$scriptfile = 'view/javascript/blog/colorbox/lang/jquery.colorbox-' . $this->config->get('config_language') . '.js';
				if (file_exists(DIR_APPLICATION . $scriptfile)) {
					$this->document->addScript('catalog/' . $scriptfile);
				}
				$scriptfile = 'view/javascript/blog/colorbox/css/' . $theme . '/colorbox.css';
				if (file_exists(DIR_APPLICATION . $scriptfile)) {
					$this->document->addStyle('catalog/' . $scriptfile);
				}
			}
			$this->data['imagebox'] = 'colorbox';
			if ($this->data['imagebox'] == 'colorbox') {
				$scriptfile = 'view/javascript/blog/blog.color.js';
				if (file_exists(DIR_APPLICATION . $scriptfile)) {
					$this->document->addScript('catalog/' . $scriptfile);
				}
			}
			if (!isset($this->data['settings_general']['css_dir'])) {
				$this->data['settings_general']['css_dir'] = 'cache';
			}
			if ($this->data['settings_general']['css_dir'] == 'cache') {
				$css_dir = DIR_CACHE;
			}
			if ($this->data['settings_general']['css_dir'] == 'image') {
				$css_dir = DIR_IMAGE;
			}

			$css_name = "seocmspro.css";
			if (file_exists($css_dir . $css_name)) {
				$css_file = getCSSDir($css_dir) . $css_name;
				$this->document->addStyle($css_file);
			} else {
						if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/agootemplates/stylesheet/seocmspro.tpl')) {
							$this->template = $this->config->get('config_template') . '/template/agootemplates/stylesheet/seocmspro.tpl';
						} else {
							$this->template = 'default/template/agootemplates/stylesheet/seocmspro.tpl';
						}
						if (SC_VERSION < 20) {
							$css_file = $this->render();
						} else {
							$css_file = $this->load->view($this->template, $this->data);
						}
						$file   = $css_dir . $css_name;
						$handle = fopen($file, 'w');
						fwrite($handle, $css_file);
						fclose($handle);
						if (file_exists($css_dir . $css_name)) {
							$this->document->addStyle(getCSSDir($css_dir) . $css_name);
						}

			}
			return $this->data;
		}

		public function cont($cont)
		{
			if (!defined('DIR_CATALOG'))
				$dir_catalog =  DIR_APPLICATION;
			else
				$dir_catalog = DIR_CATALOG;

			$file  = $dir_catalog . 'controller/' . $cont . '.php';
			if (file_exists($file)) {
	           $this->cont_loading($cont, $file);
	           return true;
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
		private function cont_loading ($cont, $file)
		{
				$class = 'Controller' . preg_replace('/[^a-zA-Z0-9]/', '', $cont);
				include_once($file);
				$this->registry->set('controller_' . str_replace('/', '_', $cont), new $class($this->registry));
		}
		private function getBlogsReviews($thislist, $type = 'reviews')
		{
			require_once(DIR_SYSTEM . 'helper/utf8blog.php');
			if (file_exists(DIR_IMAGE . 'no_image.jpg')) {
				$no_image = 'no_image.jpg';
			}
			if (file_exists(DIR_IMAGE . 'no_image.png')) {
				$no_image = 'no_image.png';
			}
			$this->data['settings']      = $thislist;
			$hash                        = md5(serialize($thislist));
			$this->data['settings_hash'] = $hash;
			if ($this->customer->isLogged()) {
				$this->data['customer_group_id'] = $this->customer_group_id;
			} else {
				$this->data['customer_group_id'] = $this->config->get('config_customer_group_id');
			}
			$rate = array();
			$this->language->load('seocms/blog');
			$this->load->model('record/comment');
			$this->load->model('record/blog');
			$this->load->model('record/fields');
			$this->load->model('tool/image');
			$this->data['text_manufacturer'] = $this->language->get('text_manufacturer');
			$this->data['text_karma']        = $this->language->get('text_karma');
			if (isset($thislist['title_list_latest'][$this->config->get('config_language_id')])) {
				$this->data['heading_title'] = $thislist['title_list_latest'][$this->config->get('config_language_id')];
			} else {
				$this->data['heading_title'] = "";
			}
			$this->data['text_comments'] = $this->language->get('text_comments');
			$this->data['text_viewed']   = $this->language->get('text_viewed');
			if (isset($this->data['settings']['cached']) && $this->data['settings']['cached']) {
				$row = $this->cache->get('blog.product.reviews.' . (int) $this->config->get('config_language_id') . '.' . (int) $this->config->get('config_store_id') . '.' . (int) $this->data['customer_group_id'] . '.' . $hash);
			} else {
				$row = array();
			}
			if (empty($row)) {
				$this->data['fields'] = $this->model_record_fields->getFieldsDBlang();
				$comments             = $this->model_record_comment->getCommentsByBlogsIN($thislist, 3);
				if (isset($comments) && count($comments) > 0) {
					foreach ($comments as $comment) {
						if ($comment['type'] == 'blogs') {
							$this->load->model('record/path');
							$blog_href                   = $this->model_record_path->pathbyblog($comment['blog_id']);
							$blog_link                   = $this->url->link('record/blog', 'blog_id=' . $blog_href['path']);
							$record_link                 = $this->url->link('record/record', 'record_id=' . $comment['record_id']);
							$rate                        = $this->model_record_comment->getRatesByCommentId($comment['comment_id']);
							$this->data['text_category'] = $this->language->get('text_blog');
							$this->data['text_record']   = $this->language->get('text_record');
							$comment['mark']             = 'record_id';
						}
						if ($comment['type'] == 'categories') {
							$comment['mark'] = 'product_id';
							if (isset($comment['review_id']))
								$comment['comment_id'] = $comment['review_id'];
							else
								$comment['comment_id'] = '';
							if (isset($comment['commentid']))
								$comment['comment_id'] = $comment['commentid'];
							else
								$comment['comment_id'] = '';
							if (isset($comment['product_id'])) {
								$comment['record_id'] = $comment['product_id'];
							} else {
								if (!isset($comment['record_id']))
									$comment['record_id'] = '';
							}
						}
						if ($comment['type'] == 'categories') {
							$this->load->model('record/path');
							$blog_href                   = $this->model_record_path->pathbycategory($comment['blog_id']);
							$blog_link                   = $this->url->link('product/category', 'path=' . $blog_href['path']);
							$record_link                 = $this->url->link('product/product', 'product_id=' . $comment['record_id'] . "&path=" . $blog_href['path']);
							$rate                        = array();
							$this->data['text_category'] = $this->language->get('text_category');
							$this->data['text_record']   = $this->language->get('text_product');
						}
						$comment_total         = $comment['total'];
						$rate_count            = 0;
						$rate_delta            = 0;
						$rate_delta_blog_plus  = 0;
						$rate_delta_blog_minus = 0;
						foreach ($rate as $r) {
							$rate_count            = $r['rate_count'];
							$rate_delta            = $r['rate_delta'];
							$rate_delta_blog_plus  = $r['rate_delta_blog_plus'];
							$rate_delta_blog_minus = $r['rate_delta_blog_minus'];
						}
						$this->load->model('tool/image');
						if ($comment) {
							if ($comment['image']) {
								if (isset($this->data['settings']['image']['width']) && isset($this->data['settings']['image']['height']) && $this->data['settings']['image']['width'] != "" && $this->data['settings']['image']['height'] != "") {
									$thumb = $this->model_tool_image->resizeme($comment['image'], $this->data['settings']['image']['width'], $this->data['settings']['image']['height'], $this->data['settings']['image_adaptive_status']);
								} else {
									$thumb = $this->model_tool_image->resizeme($comment['image'], 150, 150, $this->data['settings']['image_adaptive_status']);
								}
							} else {
								$thumb = '';
							}
						} else {
							$thumb = '';
						}
						if (!isset($comment['text'])) {
							$comment['text'] = '';
						}
						$text = '';
						if ($comment['text'] != '') {
							$flag_desc = 'none';
							if ($thislist['desc_symbols'] != '') {
								$amount    = $thislist['desc_symbols'];
								$flag_desc = 'symbols';
							}
							if ($thislist['desc_words'] != '') {
								$amount    = $thislist['desc_words'];
								$flag_desc = 'words';
							}
							if ($thislist['desc_pred'] != '') {
								$amount    = $thislist['desc_pred'];
								$flag_desc = 'pred';
							}
							switch ($flag_desc) {
								case 'symbols':
									$limit   = $amount;
									$source  = strip_tags(html_entity_decode($comment['text'], ENT_QUOTES, 'UTF-8'));
									$counter = 0;
									$matches = Array();
									utf8_preg_match_all('/(?:\[.*\].*\[\/.*\])|(.)/Usiu', $source, $matches, PREG_OFFSET_CAPTURE);
									foreach ($matches[1] as $num => $val) {
										if (is_array($val)) {
											$counter++;
											if ($counter == $limit) {
												$source = utf8_substr_replace($source, '', $val[1] + 1);
												break;
											}
										}
									}
									$text = $source;
									break;
								case 'words':
									$limit   = $amount;
									$source  = strip_tags(html_entity_decode($comment['text'], ENT_QUOTES, 'UTF-8'));
									$counter = 0;
									$matches = Array();
									utf8_preg_match_all('/(?:\[.*\].*\[\/.*\])|(\x20)/Usiu', $source, $matches, PREG_OFFSET_CAPTURE);
									foreach ($matches[1] as $num => $val) {
										if (is_array($val)) {
											$counter++;
											if ($counter == $limit) {
												$source = utf8_substr_replace($source, '', $val[1] + 1);
												break;
											}
										}
									}
									$text = $source;
									break;
								case 'pred':
									$limit   = $amount;
									$source  = strip_tags(html_entity_decode($comment['text'], ENT_QUOTES, 'UTF-8'));
									$counter = 0;
									$matches = Array();
									utf8_preg_match_all('/(?:\[.*\].*\[\/.*\])|(\.)/Usiu', $source, $matches, PREG_OFFSET_CAPTURE);
									foreach ($matches[1] as $num => $val) {
										if (is_array($val)) {
											$counter++;
											if ($counter == $limit) {
												$source = utf8_substr_replace($source, '', $val[1] + 1);
												break;
											}
										}
									}
									$text = $source;
									break;
								case 'none':
									$text = html_entity_decode($comment['text'], ENT_QUOTES, 'UTF-8');
									break;
							}
						}
						if ($text == '') {
							$text = html_entity_decode($comment['text'], ENT_QUOTES, 'UTF-8');
						}
						if (isset($this->data['settings_general']['format_date'])) {
						} else {
							$this->data['settings_general']['format_date'] = $this->language->get('text_date');
						}
						if (isset($this->data['settings_general']['format_hours'])) {
						} else {
							$this->data['settings_general']['format_hours'] = $this->language->get('text_hours');
						}
						if (isset($this->data['settings_general']['format_time']) && $this->data['settings_general']['format_time'] && date($this->data['settings_general']['format_date']) == date($this->data['settings_general']['format_date'], strtotime($comment['date_added']))) {
							$date_str = $this->language->get('text_today');
						} else {
							$date_str = rdate($this, $this->data['settings_general']['format_date'], strtotime($comment['date_added']));
						}
						$date_available = $date_str . (rdate($this, $this->data['settings_general']['format_hours'], strtotime($comment['date_added'])));
						require_once(DIR_SYSTEM . 'library/bbcode/Parser.php');
						$text  = nl2br(strip_tags($text));
						$width = '160px';
						require_once(DIR_SYSTEM . 'library/bbcode/Parser.php');
						$parser = new JBBCode\Parser();
						$parser->addBBCode("quote", '<div class="quote">{param}</div>', true, true);
						$parser->addBBCode("quote", '<div class="quote">{param}</div>', false, false);
						$parser->addBBCode("size", '<span style="font-size:{option}%;">{param}</span>', true, true);
						$parser->addBBCode("code", '<pre class="code">{param}</pre>', false, false, 1);
						$parser->addBBCode("video", '<div style="overflow:hidden; "><iframe width="300" height="200" src="https://www.youtube.com/embed/{param}" frameborder="0" allowfullscreen></iframe></div>', false, false, 1);
						$parser->addBBCode("img", '<a href="{param}" class="imagebox" rel="imagebox" style="overflow: hidden;"><img class="bbimage" alt="" width="' . $width . '" src="{param}"></a>');
						$parser->addCodeDefinitionSet(new JBBCode\DefaultCodeDefinitionSet());
						$parser->parse($text);
						$text       = $parser->getAsHtml();
						$data       = Array(
							'review_id' => $comment['comment_id'],
							'mark' => $comment['mark']
						);
						$fields     = $this->model_record_fields->getFields($data);
						$fields_new = Array();
						foreach ($fields as $num => $field) {
							foreach ($field as $pole => $val) {
								if ($pole != 'review_id' && $pole != 'mark') {
									if ($val != '') {
										$fields_new[$pole]['field_value'] = $val;
										$fields_new[$pole]['value']       = $val;
										foreach ($this->data['fields'] as $n => $value) {
											if ($value['field_name'] == $pole) {
												$fields_new[$pole]['field_description'] = '';
												if ($value['field_description'][(int) $this->config->get('config_language_id')] != '') {
													$fields_new[$pole]['field_description'] = $value['field_description'];
													$fields_new[$pole]['field_name']        = $value['field_name'];
													$fields_new[$pole]['field']             = $value['field'];
													$fields_new[$pole]['field_image']       = $value['field_image'];
													$fields_new[$pole]['field_type']        = $value['field_type'];
													$fields_new[$pole]['field_order']       = $value['field_order'];
													$fields_new[$pole]['field_status']      = $value['field_status'];
													break;
												}
											}
										}
									}
								}
							}
						}
						if (isset($fields_new) && !empty($fields_new)) {
							usort($fields_new, 'comp_field');
						}
						$comment['info'] = '';
						if ($this->data['settings_widget']['buyer_status'] || $this->data['settings_widget']['avatar_status'] || $this->data['settings_widget']['karma_status'] || $this->data['settings_widget']['manufacturer_status']) {
							if ($comment['type'] == 'blogs') {
								$table = 'record';
							}
							if ($comment['type'] == 'categories') {
								$table = 'product';
							}
							if (isset($this->data['settings_widget']['admin_name']) && $this->data['settings_widget']['admin_name'] != '') {
								$this->data['admin_name'] = array_flip(explode(";", trim($this->data['settings_widget']['admin_name'])));
							} else {
								$this->data['admin_name'] = array();
							}
							if (isset($this->data['settings_widget']['avatar_width']) && $this->data['settings_widget']['avatar_width'] != '') {
								$width = $this->data['settings_widget']['avatar_width'];
							} else {
								if (isset($this->data['settings_general']['avatar_width']) && $this->data['settings_general']['avatar_width'] != '') {
									$width = $this->data['settings_general']['avatar_width'];
								} else {
									$width = '100';
								}
							}
							if (isset($this->data['settings_widget']['avatar_height']) && $this->data['settings_widget']['avatar_height'] != '') {
								$height = $this->data['settings_widget']['avatar_height'];
							} else {
								if (isset($this->data['settings_general']['avatar_height']) && $this->data['settings_general']['avatar_height'] != '') {
									$height = $this->data['settings_general']['avatar_height'];
								} else {
									$height = '100';
								}
							}
							$this->data['avatar_width']  = $width;
							$this->data['avatar_height'] = $height;
							$comment['info']             = $this->getAvatarComment($comment, $table, $this->data);
							if ($comment['info']['avatar'] == '') {
								if (isset($this->data['settings_general']['avatar_admin']) && $this->data['settings_general']['avatar_admin'] != '' && isset($this->data['admin_name'][trim($comment['author'])])) {
									$comment['info']['avatar'] = $this->model_tool_image->resizeme($this->data['settings_general']['avatar_admin'], $this->data['avatar_width'], $this->data['avatar_height'], $this->data['settings']['image_adaptive_status']);
								} else {
									if (isset($this->data['settings_general']['avatar_buyproduct']) && $this->data['settings_general']['avatar_buyproduct'] != '' && isset($comment['info']['buyproduct']) && $comment['info']['buyproduct'] != '') {
										$comment['info']['avatar'] = $this->model_tool_image->resizeme($this->data['settings_general']['avatar_buyproduct'], $this->data['avatar_width'], $this->data['avatar_height'], $this->data['settings']['image_adaptive_status']);
									} else {
										if (isset($this->data['settings_general']['avatar_buy']) && $this->data['settings_general']['avatar_buy'] != '' && isset($comment['info']['buy']) && $comment['info']['buy'] != '') {
											$comment['info']['avatar'] = $this->model_tool_image->resizeme($this->data['settings_general']['avatar_buy'], $this->data['avatar_width'], $this->data['avatar_height'], $this->data['settings']['image_adaptive_status']);
										} else {
											if (isset($this->data['settings_general']['avatar_reg']) && $this->data['settings_general']['avatar_reg'] != '' && isset($comment['info']['customer_id']) && $comment['info']['customer_id'] > 0) {
												$comment['info']['avatar'] = $this->model_tool_image->resizeme($this->data['settings_general']['avatar_reg'], $this->data['avatar_width'], $this->data['avatar_height'], $this->data['settings']['image_adaptive_status']);
											} else {
												if (isset($this->data['settings_general']['avatar_default']) && $this->data['settings_general']['avatar_default'] != '') {
													$comment['info']['avatar'] = $this->model_tool_image->resizeme($this->data['settings_general']['avatar_default'], $this->data['avatar_width'], $this->data['avatar_height'], $this->data['settings']['image_adaptive_status']);
												} else {
													$comment['info']['avatar'] = $this->model_tool_image->resizeme($no_image, $this->data['avatar_width'], $this->data['avatar_height'], $this->data['settings']['image_adaptive_status']);
												}
											}
										}
									}
								}
							} else {
								$comment['info']['avatar'] = $this->model_tool_image->resizeme($comment['info']['avatar'], $this->data['avatar_width'], $this->data['avatar_height'], $this->data['settings']['image_adaptive_status']);
							}
							if (isset($comment['info']['manufacturer_id']) && $comment['info']['manufacturer_id'])
								$comment['info']['manufacturer_url'] = $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $comment['info']['manufacturer_id']);
						}
						if ($comment['rating_mark'] != '0') {
							$comment['rating'] = 0;
						}
						$this->data['comments'][] = array(
							'comment_id' => $comment['comment_id'],
							'fields' => $fields_new,
							'parent_id' => $comment['parent_id'],
							'blog_id' => $comment['blog_id'],
							'blog_name' => $comment['blog_name'],
							'blog_href' => $blog_link,
							'blog_path' => $blog_href['path'],
							'record_id' => $comment['record_id'],
							'cmswidget' => $comment['cmswidget'],
							'record_comments' => $comment['record_comments'],
							'record_viewed' => $comment['record_viewed'],
							'record_name' => $comment['record_name'],
							'record_rating' => (int) $comment['rating_avg'],
							'record_href' => $record_link,
							'customer_id' => $comment['customer_id'],
							'author' => $comment['author'],
							'text' => $text,
							'rating' => (int) $comment['rating'],
							'rate_count' => $rate_count,
							'rate_delta' => $rate_delta,
							'rate_delta_blog_plus' => $rate_delta_blog_plus,
							'rate_delta_blog_minus' => $rate_delta_blog_minus,
							'date' => $date_available,
							'image' => $comment['image'],
							'thumb' => $thumb,
							'text_category' => $this->data['text_category'],
							'text_record' => $this->data['text_record'],
							'info' => $comment['info']
						);
					}
					$this->data['comment_total'] = $comment_total;
				}
				$this->cache->set('blog.product.reviews.' . (int) $this->config->get('config_language_id') . '.' . (int) $this->config->get('config_store_id') . '.' . (int) $this->data['customer_group_id'] . '.' . $hash, $this->data);
			} else {
				$this->data = $row;
			}
			return $this->data;
		}
		private function getAvatarComment($data, $mark, $this_data)
		{
			$data['complete_status'] = $this_data['settings_general']['complete_status'];
			$avatar                  = $this->model_record_comment->getCommentByMark($data, $mark);
			return $avatar;
		}
		private function getRecordImages($record_id, $settings)
		{
			$images = array();
			if (!isset($settings['images']['width']) || $settings['images']['width'] == '') {
				$settings['images']['width'] = $this->config->get('config_image_additional_width');
			}
			if (!isset($settings['images']['height']) || $settings['images']['height'] == '') {
				$settings['images']['height'] = $this->config->get('config_image_additional_height');
			}
			$width  = $settings['images']['width'];
			$height = $settings['images']['height'];
			if (isset($settings['images_number']) && $settings['images_number'] != '' && (isset($settings['images_number_hide']) && !$settings['images_number_hide'])) {
				$images_number = $settings['images_number'];
			} else {
				$images_number = false;
			}
			if (isset($settings['images_adaptive_resize']) && $settings['images_adaptive_resize']) {
				$images_adaptive_resize = $settings['images_adaptive_resize'];
			} else {
				$images_adaptive_resize = false;
			}
			$results = $this->model_record_record->getRecordImages($record_id, $images_number);
			foreach ($results as $res) {
				$image_options = unserialize(base64_decode($res['options']));
				if (isset($image_options['title'][$this->config->get('config_language_id')])) {
					$image_title = html_entity_decode($image_options['title'][$this->config->get('config_language_id')], ENT_QUOTES, 'UTF-8');
					;
				} else {
					$image_title = getHttpImage($this) . $res['image'];
				}
				if (isset($image_options['description'][$this->config->get('config_language_id')])) {
					$image_description = html_entity_decode($image_options['description'][$this->config->get('config_language_id')], ENT_QUOTES, 'UTF-8');
					;
				} else {
					$image_description = "";
				}
				if (isset($image_options['url'][$this->config->get('config_language_id')])) {
					$image_url = $image_options['url'][$this->config->get('config_language_id')];
				} else {
					$image_url = "";
				}
				$images[] = array(
					'popup' => getHttpImage($this) . $res['image'],
					'title' => $image_title,
					'description' => $image_description,
					'url' => $image_url,
					'options' => $image_options,
					'thumb' => $this->model_tool_image->resizeme($res['image'], $width, $height, $images_adaptive_resize)
				);
			}
			return $images;
		}
		private function getBlogsRecords($thislist, $type = 'latest')
		{
			$this->language->load('seocms/blog');
			$this->load->model('record/record');
			$this->load->model('tool/image');
			$this->data['text_comments'] = $this->language->get('text_comments');
			$this->data['text_author']   = $this->language->get('text_author');
			$this->data['text_viewed']   = $this->language->get('text_viewed');
			if (isset($thislist['title_list_latest'][$this->config->get('config_language_id')]) && $thislist['title_list_latest'][$this->config->get('config_language_id')] != '') {
				$this->data['heading_title'] = $thislist['title_list_latest'][$this->config->get('config_language_id')];
			} else {
				$this->data['heading_title'] = '';
			}
			$page = 1;
			if (isset($thislist['number_per_widget']) && $thislist['number_per_widget'] != '') {
				$limit = $thislist['number_per_widget'];
			} else {
				$limit = 20;
			}
			if (isset($thislist['order']) && $thislist['order'] != '') {
				$sort = $thislist['order'];
			} else {
				$sort = 'latest';
			}
			if (isset($thislist['blogs'])) {
				$this->data['blogs'] = $thislist['blogs'];
			} else {
				$this->data['blogs'] = 0;
			}
			if (isset($thislist['related'])) {
				$this->data['related'] = $thislist['related'];
			} else {
				$this->data['related'] = Array();
			}
			if (isset($thislist['order_ad'])) {
				$this->data['order_ad'] = $thislist['order_ad'];
			} else {
				$this->data['order_ad'] = 'DESC';
			}
			if (!isset($thislist['images'])) {
				$thislist['images'] = array();
			}
			if (isset($thislist['pointer']) && $thislist['pointer'] != '') {
				$pointer = $thislist['pointer'];
			} else {
				$pointer = 'product_id';
			}
			$amount                = 0;
			$order                 = $this->data['order_ad'];
			$this->data['records'] = array();
			if (isset($thislist['pagination']) && $thislist['pagination']) {
				$pagination_records = true;
			} else {
				$pagination_records = false;
			}
			if (isset($this->data['request_get']['wsort'])) {
				$sort = $this->data['request_get']['wsort'];
			}
			if (isset($this->data['request_get']['worder'])) {
				$order = $this->data['request_get']['worder'];
			}
			if (isset($this->data['request_get']['wlimit'])) {
				$limit = $this->data['request_get']['wlimit'];
			}
			if (!isset($thislist['paging']))
				$thislist['paging'] = 0;
			$data          = array(
				'settings' => $thislist,
				'filter_blogs' => $this->data['blogs'],
				'sort' => $sort,
				'order' => $order,
				'pagination' => $pagination_records,
				'start' => $thislist['paging'],
				'limit' => $limit
			);
			$results       = false;
			$total_records = false;
			if ($type == 'latest') {
				$results = $this->model_record_record->getBlogsRecords($data);
				foreach ($results as $nm => $res) {
					$total_records = $res['total'];
				}
			}
			$this->data['total'] = $total_records;



			if ($type == 'records') {
				if (isset($this->data['related']) && !empty($this->data['related'])) {
					foreach ($this->data['related'] as $related_id) {
						$results[$related_id] = $this->model_record_record->getRecord($related_id);
					}
				}
			}
			if ($type == 'related') {
				$pointer_id  = false;
				$blog_id     = false;
				$category_id = false;
				$related_id  = false;
				if (isset($this->request->get['product_id']) && $pointer == 'product_id') {
					$pointer_id = $this->request->get['product_id'];
				}
				if (isset($this->request->get['blog_id']) && $pointer == 'blog_id') {
					$parts = array();
					$path  = '';
					if (isset($this->request->get['blog_id'])) {
						$parts = explode('_', (string) $this->request->get['blog_id']);
					}
					foreach ($parts as $path_id) {
						if (!$path) {
							$pointer_id = (int) $path_id;
						}
					}
				}
				if (isset($this->request->get['path']) && $pointer == 'category_id') {
					$parts = array();
					$path  = '';
					if (isset($this->request->get['path'])) {
						$parts = explode('_', (string) $this->request->get['path']);
					}
					foreach ($parts as $path_id) {
						if (!$path) {
							$pointer_id = (int) $path_id;
						}
					}
				}
				if (isset($this->request->get['manufacturer_id']) && $pointer == 'manufacturer_id') {
					$parts = array();
					$path  = '';
					if (isset($this->request->get['manufacturer_id'])) {
						$parts = explode('_', (string) $this->request->get['manufacturer_id']);
					}
					foreach ($parts as $path_id) {
						if (!$path) {
							$pointer_id = (int) $path_id;
						}
					}
				}
				if ($pointer_id) {
					$this->data['related'] = $this->model_record_record->getRelatedRecords($pointer_id, $data, $pointer);
					foreach ($this->data['related'] as $nm => $res) {
						$total_records = $res['total'];
					}
					$this->data['total'] = $total_records;

					if (isset($this->data['related']) && !empty($this->data['related'])) {
						foreach ($this->data['related'] as $num => $related) {
							$related_id           = $related['record_id'];
							$results[$related_id] = $this->model_record_record->getRecord($related_id);
						}
					}
				}
			}



			if (isset($thislist['avatar_adaptive_resize']) && $thislist['avatar_adaptive_resize']) {
				$avatar_adaptive_resize = $thislist['avatar_adaptive_resize'];
			} else {
				$avatar_adaptive_resize = false;
			}
			if ($results) {
				$array_dir_image = str_split(DIR_IMAGE);
				$array_dir_app   = str_split(DIR_APPLICATION);
				$i               = 0;
				$dir_root        = '';
				while ($array_dir_image[$i] == $array_dir_app[$i]) {
					$dir_root .= $array_dir_image[$i];
					$i++;
				}
				$dir_image = str_replace($dir_root, '', DIR_IMAGE);
				if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
					$http_image = HTTPS_SERVER . $dir_image;
				} else {
					$http_image = HTTP_SERVER . $dir_image;
				}
				foreach ($results as $result) {
					if ($result != '' && isset($result['record_id'])) {
						if ($result['image']) {
							$dimensions = $thislist['avatar'];
							if ($dimensions['width'] == '')
								$dimensions['width'] = 200;
							if ($dimensions['height'] == '')
								$dimensions['height'] = 100;
							$image = $this->model_tool_image->resizeme($result['image'], $dimensions['width'], $dimensions['height'], $avatar_adaptive_resize);
							$popup = $http_image . $result['image'];
						} else {
							$image = false;
							$popup = false;
						}
						if ($this->config->get('config_comment_status')) {
							$rating = (int) $result['rating'];
						} else {
							$rating = false;
						}
						if (!isset($result['sdescription'])) {
							$result['sdescription'] = '';
						}
						$description = false;
						if (isset($result['sdescription']) && $result['sdescription'] != '') {
							$description = html_entity_decode($result['sdescription'], ENT_QUOTES, 'UTF-8');
						}
						if ($result['description'] && $result['sdescription'] == '') {
							$description = $this->trim_desc($result['description'], $thislist);
						}
						if ((isset($thislist['short_desc_trim_status']) && $thislist['short_desc_trim_status']) && isset($result['sdescription']) && $result['sdescription'] != '') {
							$description = $this->trim_desc($result['sdescription'], $thislist);
						}
						if (isset($this->data['settings_general']['format_date'])) {
						} else {
							$this->data['settings_general']['format_date'] = $this->language->get('text_date');
						}
						if (isset($this->data['settings_general']['format_hours'])) {
						} else {
							$this->data['settings_general']['format_hours'] = $this->language->get('text_hours');
						}
						if (isset($this->data['settings_general']['format_time']) && $this->data['settings_general']['format_time'] && date($this->data['settings_general']['format_date']) == date($this->data['settings_general']['format_date'], strtotime($result['date_available']))) {
							$date_str = $this->language->get('text_today');
						} else {
							$date_str = rdate($this, $this->data['settings_general']['format_date'], strtotime($result['date_available']));
						}
						$date_available = $date_str . (rdate($this, $this->data['settings_general']['format_hours'], strtotime($result['date_available'])));
						$this->load->model('record/path');
						$this->load->model('record/blog');
						$blog_href = $this->model_record_path->pathbyrecord($result['record_id']);
						if (strpos($blog_href['path'], '_') !== false) {
							$abid    = explode('_', $blog_href['path']);
							$blog_id = $abid[count($abid) - 1];
						} else {
							$blog_id = (int) $blog_href['path'];
						}
						$blog_id                   = (int) $blog_id;
						$blog_info                 = $this->model_record_blog->getBlog($blog_id, false);
						$this->data['blog_design'] = Array();
						if ($blog_info) {
							if ($blog_info['design'] != '') {
								$this->data['blog_design'] = unserialize($blog_info['design']);
							} else {
								$this->data['blog_design'] = Array();
							}
						}
						if (isset($this->request->get['record_id']) && $result['record_id'] == $this->request->get['record_id']) {
							$active = true;
						} else {
							$active = false;
						}
						$attribute_groups = array();
						if (isset($thislist['attribute_groups_status']) && $thislist['attribute_groups_status']) {
							$attribute_groups = $this->model_record_record->getRecordAttributes($result['record_id']);
						}
						$record_images = array();
						if (isset($thislist['images_view']) && $thislist['images_view']) {
							$record_images = $this->getRecordImages($result['record_id'], $thislist);
						}
						$this->data['records'][] = array(
							'record_id' => $result['record_id'],
							'thumb' => $image,
							'popup' => $popup,
							'images' => $record_images,
							'attribute_groups' => $attribute_groups,
							'name' => $result['name'],
							'author' => $result['author'],
							'customer_id' => $result['customer_id'],
							'description' => $description,
							'rating' => $result['rating'],
							'date_added' => $result['date_added'],
							'date_available' => $date_available,
							'date_end' => $result['date_end'],
							'viewed' => $result['viewed'],
							'comments' => (int) $result['comments'],
							'href' => $this->url->link('record/record', 'record_id=' . $result['record_id']),
							'blog_id' => $blog_id,
							'blog_href' => $this->url->link('record/blog', 'blog_id=' . $blog_href['path']),
							'blog_name' => $blog_href['name'],
							'category' => $blog_info,
							'settings' => $thislist,
							'settings_blog' => $this->data['blog_design'],
							'active' => $active,
							'settings_comment' => unserialize($result['comment'])
						);
					}
				}
			}
			return $this->data;
		}
		private function trim_desc($desc, $thislist)
		{
			$flag_desc                   = 'pred';
			$this->data['blog_num_desc'] = $thislist['desc_symbols'];
			if ($this->data['blog_num_desc'] == '') {
				$this->data['blog_num_desc'] = 50;
			} else {
				$amount    = $this->data['blog_num_desc'];
				$flag_desc = 'symbols';
			}
			$this->data['blog_num_desc_words'] = $thislist['desc_words'];
			if ($this->data['blog_num_desc_words'] == '') {
				$this->data['blog_num_desc_words'] = 10;
			} else {
				$amount    = $this->data['blog_num_desc_words'];
				$flag_desc = 'words';
			}
			$this->data['blog_num_desc_pred'] = $thislist['desc_pred'];
			if ($this->data['blog_num_desc_pred'] == '') {
				$this->data['blog_num_desc_pred'] = 3;
			} else {
				$amount    = $this->data['blog_num_desc_pred'];
				$flag_desc = 'pred';
			}
			if (!isset($amount))
				$amount = 0;
			switch ($flag_desc) {
				case 'symbols':
					$pattern = ('/((.*?)\S){0,' . $amount . '}/isu');
					preg_match_all($pattern, strip_tags(html_entity_decode($desc, ENT_QUOTES, 'UTF-8')), $out);
					$description = $out[0][0];
					break;
				case 'words':
					$pattern = ('/((.*?)\x20){0,' . $amount . '}/isu');
					preg_match_all($pattern, strip_tags(html_entity_decode($desc, ENT_QUOTES, 'UTF-8')), $out);
					$description = $out[0][0];
					break;
				case 'pred':
					$pattern = ('/((.*?)\.){0,' . $amount . '}/isu');
					preg_match_all($pattern, strip_tags(html_entity_decode($desc, ENT_QUOTES, 'UTF-8')), $out);
					$description = $out[0][0];
					break;
			}
			return $description;
		}
		private function getMarkReviews($thislist, $type = 'treecomments', $mark = 'product_id')
		{
			if ($thislist['status']) {
				$this->language->load('seocms/blog');
				if (isset($thislist['langfile']) && $thislist['langfile'] != '') {
					$this->language->load($thislist['langfile']);
				}
				$this->load->model('record/treecomments');
				$this->data['text_comments'] = $this->language->get('text_comments');
				$this->data['text_viewed']   = $this->language->get('text_viewed');
				if (isset($thislist) && !empty($thislist)) {
					$this->data['thislist'] = $thislist;
				} else {
					$this->data['thislist'] = Array();
				}
				if (isset($thislist['title_list_latest'][$this->config->get('config_language_id')]) && $thislist['title_list_latest'][$this->config->get('config_language_id')] != '') {
					$this->data['heading_title'] = $thislist['title_list_latest'][$this->config->get('config_language_id')];
				} else {
					$this->data['heading_title'] = '';
				}
				if (isset($thislist[$mark])) {
					$this->data[$mark] = $thislist[$mark];
				} else {
					$this->data[$mark] = false;
				}
				if (isset($thislist['number_comments']) && $thislist['number_comments'] != '') {
					$limit = $thislist['number_comments'];
				} else {
					$limit = 10;
				}
				if (isset($thislist['status_now']) && $thislist['status_now'] != '') {
					$this->data['status_now'] = $thislist['status_now'];
				} else {
					$this->data['status_now'] = 0;
				}
				if (isset($thislist['status_reg']) && $thislist['status_reg'] != '') {
					$this->data['status_reg'] = $thislist['status_reg'];
				} else {
					$this->data['status_reg'] = 0;
				}
				if (isset($thislist['rating']) && $thislist['rating'] != '') {
					$this->data['rating'] = $thislist['rating'];
				} else {
					$this->data['rating'] = 1;
				}
				if (isset($thislist['rating_num']) && $thislist['rating_num'] != '') {
					$this->data['rating_num'] = $thislist['rating_num'];
				} else {
					$this->data['rating_num'] = '';
				}
				if (isset($thislist['order_ad'])) {
					$this->data['order_ad'] = $thislist['order_ad'];
				} else {
					$this->data['order_ad'] = 'DESC';
				}
				$this->data['comment_status'] = true;
				if ($this->customer->isLogged()) {
					$this->data['customer_group_id'] = $this->customer_group_id;
					$this->data['captcha_status']    = false;
				} else {
					$this->data['customer_group_id'] = $this->config->get('config_customer_group_id');
					$this->data['captcha_status']    = true;
				}
				if (isset($thislist['status_language'])) {
					if ($thislist['status_language']) {
						$this->registry->set("status_language", true);
					} else {
						$this->registry->set("status_language", false);
					}
				} else {
					$this->registry->set("status_language", true);
				}
				if (!isset($this->data['settings_general']['complete_status']))
					$this->data['settings_general']['complete_status'] = false;
				$order   = $this->data['order_ad'];
				$data    = array(
					'status' => $this->data['settings_general']['complete_status'],
					$mark => $this->data[$mark],
					'order' => $order,
					'start' => 0,
					'limit' => $limit
				);
				$results = false;
				if ($type == 'treecomments' || $type == 'forms') {
					$results                     = $this->model_record_treecomments->getCommentsByMarkId($data, $mark, $thislist);
					$this->data['comment_total'] = count($results);
				}
				if ($results) {
					foreach ($results as $result) {
						if ($result != '') {
							if ($mark == "record_id") {
								$result['review_id'] = $result['comment_id'];
							}
							$this->data['reviews'][] = array(
								$mark => $result[$mark],
								'review_id' => $result['review_id'],
								'parent_id' => $result['parent_id'],
								'date_added' => $result['date_added']
							);
						}
					}
				}
				return $this->data;
			}
		}
		public function getThemeStars($file)
		{
			$themefile = false;
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/' . $file)) {
				$themefile = $this->config->get('config_template');
			} else {
				if (file_exists(DIR_TEMPLATE . 'default/' . $file)) {
					$themefile = 'default';
				}
			}
			return $themefile;
		}
	}
}
