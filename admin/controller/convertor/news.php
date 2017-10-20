<?php
/* All rights reserved belong to the module, the module developers http://opencartadmin.com */
// http://opencartadmin.com © 2011-2016 All Rights Reserved
// Distribution, without the author's consent is prohibited
// Commercial license
class ControllerConvertorNews extends Controller
{
	private $error = array();
	protected $data;
	protected $blog_id;
	public function index()
	{

		 $this->config->set("blog_work", true);


		$this->language->load('module/blog');
		$this->data['oc_version'] = str_pad(str_replace(".", "", VERSION), 7, "0");
		$this->load->model('setting/setting');
		$this->data['blog_version']       = '*';
		$this->data['blog_version_model'] = '';
		$settings_admin                   = $this->model_setting_setting->getSetting('ascp_version', 'ascp_version');
		foreach ($settings_admin as $key => $value) {
			$this->data['blog_version'] = $value;
		}
		$settings_admin_model = $this->model_setting_setting->getSetting('ascp_version_model', 'ascp_version_model');
		foreach ($settings_admin_model as $key => $value) {
			$this->data['blog_version_model'] = $value;
		}

		$this->data['blog_version'] = $this->data['blog_version'] . ' ' . $this->data['blog_version_model'];

		$this->load->language('convertor/news');

		$this->data['tab_general']      = $this->language->get('tab_general');
		$this->data['tab_list']         = $this->language->get('tab_list');
		$this->data['url_modules_text'] = $this->language->get('url_modules_text');

		if (file_exists(DIR_APPLICATION . 'view/stylesheet/seocmspro.css')) {
			$this->document->addStyle('view/stylesheet/seocmspro.css');
		}
		if (file_exists(DIR_APPLICATION . 'view/javascript/blog/seocmspro.js')) {
			$this->document->addScript('view/javascript/blog/seocmspro.js');
		}

		$this->data['url_modules']      = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_options']      = $this->url->link('module/blog', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_schemes']      = $this->url->link('module/blog/schemes', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_widgets']      = $this->url->link('module/blog/widgets', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_back']         = $this->url->link('module/blog', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_back_text']    = $this->language->get('url_back_text');
		$this->data['url_blog']         = $this->url->link('catalog/blog', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_convertor']     = $this->url->link('convertor/news', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_convert_news'] = $this->url->link('convertor/news/convert_news', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['url_comment']      = $this->url->link('catalog/comment', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_record']       = $this->url->link('catalog/record', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_blog_text']    = $this->language->get('url_blog_text');
		$this->data['url_sitemap_text'] = $this->language->get('url_sitemap_text');
		$this->data['url_comment_text'] = $this->language->get('url_comment_text');
		$this->data['url_create_text']  = $this->language->get('url_create_text');
		$this->data['url_record_text']  = $this->language->get('url_record_text');

		$this->data['text_loading']  = $this->language->get('text_loading');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {



            $this->config->set("blog_work", false);
            $this->cache->delete('blog');
            $this->blog_id = $this->request->post['category_news'];
            $this->convert();
			$this->session->data['success'] = $this->language->get('text_success');

			if (SC_VERSION < 20) {
				//$this->redirect($this->url->link('extension/feed', 'token=' . $this->session->data['token'], 'SSL'));
			} else {
				//$this->response->redirect($this->url->link('extension/feed', 'token=' . $this->session->data['token'], 'SSL'));
			}
		}


		if (isset($this->request->post['ascp_settings_sitemap'])) {
			$this->data['ascp_settings_sitemap'] = $this->request->post['ascp_settings_sitemap'];
		} else {
			$this->data['ascp_settings_sitemap'] = $this->config->get('ascp_settings_sitemap');
		}

		$this->data['heading_title']   = $this->language->get('heading_title');
		$this->data['text_enabled']    = $this->language->get('text_enabled');
		$this->data['text_disabled']   = $this->language->get('text_disabled');
		$this->data['entry_status']    = $this->language->get('entry_status');
		$this->data['entry_language_status']    = $this->language->get('entry_language_status');
		$this->data['entry_file_sitemap']    = $this->language->get('entry_file_sitemap');

		$this->data['button_save']     = $this->language->get('button_save');
		$this->data['button_cancel']   = $this->language->get('button_cancel');
		$this->data['tab_general']     = $this->language->get('tab_general');

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
		$this->data['breadcrumbs']   = array();
		$this->data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);
		$this->data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('convertor/news', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);
		$this->data['action']        = $this->url->link('convertor/news', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['cancel']        = $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL');

        $this->cont('agooa/adminmenu');
        $this->data['agoo_menu'] = $this->controller_agooa_adminmenu->index();


		if (!isset($this->data['ascp_settings_sitemap']['google_sitemap_blog_file_sitemap']) || $this->data['ascp_settings_sitemap']['google_sitemap_blog_file_sitemap']=='') {
			$this->data['ascp_settings_sitemap']['google_sitemap_blog_file_sitemap'] = 'sitemap.xml';
		}


		$this->load->model('catalog/blog');
		$this->data['categories'] = $this->model_catalog_blog->getCategories(0);


		$this->template          = 'convertor/news.tpl';
		$this->children          = array(
			'common/header',
			'common/footer'
		);
		$this->data['registry']  = $this->registry;
		$this->data['language']  = $this->language;
		$this->data['config']    = $this->config;
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


	private function convert()
	{


		$all_news = $this->loadAllNews();

		foreach ($all_news as $news_id) {

			$news = $this->loadNews($news_id);

			if (!$this->checkRecord($news)) {
				$this->addRecord($news);
			}
		}

	}


	private function loadAllNews()
	{
         $all_news = array();
         $query = $this->db->query("SELECT news_id FROM " . DB_PREFIX . "news");
         foreach ($query->rows as $num => $news) {
          $all_news[$news['news_id']] = $news['news_id'];
         }

		return $all_news;

	}

	private function loadNews($news_id)
	{

        if (file_exists(DIR_APPLICATION.'model/sale/customer_group.php')) {
        	$this->load->model('sale/customer_group');
			$model_customer = 'model_sale_customer_group';
		} else {
			$this->load->model('customer/customer_group');
			$model_customer = 'model_customer_customer_group';
		}
		$this->data['customer_groups'] = $this->$model_customer->getCustomerGroups();

	    array_push($this->data['customer_groups'], array( 'customer_group_id' => -1 ));
	    array_push($this->data['customer_groups'], array( 'customer_group_id' => -2 ));
	    array_push($this->data['customer_groups'], array( 'customer_group_id' => -3 ));


      $query = $this->db->query("SELECT *,
      (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'news_id=" . (int)$news_id . "') AS keyword
      FROM " . DB_PREFIX . "news n
      LEFT JOIN " . DB_PREFIX . "news_description nd ON (n.news_id = nd.news_id)
      WHERE
      n.news_id = '".$news_id."'
      ");


      foreach ($query->rows as $num => $news) {
	          $my_news['record_description'] [$news['language_id']]['name'] = $news['title'];
	          $my_news['record_description'] [$news['language_id']]['meta_description'] = $news['meta_description'];
	          $my_news['record_description'] [$news['language_id']]['meta_keyword'] = $news['meta_keyword'];
	          $my_news['record_description'] [$news['language_id']]['description'] = $news['description'];

	          if ($news['language_id'] == $this->config->get('config_language_id')) {
	          	$my_news['keyword'][$news['language_id']] = $news['keyword'];
	          } else {
	          	$my_news['keyword'][$news['language_id']] = '';
	          }


              $my_news['image']= $news['image'];
              $my_news['viewed']= $news['viewed'];

              $my_news['status']= $news['status'];
              $my_news['date_available']= $news['date_added'].'  00:00:00';
              $my_news['date_end'] = '2030-11-11  00:00:00';
              $my_news['index_page'] = Array(0 => 'index', 1 => 'follow');

              $my_news['author'] = '';
			  $my_news['customer_id'] = 0;
			  $my_news['sort_order'] = '';
			  $my_news['comment'] = Array(
								            'status' => 0,
								            'status_reg' => 0,
								            'status_now' => 1,
								            'rating' => 1,
								            'signer' => 1,
								            'order' => 'sort',
								            'order_ad' => 'desc',
								            'rating_num' => ''
								        );

			$my_news['blog_main'] = $this->blog_id;
   			$my_news['record_blog'] = Array(
										      1 => $this->blog_id
                                            );

			foreach ($this->data['customer_groups'] as $number =>  $c_g) {
				$my_news['customer_groups_record'][$number] = $c_g['customer_group_id'];
	        }

      }

     $this->load->model('catalog/news');
	 $this->data['news_store'] = $this->model_catalog_news->getNewsStores($news_id);
	 foreach ($this->data['news_store'] as $number =>  $n_s) {
		$my_news['record_store'][$number] = $n_s['store_id'];
     }

     $my_news['news_id'] =  (int)$news_id;

	  return $my_news;
	}

	private function checkRecord($news)
	{
        $flag = false;


		foreach ($news['record_description'] as $language_id => $optional) {

			$sql= "
			SELECT DISTINCT * FROM " . DB_PREFIX . "record p
			LEFT JOIN " . DB_PREFIX . "record_description pd ON (p.record_id = pd.record_id)
			WHERE
			LCASE(pd.name) LIKE '" . $this->db->escape(utf8_strtolower($optional['name'])) . "'
			AND
			pd.language_id = '" . (int)$language_id . "'";


			$query = $this->db->query($sql);

			if ($query->row) {

				$flag = true;
				return $flag;
			}

	    }

		return $flag;
	}

	private function addRecord($news)
	{
      $this->load->model('catalog/record');
      $this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'news_id=" . (int)$news['news_id'] . "'");
      $record_id =  $this->model_catalog_record->addRecord($news);
	  return $record_id;
	}

	private function validate()
	{
		if (!$this->user->hasPermission('modify', 'module/blog')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	public function convert_news() {

		$this->load->language('feed/google_sitemap_blog');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate() && $this->request->post['category_news_id']!='') {
            $html = '';
	     	$category_news_id = $this->request->post['category_news_id'];

			if ($category_news_id) {



			} else {
       	    	$html = $this->language->get('error_create_file');
			}

	    } else {
	    	$html = $this->language->get('error_permission');
	    }

   	    $this->response->setOutput($html);

	}

/***************************************/
	public function cont($cont)
	{
		$file  = DIR_CATALOG . 'controller/' . $cont . '.php';
		if (file_exists($file)) {
     		$this->cont_loading($cont, $file);
     		return true;
		} else {
			$file  = DIR_APPLICATION . 'controller/' . $cont . '.php';
            if (file_exists($file)) {
             	$this->cont_loading($cont, $file);
             	return true;
            } else {
				trigger_error('Error: Could not load controller ' . $cont . '!');
            	return false;
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
require_once(DIR_SYSTEM . 'helper/seocmsprofunc.php');