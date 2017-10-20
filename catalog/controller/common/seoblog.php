<?php
/* All rights reserved belong to the module, the module developers http://opencartadmin.com */
// http://opencartadmin.com © 2011-2016 All Rights Reserved
// Distribution, without the author's consent is prohibited
// Commercial license
if (!class_exists('ControllerCommonSeoBlog')) {
	class ControllerCommonSeoBlog extends Controller
	{
		protected $data;
		private $blog_design = Array();
		private $blog_id_current;
		private $cache_pathbyblog_current;
		private $cache_data = null;
		private $langcode_all;
		private $languages_all;
		private $flag_language = false;
		private $comp_url = false;
		private $validflag = false;
		private $url_search = '';
		private $config_url = '';
		private $flag_router;

		private $class_name = 'ControllerCommonSeoBlog';

		public function __construct($registry)
		{
			parent::__construct($registry);

			if (!$this->config->get("blog_work")) {
				$this->config->set("blog_work", true);
				$is_blog_work = false;
			} else {
				$is_blog_work = true;
			}
			if ((isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) || $this->config->get('config_secure')) {
				$this->config_url = substr($this->config->get('config_ssl'), 0, $this->strpos_offset('/', $this->config->get('config_ssl'), 3) + 1);
			} else {
				$this->config_url = substr($this->config->get('config_url'), 0, $this->strpos_offset('/', $this->config->get('config_url'), 3) + 1);
			}
			$url_data_search  = parse_url(str_replace('&amp;', '&', $this->url->link('product/search')));
			$this->url_search = $url_data_search['path'];
			if ($this->config->get('ascp_settings') != '') {
				$this->data['settings_general'] = $this->config->get('ascp_settings');
			} else {
				$this->data['settings_general'] = Array();
			}
			$this->comp_url = $this->config->get('ascp_comp_url');
			if (!isset($this->session->data['language_old'])) {
				if (isset($this->session->data['language'])) {
					$this->session->data['language_old'] = $this->session->data['language'];
				}
			}
			$query_lang = $this->db->query("SELECT * FROM " . DB_PREFIX . "language WHERE status = '1' ");
			foreach ($query_lang->rows as $result_lang) {
				$this->languages_all[$result_lang['language_id']] = $result_lang;
				$this->langcode_all[$result_lang['code']]         = $result_lang;
			}
			if (isset($this->session->data['language_old']) && isset($this->session->data['language']) && $this->session->data['language_old'] != $this->session->data['language']) {
				$this->flag_language                 = true;
				$this->session->data['language_old'] = $this->session->data['language'];
				$this->registry->set('flag_language', true);
			}
			if ($this->registry->get('flag_language')) {
				if (isset($this->request->get['route']) && ($this->request->get['route'] == 'record/blog' || $this->request->get['route'] == 'record/record')) {
					$language_switch      = $this->langcode_all[$this->session->data['language']]['language_id'];
					$language_code_switch = $this->session->data['language'];
					$this->switchLanguage($language_switch, $language_code_switch);
					$this->validate();
				}
			}
			$this->cache_data = $this->cache->get('blog.seoblog.construct');
			if (!$this->cache_data) {
				$query            = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias_blog");
				$this->cache_data = array();
				$this->cache_data = $query->rows;
				foreach ($query->rows as $row) {
					if (isset($this->languages_all[$row['language_id']])) {
						$this->cache_data[$row['query']]                              = $row;
						$this->cache_data['keyword'][$row['keyword']]                 = $row;
						$this->cache_data['lang'][$row['query']][$row['language_id']] = $row;
					}
				}
				$this->cache->set('blog.seoblog.construct', $this->cache_data);
			}
			$this->cont('record/addrewrite');
			if (!$is_blog_work) {
				$this->config->set("blog_work", false);
			}
		}
		public function index()
		{
			$this->tags();
			if (isset($this->request->get['record_id']) && isset($this->request->get['blog_id'])) {
				unset($this->request->get['blog_id']);
			}


            /*
			if ($this->config->get('config_seo_url') && !class_exists('ControllerCommonSeoBlog')) {
				$this->url->addRewrite($this);
			}
			*/
			if ($this->registry->get('response_work')) {
				return;
			}
			if (isset($_GET['_route_'])) {
				$this->request->get['_route_'] = htmlspecialchars($_GET['_route_'], ENT_COMPAT, 'UTF-8');
			}
			if (isset($_GET['route'])) {
				$this->request->get['route'] = htmlspecialchars($_GET['route'], ENT_COMPAT, 'UTF-8');
			}
			$this->flag_router = 'none';
			$lang_all   = $this->languages_all;
			if (isset($this->request->get['record_id']) && $this->request->get['route'] == 'record/record' && !isset($_route_)) {
				$this->request->get['route'] = 'record/record';
				if (isset($this->request->get['_route_'])) {
					$_route_ = $this->request->get['_route_'];
					unset($this->request->get['_route_']);
				}
				if (isset($this->request->get['blog_id'])) {
					$blog_id   = explode('_', (string) $this->request->get['blog_id']);
					$query_tag = 'blog_id=' . (int) end($blog_id);
					if (isset($this->cache_data[$query_tag])) {
						$rows = $this->cache_data['lang'][$query_tag];
					} else {
						$rows = '';
					}
				} else {
					$rows = '';
				}
				if ($rows && !isset($_route_)) {
					foreach ($rows as $num => $val) {
						if (in_array($val['language_id'], $lang_all)) {
							unset($lang_all[$val['language_id']]);
						}
					}
					$l_a                  = end($lang_all);
					$language_switch      = $l_a['language_id'];
					$language_code_switch = $l_a['code'];
					if (!$this->registry->get('flag_language')) {
						$this->switchLanguage($language_switch, $language_code_switch);
					}
				} else {
					if (isset($_route_)) {
						$parts_route = explode('/', $_route_);
						foreach ($parts_route as $p_num => $p_val) {
							foreach ($this->cache_data as $c_num => $c_val) {
								if (isset($c_val['keyword']) && $p_val == $c_val['keyword']) {
									$pere = $c_val;
									break;
								}
							}
						}
						if (isset($pere['language_id']) && $pere['language_id'] != $this->config->get('config_language_id')) {
							$language_switch      = $pere['language_id'];
							$language_code_switch = $this->languages_all[$pere['language_id']]['code'];
							if (!$this->registry->get('flag_language')) {
								$this->switchLanguage($language_switch, $language_code_switch);
							}
						}
					}
				}
				if ($this->config->get('config_seo_url')) {
					$this->validate();
				}
				if (isset($this->request->get['_route_'])) {
					$this->request->get['_route_'] = $_route_;
				}
				// $this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . '/1.1 200 OK');
				return $this->flag_router = 'record';
			}
			if (isset($this->request->get['blog_id']) && $this->request->get['route'] == 'record/blog' && !isset($_route_)) {
				$this->request->get['route']   = 'record/blog';
				$this->request->get['blog_id'] = $this->getSEOPathByBlog($this->request->get['blog_id']);

				if (isset($this->request->get['_route_'])) {
					$_route_ = $this->request->get['_route_'];
					unset($this->request->get['_route_']);
				}
				$blog_id   = explode('_', (string) $this->request->get['blog_id']);
				$query_tag = 'blog_id=' . (int) end($blog_id);
				if (isset($this->cache_data[$query_tag])) {
					$rows = $this->cache_data['lang'][$query_tag];
				} else {
					$rows = '';
				}
				if ($rows && !isset($_route_)) {
					foreach ($rows as $num => $val) {
						if (isset($lang_all[$val['language_id']])) {
							unset($lang_all[$val['language_id']]);
						}
					}
					$l_a                  = end($lang_all);
					$language_switch      = $l_a['language_id'];
					$language_code_switch = $l_a['code'];
					if (!$this->registry->get('flag_language')) {
						$this->switchLanguage($language_switch, $language_code_switch);
					}
				} else {
					if (isset($_route_)) {
						$parts_route = explode('/', $_route_);
						foreach ($parts_route as $p_num => $p_val) {
							foreach ($this->cache_data as $c_num => $c_val) {
								if (isset($c_val['keyword']) && $p_val == $c_val['keyword']) {
									$pere = $c_val;
									break;
								}
							}
						}
					}
					if (isset($pere['language_id']) && $pere['language_id'] != $this->config->get('config_language_id')) {
						$language_switch      = $pere['language_id'];
						$language_code_switch = $this->languages_all[$pere['language_id']]['code'];
						if (!$this->registry->get('flag_language')) {
							$this->switchLanguage($language_switch, $language_code_switch);
						}
					}
				}
				$this->validate();
				if (isset($this->request->get['_route_'])) {
					$this->request->get['_route_'] = $_route_;
				}
				// $this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . '/1.1 200 OK');
				return $this->flag_router = 'blog';
			}
			if ($this->config->get('ascp_settings') != '') {
				$this->data['settings_general'] = $this->config->get('ascp_settings');
			} else {
				$this->data['settings_general'] = Array();
			}

			if (isset($this->request->get['_route_'])) {

				$this->load->model('design/bloglayout');
				$this->data['layouts'] = $this->model_design_bloglayout->getLayouts();
				$route                 = $this->request->get['_route_'];

				if ($this->config->get('asc_cnt_cnt') != 'fec00258b41bb6fb92a7feb8ccb0bed9') {
					$this->data['settings_general']['end_url_record'] = '.(c)';
				}

				$route     = trim($route, '/');
				$parts     = explode('/', $route);
				$parts_end = end($parts);
				if (strpos($parts_end, 'page-') !== false) {
					list($key, $value) = explode("-", $parts_end);
					$value = (int) $value;
					if ($value > 1) {
						$this->request->get[$key] = $value;
					}
					$title = $this->document->getTitle();
					if (isset($this->data['settings_general']['langmark_widget_status']) && !$this->data['settings_general']['langmark_widget_status']) {
						$this->document->setTitle($title . " " . $key . " " . $value);
					}
					$this->config->set('blog_page', $value);
					unset($parts[count($parts) - 1]);
				}
				reset($parts);

                $parts_end = end($parts);
                $route = implode('/', $parts);
                $parts_end_ext = substr(strrchr($parts_end, '.'), 0);

                $devider = '';
				if (isset($this->data['settings_general']['end_url_record']) && $this->data['settings_general']['end_url_record'] != '') {
					$devider = $this->data['settings_general']['end_url_record'];

					if ($parts_end_ext == $devider && !isset($this->cache_data['keyword'][$this->db->escape($parts_end)])) {
                        $end_new = substr_replace($parts_end, '', strrpos($parts_end, $devider), strlen($parts_end));
					    array_pop($parts) xor array_push($parts, $end_new);
					}
				}

                $devider = '';
				if (isset($this->request->get['record_id']) && $this->request->get['record_id'] != '') {
					array_push($parts, 'record_id=' . $this->request->get['record_id']);
				}
				if (isset($this->request->get['blog_id']) && $this->request->get['blog_id'] != '') {
					array_push($parts, 'blog_id=' . $this->request->get['blog_id']);
				}

				foreach ($parts as $part) {

					if (isset($this->cache_data['keyword'][$this->db->escape($part.$devider)])) {
						$query_data[0] = $this->cache_data['keyword'][$this->db->escape($part.$devider)];
						$num_rows      = 1;
					} else {
						$query_data = array();
						$num_rows   = 0;
					}

                    $url_query = explode('=', $part);

					if ($num_rows == 0 && ($url_query[0] == 'blog_id' || $url_query[0] == 'record_id') ) {
						$num_rows               = 1;
						$query_data[0]['query'] = $url_query[0]. '=' . $url_query[1];
					}


					if ($num_rows > 0) {

						foreach ($query_data as $row) {
								if (isset($row['keyword']) && $row['keyword'] == $this->db->escape($part.$devider)) {
									if (($row['language_id'] != $this->config->get('config_language_id')) && $num_rows < 2) {
										$languages          = array();
										$detect             = '';
										$query_lang_data[0] = $this->languages_all[$row['language_id']];
										foreach ($query_lang_data as $result_lang) {
											$languages[$result_lang['code']] = $result_lang;
											$code                            = $result_lang['code'];
										}
										if (!$this->registry->get('flag_language')) {
											$this->switchLanguage($languages[$code]['language_id'], $code);
										}
										break;
									}
								}
						}

						$url = explode('=', $query_data[0]['query']);

						if (isset($url[0]) && $url[0] == 'record_id') {

								$layout                          = 0;
								foreach ($this->data['layouts'] as $num => $lay) {
									if (isset($lay['route']) && $lay['route'] == 'record/record')
										$layout = $lay['layout_id'];
								}
								$this->config->set("config_layout_id", $layout);

								$path = $this->getSEOPathByRecord($url[1]);
								$this->request->get['record_id'] = $url[1];

								$this->flag_router  = 'record';

						} else {
								if (isset($url[0]) && $url[0] == 'blog_id') {

									$layout     = 0;
									foreach ($this->data['layouts'] as $num => $lay) {
										if (isset($lay['route']) && $lay['route'] == 'record/blog')
											$layout = $lay['layout_id'];
									}
									$this->config->set("config_layout_id", $layout);

									$path                          = $this->getSEOPathByBlog($url[1]);
									$this->request->get['blog_id'] = $path;

	                               	$this->flag_router = 'blog';
								}
						}


	  					if (isset($url[0]) && $url[0] == 'route') {
							$this->request->get['route'] = $url[1];
						}

                    }

					if (isset($this->request->get['record_id']) &&  $this->request->get['record_id']!='') {
                    	unset($this->request->get['blog_id']);
					}

				}


 				$flg = false;
				if (isset($this->request->get['record_id'])) {
					//$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . '/1.1 200 OK');
					$this->request->get['route'] = 'record/record';
					$flg                         = true;
				} elseif (isset($this->request->get['blog_id'])) {
					//$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . '/1.1 200 OK');
					$this->request->get['route'] = 'record/blog';
					$flg                         = true;
				}

				if ($flg) {
					$_route_ = $this->request->get['_route_'];
					unset($this->request->get['_route_']);
					if ($this->config->get('config_seo_url')) {
						$this->validate();
					}
					$this->request->get['_route_'] = $_route_;
					if (isset($this->request->get['route'])) {
						$this->request->get['_route_'] = $this->request->get['route'];
					}

					return $this->flag_router;
				}
			}
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
						$language->load($code);
					} else {
						$language->load('default');
						$language->load($language_construct);
					}

				} else {
					$language->load($this->langcode_all[$code]['filename']);
				}
				$this->registry->set('language', $language);
				$this->session->data['language_old'] = $code;
			}
		}

		public function router()
		{
				if (!$this->registry->get("request_blog_router")) {
					$this->registry->set("request_blog_router", true);

					$this->flag_router = $this->index();

					if ($this->flag_router == 'search' || $this->flag_router == 'record' || $this->flag_router == 'blog') {
						if ($this->registry->get("fblogwork") != 1) {
							$this->registry->set("fblogwork", 1);
							if (SC_VERSION > 15) {
								$html = $this->load->controller('record/' . $this->flag_router);
							} else {
								$html = $this->getChild('record/' . $this->flag_router);
							}
							$this->registry->set("blog_output", true);
							$this->response->setOutput($html);
							$this->response->output();
							$this->registry->set("fblogwork", 0);
							exit();
						}
					}

				}
		}


		public function rewrite($link)
		{
			$link_original     = $link;
			$seocms_force_flag = false;
			$url_data          = parse_url(str_replace('&amp;', '&', $link));
			$url               = '';
			$data              = array();
			if (isset($url_data['query'])) {
				parse_str($url_data['query'], $data);
			}
			if (isset($data['route'])) {
				if ($data['route'] == "record/record" || $data['route'] == "record/blog") {
					$seocms_force_flag = true;
				} else {
					$seocms_force_flag = false;
				}
			}
			if ($seocms_force_flag == false) {
				if (isset($url_data['path']) && $url_data['path']) {
					if ($url_data['path'] != $this->url_search) {
						return $link_original;
					}
				} else {
					return $link_original;
				}
				if (isset($this->data['settings_general']['tags_widget_status']) && $this->data['settings_general']['tags_widget_status']) {
					$str_search = false;
					$token_tags = false;
					if (isset($data['tag']) || isset($data['search'])) {
						if (isset($data['tag'])) {
							$token_tags = 'tag';
						} else {
							$token_tags = 'search';
						}
						$str_search = trim($data[$token_tags]);
					} else {
					}
					if ($token_tags || $str_search) {
						$data['route']     = "record/record";
						$data['record_id'] = $this->getRecordbyTag($str_search);
						if ($data['record_id']) {
							$link = '';
							if (isset($url_data['path'])) {
								$url_data['path'] = '';
							}
							if (isset($url_data['query'])) {
								$url_data['query'] = '';
							}
						}
					}
				}
			}
			if ($this->config->get('config_seo_url') || (isset($this->data['settings_general']['tags_widget_status']) && $this->data['settings_general']['tags_widget_status'])) {
				if (isset($token_tags) && (isset($data['tag']) || isset($data['search']))) {
					unset($data[$token_tags]);
					if (isset($data['description'])) {
						unset($data['description']);
					}
				}
				if (!isset($url_data['scheme'])) {
					$url_data['scheme'] = 'http';
				}
				foreach ($data as $num => $name) {
					if ($name != 'record_id' && $name != '' && $name != 'route' && $name != 'blog_id') {
						if (is_array($name)) {
							unset($data[$num]);
						} else {
							if (is_array($data) && !empty($data) && isset($data[$name]))
								unset($data[$name]);
						}
					}
				}
				reset($data);
				if (isset($data['record_id'])) {
					$record_id = $data['record_id'];
					if ($this->config->get('config_seo_url')) {
						$path = $this->getSEOPathByRecord($record_id);
						if ($path != '') {
							$array_path = explode('_', $path);
							$category   = end($array_path);
						}
					}
					if ($path != '') {
						$data['create_path'] = $path;
					}
				}
				$flag_record   = false;
				$flag_category = false;
				$flag_unset    = false;
				foreach ($data as $key => $value) {
					if (isset($data['route'])) {
						if ($key == 'blog_id') {
							$path       = $this->getSEOPathByBlog($value);
							$array_path = explode('_', $path);
							$category   = end($array_path);
						}
						if ($key == 'create_path') {
							$categories = explode('_', $value);
							$new        = array_reverse($categories);
							foreach ($new as $new_category) {
								$query_tag = 'blog_id=' . (int) $new_category;
								$this->getSEOPathByBlog((int) $new_category);
								if (isset($this->cache_data['lang'][$query_tag][$this->config->get('config_language_id')])) {
									$row = $this->cache_data['lang'][$query_tag][$this->config->get('config_language_id')];
								} else {
									$row = '';
								}
								if ($row && isset($this->blog_design[$new_category]['end_url_category']) && $this->blog_design[$new_category]['end_url_category'] != '' && strrpos($row['keyword'], $this->blog_design[$new_category]['end_url_category'])) {
									$row['keyword'] = substr_replace($row['keyword'], '', strrpos($row['keyword'], $this->blog_design[$new_category]['end_url_category']), strlen($row['keyword']));
								}
								if ($row) {
									$url = '/' . $row['keyword'] . $url;
								}
							}
							unset($data[$key]);
						}
						if (($data['route'] == 'record/record' && $key == 'record_id')) {
							$flag_record = true;
							$query_tag   = $this->db->escape($key . '=' . (int) $value);
							if (isset($this->cache_data['lang'][$query_tag][$this->config->get('config_language_id')])) {
								$row = $this->cache_data['lang'][$query_tag][$this->config->get('config_language_id')];
							} else {
								$row = '';
							}
							if ($row) {
								$url = '/' . $row['keyword'];
								unset($data[$key]);
							}
						} elseif ($key == 'blog_id' && !$flag_record) {
							$flag_category = true;
							$categories    = explode('_', $path);
							if (count($categories) == 1) {
								$path       = $this->getSEOPathByBlog($categories[0]);
								$categories = explode('_', $path);
							}
							foreach ($categories as $category) {
								$query_tag = 'blog_id=' . (int) $category;
								$this->getSEOPathByBlog((int) $category);
								if (isset($this->cache_data['lang'][$query_tag][$this->config->get('config_language_id')])) {
									$row = $this->cache_data['lang'][$query_tag][$this->config->get('config_language_id')];
								} else {
									$row = '';
								}
								if ($row && isset($this->blog_design[$category]['end_url_category']) && $this->blog_design[$category]['end_url_category'] != '' && strrpos($row['keyword'], $this->blog_design[$category]['end_url_category'])) {
									$row['keyword'] = substr_replace($row['keyword'], '', strrpos($row['keyword'], $this->blog_design[$category]['end_url_category']), strlen($row['keyword']));
								}
								if ($row) {
									$url .= '/' . $row['keyword'];
									$flag_unset = true;
								} else {
									$flag_unset = false;
									break;
								}
							}
						}
						if ($flag_category && $flag_unset && $key == 'blog_id') {
							unset($data[$key]);
						}
						if ($flag_record && $key == 'blog_id') {
							unset($data[$key]);
						} else {
							if ($url == '') {
								$query_tag = $this->db->escape($key . '=' . (int) $value);
								if (isset($this->cache_data['lang'][$query_tag][$this->config->get('config_language_id')])) {
									$row = $this->cache_data['lang'][$query_tag][$this->config->get('config_language_id')];
								} else {
									$row = '';
								}
								if ($row) {
									$url .= '/' . $row['keyword'];
								}
							}
						}
					}
				}
				unset($data['create_path']);
				if (!isset($category) || $category == '') {
					$blog_id = $this->blog_id_current;
					$this->getSEOPathByBlog((int) $blog_id);
				} else {
					$blog_id = $category;
				}
				if ($url) {
					unset($data['route']);
					if ($this->config->get('ascp_settings') != '') {
						$this->data['settings_general'] = $this->config->get('ascp_settings');
					} else {
						$this->data['settings_general'] = Array();
					}
					if ($this->config->get('asc_cnt_cnt') != 'fec00258b41bb6fb92a7feb8ccb0bed9') {
						$this->data['settings_general']['end_url_record'] = '.(c)';
					}
					if (isset($this->blog_design[$blog_id]['blog_devider']) && $this->blog_design[$blog_id]['blog_devider'] == '1') {
						$devider = "/";
					} else {
						$devider = "";
					}
					$array_url_devider = explode('/', $url);
					$url_devider       = end($array_url_devider);
					if (strpos($url_devider, '.') !== false) {
						$devider = "";
					} else {
						if (!$flag_record) {
							if (isset($this->blog_design[$blog_id]['end_url_category']) && $this->blog_design[$blog_id]['end_url_category'] != '') {
								$devider = $this->blog_design[$blog_id]['end_url_category'];
								/*
								if (isset($this->data['settings_general']['end_url_record']) && $this->data['settings_general']['end_url_record'] != '') {
									$devider_setting = $this->data['settings_general']['end_url_record'];
								} else {
									$devider_setting = '';
								}
								if ($devider_setting == '.' || $devider_setting == ' ') {
									$devider = '';
								}
								*/
							}
						} else {
							if (isset($this->data['settings_general']['end_url_record']) && $this->data['settings_general']['end_url_record'] != '') {
								$devider = $this->data['settings_general']['end_url_record'];
								if ($devider == '.' || $devider == ' ') {
									$devider = '';
								}
							}
						}
					}
					$query  = '';
					$paging = '';
					if ($data) {
						foreach ($data as $key => $value) {
							if ($key != 'page') {
								$query .= '&' . $key . '=' . $value;
							} else {
								if ($devider != '/')
									$paging = "/" . $key . "-" . $value;
								else
									$paging = $key . "-" . $value;
							}
						}
						if ($query) {
							$query = '?' . trim($query, '&');
						}
					}
					$link = $url_data['scheme'] . '://' . $url_data['host'] . (isset($url_data['port']) ? ':' . $url_data['port'] : '') . str_replace('/index.php', '', $url_data['path']) . $url . $devider . $paging . $query;
					return $link;
				} else {
					return $link;
				}
			} else {
				return $link;
			}
		}
		private function tags()
		{
			$url_data = parse_url(str_replace('&amp;', '&', $this->request->server['REQUEST_URI']));
			if ($url_data['path']) {
				if ($url_data['path'] != $this->url_search) {
					return;
				}
			} else {
				return;
			}
			if (isset($this->data['settings_general']['tags_widget_status']) && $this->data['settings_general']['tags_widget_status']) {
				if (isset($this->request->get['tag']) || isset($this->request->get['search'])) {
					if (isset($this->request->get['tag'])) {
						$token_tags = 'tag';
					}
					if (isset($this->request->get['search'])) {
						$token_tags = 'search';
					}
					$str_search = trim($this->request->get[$token_tags]);
				} else {
					$str_search = ltrim($this->request->server['REQUEST_URI'], '/');
					$token_tags = false;
				}
				$record_id = $this->getRecordbyTag($str_search);
				if ($record_id) {
					$this->request->get['record_id'] = $record_id;
					$this->request->get['route']     = $_GET['route'] = 'record/record';
					unset($this->request->get['_route_']);
					if (isset($this->request->get[$token_tags]) && $token_tags) {
						unset($this->request->get[$token_tags]);
					}
				}
			}
		}
		private function getRecordbyTag($tag)
		{
			$record_id = false;
			if ($tag != '') {
				$tags = array();
				$tags = $this->cache->get('blog.seoblog.tags');
				if (!isset($tags[$tag])) {
					$sql   = "SELECT rd.record_id
				FROM " . DB_PREFIX . "record_description rd
				WHERE
				rd.tag_product = '" . $this->db->escape($tag) . "'
				AND
				rd.language_id = '" . $this->config->get('config_language_id') . "'
				LIMIT 1";
					$query = $this->db->query($sql);
					if (isset($query->row['record_id'])) {
						$record_id  = $query->row['record_id'];
						$tags[$tag] = $record_id;
						$this->cache->set('blog.seoblog.tags', $tags);
					}
				} else {
					$record_id = $tags[$tag];
				}
			}
			return $record_id;
		}
		private function getSEOPathByRecord($record_id)
		{
			if (!$this->config->get("blog_work")) {
				$this->config->set("blog_work", true);
				$is_blog_work = false;
			} else {
				$is_blog_work = true;
			}
			if (utf8_strpos($record_id, '_') !== false) {
				$abid      = explode('_', $record_id);
				$record_id = $abid[count($abid) - 1];
			}
			$record_id = (int) $record_id;
			if ($record_id < 1) {
				if (!$is_blog_work) {
					$this->config->set("blog_work", false);
				}
				return false;
			}
			$path        = $this->cache->get('blog.seoblog.record.seopath');
			$blog_design = $this->cache->get('blog.seoblog.record.blog_design');
			if (!is_array($path)) {
				$path = array();
			}
			if (!is_array($blog_design)) {
				$blog_design = array();
			}
			if (isset($path[$record_id])) {
				$a_blog_id             = explode('_', $path[$record_id]);
				$this->blog_id_current = $blog_id = end($a_blog_id);
			}
			if (!isset($path[$record_id]) || !isset($blog_design[$record_id])) {
				$sql              = "SELECT r2b.blog_id as blog_id,
			IF(r.blog_main=r2b.blog_id, 1, 0) as blog_main
			FROM " . DB_PREFIX . "record_to_blog r2b
			LEFT JOIN " . DB_PREFIX . "record r  ON (r.record_id = r2b.record_id)
			WHERE r2b.record_id = '" . (int) $record_id . "' ORDER BY blog_main DESC LIMIT 1";
				$query            = $this->db->query($sql);
				$path[$record_id] = $this->getSEOPathByBlog($query->num_rows ? (int) $query->row['blog_id'] : 0);
				if (utf8_strpos($path[$record_id], '_') !== false) {
					$abid    = explode('_', $path[$record_id]);
					$blog_id = (int) $abid[count($abid) - 1];
				} else {
					$blog_id = (int) $path[$record_id];
				}
				$this->blog_id_current = $blog_id = (int) $blog_id;
				$this->load->model('record/blog');
				$blog_info = $this->model_record_blog->getBlog($blog_id, false);
				if (isset($blog_info['design']) && $blog_info['design'] != '') {
					$this->blog_design[$blog_id] = unserialize($blog_info['design']);
				} else {
					$this->blog_design[$blog_id] = Array();
				}
				if (isset($blog_info['design']) && $blog_info['design'] != '') {
					$blog_design[$record_id] = $blog_info['design'];
				} else {
					$blog_design[$record_id] = array();
				}
				$this->cache->set('blog.seoblog.record.blog_design', $blog_design);
				$this->cache->set('blog.seoblog.record.seopath', $path);
			} else {
				if (isset($blog_design[$record_id]) && is_string($blog_design[$record_id])) {
					$this->blog_design[$blog_id] = unserialize($blog_design[$record_id]);
				} else {
					$this->blog_design[$blog_id] = Array();
				}
			}
			if (isset($this->blog_design[$blog_id]['blog_short_path']) && $this->blog_design[$blog_id]['blog_short_path'] == 1) {
				$path[$record_id] = '';
			}
			if (!$is_blog_work) {
				$this->config->set("blog_work", false);
			}
			return $path[$record_id];
		}
		private function getSEOPathByBlog($blog_id)
		{
			if (!$this->config->get("blog_work")) {
				$this->config->set("blog_work", true);
				$is_blog_work = false;
			} else {
				$is_blog_work = true;
			}
			if (utf8_strpos($blog_id, '_') !== false) {
				$array_blog_id = explode('_', $blog_id);
				$blog_id       = end($array_blog_id);
			}
			$this->blog_id_current = $blog_id = (int) $blog_id;
			if ($blog_id < 1)
				return false;
			if (!isset($this->cache_pathbyblog_current[$blog_id]['path'])) {
				$this->cache_pathbyblog_current = $cache_pathbyblog = $this->cache->get('blog.pathbyblog');
			} else {
				$cache_pathbyblog = $this->cache_pathbyblog_current;
			}
			if (!isset($cache_pathbyblog[$blog_id]['design'])) {
				$this->load->model('record/blog');
				$blog_info = $this->model_record_blog->getBlog($blog_id, false);
				if (isset($blog_info['design']) && $blog_info['design'] != '') {
					$this->blog_design[$blog_id] = unserialize($blog_info['design']);
				} else {
					$this->blog_design[$blog_id] = Array();
				}
				$cache_pathbyblog[$blog_id]['design'] = $this->blog_design[$blog_id];
			} else {
				$this->blog_design[$blog_id] = $cache_pathbyblog[$blog_id]['design'];
			}
			if (!isset($cache_pathbyblog[$blog_id]['path'])) {
				if (isset($this->blog_design[$blog_id]['blog_short_path_category']) && $this->blog_design[$blog_id]['blog_short_path_category'] == 1) {
					$cache_pathbyblog[$blog_id]['path'] = $blog_id;
				} else {
					$flag_end      = false;
					$blog_path     = (int) $blog_id;
					$category_path = $blog_path;
					$array_path    = array();
					$level         = 0;
					do {
						if (!isset($array_path[$blog_path])) {
							$array_path[$blog_path] = $blog_path;
							$sql                    = "SELECT parent_id as parent_id FROM " . DB_PREFIX . "blog WHERE blog_id = '" . (int) $blog_path . "'";
							$query                  = $this->db->query($sql);
							if ((isset($query->row['parent_id']) && $query->row['parent_id'] == 0) || $level == 50) {
								$flag_end = true;
							} else {
								if (isset($query->row['parent_id'])) {
									$blog_path     = $query->row['parent_id'];
								}
								$category_path = $blog_path . '_' . $category_path;
							}
							$level++;
						} else {
							$flag_end = true;
						}
					} while (!$flag_end);
					$cache_pathbyblog[$blog_id]['path'] = $category_path;
				}
				$this->cache->set('blog.pathbyblog', $cache_pathbyblog);
				$this->cache_pathbyblog_current = $cache_pathbyblog;
			}
			$category = $cache_pathbyblog[$blog_id]['path'];
			if (!$is_blog_work) {
				$this->config->set("blog_work", false);
			}

			return $category;
		}
		private function validate()
		{
			$this->validflag 	= true;
			$cnt_cnt			= $this->config->get('asc_cnt_cnt');
			if (isset($this->request->get['route']) && $this->request->get['route'] == 'error/not_found') {
				return;
			}
			if (empty($this->request->get['route'])) {
				$this->request->get['route'] = 'common/home';
			}
			if (isset($this->request->server['HTTP_X_REQUESTED_WITH']) && strtolower($this->request->server['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
				return;
			}
			$url = str_replace('&amp;', '&', ltrim($this->request->server['REQUEST_URI'], '/'));
			$seo = str_replace('&amp;', '&', str_replace($this->config_url, '', $this->url->link($this->request->get['route'], $this->getQueryString(array(
				'route',
				'_route_',
				'site_language'
			)), 'SSL')));

			//print_my($url);
			//print_my($seo);
			//print_my($this->request->get);
			//print_my($this->getQueryString(array('route','_route_','site_language')));

			$this->validflag = false;
			$this->registry->set('url_site', $seo);
			if (rawurldecode($url) != rawurldecode($seo)) {
				header($this->request->server['SERVER_PROTOCOL'] . ' 301 Moved Permanently');
				if (!$this->comp_url && $cnt_cnt == 'fec00258b41bb6fb92a7feb8ccb0bed9') {
					$this->response->redirect($this->config_url . $seo);
				}
			}
		}
		private function strpos_offset($needle, $haystack, $occurrence)
		{
			$arr = explode($needle, $haystack);
			switch ($occurrence) {
				case $occurrence == 0:
					return false;
				case $occurrence > max(array_keys($arr)):
					return false;
				default:
					return strlen(implode($needle, array_slice($arr, 0, $occurrence)));
			}
		}
		private function getQueryString($exclude = array())
		{
			if (!is_array($exclude)) {
				$exclude = array();
			}
			return urldecode(http_build_query(array_diff_key($this->request->get, array_flip($exclude))));
		}
		public function get_name()
		{
			return $this->class_name;
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
					trigger_error('Error: Could not load controller ' . $cont . '! File: '.$file);
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
	}
}