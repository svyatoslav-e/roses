<?php
/* All rights reserved belong to the module, the module developers http://opencartadmin.com */
// http://opencartadmin.com © 2011-2016 All Rights Reserved
// Distribution, without the author's consent is prohibited
// Commercial license
class ControllerConvertorInformation extends Controller
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

		$this->load->language('convertor/information');

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
		$this->data['url_convertor']     = $this->url->link('convertor/information', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_convert_information'] = $this->url->link('convertor/information/convert_information', 'token=' . $this->session->data['token'], 'SSL');

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
            $this->blog_id = $this->request->post['category_information'];
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
			'href' => $this->url->link('convertor/information', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);
		$this->data['action']        = $this->url->link('convertor/information', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['cancel']        = $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL');

        $this->cont('agooa/adminmenu');
        $this->data['agoo_menu'] = $this->controller_agooa_adminmenu->index();


		if (!isset($this->data['ascp_settings_sitemap']['google_sitemap_blog_file_sitemap']) || $this->data['ascp_settings_sitemap']['google_sitemap_blog_file_sitemap']=='') {
			$this->data['ascp_settings_sitemap']['google_sitemap_blog_file_sitemap'] = 'sitemap.xml';
		}


		$this->load->model('catalog/blog');
		$this->data['categories'] = $this->model_catalog_blog->getCategories(0);


		$this->template          = 'convertor/information.tpl';
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


		$all_information = $this->loadAllinformation();

		foreach ($all_information as $information_id) {

			$information = $this->loadinformation($information_id);

			if (!$this->checkRecord($information)) {
				$this->addRecord($information);
			}
		}

	}


	private function loadAllinformation()
	{
         $all_information = array();
         $query = $this->db->query("SELECT information_id FROM " . DB_PREFIX . "information");
         foreach ($query->rows as $num => $information) {
          $all_information[$information['information_id']] = $information['information_id'];
         }

		return $all_information;

	}

	private function loadinformation($information_id)
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
      (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'information_id=" . (int)$information_id . "') AS keyword
      FROM " . DB_PREFIX . "information n
      LEFT JOIN " . DB_PREFIX . "information_description nd ON (n.information_id = nd.information_id)
      WHERE
      n.information_id = '".$information_id."'
      ");


      foreach ($query->rows as $num => $information) {
	          $my_information['record_description'] [$information['language_id']]['name'] = $information['title'];
	          $my_information['record_description'] [$information['language_id']]['meta_description'] = $information['meta_description'];
	          $my_information['record_description'] [$information['language_id']]['meta_keyword'] = $information['meta_keyword'];
	          $my_information['record_description'] [$information['language_id']]['description'] = $information['description'];

	          if ($information['language_id'] == $this->config->get('config_language_id')) {
	          	$my_information['keyword'][$information['language_id']] = $information['keyword'];
	          } else {
	          	$my_information['keyword'][$information['language_id']] = '';
	          }

              if (isset($information['image']))
              $my_information['image']= $information['image'];
              else
              $information['image'] ='';

              if (isset($information['viewed']))
              $my_information['viewed']= $information['viewed'];
              else
              $information['viewed'] ='';

              $my_information['status']= $information['status'];

             // $my_information['date_available']= $information['date_added'].'  00:00:00';

              $my_information['date_end'] = '2030-11-11  00:00:00';
              $my_information['index_page'] = Array(0 => 'index', 1 => 'follow');

              $my_information['author'] = '';
			  $my_information['customer_id'] = 0;
			  $my_information['sort_order'] = '';
			  $my_information['comment'] = Array(
								            'status' => 0,
								            'status_reg' => 0,
								            'status_now' => 1,
								            'rating' => 1,
								            'signer' => 1,
								            'order' => 'sort',
								            'order_ad' => 'desc',
								            'rating_num' => ''
								        );

			$my_information['blog_main'] = $this->blog_id;
   			$my_information['record_blog'] = Array(
										      1 => $this->blog_id
                                            );

			foreach ($this->data['customer_groups'] as $number =>  $c_g) {
				$my_information['customer_groups_record'][$number] = $c_g['customer_group_id'];
	        }

      }

     $this->load->model('catalog/information');

	 $this->data['information_store'] = $this->getNewsStores($information_id);

	 foreach ($this->data['information_store'] as $number =>  $n_s) {
		$my_information['record_store'][$number] = $n_s['store_id'];
     }

     $my_information['information_id'] =  (int)$information_id;

	  return $my_information;
	}

	public function getNewsStores($news_id) {
		$newspage_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "information_to_store WHERE information_id = '" . (int)$news_id . "'");

		foreach ($query->rows as $result) {
			$newspage_store_data[] = $result['store_id'];
		}

		return $newspage_store_data;
	}


	private function checkRecord($information)
	{
        $flag = false;


		foreach ($information['record_description'] as $language_id => $optional) {

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

	private function addRecord($information)
	{
      $this->load->model('catalog/record');
      $this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'information_id=" . (int)$information['information_id'] . "'");
      $record_id =  $this->model_catalog_record->addRecord($information);
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

	public function convert_information() {

		$this->load->language('feed/google_sitemap_blog');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate() && $this->request->post['category_information_id']!='') {
            $html = '';
	     	$category_information_id = $this->request->post['category_information_id'];

			if ($category_information_id) {



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