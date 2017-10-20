<?php
/* All rights reserved belong to the module, the module developers http://opencartadmin.com */
// http://opencartadmin.com © 2011-2016 All Rights Reserved
// Distribution, without the author's consent is prohibited
// Commercial license
class ControllerCatalogComment extends Controller
{
	private $error = array();
	protected $data;
	public function index()
	{
		 $this->config->set("blog_work", true);

		$this->language->load('module/blog');
		$this->data['oc_version'] = str_pad(str_replace(".", "", VERSION), 7, "0");
		$this->load->model('setting/setting');
		$this->data['blog_version']       = '*';
		$this->data['blog_version_model'] = 'PRO';
		$settings_admin                   = $this->model_setting_setting->getSetting('ascp_version', 'ascp_version');
		foreach ($settings_admin as $key => $value) {
			$this->data['blog_version'] = $value;
		}
		$settings_admin_model = $this->model_setting_setting->getSetting('ascp_version_model', 'ascp_version_model');
		foreach ($settings_admin_model as $key => $value) {
			$this->data['blog_version_model'] = $value;
		}
		$this->data['blog_version'] = $this->data['blog_version'] . ' ' . $this->data['blog_version_model'];
		$this->language->load('seocms/catalog/comment');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->data['tab_general']      = $this->language->get('tab_general');
		$this->data['tab_list']         = $this->language->get('tab_list');
		$this->data['url_modules_text'] = $this->language->get('url_modules_text');
		$this->data['column_language'] = $this->language->get('column_language');
		$this->load->model('catalog/blogcomment');

		$this->load->model('localisation/language');
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		foreach ($this->data['languages'] as $code => $language) {
			if (!isset($language['image'])) {
            	$this->data['languages'][$code]['image'] = "language/".$code."/".$code.".png";
			} else {
                $this->data['languages'][$code]['image'] = "view/image/flags/".$language['image'];
			}
			if (!file_exists(DIR_APPLICATION.$this->data['languages'][$code]['image'])) {
				$this->data['languages'][$code]['image'] = "view/image/seocms/sc_1x1.png";
			}
		}

		if (isset($this->request->get['action']) && $this->request->get['action']=='review') {
			$this->data['mark'] = 'product_id';
			$this->data['mark_name'] = 'review';
		} else {
			$this->data['mark'] = 'record_id';
			$this->data['mark_name'] = 'comment';
		}

       $this->cont('agooa/adminmenu');
       $this->data['agoo_menu'] = $this->controller_agooa_adminmenu->index();


		$this->getList();
	}


	private function getList()
	{
		$this->config->set("blog_work", true);
		$this->data['ascp_settings'] = $this->config->get('ascp_settings');

		if (file_exists(DIR_APPLICATION . 'view/stylesheet/seocmspro.css')) {
			$this->document->addStyle('view/stylesheet/seocmspro.css');
		}
		if (file_exists(DIR_APPLICATION . 'view/javascript/blog/seocmspro.js')) {
			$this->document->addScript('view/javascript/blog/seocmspro.js');
		}
		$this->data['url_modules']        = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_options']        = $this->url->link('module/blog', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_schemes']        = $this->url->link('module/blog/schemes', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_widgets']        = $this->url->link('module/blog/widgets', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_back']           = $this->url->link('module/blog', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_back_text']      = $this->language->get('url_back_text');
		$this->data['token']              = $this->session->data['token'];
		$this->data['button_filter']      = $this->language->get('button_filter');
		$this->data['entry_comment_text'] = $this->language->get('entry_comment_text');
        $no_image = '';
		if (file_exists(DIR_IMAGE . 'no_image.jpg')) {
			$no_image = 'no_image.jpg';
		}
		if (file_exists(DIR_IMAGE . 'no_image.png')) {
			$no_image = 'no_image.png';
		}
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = NULL;
		}
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'r.date_added';
		}
		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
		}
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		$url = '';
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		$this->data['breadcrumbs']   = array();
		$this->data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);
		$this->data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('catalog/comment', 'action='.$this->data['mark_name'].'&token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);
		$this->data['insert']        = $this->url->link('catalog/comment/insert', 'action='.$this->data['mark_name'].'&token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete']        = $this->url->link('catalog/comment/delete', 'action='.$this->data['mark_name'].'&token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['comments']      = array();

        if (SC_VERSION < 20) {
	        if (!$this->config->get('config_admin_limit')) {
	        	$this->config->set('config_admin_limit', 40);
	        } else {
	       		 $config_limit_admin	 = $this->config->get('config_admin_limit');
	        }
        } else {
	        if (!$this->config->get('config_limit_admin')) {
	        	$this->config->set('config_limit_admin', 40);
	        } else {
	        	$config_limit_admin	 = $this->config->get('config_limit_admin');
	        }
        }


		$data                        = array(
			'filter_name' => $filter_name,
			'mark' => $this->data['mark'],
			'sort' => $sort,
			'order' => $order,
			'start' => ($page - 1) * $config_limit_admin,
			'limit' => $config_limit_admin
		);

		$results                     = $this->model_catalog_blogcomment->getComments($data);

		$loader_old                  = $this->registry->get('load');
		$this->load->library('agoo/loader');
		$agooloader = new agooLoader($this->registry);
		$this->registry->set('load', $agooloader);
		$this->load->model('record/treecomments', array(), DIR_CATALOG);

        $action                   = array();
       foreach ($results as $result) {

			$action[$result[$this->data['mark_name'].'_id']][]                 = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('catalog/comment/update', 'action='.$this->data['mark_name'].'&token=' . $this->session->data['token'] . '&comment_id=' . $result[$this->data['mark_name'].'_id'] . $url, 'SSL')
			);
			$action[$result[$this->data['mark_name'].'_id']][]                 = array(
				'text' => $this->language->get('text_answer'),
				'href' => $this->url->link('catalog/comment/insert', 'action='.$this->data['mark_name'].'&token=' . $this->session->data['token'] . '&comment_id=' . $result[$this->data['mark_name'].'_id'] . $url, 'SSL')
			);
       }


		$this->data['heading_title']     = $this->language->get('heading_title');
		$this->data['text_no_results']   = $this->language->get('text_no_results');
		$this->data['column_comment_id'] = $this->language->get('column_comment_id');
		$this->data['column_comment_type'] = $this->language->get('column_comment_type');
		$this->data['column_record']     = $this->language->get('column_'.$this->data['mark']);
		$this->data['column_author']     = $this->language->get('column_author');
		$this->data['column_rating']     = $this->language->get('column_rating');
		$this->data['column_status']     = $this->language->get('column_status');
		$this->data['column_date_added'] = $this->language->get('column_date_added');
		$this->data['column_action']     = $this->language->get('column_action');
		$this->data['button_insert']     = $this->language->get('button_insert');
		$this->data['button_delete']     = $this->language->get('button_delete');
		$this->data['url_blog']          = $this->url->link('catalog/blog', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_comment']       = $this->url->link('catalog/comment', 'action=comment&token=' . $this->session->data['token'], 'SSL');
		$this->data['url_review']        = $this->url->link('catalog/comment', 'action=review&token=' . $this->session->data['token'], 'SSL');
       	$this->data['url_comment_text']  = $this->language->get('url_comment_text');
		$this->data['url_review_text']   = $this->language->get('url_review_text');
		$this->data['url_blog_text']     = $this->language->get('url_blog_text');
		$this->data['url_record_text']   = $this->language->get('url_record_text');
		$this->data['url_record']        = $this->url->link('catalog/record', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_create_text']   = $this->language->get('url_create_text');
		$this->data['filter_name']       = $filter_name;

		if (!isset($this->session->data['language'])) {
			$this->session->data['language'] = $this->config->get('config_language');
		}

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
		$url = '';
		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}
		$this->data['sort_record']     = $this->url->link('catalog/comment', 'action='.$this->data['mark_name'].'&token=' . $this->session->data['token'] . '&sort=pd.name' . $url, 'SSL');
		$this->data['sort_author']     = $this->url->link('catalog/comment', 'action='.$this->data['mark_name'].'&token=' . $this->session->data['token'] . '&sort=r.author' . $url, 'SSL');
		$this->data['sort_rating']     = $this->url->link('catalog/comment', 'action='.$this->data['mark_name'].'&token=' . $this->session->data['token'] . '&sort=r.rating' . $url, 'SSL');
		$this->data['sort_status']     = $this->url->link('catalog/comment', 'action='.$this->data['mark_name'].'&token=' . $this->session->data['token'] . '&sort=r.status' . $url, 'SSL');
		$this->data['sort_date_added'] = $this->url->link('catalog/comment', 'action='.$this->data['mark_name'].'&token=' . $this->session->data['token'] . '&sort=r.date_added' . $url, 'SSL');
		$url                           = '';
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}

        if (isset($results[0]['total'])) {
        	$comment_total  =$results[0]['total'];
        } else {
        	$comment_total = 0;
        }

		$pagination                = new Pagination();
		$pagination->total         = $comment_total;
		$pagination->page          = $page;
		$pagination->limit         = $config_limit_admin;
		$pagination->text          = $this->language->get('text_pagination');
		$pagination->url           = $this->url->link('catalog/comment', 'action='.$this->data['mark_name'].'&token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
		$this->data['pagination']  = $pagination->render();


		$this->data['sort']        = $sort;
		$this->data['order']       = $order;
		$this->data['this']        = $this;
		$this->data['filter_name'] = $filter_name;


			$this->config->set('config_ssl', HTTPS_CATALOG );
			$this->config->set('config_url', HTTP_CATALOG);

			if (SC_VERSION < 22) {
				$this->url = new Url(HTTP_CATALOG, $this->config->get('config_secure') ? HTTPS_CATALOG : HTTP_CATALOG);
			} else {
				$this->url = new Url($this->config->get('config_secure'));
			}

        /*
		if (isset($this->request->get['action']) && $this->request->get['action']=='comment') {

        	if (!class_exists('ControllerCommonSeoBlog')) {
	        	require_once(DIR_CATALOG . 'controller/common/seoblog.php');
				$seoBlog = new ControllerCommonSeoBlog ($this->registry);
				$this->url->addRewrite($seoBlog);
			}

		} else {

	       	$seo_type = $this->config->get('config_seo_url_type');
			if (!$seo_type) {
				$seo_type = 'seo_url';
			}

			if (SC_VERSION < 22) {
				$seo_dir = 'common';
				$seo_class = 'Common';
			} else {
				$seo_dir = 'startup';
				$seo_class = 'Startup';
			}

			require_once(DIR_CATALOG . 'controller/'.$seo_dir.'/' . $seo_type . '.php');
	       	$classSeo = 'Controller'.$seo_class.str_replace('_','',$seo_type);

			if (!class_exists($classSeo)) {
				$seoUrl = new $classSeo($this->registry);
    	        $this->url->addRewrite($seoUrl);
            }
		}
       */

		foreach ($results as $result) {
			$comment_total            = $result['total'];

			$this->data['karma']      = $this->model_record_treecomments->getRatesByCommentId($result[$this->data['mark_name'].'_id'], $this->data['mark'], true);
			$this->data['karma_all']  = $this->model_record_treecomments->getRatesByCommentId($result[$this->data['mark_name'].'_id'], $this->data['mark']);

			if (isset($this->data['ascp_settings']['comment_type'][$result ['type_id']])) {
			    $comment_type = $result ['type_id'].'.'.$this->data['ascp_settings']['comment_type'][$result ['type_id']]['title'][$this->config->get('config_language_id')];
			} else {
				$comment_type = 'NaN';
			}
            $comment_href = '';

             if ($this->registry->get('admin_work')) {

					if (isset($this->data['mark']) && $this->data['mark']=='product_id') {
						$route_comment = "product/product";
					} else {
						$route_comment = "record/record";
					}

                    $id_comment = $result[$this->data['mark']];
                    $commentlink = '#commentlink_'.$result[$this->data['mark_name'].'_id']."_".$result['cmswidget'];
                    $comment_href = $this->url->link($route_comment, $this->data['mark'].'='.$id_comment );

            }

			$this->data['comments'][] = array(
				'comment_id' => $result[$this->data['mark_name'].'_id'],
				'type'	=> $comment_type,
				'href'	=> $comment_href,
				'commentlink'	=> $commentlink,
				'language_id' => $result['language_id'],
				'karma' => $this->data['karma'],
				'karma_all' => $this->data['karma_all'],
				'name' => $result['name'],
				'text' => $result['text'],
				'author' => $result['author'],
				'rating' => $result['rating'],
				'status' => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
				'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'selected' => isset($this->request->post['selected']) && in_array($result[$this->data['mark_name'].'_id'], $this->request->post['selected']),
				'action' => $action[$result[$this->data['mark_name'].'_id']]
			);
		}

		$this->config->set('config_ssl', HTTPS_SERVER );
		$this->config->set('config_url', HTTP_SERVER);

		if (SC_VERSION < 22) {
			$this->url = new Url(HTTP_SERVER, $this->config->get('config_secure') ? HTTPS_SERVER : HTTP_SERVER);
		} else {
			$this->url = new Url($this->config->get('config_secure'));
		}

        /*
		if (isset($this->request->get['action']) && $this->request->get['action']=='comment') {
        	unset($seoBlog);
		} else {
   			if (isset($seoUrl)) {
	   			$this->url->addRewrite($seoUrl);
    	    	unset($seoUrl);
        	}
		}
        */

		$this->registry->set('load', $loader_old);

		if (!isset($comment_total)) {
			$comment_total = 0;
		}

		$this->template            = 'catalog/comment_list.tpl';
		$this->children            = array(
			'common/header',
			'common/footer'
		);
		$this->data['registry']    = $this->registry;
		$this->data['language']    = $this->language;
		$this->data['config']      = $this->config;
		if (SC_VERSION < 20) {
			$this->data['column_left'] = '';
			$html                      = $this->render();
		} else {
			$this->data['header']      = $this->load->controller('common/header');
			$this->data['menu']        = $this->load->controller('common/menu');
			$this->data['footer']      = $this->load->controller('common/footer');
			$this->data['column_left'] = $this->load->controller('common/column_left');
			$html                      = $this->load->view($this->template, $this->data);
		}
		$this->response->setOutput($html);
	}

	private function getForm()
	{
		 $this->config->set("blog_work", true);


		$this->load->model('localisation/language');
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		foreach ($this->data['languages'] as $code => $language) {
			if (!isset($language['image'])) {
            	$this->data['languages'][$code]['image'] = "language/".$code."/".$code.".png";
			} else {
                $this->data['languages'][$code]['image'] = "view/image/flags/".$language['image'];
			}
			if (!file_exists(DIR_APPLICATION.$this->data['languages'][$code]['image'])) {
				$this->data['languages'][$code]['image'] = "view/image/seocms/sc_1x1.png";
			}
		}

        $this->data['ascp_settings'] = $this->config->get('ascp_settings');

		if (isset($this->request->get['action']) && $this->request->get['action']=='review') {
			$this->data['mark'] = 'product_id';
			$this->data['mark_name'] = 'review';
		} else {
			$this->data['mark'] = 'record_id';
			$this->data['mark_name'] = 'comment';
		}

       $this->cont('agooa/adminmenu');
       $this->data['agoo_menu'] = $this->controller_agooa_adminmenu->index();


		$this->language->load('module/blog');
		$this->data['oc_version'] = str_pad(str_replace(".", "", VERSION), 7, "0");
		$this->load->model('setting/setting');
		$this->data['blog_version']       = '*';
		$this->data['blog_version_model'] = 'PRO';
		$settings_admin                   = $this->model_setting_setting->getSetting('ascp_version', 'ascp_version');
		foreach ($settings_admin as $key => $value) {
			$this->data['blog_version'] = $value;
		}
		$settings_admin_model = $this->model_setting_setting->getSetting('ascp_version_model', 'ascp_version_model');
		foreach ($settings_admin_model as $key => $value) {
			$this->data['blog_version_model'] = $value;
		}
		$this->data['blog_version']     = $this->data['blog_version'] . ' ' . $this->data['blog_version_model'];
		$this->data['tab_general']      = $this->language->get('tab_general');
		$this->data['tab_list']         = $this->language->get('tab_list');
		$this->data['url_modules_text'] = $this->language->get('url_modules_text');
		if (file_exists(DIR_APPLICATION . 'view/stylesheet/seocmspro.css')) {
			$this->document->addStyle('view/stylesheet/seocmspro.css');
		}
		if (file_exists(DIR_APPLICATION . 'view/javascript/jquery/tabs.js')) {
			$this->document->addScript('view/javascript/jquery/tabs.js');
		} else {
			if (file_exists(DIR_APPLICATION . 'view/javascript/blog/tabs/tabs.js')) {
				$this->document->addScript('view/javascript/blog/tabs/tabs.js');
			}
		}
		if (file_exists(DIR_APPLICATION . 'view/javascript/blog/seocmspro.js')) {
			$this->document->addScript('view/javascript/blog/seocmspro.js');
		}
		$this->language->load('seocms/catalog/comment');
		$this->load->model('catalog/blogcomment');

		$this->data['url_modules']        = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_options']        = $this->url->link('module/blog', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_schemes']        = $this->url->link('module/blog/schemes', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_widgets']        = $this->url->link('module/blog/widgets', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_back']           = $this->url->link('module/blog', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_back_text']      = $this->language->get('url_back_text');
		$this->data['token']              = $this->session->data['token'];
		$this->data['button_filter']      = $this->language->get('button_filter');
		$this->data['entry_comment_text'] = $this->language->get('entry_comment_text');
		if (file_exists(DIR_IMAGE . 'no_image.jpg')) {
			$no_image = 'no_image.jpg';
		}
		if (file_exists(DIR_IMAGE . 'no_image.png')) {
			$no_image = 'no_image.png';
		}
		$this->document->addScript('view/javascript/wysibb/jquery.wysibb.min.js');
		$this->document->addStyle('view/javascript/wysibb/theme/default/wbbtheme.css');
		$this->data['config_language']      = $this->config->get('config_language');
		$this->data['config_language_id']      = $this->config->get('config_language_id');
		$this->data['heading_title']        = $this->language->get('heading_title');
		$this->data['text_enabled']         = $this->language->get('text_enabled');
		$this->data['text_disabled']        = $this->language->get('text_disabled');
		$this->data['text_none']            = $this->language->get('text_none');
		$this->data['text_select']          = $this->language->get('text_select');
		$this->data['entry_date_available'] = $this->language->get('entry_date_available');
 		$this->data['entry_type_id']        = $this->language->get('entry_type_id');
		$this->data['entry_record']    		= $this->language->get('entry_'.$this->data['mark']);
		$this->data['entry_author']         = $this->language->get('entry_author');
		$this->data['entry_language']       = $this->language->get('entry_language');
		$this->data['entry_author_id']      = $this->language->get('entry_author_id');
		$this->data['entry_widget_id']      = $this->language->get('entry_widget_id');
		$this->data['entry_rating']         = $this->language->get('entry_rating');
		$this->data['entry_rating_mark']    = $this->language->get('entry_rating_mark');
		$this->data['entry_status']         = $this->language->get('entry_status');
		$this->data['entry_text']           = $this->language->get('entry_text');
		$this->data['entry_good']           = $this->language->get('entry_good');
		$this->data['entry_bad']            = $this->language->get('entry_bad');
		$this->data['button_save']          = $this->language->get('button_save');
		$this->data['button_cancel']        = $this->language->get('button_cancel');
		$this->data['url_back']             = $this->url->link('module/blog', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['url_back_text']        = $this->language->get('url_back_text');
		$this->data['url_blog']             = $this->url->link('catalog/blog', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_record']           = $this->url->link('catalog/record', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['url_comment']       = $this->url->link('catalog/comment', 'action=comment&token=' . $this->session->data['token'], 'SSL');
		$this->data['url_review']       = $this->url->link('catalog/comment', 'action=review&token=' . $this->session->data['token'], 'SSL');
       	$this->data['url_comment_text']  = $this->language->get('url_comment_text');
		$this->data['url_review_text']  = $this->language->get('url_review_text');

		$this->data['url_blog_text']        = $this->language->get('url_blog_text');
		$this->data['url_record_text']      = $this->language->get('url_record_text');
		$this->data['url_create_text']      = $this->language->get('url_create_text');
		$this->data['url_create_text']      = $this->language->get('url_create_text');
		$this->data['url_back_text']        = $this->language->get('url_back_text');

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
		if (isset($this->error['name'])) {
			$this->data['error_name'] = $this->error['name'];
		} else {
			$this->data['error_name'] = array();
		}
		if (isset($this->error['date_available'])) {
			$this->data['error_date_available'] = $this->error['date_available'];
		} else {
			$this->data['error_date_available'] = '';
		}
		if (isset($this->error['record'])) {
			$this->data['error_record'] = $this->error['record'];
		} else {
			$this->data['error_record'] = '';
		}
		if (isset($this->error['author'])) {
			$this->data['error_author'] = $this->error['author'];
		} else {
			$this->data['error_author'] = '';
		}
		if (isset($this->error['text'])) {
			$this->data['error_text'] = $this->error['text'];
		} else {
			$this->data['error_text'] = '';
		}
		if (isset($this->error['rating'])) {
			$this->data['error_rating'] = $this->error['rating'];
		} else {
			$this->data['error_rating'] = '';
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
		$this->data['breadcrumbs']   = array();
		$this->data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);
		$this->data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('catalog/comment', 'action='.$this->data['mark_name'].'&token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);
		if (!isset($this->request->get['comment_id']) || $this->request->get['route'] == 'catalog/comment/insert') {
			$this->data['action'] = $this->url->link('catalog/comment/insert', 'action='.$this->data['mark_name'].'&token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('catalog/comment/update', 'action='.$this->data['mark_name'].'&token=' . $this->session->data['token'] . '&comment_id=' . $this->request->get['comment_id'] . $url, 'SSL');
		}

		$this->data['cancel'] = $this->url->link('catalog/comment', 'action='.$this->data['mark_name'].'&token=' . $this->session->data['token'] . $url, 'SSL');

		$this->data['token']  = $this->session->data['token'];


		if (isset($this->data['ascp_settings']['comment_type'])) {
			$this->data['comment_type'] = $this->data['ascp_settings']['comment_type'];
		} else {
			$this->data['comment_type'] = array();
		}

		if (isset($this->request->post['ascp_widgets'])) {
			$this->data['ascp_widgets'] = $this->request->post['ascp_widgets'];
		} else {
			$this->data['ascp_widgets'] = $this->config->get('ascp_widgets');
		}

		if (count($this->data['ascp_widgets']) > 0) {
			ksort($this->data['ascp_widgets']);
		}
         $this->data['widget_type'] = array();
         foreach ($this->data['ascp_widgets'] as $cmswidget_id => $widget) {
         	if ($widget['type'] == 'treecomments' || $widget['type']  == 'forms') {
         		$this->data['widget_type'][$cmswidget_id] = $widget;
         	}
         }



		if (isset($this->request->get['comment_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST') ||
		  	isset($this->request->get['comment_id']) && !isset($this->request->post['text'])
			)

		{
			$comment_info = $this->model_catalog_blogcomment->getComment($this->request->get['comment_id'], $this->data['mark_name']);
		}


		if (isset($this->request->post['parent_id'])) {
			$this->data['parent_id'] = $this->request->post['parent_id'];
		} elseif (isset($this->request->get['comment_id']) && $this->request->get['route'] == 'catalog/comment/insert') {
		  $this->data['parent_id'] = $this->request->get['comment_id'];

		} elseif (!empty($comment_info)) {
			$this->data['parent_id'] = $comment_info['parent_id'];
		} else {
			$this->data['parent_id'] = '0';
		}

		if (isset($this->request->post['customer_id'])) {
			$this->data['customer_id'] = $this->request->post['customer_id'];
		} elseif (!empty($comment_info)) {
			$this->data['customer_id'] = $comment_info['customer_id'];
		} else {
			$this->data['customer_id'] = '0';
		}

		if (isset($this->request->post['rating_mark'])) {
			$this->data['rating_mark'] = $this->request->post['rating_mark'];
		} elseif (!empty($comment_info)) {
			$this->data['rating_mark'] = $comment_info['rating_mark'];
		} else {
			$this->data['rating_mark'] = '0';
		}


		if (isset($this->request->post['language_id'])) {
			$this->data['language_id'] = $this->request->post['language_id'];
		} elseif (!empty($comment_info)) {
			$this->data['language_id'] = $comment_info['language_id'];
		} else {
			$this->data['language_id'] = $this->data['config_language_id'];
		}

		$this->load->model('catalog/record');

		if (isset($this->request->post['date_available'])) {
			$this->data['date_available'] = $this->request->post['date_available'];
		} elseif (!empty($comment_info)) {
			$this->data['date_available'] = date('Y-m-d H:i:s', strtotime($comment_info['date_added']));
		} else {
			$this->data['date_available'] = date('Y-m-d H:i:s');
		}

		if (isset($this->request->post['record_id'])) {
			$this->data['record_id'] = $this->request->post['record_id'];
		} elseif (!empty($comment_info)) {
			$this->data['record_id'] = $comment_info['record_id'];
		} else {
			$this->data['record_id'] = '';
		}


		if (isset($this->request->post['record'])) {
			$this->data['record'] = $this->request->post['record'];
		} elseif (!empty($comment_info)) {
			$this->data['record'] = $comment_info['record'];
		} else {
			$this->data['record'] = '';
		}
		if (isset($this->request->post['author'])) {
			$this->data['author'] = $this->request->post['author'];
		} elseif (!empty($comment_info)) {
			$this->data['author'] = $comment_info['author'];
		} else {
			$this->data['author'] = '';
		}

		if (isset($this->request->post['type_id'])) {
			$this->data['type_id'] = $this->request->post['type_id'];
		} elseif (!empty($comment_info)) {
			$this->data['type_id'] = $comment_info['type_id'];
		} else {
			$this->data['type_id'] = '';
		}


		if (isset($this->request->post['cmswidget'])) {
			$this->data['cmswidget'] = $this->request->post['cmswidget'];
		} elseif (!empty($comment_info)) {
			$this->data['cmswidget'] = $comment_info['cmswidget'];
		} else {
			$this->data['cmswidget'] = '';
		}

		if (isset($this->request->post['text'])) {
			$this->data['text'] = $this->request->post['text'];
		} elseif (!empty($comment_info)) {
			$this->data['text'] = $comment_info['text'];
		} else {
			$this->data['text'] = '';
		}


		$this->data['settings_widget']['signer'] = true;
		$this->data['settings_widget']['signer_answer'] = true;
		if (isset($this->request->post['rating'])) {
			$this->data['rating'] = $this->request->post['rating'];
		} elseif (!empty($comment_info)) {
			$this->data['rating'] = $comment_info['rating'];
		} else {
			$this->data['rating'] = '';
		}
		if (isset($this->request->post['status'])) {
			$this->data['status'] = $this->request->post['status'];
		} elseif (!empty($comment_info)) {
			$this->data['status'] = $comment_info['status'];
		} else {
			$this->data['status'] = '';
		}
		if (isset($this->request->post['af'])) {
			$this->data['af'] = $this->request->post['af'];
		} else {
			if (isset($this->request->get['comment_id'])) {
				$review_id = $this->request->get['comment_id'];
				$data      = array(
					'review_id' => $this->request->get['comment_id'],
					'mark' => $this->data['mark']
				);
				$aff       = $af = $this->model_catalog_blogcomment->getField($data);
				foreach ($af as $val) {
					$this->data['af'] = $val;
				}
			} else {
				$review_id = false;
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

		$this->load->model('seocms/design/layout');

		$layout_id    = $this->model_seocms_design_layout->getRecordLayoutId($this->data['record_id']);
		$ascp_widgets = $this->config->get('ascp_widgets');


		$addfields            = $this->model_catalog_blogcomment->getFieldsDesc();
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
		$this->load->model('record/treecomments', array(), DIR_CATALOG);
		$customer_id = -1;
		if (!isset($this->request->get['comment_id'])) {
			$comment_id = false;
		} else {
			$comment_id = $this->request->get['comment_id'];
		}
		$this->data['karma']     = $this->model_record_treecomments->getRatesByCommentId($comment_id, $this->data['mark'], true);

        if (file_exists(DIR_APPLICATION.'model/sale/customer.php')) {
        	$this->load->model('sale/customer');
			$model_customer = 'model_sale_customer';
		} else {
			$this->load->model('customer/customer');
			$model_customer = 'model_customer_customer';
		}

   		foreach ($this->data['karma'] as $num =>$karma_val) {
			$results_karama = $this->$model_customer->getCustomer($karma_val['customer_id']);
    	    if (isset($results_karama['firstname']) || isset($results_karama['lastname'])) {
    	    	$this->data['karma'][$num]['name'] = $results_karama['firstname']." ".$results_karama['lastname'];
    	    } else {
 	   	     	$this->data['karma'][$num]['name'] = $this->language->get('text_ghost');
    	    }
        }

		$this->data['karma_all'] = $this->model_record_treecomments->getRatesByCommentId($comment_id, $this->data['mark']);

		if (isset($this->data['parent_id']) && (string)$this->data['parent_id'] != '0') {
			$this->data['parent_info'] = $this->model_catalog_blogcomment->getComment($this->data['parent_id'], $this->data['mark_name']);
			if (isset($this->request->get['comment_id']) && $this->request->get['route'] == 'catalog/comment/insert') {
				$this->data['author'] = "";
				$this->data['customer_id'] = $comment_info['customer_id'] = "0";
				$this->data['text'] = "[quote]".$comment_info['text']."[/quote]";
				$this->data['karma_all'] = array();
				$this->data['karma'] = array();
			}
		}



		$this->data['this']      = $this;
		$this->registry->set('load', $loader_old);
		$this->template         = 'catalog/comment_form.tpl';
		$this->children         = array(
			'common/header',
			'common/footer'
		);
		$this->data['registry'] = $this->registry;
		$this->data['language'] = $this->language;
		$this->data['config']   = $this->config;
		if (SC_VERSION < 20) {
			$this->data['column_left'] = '';
			$html                      = $this->render();
		} else {
			$this->data['header']      = $this->load->controller('common/header');
			$this->data['menu']        = $this->load->controller('common/menu');
			$this->data['footer']      = $this->load->controller('common/footer');
			$this->data['column_left'] = $this->load->controller('common/column_left');
			$html                      = $this->load->view($this->template, $this->data);
		}
		$this->response->setOutput($html);
	}


	public function insert()
	{
		 $this->config->set("blog_work", true);


		if (isset($this->request->get['action']) && $this->request->get['action']=='review') {
			$this->data['mark'] = 'product_id';
			$this->data['mark_name'] = 'review';
		} else {
			$this->data['mark'] = 'record_id';
			$this->data['mark_name'] = 'comment';
		}

		$this->language->load('seocms/catalog/comment');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('catalog/blogcomment');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

			if (isset($this->request->post['text'])) {
				$this->request->post['text'] = strip_tags($this->request->post['text']);
				$this->request->post['text'] = $this->db->escape($this->request->post['text']);
				$this->request->post['name'] = strip_tags($this->db->escape($this->request->post['author']));
			}
			$this->request->post['mark'] = $this->data['mark'];
			$comment_id                  = $this->model_catalog_blogcomment->addComment($this->request->post);
			$record_id                   = $this->model_catalog_blogcomment->getRecordIdbyCommentId($comment_id, $this->data['mark_name']);
			$this->load->model('catalog/record');
			$record_info = $this->model_catalog_record->getRecord($record_id, $this->data['mark']);

			$this->cont('record/treecomments');

			if (isset($this->request->post['settings_widget'])) {
				$str                    = base64_decode($this->request->post['settings_widget']);
				$this->data['settings_widget'] = unserialize($str);
			} else {
				$this->data['settings_widget'] = Array();
			}

			if (isset($this->request->post['notify']) && $this->request->post['notify']) {
				$this->data['settings_widget']['signer']             = true;
				$this->data['settings_widget']['signer_answer']      = true;
				$this->data['settings_widget']['status_now']         = $this->request->post['status'];
				$this->data['settings_widget']['comment_signer']     = $this->request->post['status'];
				$this->data['settings_widget']['comment_status']     = $this->request->post['status'];
				$this->data['settings_widget']['comment_status_reg'] = $this->request->post['status'];
				$this->data['settings_widget']['comment_status_now'] = $this->request->post['status'];
				$record_info['comment_id']                    		 = $comment_id;
				$this->cont('record/signer');
				$this->controller_record_signer->signer($record_id, $record_info, $this->data['settings_widget'], $this->data['mark']);
			}
			$this->session->data['success'] = $this->language->get('text_success');
			$url                            = '';

			if (SC_VERSION < 20) {
				$this->redirect($this->url->link('catalog/comment', 'token=' . $this->session->data['token'], 'SSL'));
			} else {
				$this->response->redirect($this->url->link('catalog/comment', 'token=' . $this->session->data['token'], 'SSL'));
			}
		}

		unset($this->request->post['text']);
		$this->getForm();
	}

	public function update()
	{
		 $this->config->set("blog_work", true);

		$this->language->load('seocms/catalog/comment');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('catalog/blogcomment');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

			if (isset($this->request->post['text'])) {
				$this->request->post['text'] = strip_tags($this->request->post['text']);
				$this->request->post['text'] = $text_original = $this->db->escape($this->request->post['text']);
				$this->request->post['name'] = strip_tags($this->db->escape($this->request->post['author']));
			}


		if (isset($this->request->post['action']) && $this->request->post['action']=='review') {
			$this->data['mark'] = 'product_id';
			$this->data['mark_name'] = 'review';
		} else {
			$this->data['mark'] = 'record_id';
			$this->data['mark_name'] = 'comment';
		}


			$this->request->post['mark'] = $this->data['mark'];
			$this->request->post['mark_name'] = $this->data['mark_name'];

			$this->model_catalog_blogcomment->editComment($this->request->get['comment_id'], $this->request->post);

			$record_id = $this->request->post['record_id'];


			$this->load->model('catalog/record');
			$record_info = $this->model_catalog_record->getRecord($record_id, $this->data['mark']);

			$this->cont('record/treecomments');

			if (isset($this->request->post['settings_widget'])) {
				$str                    = base64_decode($this->request->post['settings_widget']);
				$this->data['settings_widget'] = unserialize($str);
			} else {
				$this->data['settings_widget'] = Array();
			}
			if (isset($this->request->post['notify']) && $this->request->post['notify']) {
				$this->data['settings_widget']['signer']             	= true;
				$this->data['settings_widget']['signer_answer']      	= true;
				$this->data['settings_widget']['status_now']         	= $this->request->post['status'];
				$this->data['settings_widget']['comment_signer']     	= $this->request->post['status'];
				$this->data['settings_widget']['comment_status']     	= $this->request->post['status'];
				$this->data['settings_widget']['comment_status_reg'] 	= $this->request->post['status'];
				$this->data['settings_widget']['comment_status_now'] 	= $this->request->post['status'];
				$record_info['comment_id']                    			= $this->request->get['comment_id'];
				$this->cont('record/signer');

				$this->controller_record_signer->signer($record_id, $record_info, $this->data['settings_widget'], $this->data['mark']);
			}

			$this->session->data['success'] = $this->language->get('text_success');
			$url                            = '';
			if (SC_VERSION < 20) {
				//$this->redirect($this->url->link('catalog/comment', 'action='.$this->data['mark_name'].'&token=' . $this->session->data['token'], 'SSL'));
			} else {
				//$this->response->redirect($this->url->link('catalog/comment', 'action='.$this->data['mark_name'].'&token=' . $this->session->data['token'], 'SSL'));
			}
		}
        unset($this->request->post['text']);
		$this->getForm();
	}
	public function delete()
	{
		 $this->config->set("blog_work", true);

		if (isset($this->request->post['action']) && $this->request->post['action']=='review') {
			$this->data['mark'] = 'product_id';
			$this->data['mark_name'] = 'review';
		} else {
			$this->data['mark'] = 'record_id';
			$this->data['mark_name'] = 'comment';
		}

		$this->language->load('seocms/catalog/comment');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('catalog/blogcomment');
		$this->cache->delete('blog');
		$this->cache->delete('record');
		$this->cache->delete('blogsrecord');
		if (isset($this->request->post['selected']) && $this->validateDelete()) {

			foreach ($this->request->post['selected'] as $comment_id) {
				$this->model_catalog_blogcomment->deleteComment($comment_id, $this->data['mark_name']);
			}

			$this->session->data['success'] = $this->language->get('text_success');
			$url                            = '';
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			if (SC_VERSION < 20) {
				$this->redirect($this->url->link('catalog/comment', 'action='.$this->data['mark_name'].'&token=' . $this->session->data['token'], 'SSL'));
			} else {
				$this->response->redirect($this->url->link('catalog/comment', 'action='.$this->data['mark_name'].'&token=' . $this->session->data['token'], 'SSL'));
			}
		}
		$this->getList();
	}

	private function validateForm()
	{
		if (!$this->user->hasPermission('modify', 'catalog/comment')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if (!$this->request->post['record_id']) {
			$this->error['record'] = $this->language->get('error_record');
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
	private function validateDelete()
	{
		if (!$this->user->hasPermission('modify', 'catalog/comment')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
	public function autocomplete()
	{
	 if ($this->validateDelete()) {

		if (isset($this->request->get['action']) && $this->request->get['action']=='review') {
			$this->data['mark'] = 'product_id';
			$this->data['mark_name'] = 'review';
		} else {
			$this->data['mark'] = 'record_id';
			$this->data['mark_name'] = 'comment';
		}

		$json               = array();
		if (isset($this->request->get['filter_name'])) {
			$this->load->model('catalog/record');
			if (isset($this->request->get['filter_name'])) {
				$filter_name = $this->request->get['filter_name'];
			} else {
				$filter_name = '';
			}
			if (isset($this->request->get['limit'])) {
				$limit = $this->request->get['limit'];
			} else {
				$limit = 20;
			}
			$data    = array(
				'mark' =>  $this->data['mark'],
				'filter_name' => $filter_name,
				'start' => 0,
				'limit' => $limit
			);

			$results = $this->model_catalog_record->getRecords($data);

			foreach ($results as $result) {
				$option_data = array();
				$json[]      = array(
					'record_id' => $result[$this->data['mark']],
					'name' => html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'),
					'blog' => $result['blog_name'],
					'option' => $option_data
				);
			}
		}
		$this->response->setOutput(json_encode($json));
	 }
	}

	public function rdate($param, $time = 0)
	{
		$this->language->load('module/blog');
		if (intval($time) == 0)
			$time = time();
		$MonthNames = array(
			$this->language->get('text_january'),
			$this->language->get('text_february'),
			$this->language->get('text_march'),
			$this->language->get('text_april'),
			$this->language->get('text_may'),
			$this->language->get('text_june'),
			$this->language->get('text_july'),
			$this->language->get('text_august'),
			$this->language->get('text_september'),
			$this->language->get('text_october'),
			$this->language->get('text_november'),
			$this->language->get('text_december')
		);
		if (strpos($param, ' M ') === false)
			return date($param, $time);
		else {
			$str_begin  = date(utf8_substr($param, 0, utf8_strpos($param, 'M')), $time);
			$str_middle = $MonthNames[date('n', $time) - 1];
			$str_end    = date(utf8_substr($param, utf8_strpos($param, 'M') + 1, utf8_strlen($param)), $time);
			$str_date   = $str_begin . $str_middle . $str_end;
			return $str_date;
		}
	}

	public function authorcomplete()
	{
		if ($this->validateDelete()) {

        if (file_exists(DIR_APPLICATION.'model/sale/customer.php')) {
        	$this->load->model('sale/customer');
			$model_customer = 'model_sale_customer';
		} else {
			$this->load->model('customer/customer');
			$model_customer = 'model_customer_customer';
		}
		$this->data['this'] = $this;
		$json               = array();
		if (isset($this->request->get['filter_name'])) {

			if (isset($this->request->get['filter_name'])) {
				$filter_name = $this->request->get['filter_name'];
			} else {
				$filter_name = '';
			}

			if (isset($this->request->get['limit'])) {
				$limit = $this->request->get['limit'];
			} else {
				$limit = 20;
			}
			$data    = array(
				'filter_name' => $filter_name,
				'start' => 0,
				'limit' => $limit
			);

			$results = $this->$model_customer->getCustomers($data);
			foreach ($results as $result) {
				$json[] = array(
					'customer_id' => $result['customer_id'],
					'name' => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
				);
			}
		}
		$this->response->setOutput(json_encode($json));
		}
	}


	public function karma_delete()
	{
        if ($this->validateDelete()) {

			if (isset($this->request->get['action']) && $this->request->get['action']=='review') {
				$this->data['mark'] = 'product_id';
				$this->data['mark_name'] = 'review';
			} else {
				$this->data['mark'] = 'record_id';
				$this->data['mark_name'] = 'comment';
			}


			if (isset($this->request->get['id'])) {
				$id = (int)$this->request->get['id'];
			} else {
				$id = false;
			}

            if ($id) {
             $this->load->model('catalog/blogcomment');
             $ret =  $this->model_catalog_blogcomment->deleteKarma($id, $this->data['mark_name']);
            }


			$this->response->setOutput($ret);
		}
	}

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

}
require_once(DIR_SYSTEM . 'helper/seocmsprofunc.php');
