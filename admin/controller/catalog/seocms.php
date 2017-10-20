<?php
/* All rights reserved belong to the module, the module developers http://opencartadmin.com */
// http://opencartadmin.com © 2011-2016 All Rights Reserved
// Distribution, without the author's consent is prohibited
// Commercial license
class ControllerCatalogSeocms extends Controller {
    protected  $data;

	public function index() {

       	$this->config->set("blog_work", true);
		$this->data['ascp_settings'] = $this->config->get('ascp_settings');

		$this->data['this'] = $this;

		if (!class_exists('ModelSettingSetting')) {
			$this->load->model('setting/setting');
	    }
		$this->data['blog_version'] = '*';
		$this->data['blog_version_model'] = 'PRO';
		$settings_admin = $this->model_setting_setting->getSetting('ascp_version', 'ascp_version');
		foreach ($settings_admin as $key => $value) { $this->data['blog_version'] = $value; }
		$settings_admin_model = $this->model_setting_setting->getSetting('ascp_version_model', 'ascp_version_model');
		foreach ($settings_admin_model as $key => $value) { $this->data['blog_version_model'] = $value; }
        $this->data['blog_version'] = $this->data['blog_version']. ' '. $this->data['blog_version_model'];

		if (!class_exists('User')) {
			loadlibrary('user');
		}
		if (SC_VERSION > 21) {
			$user_str = 'Cart\User';
		} else {
			$user_str = 'User';
		}
		$this->user = new $user_str($this->registry);

		if ($this->user->isLogged() && $this->user->hasPermission('modify', 'module/blog')) {
			$this->data['userLogged'] = true;
		} else {
			$this->data['userLogged'] = false;
		}

		$html = $this->loadadminmenu();

		if (isset($this->request->get['route'])) {
		        if (SC_VERSION < 20) {
					$route = array('catalog/review/update' => 'reviewdate_load', 'catalog/product/edit' => 'product_edit');
				} else {
					$route = array('catalog/review/edit' => 'reviewdate_load', 'catalog/review/add' => 'reviewdate_load', 'catalog/product/edit' => 'product_edit');
				}


				if (isset($route[$this->request->get['route']])) {

					if (!$this->user->hasPermission('modify', 'catalog/review')) {
						$this->error['warning'] = $this->language->get('error_permission');
					} else {						$class_execute = $route[$this->request->get['route']];
						$html .= $this->$class_execute();
					}
				}
		}

		return $html;
	}

/***************************************/
	public function reviewdate_load()
	{
        $this->config->set("blog_work", true);
		$ascp_settings = $this->data['ascp_settings'] = $this->config->get('ascp_settings');

		$this->data['this'] = $this;

		if (isset($ascp_settings['review_visual']) && $ascp_settings['review_visual']) {
			$this->language->load('module/blog');



			if (isset($this->request->get['review_id']) || $this->request->get['route'] == 'catalog/review/add' ) {
				if (isset($this->session->data['token'])) {
					$this->data['token'] = $this->session->data['token'];
				} else {
					$this->data['token'] = "";
				}
				$url = '';
				if (isset($this->request->get['sort'])) {
					$url .= '&sort=' . $this->request->get['sort'];
				}
				if (isset($this->request->get['order'])) {
					$url .= '&order=' . $this->request->get['order'];
				}
				if (isset($this->request->get['page'])) {
					$url .= '&page=' . $this->request->get['page'];
				}
				$this->data['config_language'] = $this->config->get('config_language');
				if (isset($this->request->get['review_id'])) {
					$this->data['action'] = $this->url->link('common/seocms/reviewdate_save', 'token=' . $this->session->data['token'] . '&review_id=' . $this->request->get['review_id'] . $url, 'SSL');
				} else {					$this->data['action'] = '';
				}

			   if (!class_exists('ModelCatalogReview')) {
					$this->load->model('catalog/review');
		       }

				$this->language->load('module/blog');
				$this->data['entry_date_added'] = $this->language->get('entry_date_added');

				if (isset($this->request->get['review_id'])) {
					$review_info = $this->model_catalog_review->getReview($this->request->get['review_id']);
				} else {					$review_info = array();
				}

				if (!empty($review_info)) {
					$this->data['date_added'] = $review_info['date_added'];
					$this->data['product_id'] = $review_info['product_id'];
				} else {
					$this->data['date_added'] = '';
					$this->data['product_id'] = false;
				}
				if (isset($this->request->get['review_id'])) {
					$this->data['review_id'] = $this->request->get['review_id'];
				} else {					$this->data['review_id'] = false;
				}

			   if (!class_exists('ModelCatalogBlogcomment')) {
				$this->load->model('catalog/blogcomment');
		       }


				if (isset($this->request->post['af'])) {
					$this->data['af'] = $this->request->post['af'];
				} else {
					if (isset($this->request->get['review_id'])) {
						$review_id = $this->request->get['review_id'];
						$data = array(
							'review_id' => $this->request->get['review_id'],
							'mark' => 'product_id'
						);
						$af = $this->model_catalog_blogcomment->getField($data);
						foreach ($af as $val) {
							$this->data['af'] = $val;
						}
					} else {
						$review_id = false;
					}
				}


			   if (!class_exists('ModelSeocmsDesignLayout')) {
					$this->load->model('seocms/design/layout');
		       }

				if (isset($this->request->get['review_id'])) {
					$this->data['record_id'] = $this->request->get['review_id'];
				} else {					$this->data['record_id'] = false;
				}
				$layout_id = $this->model_seocms_design_layout->getRecordLayoutId($this->data['product_id'], 'product');
				if (isset($this->request->post['ascp_widgets'])) {
					$ascp_widgets = $this->request->post['ascp_widgets'];
				} else {
					$ascp_widgets = $this->config->get('ascp_widgets');
				}
				if (!isset($record_settings['addfields'])) {
					$record_settings['addfields'] = array();
				}
				$this->data['thislist'] = array();
				$this->data['thislist']['addfields'] = array();
				foreach ($this->config->get('blog_module') as $num => $val) {
					if (isset($ascp_widgets[$val['what']]['addfields'])) {
						$this->data['thislist'] = $ascp_widgets[$val['what']];
						if (isset($ascp_widgets[$val['what']]['addfields'])) {
							$record_settings['addfields'] = array_merge($record_settings['addfields'], $ascp_widgets[$val['what']]['addfields']);
						}
					}
				}
				if (!function_exists('comp_field')) {
					function comp_field($a, $b)
					{
						if (!isset($a['field_order']) || $a['field_order'] == '')
							$a['field_order'] = '9999999';
						if (!isset($b['field_order']) || $b['field_order'] == '')
							$b['field_order'] = '9999999';
						$a['field_order'] = (int) $a['field_order'];
						$b['field_order'] = (int) $b['field_order'];
						if ($a['field_order'] > $b['field_order'])
							return 1;
						if ($b['field_order'] > $a['field_order'])
							return -1;
						return 0;
					}
				}
				if (!function_exists('group_by_key')) {
					function group_by_key($array)
					{
						$result = array();
						foreach ($array as $row) {
							if (!isset($result[$row['field_name']])) {
								$result[$row['field_name']] = $row;
							} else {
								$result[$row['field_name']] = $row;
							}
						}
						return array_values($result);
					}
				}

				$addfields = $this->model_catalog_blogcomment->getFieldsDesc();
		        $this->data['fields'] = $addfields;

				if (isset($this->data['af'])) {
					foreach ($this->data['fields'] as $num => $field) {

						foreach ($this->data['af'] as $anum => $af) {
							if ($field['field_name'] == $anum) {
								$this->data['fields'][$num]['value'] = $af;
							}
						}
					}
				}
				$loader_old = $this->registry->get('load');
				$this->load->library('agoo/loader');
				$agooloader = new agooLoader($this->registry);
				$this->registry->set('load', $agooloader);

			   if (!class_exists('ModelCatalogTreecomments')) {
					$this->load->model('catalog/treecomments', array(), DIR_CATALOG);
		       }

				if (isset($this->request->get['review_id'])) {
					$this->data['karma'] = $this->model_catalog_treecomments->getRatesByCommentId($this->request->get['review_id'], 'product_id', true);
					$this->data['karma_all'] = $this->model_catalog_treecomments->getRatesByCommentId($this->request->get['review_id'], 'product_id');
				} else {					$this->data['karma'] = false;
					$this->data['karma_all'] = false;
				}
				$this->registry->set('load', $loader_old);
				$this->language->load('seocms/catalog/comment');
				$this->document->addScript('view/javascript/wysibb/jquery.wysibb.min.js');
				$this->document->addStyle('view/javascript/wysibb/theme/default/wbbtheme.css');
				$this->template = 'catalog/seocms_review_date.tpl';
				if (file_exists(DIR_TEMPLATE . $this->template)) {
					$this->template = $this->template;
				} else {
					$this->template = '';
				}


				$this->data['registry'] = $this->registry;
				$this->data['language'] =  $this->language;
				$this->data['config'] 	=  $this->config;

		        if (SC_VERSION < 20) {
					$html = $this->render();
				} else {
					$html = $this->load->view($this->template , $this->data);
				}

				if (isset($this->request->get['ajax'])) {
					$this->response->setOutput($html);
				} else {
					return $html;
				}
			}
		}
	}
/***************************************/
	public function product_edit()
	{
        $this->config->set("blog_work", true);
		$this->data['ascp_settings'] = $this->config->get('ascp_settings');

        $this->data['config_language'] = $this->config->get('config_language');

		if (isset($this->session->data['token'])) {
			$this->data['token'] = $this->session->data['token'];
		} else {
			$this->data['token'] = "";
		}

		$this->document->addScript('view/javascript/wysibb/jquery.wysibb.min.js');
		$this->document->addStyle('view/javascript/wysibb/theme/default/wbbtheme.css');
		$this->template = 'agoo/tab/tab_edit.tpl';

		if (file_exists(DIR_TEMPLATE . $this->template)) {
				$this->template = $this->template;
		} else {
				$this->template = '';
		}

	    if ($this->template != '') {
			$this->data['registry'] = $this->registry;
			$this->data['language'] = $this->language;
			$this->data['config'] 	= $this->config;

			if (SC_VERSION < 20) {
				$html = $this->render();
			} else {
				$html   = $this->load->view($this->template , $this->data);
			}

			if (isset($this->request->get['ajax'])) {
				$this->response->setOutput($html);
			} else {
				return $html;
			}
		}


	}
/***************************************/

	private function loadadminmenu()
	{
        $this->config->set("blog_work", true);
		$this->data['ascp_settings'] = $this->config->get('ascp_settings');

		$this->language->load('module/blog');
		if (isset($this->session->data['token'])) {
			$this->data['token'] = $this->session->data['token'];
		} else {
			$this->data['token'] = "";
		}
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$admin_url = HTTP_SERVER;
		} else {
			$admin_url = HTTPS_SERVER;
		}
		$this->data['url_module'] = $admin_url . 'index.php?route=module/blog' . '&token=' . $this->data['token'];
		$this->data['url_blog'] = $admin_url . 'index.php?route=catalog/blog' . '&token=' . $this->data['token'];
		$this->data['url_record'] = $admin_url . 'index.php?route=catalog/record' . '&token=' . $this->data['token'];
		$this->data['url_comment'] = $admin_url . 'index.php?route=catalog/comment' . '&action=comment&token=' . $this->data['token'];
		$this->data['url_review'] = $admin_url . 'index.php?route=catalog/comment' . '&action=review&token=' . $this->data['token'];
		$this->data['url_modules'] = $admin_url . 'index.php?route=extension/module' . '&token=' . $this->data['token'];
		$this->data['url_forum'] = $this->language->get('url_forum');
		$this->data['url_forum_buy'] = $this->language->get('url_forum_buy');
		$this->data['url_opencartadmin'] = $this->language->get('url_opencartadmin');
		$this->data['url_forum_text'] = $this->language->get('url_forum_text');
		$this->data['url_forum_site_text'] = $this->language->get('url_forum_site_text');
		$this->data['url_forum_buy_text'] = $this->language->get('url_forum_buy_text');
		$this->data['url_forum_update_text'] = $this->language->get('url_forum_update_text');
		$this->data['url_opencartadmin_text'] = $this->language->get('url_opencartadmin_text');
		$this->data['url_module_text'] = $this->language->get('url_module_text');
		$this->data['url_blog_text'] = $this->language->get('url_blog_text');
		$this->data['url_record_text'] = $this->language->get('url_record_text');
		$this->data['url_comment_text'] = $this->language->get('url_comment_text');
		$this->data['url_review_text'] = $this->language->get('url_review_text');

		if (file_exists(DIR_APPLICATION . 'view/stylesheet/seocmspro.css')) {
		//	$this->document->addStyle('view/stylesheet/seocmspro.css');
		}

        $data['styles'] = $this->document->getStyles();

		$this->template = 'module/blogadmin.tpl';
		if (file_exists(DIR_TEMPLATE . $this->template)) {
			$this->template = $this->template;
		} else {
			$this->template = '';
		}

		$this->data['language'] =  $this->language;


        if (SC_VERSION < 20) {
			$html = $this->render();
		} else {
			$html = $this->load->view($this->template , $this->data);
		}

		return $html;
	}
/***************************************/


 	public function reviewdate_save()
	{
		/*
		$this->data['this'] = $this;
		$ascp_settings = $this->config->get('ascp_settings');
		if (isset($ascp_settings['review_visual']) && $ascp_settings['review_visual']) {
			$this->load->language('catalog/review');
			$this->document->setTitle($this->language->get('heading_title'));
			$url = '';
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateFormReview()) {
				$this->load->model('catalog/review');
				$this->load->model('catalog/blogreview');
				$this->model_catalog_review->editReview($this->request->get['review_id'], $this->request->post);
				$this->request->post['name'] = strip_tags($this->db->escape($this->request->post['author']));
				$this->request->post['mark'] = 'product_id';
				$this->model_catalog_blogreview->editReview($this->request->get['review_id'], $this->request->post);
				$this->load->model('catalog/blogcomment');
				$record_info = $this->model_catalog_blogcomment->getProductbyReviewId($this->request->get['review_id']);
				$record_id = $record_info['product_id'];
				$this->cont('record/treecomments');
				$this->data['mark'] = 'product_id';
				if (isset($this->request->post['thislist'])) {
					$str = base64_decode($this->request->post['thislist']);
					$this->data['thislist'] = unserialize($str);
				} else {
					$this->data['thislist'] = Array();
				}
				$this->data['thislist']['signer'] = true;
				$this->session->data['success'] = $this->language->get('text_success');
				$link = $this->url->link('catalog/review', 'token=' . $this->session->data['token'] . $url, 'SSL');
				$this->redirect($link);
			} else {



				$this->data['link'] = $this->url->link('catalog/review/update', 'token=' . $this->session->data['token'] . '&review_id=' . $this->request->get['review_id'] . $url, 'SSL');
				$this->data['post'] = $_POST;
				$this->template = 'module/blogredirect.tpl';
				if (file_exists(DIR_TEMPLATE . $this->template)) {
					$this->template = $this->template;
				} else {
					$this->template = '';
				}
				$html = $this->render();
				$this->response->setOutput($html);
			}
		}
		*/
	}
/***************************************/
	private function validateFormReview()
	{
		if (!$this->user->hasPermission('modify', 'catalog/review')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if (!$this->request->post['product_id']) {
			$this->error['product'] = $this->language->get('error_product');
		}
		if ((utf8_strlen($this->request->post['author']) < 3) || (utf8_strlen($this->request->post['author']) > 64)) {
			$this->error['author'] = $this->language->get('error_author');
		}
		if (utf8_strlen($this->request->post['text']) < 1) {
			$this->error['text'] = $this->language->get('error_text');
		}
		if (!isset($this->request->post['rating'])) {
			$this->error['rating'] = $this->language->get('error_rating');
		}
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
/***************************************/
	public function cont($cont)
	{
		$file  = DIR_CATALOG . 'controller/' . $cont . '.php';
		if (file_exists($file)) {
           $this->cont_loading($cont, $file);
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
/***************************************/
}
