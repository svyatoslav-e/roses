<?php
/* All rights reserved belong to the module, the module developers http://opencartadmin.com */
// http://opencartadmin.com © 2011-2016 All Rights Reserved
// Distribution, without the author's consent is prohibited
// Commercial license
class ControllerCatalogRecord extends Controller
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
		$this->language->load('seocms/catalog/record');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->data['tab_general']      = $this->language->get('tab_general');
		$this->data['tab_list']         = $this->language->get('tab_list');
		$this->data['url_modules_text'] = $this->language->get('url_modules_text');
		$this->load->model('catalog/record');
        $this->cont('agooa/adminmenu');
        $this->data['agoo_menu'] = $this->controller_agooa_adminmenu->index();
        if ($this->config->get('asc_cnt_cnt')!='fec00258b41bb6fb92a7feb8ccb0bed9') {
        $this->model_setting_setting->editSetting('ascp_version_model', Array('ascp_version_model'=>$this->language->get('blog_version_model')." &copy;"));
        }
		$this->getList();
	}
	public function insert()
	{
		$this->config->set("blog_work", false);
		$this->cache->delete('blog');
		 $this->config->set("blog_work", true);

        $this->cache->delete('blog');
		$this->language->load('seocms/catalog/record');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('catalog/record');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

			$this->model_catalog_record->addRecord($this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
			$url                            = '';
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}
			if (isset($this->request->get['filter_blog'])) {
				$url .= '&filter_blog=' . $this->request->get['filter_blog'];
			}
			if (isset($this->request->get['filter_price'])) {
				$url .= '&filter_price=' . $this->request->get['filter_price'];
			}
			if (isset($this->request->get['filter_quantity'])) {
				$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
			}
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
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
			if (!isset($this->request->post['button_apply']) || !$this->request->post['button_apply']) {
				if (SC_VERSION < 20) {
					$this->redirect($this->url->link('catalog/record', 'token=' . $this->session->data['token'], 'SSL'));
				} else {
					$this->response->redirect($this->url->link('catalog/record', 'token=' . $this->session->data['token'], 'SSL'));
				}
			}
		}
		$this->getForm();
	}
	public function update()
	{
		$this->config->set("blog_work", false);
		$this->cache->delete('blog');

		 $this->config->set("blog_work", true);

        $this->cache->delete('blog');
		$this->language->load('seocms/catalog/record');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('catalog/record');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

			$this->model_catalog_record->editRecord($this->request->get['record_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');
			$url                            = '';
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}
			if (isset($this->request->get['filter_blog'])) {
				$url .= '&filter_blog=' . $this->request->get['filter_blog'];
			}
			if (isset($this->request->get['filter_price'])) {
				$url .= '&filter_price=' . $this->request->get['filter_price'];
			}
			if (isset($this->request->get['filter_quantity'])) {
				$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
			}
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
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
			if (!isset($this->request->post['button_apply']) || !$this->request->post['button_apply']) {
				if (SC_VERSION < 20) {
					$this->redirect($this->url->link('catalog/record', 'token=' . $this->session->data['token'], 'SSL'));
				} else {
					$this->response->redirect($this->url->link('catalog/record', 'token=' . $this->session->data['token'], 'SSL'));
				}
			}
		}

		$this->getForm();
	}
	public function delete()
	{
		$this->config->set("blog_work", false);
		$this->cache->delete('blog');

		 $this->config->set("blog_work", true);

		$this->cache->delete('blog');
		$this->language->load('seocms/catalog/record');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('catalog/record');
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $record_id) {
				$this->model_catalog_record->deleteRecord($record_id);
			}
			$this->session->data['success'] = $this->language->get('text_success');
			$url                            = '';
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}
			if (isset($this->request->get['filter_blog'])) {
				$url .= '&filter_blog=' . $this->request->get['filter_blog'];
			}
			if (isset($this->request->get['filter_price'])) {
				$url .= '&filter_price=' . $this->request->get['filter_price'];
			}
			if (isset($this->request->get['filter_quantity'])) {
				$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
			}
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
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
			if (SC_VERSION < 20) {
				$this->redirect($this->url->link('catalog/record', 'token=' . $this->session->data['token'], 'SSL'));
			} else {
				$this->response->redirect($this->url->link('catalog/record', 'token=' . $this->session->data['token'], 'SSL'));
			}
		}
		$this->getList();
	}

	public function copy()
	{
		 $this->config->set("blog_work", true);

		$this->language->load('seocms/catalog/record');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('catalog/record');
		if (isset($this->request->post['selected']) && $this->validateCopy()) {
			foreach ($this->request->post['selected'] as $record_id) {
				$this->model_catalog_record->copyRecord($record_id);
			}
			$this->session->data['success'] = $this->language->get('text_success');
			$url                            = '';
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}
			if (isset($this->request->get['filter_blog'])) {
				$url .= '&filter_blog=' . $this->request->get['filter_blog'];
			}
			if (isset($this->request->get['filter_price'])) {
				$url .= '&filter_price=' . $this->request->get['filter_price'];
			}
			if (isset($this->request->get['filter_quantity'])) {
				$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
			}
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
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
			if (SC_VERSION < 20) {
				$this->redirect($this->url->link('catalog/record', 'token=' . $this->session->data['token'], 'SSL'));
			} else {
				$this->response->redirect($this->url->link('catalog/record', 'token=' . $this->session->data['token'], 'SSL'));
			}
		}
		$this->getList();
	}

	private function getList()
	{
		if (file_exists(DIR_APPLICATION . 'view/stylesheet/seocmspro.css')) {
			$this->document->addStyle('view/stylesheet/seocmspro.css');
		}
		if (file_exists(DIR_APPLICATION . 'view/javascript/blog/seocmspro.js')) {
			$this->document->addScript('view/javascript/blog/seocmspro.js');
		}
		$this->data['url_modules']   = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_options']   = $this->url->link('module/blog', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_schemes']   = $this->url->link('module/blog/schemes', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_widgets']   = $this->url->link('module/blog/widgets', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_back']      = $this->url->link('module/blog', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_back_text'] = $this->language->get('url_back_text');
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = null;
		}
		if (isset($this->request->get['filter_blog'])) {
			$filter_blog = $this->request->get['filter_blog'];
		} else {
			$filter_blog = null;
		}
		if (isset($this->request->get['filter_price'])) {
			$filter_price = $this->request->get['filter_price'];
		} else {
			$filter_price = null;
		}
		if (isset($this->request->get['filter_quantity'])) {
			$filter_quantity = $this->request->get['filter_quantity'];
		} else {
			$filter_quantity = null;
		}
		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = null;
		}
		if (isset($this->request->get['filter_date'])) {
			$filter_date = $this->request->get['filter_date'];
		} else {
			$filter_date = null;
		}
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'p.record_id';
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
		if (isset($this->request->get['filter_blog'])) {
			$url .= '&filter_blog=' . $this->request->get['filter_blog'];
		}
		if (isset($this->request->get['filter_price'])) {
			$url .= '&filter_price=' . $this->request->get['filter_price'];
		}
		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
		}
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}
		if (isset($this->request->get['filter_date'])) {
			$url .= '&filter_date=' . $this->request->get['filter_date'];
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
			'href' => $this->url->link('catalog/record', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);
		$this->data['insert']        = $this->url->link('catalog/record/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['copy']          = $this->url->link('catalog/record/copy', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete']        = $this->url->link('catalog/record/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['records']       = array();

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
			'filter_blog' => $filter_blog,
			'filter_price' => $filter_price,
			'filter_quantity' => $filter_quantity,
			'filter_status' => $filter_status,
			'filter_date' => $filter_date,
			'sort' => $sort,
			'order' => $order,
			'start' => ($page - 1) * $config_limit_admin,
			'limit' => $config_limit_admin
		);
		$this->load->model('tool/image');

		$no_image = 'no_image.jpg';

		if (file_exists(DIR_IMAGE . 'no_image.jpg')) {
			$no_image = 'no_image.jpg';
		}
		if (file_exists(DIR_IMAGE . 'no_image.png')) {
			$no_image = 'no_image.png';
		}
		$record_total = $this->model_catalog_record->getTotalRecords($data);
		$results      = $this->model_catalog_record->getRecords($data);
		foreach ($results as $result) {
			$action   = array();
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('catalog/record/update', 'token=' . $this->session->data['token'] . '&record_id=' . $result['record_id'] . $url, 'SSL')
			);
			if ($result['image'] && file_exists(DIR_IMAGE . $result['image'])) {
				$image = $this->model_tool_image->resize($result['image'], 40, 40);
			} else {
				$image = $this->model_tool_image->resize($no_image, 40, 40);
			}
			$special = false;
			if (!isset($result['comment']) || $result['comment'] == '') {
				$result['comment']['status']     = 1;
				$result['comment']['status_reg'] = 0;
				$result['comment']['status_now'] = 0;
				$result['comment']['rating']     = 0;
				$result['comment']['rating_num'] = '';
			} else {
				$result['comment'] = unserialize($result['comment']);
			}
			if (!isset($result['comment']) || !is_array($result['comment'])) {
				$result['comment'] = array();
			}
			if (!isset($result['comment']['status'])) {
				$result['comment']['status'] = '0';
			}
			if (!isset($result['comment']['status_reg'])) {
				$result['comment']['status_reg'] = '0';
			}
			if (!isset($result['comment']['status_now'])) {
				$result['comment']['status_now'] = '0';
			}
			if (!isset($result['comment']['rating'])) {
				$result['comment']['rating'] = '0';
			}

			$blog_main = $this->model_catalog_record->getMainBlog($result['record_id']);
             if (!isset($blog_main['name'])) $blog_main['name'] = '';

			$this->data['records'][] = array(
				'record_id' => $result['record_id'],
				'name' => $result['name'],
				'blog' => $blog_main['name'],
				'date_added' => $result['date_added'],
				'image' => $image,
				'status' => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
				'comment_status' => ($result['comment']['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
				'comment_status_reg' => ($result['comment']['status_reg'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
				'comment_status_now' => ($result['comment']['status_now'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
				'comment_rating' => ($result['comment']['rating'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
				'comment' => $result['comment'],
				'selected' => isset($this->request->post['selected']) && in_array($result['record_id'], $this->request->post['selected']),
				'action' => $action
			);
		}
		$this->data['heading_title']      = $this->language->get('heading_title');
		$this->data['text_enabled']       = $this->language->get('text_enabled');
		$this->data['text_disabled']      = $this->language->get('text_disabled');
		$this->data['text_no_results']    = $this->language->get('text_no_results');
		$this->data['text_image_manager'] = $this->language->get('text_image_manager');
		$this->data['column_image']       = $this->language->get('column_image');
		$this->data['column_name']        = $this->language->get('column_name');
		$this->data['column_blog']        = $this->language->get('column_blog');
		$this->data['column_price']       = $this->language->get('column_price');
		$this->data['column_quantity']    = $this->language->get('column_quantity');
		$this->data['column_status']      = $this->language->get('column_status');
		$this->data['column_date']        = $this->language->get('column_date');
		$this->data['column_action']      = $this->language->get('column_action');
		$this->data['button_copy']        = $this->language->get('button_copy');
		$this->data['button_insert']      = $this->language->get('button_insert');
		$this->data['button_delete']      = $this->language->get('button_delete');
		$this->data['button_filter']      = $this->language->get('button_filter');
		$this->data['url_blog']           = $this->url->link('catalog/blog', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_record']         = $this->url->link('catalog/record', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_comment']        = $this->url->link('catalog/comment', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_blog_text']      = $this->language->get('url_blog_text');
		$this->data['url_record_text']    = $this->language->get('url_record_text');
		$this->data['url_comment_text']   = $this->language->get('url_comment_text');
		$this->data['url_create_text']    = $this->language->get('url_create_text');
		$this->data['token']              = $this->session->data['token'];
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
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}
		if (isset($this->request->get['filter_blog'])) {
			$url .= '&filter_blog=' . $this->request->get['filter_blog'];
		}
		if (isset($this->request->get['filter_price'])) {
			$url .= '&filter_price=' . $this->request->get['filter_price'];
		}
		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
		}
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}
		if (isset($this->request->get['filter_date'])) {
			$url .= '&filter_date=' . $this->request->get['filter_date'];
		}
		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		$this->data['sort_name']     = $this->url->link('catalog/record', 'token=' . $this->session->data['token'] . '&sort=pd.name' . $url, 'SSL');
		$this->data['sort_blog']     = $this->url->link('catalog/record', 'token=' . $this->session->data['token'] . '&sort=blog_name' . $url, 'SSL');
		$this->data['sort_price']    = $this->url->link('catalog/record', 'token=' . $this->session->data['token'] . '&sort=p.price' . $url, 'SSL');
		$this->data['sort_quantity'] = $this->url->link('catalog/record', 'token=' . $this->session->data['token'] . '&sort=p.quantity' . $url, 'SSL');
		$this->data['sort_status']   = $this->url->link('catalog/record', 'token=' . $this->session->data['token'] . '&sort=p.status' . $url, 'SSL');
		$this->data['sort_date']     = $this->url->link('catalog/record', 'token=' . $this->session->data['token'] . '&sort=p.date_added' . $url, 'SSL');
		$this->data['sort_order']    = $this->url->link('catalog/record', 'token=' . $this->session->data['token'] . '&sort=p.sort_order' . $url, 'SSL');
		$url                         = '';
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}
		if (isset($this->request->get['filter_blog'])) {
			$url .= '&filter_blog=' . $this->request->get['filter_blog'];
		}
		if (isset($this->request->get['filter_price'])) {
			$url .= '&filter_price=' . $this->request->get['filter_price'];
		}
		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
		}
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}
		if (isset($this->request->get['filter_date'])) {
			$url .= '&filter_date=' . $this->request->get['filter_date'];
		}
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination                    = new Pagination();
		$pagination->total             = $record_total;
		$pagination->page              = $page;
		$pagination->limit             = $config_limit_admin;
		$pagination->text              = $this->language->get('text_pagination');
		$pagination->url               = $this->url->link('catalog/record', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
		$this->data['pagination']      = $pagination->render();
		$this->data['filter_name']     = $filter_name;
		$this->data['filter_blog']     = $filter_blog;
		$this->data['filter_price']    = $filter_price;
		$this->data['filter_quantity'] = $filter_quantity;
		$this->data['filter_status']   = $filter_status;
		$this->data['sort']            = $sort;
		$this->data['order']           = $order;
		$this->data['this']            = $this;
		$this->template                = 'catalog/record_list.tpl';
		$this->children                = array(
			'common/header',
			'common/footer'
		);
		$this->data['registry']        = $this->registry;
		$this->data['language']        = $this->language;
		$this->data['config']          = $this->config;
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


//**********************************************************************************************************************************************************************************

	private function get_access($data)
	{
		 $this->config->set("blog_work", true);

		$this->data = $data;


        if (file_exists(DIR_APPLICATION.'model/sale/customer_group.php')) {
        	$this->load->model('sale/customer_group');
			$model_customer = 'model_sale_customer_group';
		} else {
			$this->load->model('customer/customer_group');
			$model_customer = 'model_customer_customer_group';
		}
		$this->data['customer_groups'] = $this->$model_customer->getCustomerGroups();

	    array_push($this->data['customer_groups'], array( 'customer_group_id' => -1,  'name' => $this->language->get('text_group_reg') ));
	    array_push($this->data['customer_groups'], array( 'customer_group_id' => -2,  'name' => $this->language->get('text_group_order') ));
	    array_push($this->data['customer_groups'], array( 'customer_group_id' => -3,  'name' => $this->language->get('text_group_order_this')));

	    $this->data['customer_groups_record'] = $this->data['customer_groups'];

	    if ($this->data['record_id']) {
		    $this->data['record_access'] = $this->model_catalog_record->getRecordAccess($this->data['record_id']);
	    }

	    return $this->data;

	}
//**********************************************************************************************************************************************************************************



	private function getForm()
	{
		$this->config->set("blog_work", true);

		if (!isset($this->request->get['record_id'])) {
			$this->data['record_id'] = false;
		} else {
			$this->data['record_id'] = $this->request->get['record_id'];
		}

		$this->data['ascp_settings'] = $this->config->get('ascp_settings');

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

        $this->cont('agooa/adminmenu');
        $this->data['agoo_menu'] = $this->controller_agooa_adminmenu->index();

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

		if (SC_VERSION < 20) {
				$this->document->addStyle('view/javascript/seocms/bootstrap/css/bootstrap.css');
				//$this->document->addScript('view/javascript/seocms/bootstrap/jquery-2.1.1.min.js');
				//$this->document->addScript('view/javascript/seocms/bootstrap/js/bootstrap.min.js');
		}


        if (SC_VERSION > 10) {
			$this->data['upload_images_url'] = $this->url->link('catalog/record/upload_images', 'record_id='.$this->data['record_id'].'&token=' . $this->session->data['token'], 'SSL');
			$this->data['upload_images_url'] = str_replace('&amp;', '&', $this->data['upload_images_url']);
			$this->data['upload_images_lang'] = substr(strtolower($this->config->get('config_admin_language')), 0,2);

			if (!isset($this->data['ascp_settings']['multifile_ext'])) {
				$this->data['ascp_settings']['multifile_ext'] = 'jpg,png,gif';
			}

            $array_ext = explode(',', $this->data['ascp_settings']['multifile_ext']);
			// 'jpg', 'png','gif'
			$array_ext = array_map(function($person) { return "'".trim($person)."'"; }, $array_ext);
			$str_ext = implode($array_ext,',');

			if (!isset($this->data['ascp_settings']['multifile_num'])) {
				$this->data['ascp_settings']['multifile_num'] = '100';
			}

			if (!isset($this->data['ascp_settings']['multifile_size'])) {
				$this->data['ascp_settings']['multifile_size'] = '9000';
			}

            $this->data['upload_images_ext'] = $str_ext;
            $this->data['upload_images_num'] = (int)$this->data['ascp_settings']['multifile_num'];
            $this->data['upload_images_size'] = $this->data['ascp_settings']['multifile_size'];

			if (file_exists(DIR_APPLICATION . 'view/javascript/seocms/images/js/fileinput.min.js')) {
				$this->document->addScript('view/javascript/seocms/images/js/fileinput.min.js');
			}
			if (file_exists(DIR_APPLICATION . 'view/javascript/seocms/images/js/fileinput_locale_'.$this->data['upload_images_lang'].'.js')) {
				$this->document->addScript('view/javascript/seocms/images/js/fileinput_locale_'.$this->data['upload_images_lang'].'.js');
			}
			if (file_exists(DIR_APPLICATION . 'view/javascript/seocms/images/css/fileinput.min.css')) {
				$this->document->addStyle('view/javascript/seocms/images/css/fileinput.min.css');
			}
        }

		if (file_exists(DIR_IMAGE . 'no_image.jpg')) {
			$no_image = 'no_image.jpg';
		}
		if (file_exists(DIR_IMAGE . 'no_image.png')) {
			$no_image = 'no_image.png';
		}
		$this->language->load('module/blog');
		$this->language->load('seocms/catalog/blog');
		 $this->config->set("blog_work", true);


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
		$this->data['blog_version']    = $this->data['blog_version'] . ' ' . $this->data['blog_version_model'];
		$this->data['url_modules']     = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_options']     = $this->url->link('module/blog', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_schemes']     = $this->url->link('module/blog/schemes', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_widgets']     = $this->url->link('module/blog/widgets', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['config_language'] = $this->config->get('config_language');
		$this->language->load('seocms/catalog/record');
		$this->data['heading_title']            = $this->language->get('heading_title');
		$this->data['text_enabled']             = $this->language->get('text_enabled');
		$this->data['text_disabled']            = $this->language->get('text_disabled');
		$this->data['text_none']                = $this->language->get('text_none');
		$this->data['text_yes']                 = $this->language->get('text_yes');
		$this->data['text_no']                  = $this->language->get('text_no');
		$this->data['text_select_all']          = $this->language->get('text_select_all');
		$this->data['text_unselect_all']        = $this->language->get('text_unselect_all');
		$this->data['text_blog_plus']           = $this->language->get('text_blog_plus');
		$this->data['text_blog_minus']          = $this->language->get('text_blog_minus');
		$this->data['text_default']             = $this->language->get('text_default');
		$this->data['text_image_manager']       = $this->language->get('text_image_manager');
		$this->data['text_browse']              = $this->language->get('text_browse');
		$this->data['text_clear']               = $this->language->get('text_clear');
		$this->data['text_option']              = $this->language->get('text_option');
		$this->data['text_option_value']        = $this->language->get('text_option_value');
		$this->data['text_select']              = $this->language->get('text_select');
		$this->data['text_none']                = $this->language->get('text_none');
		$this->data['text_percent']             = $this->language->get('text_percent');
		$this->data['text_amount']              = $this->language->get('text_amount');
		$this->data['url_back']                 = $this->url->link('module/blog', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_comment']              = $this->url->link('catalog/comment', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_back_text']            = $this->language->get('url_back_text');
		$this->data['url_blog']                 = $this->url->link('catalog/blog', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_record']               = $this->url->link('catalog/record', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_comment']              = $this->url->link('catalog/comment', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_blog_text']            = $this->language->get('url_blog_text');
		$this->data['url_record_text']          = $this->language->get('url_record_text');
		$this->data['url_comment_text']         = $this->language->get('url_comment_text');
		$this->data['url_create_text']          = $this->language->get('url_create_text');
		$this->data['entry_name']               = $this->language->get('entry_name');
		$this->data['entry_meta_description']   = $this->language->get('entry_meta_description');
		$this->data['entry_meta_keyword']       = $this->language->get('entry_meta_keyword');
		$this->data['entry_description']        = $this->language->get('entry_description');
		$this->data['entry_sdescription']       = $this->language->get('entry_sdescription');
		$this->data['entry_store']              = $this->language->get('entry_store');
		$this->data['entry_keyword']            = $this->language->get('entry_keyword');
		$this->data['entry_model']              = $this->language->get('entry_model');
		$this->data['entry_date_available']     = $this->language->get('entry_date_available');
		$this->data['entry_comment_status_reg'] = $this->language->get('entry_comment_status_reg');
		$this->data['entry_comment_status_now'] = $this->language->get('entry_comment_status_now');
		$this->data['entry_option_points']      = $this->language->get('entry_option_points');
		$this->data['entry_subtract']           = $this->language->get('entry_subtract');
		$this->data['entry_weight_class']       = $this->language->get('entry_weight_class');
		$this->data['entry_weight']             = $this->language->get('entry_weight');
		$this->data['entry_dimension']          = $this->language->get('entry_dimension');
		$this->data['entry_length']             = $this->language->get('entry_length');
		$this->data['entry_image']              = $this->language->get('entry_image');
		$this->data['entry_download']           = $this->language->get('entry_download');
		$this->data['entry_blog']               = $this->language->get('entry_blog');
		$this->data['entry_related']            = $this->language->get('entry_related');
		$this->data['entry_customer_group_v']   = $this->language->get('entry_customer_group_v');
		$this->data['entry_customer_group']     = $this->language->get('entry_customer_group');
		$this->data['entry_attribute']          = $this->language->get('entry_attribute');
		$this->data['entry_text']               = $this->language->get('entry_text');
		$this->data['entry_option']             = $this->language->get('entry_option');
		$this->data['entry_option_value']       = $this->language->get('entry_option_value');
		$this->data['entry_required']           = $this->language->get('entry_required');
		$this->data['entry_sort_order']         = $this->language->get('entry_sort_order');
		$this->data['entry_status']             = $this->language->get('entry_status');
		$this->data['entry_comment_status']     = $this->language->get('entry_comment_status');
		$this->data['entry_customer_group']     = $this->language->get('entry_customer_group');
		$this->data['entry_date_start']         = $this->language->get('entry_date_start');
		$this->data['entry_date_end']           = $this->language->get('entry_date_end');
		$this->data['entry_priority']           = $this->language->get('entry_priority');
		$this->data['entry_tag']                = $this->language->get('entry_tag');
		$this->data['entry_customer_group']     = $this->language->get('entry_customer_group');
		$this->data['entry_layout']             = $this->language->get('entry_layout');
		$this->data['button_save']              = $this->language->get('button_save');
		$this->data['button_cancel']            = $this->language->get('button_cancel');
		$this->data['button_add_attribute']     = $this->language->get('button_add_attribute');
		$this->data['button_add_option']        = $this->language->get('button_add_option');
		$this->data['button_add_option_value']  = $this->language->get('button_add_option_value');
		$this->data['button_add_image']         = $this->language->get('button_add_image');
		$this->data['button_apply']               = $this->language->get('button_apply');
		$this->data['button_remove']            = $this->language->get('button_remove');
		$this->data['tab_general']              = $this->language->get('tab_general');
		$this->data['tab_data']                 = $this->language->get('tab_data');
		$this->data['tab_attribute']            = $this->language->get('tab_attribute');
		$this->data['tab_option']               = $this->language->get('tab_option');
		$this->data['tab_image']                = $this->language->get('tab_image');
		$this->data['tab_links']                = $this->language->get('tab_links');
		$this->data['tab_design']               = $this->language->get('tab_design');

		$this->data['entry_author']         = $this->language->get('entry_author');
		$this->data['entry_author_id']      = $this->language->get('entry_author_id');


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

		if (isset($this->error['keyword'])) {
			$this->data['error_keyword'] = $this->error['keyword'];
		} else {
			$this->data['error_keyword'] = array();
		}


		if (isset($this->error['author'])) {
			$this->data['error_author'] = $this->error['author'];
		} else {
			$this->data['error_author'] = '';
		}

		if (isset($this->error['error_record_tags_product'])) {
			$this->data['error_record_tags_product'] = $this->error['error_record_tags_product'];
		} else {
			$this->data['error_record_tags_product'] = '';
		}


		if (isset($this->error['meta_description'])) {
			$this->data['error_meta_description'] = $this->error['meta_description'];
		} else {
			$this->data['error_meta_description'] = array();
		}
		if (isset($this->error['description'])) {
			$this->data['error_description'] = $this->error['description'];
		} else {
			$this->data['error_description'] = array();
		}
		if (isset($this->error['sdescription'])) {
			$this->data['error_sdescription'] = $this->error['sdescription'];
		} else {
			$this->data['error_sdescription'] = array();
		}
		if (isset($this->error['model'])) {
			$this->data['error_model'] = $this->error['model'];
		} else {
			$this->data['error_model'] = '';
		}
		if (isset($this->error['date_available'])) {
			$this->data['error_date_available'] = $this->error['date_available'];
		} else {
			$this->data['error_date_available'] = '';
		}
		if (isset($this->error['date_end'])) {
			$this->data['error_date_end'] = $this->error['date_end'];
		} else {
			$this->data['error_date_end'] = '';
		}
		$url = '';
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}
		if (isset($this->request->get['filter_blog'])) {
			$url .= '&filter_blog=' . $this->request->get['filter_blog'];
		}
		if (isset($this->request->get['filter_price'])) {
			$url .= '&filter_price=' . $this->request->get['filter_price'];
		}
		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
		}
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}
		if (isset($this->request->get['filter_date'])) {
			$url .= '&filter_date=' . $this->request->get['filter_date'];
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
			'href' => $this->url->link('catalog/record', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);
		if (!isset($this->request->get['record_id'])) {
			$this->data['action'] = $this->url->link('catalog/record/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('catalog/record/update', 'token=' . $this->session->data['token'] . '&record_id=' . $this->request->get['record_id'] . $url, 'SSL');
		}


		$this->data = $this->get_access($this->data);

		$this->data['cancel'] = $this->url->link('catalog/record', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['token']  = $this->session->data['token'];
        $this->data['keyword'] = '';
        $record_info = array();
		if (isset($this->request->get['record_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$record_info           = $this->model_catalog_record->getRecord($this->request->get['record_id']);
			$this->data['keyword'] = $this->model_catalog_record->getRecordKeywords($this->request->get['record_id']);
		}

		if ((!isset($record_info) || empty($record_info)) && $this->data['record_id']) {
			$record_info           = $this->model_catalog_record->getRecord($this->data['record_id']);
		}

		if ((!isset($this->data['keyword']) || $this->data['keyword']=='') && $this->data['record_id']) {
			$this->data['keyword'] = $this->model_catalog_record->getRecordKeywords($this->data['record_id']);
		}

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

		if (isset($record_info['blog_main'])) {
			$this->data['blog_main'] = $record_info['blog_main'];
		} else {
			$this->data['blog_main'] = false;
		}

        if (isset($this->data['record_id'])) {
			$this->data['record_description'] = $this->model_catalog_record->getRecordDescriptions($this->data['record_id']);
		} else {
			$this->data['record_description'] = '';
		}

        if (isset($this->request->get['record_id'])) {
        	$this->data['record_tag'] = $this->model_catalog_record->getRecordTags($this->request->get['record_id']);
        } else {
        	$this->data['record_tag'] = '';
        }


		$this->load->model('setting/store');
		$this->data['stores'] = $this->model_setting_store->getStores();
		if (isset($this->request->post['record_store'])) {
			$this->data['record_store'] = $this->request->post['record_store'];
		} elseif (isset($this->request->get['record_id'])) {
			$this->data['record_store'] = $this->model_catalog_record->getRecordStores($this->request->get['record_id']);
		} else {
			$this->data['record_store'] = array(
				0
			);
		}
		if (isset($this->request->post['keyword'])) {
			$this->data['keyword'] = $this->request->post['keyword'];
		} elseif (!empty($this->data['keyword'])) {
			$this->data['keyword'] = $this->data['keyword'];
		} else {
			$this->data['keyword'] = '';
		}

        if (isset($this->data['ascp_settings']['tags_widget_status']) && $this->data['ascp_settings']['tags_widget_status']) {
            $this->load->model('agoo/tags/tags');
			$model_tags = 'model_agoo_tags_tags';

			if (isset($this->request->post['record_tags_product'])) {
				$this->data['record_tags_product'] = $this->request->post['record_tags_product'];
			} elseif (isset($this->request->get['record_id'])) {
				$this->data['record_tags_product'] = $this->$model_tags->getRecordTagsProduct($this->request->get['record_id']);
			} else {
				$this->data['record_tags_product'] = array();
			}

			if (isset($this->request->post['record_tags_search'])) {
				$this->data['record_tags_search'] = $this->request->post['record_tags_search'];
			} elseif (isset($this->request->get['record_id'])) {
				$this->data['record_tags_search'] = $this->$model_tags->getRecordTagSearch($this->request->get['record_id']);
			} else {
				$this->data['record_tags_search'] = array();
			}
		}

		if (isset($record_info['author'])) {
			$this->data['author'] = $record_info['author'];
		} else {
			$this->data['author'] = '';
		}

		if (isset($record_info['customer_id'])) {
			$this->data['customer_id'] = $record_info['customer_id'];
		} else {
			$this->data['customer_id'] = false;
		}


		if (isset($record_info['image'])) {
			$this->data['image'] = $record_info['image'];
		} else {
			$this->data['image'] = '';
		}

		$this->load->model('tool/image');
		if (file_exists(DIR_IMAGE . 'no_image.jpg')) {
			$no_image = 'no_image.jpg';
		}
		if (file_exists(DIR_IMAGE . 'no_image.png')) {
			$no_image = 'no_image.png';
		}
		if (!empty($record_info) && $record_info['image'] && file_exists(DIR_IMAGE . $record_info['image'])) {
			$this->data['thumb'] = $this->model_tool_image->resize($record_info['image'], 100, 100);
		} else {
			$this->data['thumb'] = $this->model_tool_image->resize($no_image, 100, 100);
		}
		if (isset($this->request->post['date_available'])) {
			$this->data['date_available'] = $this->request->post['date_available'];
		} elseif (!empty($record_info)) {
			$this->data['date_available'] = date('Y-m-d H:i:s', strtotime($record_info['date_available']));
		} else {
			$this->data['date_available'] = date('Y-m-d  H:i:s');
		}
		if (isset($this->request->post['date_end'])) {
			$this->data['date_end'] = $this->request->post['date_end'];
		} elseif (!empty($record_info) && isset($record_info['date_end'])) {
			if ($record_info['date_end'] != '0000-00-00 00:00:00') {
				$this->data['date_end'] = date('Y-m-d  H:i:s', strtotime($record_info['date_end']));
			} else {
				$this->data['date_end'] = '';
			}
		} else {
			$this->data['date_end'] = '';
		}
		if (isset($this->request->post['sort_order'])) {
			$this->data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($record_info)) {
			$this->data['sort_order'] = $record_info['sort_order'];
		} else {
			$this->data['sort_order'] = '';
		}
		if (isset($this->request->post['status'])) {
			$this->data['status'] = $this->request->post['status'];
		} else if (!empty($record_info)) {
			$this->data['status'] = $record_info['status'];
		} else {
			$this->data['status'] = 1;
		}
		if (isset($this->request->post['customer_group_id'])) {
			$this->data['customer_group_id'] = $this->request->post['customer_group_id'];
		} elseif (!empty($record_info) && isset($record_info['customer_group_id'])) {
			$this->data['customer_group_id'] = $record_info['customer_group_id'];
		} else {
			$this->data['customer_group_id'] = (int) $this->config->get('config_customer_group_id');
		}
		if (!empty($record_info)) {
			$this->data['comment'] = $record_comment = unserialize($record_info['comment']);
		}
		if (!isset($this->data['comment']) || !is_array($this->data['comment'])) {
			$this->data['comment'] = array();
		}
		if (isset($this->request->post['comment']['status'])) {
			$this->data['comment']['status'] = $this->request->post['comment']['status'];
		} else if (!empty($record_info)) {
			if (isset($record_comment['status']) && $record_info['comment'] != '')
				$this->data['comment']['status'] = $record_comment['status'];
			else
				$this->data['comment']['status'] = 1;
		} else {
			$this->data['comment']['status'] = 1;
		}

		if (isset($this->request->post['comment']['status_now'])) {
			$this->data['comment']['status_now'] = $this->request->post['comment']['status_now'];
		} else if (!empty($record_info)) {
			if (isset($record_comment['status_now']) && $record_info['comment'] != '')
				$this->data['comment']['status_now'] = $record_comment['status_now'];
			else
				$this->data['comment']['status_now'] = 1;
		} else {
			$this->data['comment']['status_now'] = 1;
		}


		if (isset($this->request->post['comment']['status_reg'])) {
			$this->data['comment']['status_reg'] = $this->request->post['comment']['status_reg'];
		} else if (!empty($record_info)) {
			if (isset($record_comment['status_reg']) && $record_info['comment'] != '')
				$this->data['comment']['status_reg'] = $record_comment['status_reg'];
			else
				$this->data['comment']['status_reg'] = 0;
		} else {
			$this->data['comment']['status_reg'] = 0;
		}
		if (isset($this->request->post['comment']['status_now'])) {
			$this->data['comment']['status_now'] = $this->request->post['comment']['status_now'];
		} else if (!empty($record_info)) {
			if (isset($record_comment['status_now']) && $record_info['comment'] != '')
				$this->data['comment']['status_now'] = $record_comment['status_now'];
			else
				$this->data['comment']['status_now'] = 0;
		} else {
			$this->data['comment']['status_now'] = 0;
		}
		if (isset($this->request->post['comment']['rating'])) {
			$this->data['comment']['rating'] = $this->request->post['comment']['rating'];
		} else if (!empty($record_info)) {
			if (isset($record_comment['rating']) && $record_info['comment'] != '')
				$this->data['comment']['rating'] = $record_comment['rating'];
			else
				$this->data['comment']['rating'] = 0;
		} else {
			$this->data['comment']['rating'] = 0;
		}
		if (isset($this->request->post['comment']['signer'])) {
			$this->data['comment']['signer'] = $this->request->post['comment']['signer'];
		} else if (!empty($record_info)) {
			if (isset($record_comment['signer']) && $record_info['comment'] != '')
				$this->data['comment']['signer'] = $record_comment['signer'];
			else
				$this->data['comment']['signer'] = 1;
		} else {
			$this->data['comment']['signer'] = 1;
		}
		if (isset($this->request->post['record_attribute'])) {
			$this->data['record_attributes'] = $this->request->post['record_attribute'];
		} elseif (isset($this->request->get['record_id'])) {
			$this->data['record_attributes'] = $this->model_catalog_record->getRecordAttributes($this->request->get['record_id']);
		} else {
			$this->data['record_attributes'] = array();
		}


        if (file_exists(DIR_APPLICATION.'model/sale/customer_group.php')) {
        	$this->load->model('sale/customer_group');
			$model_customer = 'model_sale_customer_group';
		} else {
			$this->load->model('customer/customer_group');
			$model_customer = 'model_customer_customer_group';
		}
		$this->data['customer_groups'] = $this->$model_customer->getCustomerGroups();

		if (isset($this->request->post['record_image'])) {
			$record_images = $this->request->post['record_image'];
		} elseif (isset($this->request->get['record_id'])) {
			$record_images = $this->model_catalog_record->getRecordImages($this->request->get['record_id']);
		} else {
			$record_images = array();
		}

		if (isset($this->request->post['index_page'])) {
			$this->data['index_page'] = $this->request->post['index_page'];
		} elseif (!empty($record_info)) {
			if (isset($record_info['index_page'])) {
				$this->data['index_page'] =  explode(',',$record_info['index_page']);
			} else {
				$this->data['index_page'][] = 'index';
				$this->data['index_page'][] = 'follow';
			}

		} else {
			$this->data['index_page'][] = 'index';
			$this->data['index_page'][] = 'follow';
		}



		if (!function_exists('commd')) {
			function commd($a, $b)
			{
				if ($a['sort_order'] == '')
					$a['sort_order'] = 1000;
				if ($b['sort_order'] == '')
					$b['sort_order'] = 1000;
				if ($a['sort_order'] > $b['sort_order'])
					return 1;
				else
					return -1;
			}
		}
		if (isset($record_images) && is_array($record_images)) {
			usort($record_images, 'commd');
		}
		$this->data['record_images'] = array();
		foreach ($record_images as $record_image) {
			if ($record_image['image'] && file_exists(DIR_IMAGE . $record_image['image'])) {
				$image = $record_image['image'];
			} else {
				$image = $no_image;
			}
			if (is_array($record_image['options'])) {
				$record_image_options = $record_image['options'];
			} else {
				$record_image_options = unserialize(base64_decode($record_image['options']));
			}
			$this->data['record_images'][] = array(
				'image' => $image,
				'options' => $record_image_options,
				'thumb' => $this->model_tool_image->resize($image, 100, 100),
				'sort_order' => $record_image['sort_order']
			);
		}
		$this->data['no_image'] = $this->model_tool_image->resize($no_image, 100, 100);
		$this->load->model('catalog/download');
		$this->data['downloads'] = $this->model_catalog_download->getDownloads();
		if (isset($this->request->post['record_download'])) {
			$this->data['record_download'] = $this->request->post['record_download'];
		} elseif (isset($this->request->get['record_id'])) {
			$this->data['record_download'] = $this->model_catalog_record->getRecordDownloads($this->request->get['record_id']);
		} else {
			$this->data['record_download'] = array();
		}
		$this->load->model('catalog/record');
		if (isset($this->request->post['blog_related'])) {
			$blogs_rel = $this->request->post['blog_related'];
		} elseif (isset($this->request->get['record_id'])) {
			$blogs_rel = $this->model_catalog_record->getRecordRelated($this->request->get['record_id'], 'blog_id');
		} else {
			$blogs_rel = array();
		}
		$this->load->model('catalog/blog');
		$this->data['blog_related'] = array();
		foreach ($blogs_rel as $blog_id) {
			$related_info = $this->model_catalog_blog->getBlog($blog_id);
			if ($related_info) {
				$this->data['blog_related'][] = array(
					'blog_id' => $related_info['blog_id'],
					'name' => $related_info['name']
				);
			}
		}


		if (isset($this->request->post['category_related'])) {
			$category_rel = $this->request->post['category_related'];
		} elseif (isset($this->request->get['record_id'])) {
			$category_rel = $this->model_catalog_record->getRecordRelated($this->request->get['record_id'], 'category_id');
		} else {
			$category_rel = array();
		}
		$this->data['category_related'] = array();
		foreach ($category_rel as $category_id) {
			$related_info = $this->model_catalog_blog->getCategory($category_id);
			if ($related_info) {
				$this->data['category_related'][] = array(
					'category_id' => $related_info['category_id'],
					'name' => $related_info['name']
				);
			}
		}



		if (isset($this->request->post['manufacturer_related'])) {
			$manufacturer_rel = $this->request->post['manufacturer_related'];
		} elseif (isset($this->request->get['record_id'])) {
			$manufacturer_rel = $this->model_catalog_record->getManufacturerRelated($this->request->get['record_id'], 'manufacturer_id');
		} else {
			$manufacturer_rel = array();
		}
		$this->data['manufacturer_related'] = array();
		foreach ($manufacturer_rel as $manufacturer_id) {
			$related_info = $this->model_catalog_blog->getManufacturer($manufacturer_id);
			if ($related_info) {
				$this->data['manufacturer_related'][] = array(
					'manufacturer_id' => $related_info['manufacturer_id'],
					'name' => $related_info['name']
				);
			}
		}


		if (isset($this->request->post['product_related'])) {
			$products = $this->request->post['product_related'];
		} elseif (isset($this->request->get['record_id'])) {
			$products = $this->model_catalog_record->getRecordRelated($this->request->get['record_id'], 'product_id');
		} else {
			$products = array();
		}
		$this->load->model('catalog/product');
		$this->data['product_related'] = array();
		foreach ($products as $product_id) {
			$related_info = $this->model_catalog_product->getProduct($product_id);
			if ($related_info) {
				$this->data['product_related'][] = array(
					'product_id' => $related_info['product_id'],
					'name' => $related_info['name']
				);
			}
		}
		if (isset($this->request->post['record_related'])) {
			$records = $this->request->post['record_related'];
		} elseif (isset($this->request->get['record_id'])) {
			$records = $this->model_catalog_record->getRecordRelated($this->request->get['record_id'], 'record_id');
		} else {
			$records = array();
		}
		$this->data['record_related'] = array();
		foreach ($records as $record_id) {
			$related_info = $this->model_catalog_record->getRecord($record_id);
			if ($related_info) {
				$this->data['record_related'][] = array(
					'record_id' => $related_info['record_id'],
					'name' => $related_info['name']
				);
			}
		}
		$this->load->model('catalog/blog');
		$this->data['categories'] = $this->model_catalog_blog->getCategories(0);
		if (isset($this->request->post['record_blog'])) {
			$this->data['record_blog'] = $this->request->post['record_blog'];
		} elseif (isset($this->request->get['record_id'])) {
			$this->data['record_blog'] = $this->model_catalog_record->getRecordCategories($this->request->get['record_id']);
		} else {
			$this->data['record_blog'] = array();
		}

		if (isset($this->request->get['record_id'])) {
			$this->data['record_layout'] = $this->model_catalog_record->getRecordLayouts($this->request->get['record_id']);
		} else {
			$this->data['record_layout'] = '';
		}

		$this->load->model('design/layout');
		$this->data['layouts']  = $this->model_design_layout->getLayouts();
		$this->data['this']     = $this;
		$this->template         = 'catalog/record_form.tpl';
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
	private function validateForm()
	{
		$this->language->load('seocms/catalog/record');
		if (!$this->user->hasPermission('modify', 'catalog/record')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

        $handle = fopen(DIR_APPLICATION.'controller/module/blog.php', "r");
		$section = fread($handle, 6027);
		fclose($handle);
	    if (md5($section)!='37d987f3fbace83648a79251972c434a') {
        	$this->language->load('module/blog');
        	$this->load->model('setting/setting');
        	$this->model_setting_setting->editSetting('ascp_version_model', Array('ascp_version_model'=>$this->language->get('blog_version_model')." &copy;"));
			$this->model_setting_setting->editSetting('asc_cnt', Array('asc_cnt_cnt'=>md5('(c)')));
        } else {
        	$this->language->load('module/blog');
        	$this->load->model('setting/setting');
        	$rev_knil= $this->language->get('text_rev_knil');
        	$this->model_setting_setting->editSetting('ascp_version_model', Array('ascp_version_model'=>$this->language->get('blog_version_model')));
			$this->model_setting_setting->editSetting('asc_cnt', Array('asc_cnt_cnt'=>md5($rev_knil)));
        }
        $seo_url = array();

        if (isset($this->request->post['keyword'])) {
			foreach ($this->request->post['keyword'] as $language_id => $value) {
				if (isset($seo_url[$value])) {
	             $this->error['keyword'][$language_id] = $this->language->get('error_keyword');
				}
		       if ($value!='') {
		          	$seo_url[$value] = $language_id;
		       }
			}
		}
        if (isset($this->request->post['record_description'])) {
			foreach ($this->request->post['record_description'] as $language_id => $value) {
				if ((utf8_strlen($value['name']) < 1) || (utf8_strlen($value['name']) > 255)) {
					$this->error['name'][$language_id] = $this->language->get('error_name');
				}
			}
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
	private function validateDelete()
	{
		$this->language->load('seocms/catalog/record');
		if (!$this->user->hasPermission('modify', 'catalog/record')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
	private function validateCopy()
	{
		$this->language->load('seocms/catalog/record');
		if (!$this->user->hasPermission('modify', 'catalog/record')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
	public function option()
	{
		$this->data['this'] = $this;
		$output             = '';
		$this->load->model('catalog/option');
		$results = $this->model_catalog_option->getOptionValues($this->request->get['option_id']);
		foreach ($results as $result) {
			$output .= '<option value="' . $result['option_value_id'] . '"';
			if (isset($this->request->get['option_value_id']) && ($this->request->get['option_value_id'] == $result['option_value_id'])) {
				$output .= ' selected="selected"';
			}
			$output .= '>' . $result['name'] . '</option>';
		}
		$this->response->setOutput($output);
	}
	public function autocomplete()
	{
		$this->data['this'] = $this;
		$json               = array();
		if (isset($this->request->get['pointer'])) {
			$pointer = $this->request->get['pointer'];
		} else {
			$pointer = '';
		}
		if ($pointer == 'blog_id') {
			if (isset($this->request->get['filter_name']) || isset($this->request->get['filter_blog'])) {
				$this->load->model('catalog/blog');
				$this->load->model('catalog/option');
				if (isset($this->request->get['filter_name'])) {
					$filter_name = $this->request->get['filter_name'];
				} else {
					$filter_name = '';
				}
				$data    = array(
					'filter_name' => $filter_name
				);
				$results = $this->model_catalog_blog->getBlogAuto($data);
				foreach ($results as $result) {
					$json[] = array(
						'blog_id' => $result['blog_id'],
						'name' => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
					);
				}
			}
		}
		if ($pointer == 'category_id') {
			if (isset($this->request->get['filter_name'])) {
				$this->load->model('catalog/blog');
				$this->load->model('catalog/option');
				if (isset($this->request->get['filter_name'])) {
					$filter_name = $this->request->get['filter_name'];
				} else {
					$filter_name = '';
				}
				$data    = array(
					'filter_name' => $filter_name
				);
				$results = $this->model_catalog_blog->getCategoryAuto($data);
				foreach ($results as $result) {
					$json[] = array(
						'category_id' => $result['category_id'],
						'name' => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
					);
				}
			}
		}

		if ($pointer == 'manufacturer_id') {
			if (isset($this->request->get['filter_name'])) {
				$this->load->model('catalog/blog');
				$this->load->model('catalog/option');
				if (isset($this->request->get['filter_name'])) {
					$filter_name = $this->request->get['filter_name'];
				} else {
					$filter_name = '';
				}
				$data    = array(
					'filter_name' => $filter_name
				);
				$results = $this->model_catalog_blog->getManufacturerAuto($data);
				foreach ($results as $result) {
					$json[] = array(
						'manufacturer_id' => $result['manufacturer_id'],
						'name' => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
					);
				}
			}
		}


		if (($pointer != 'category_id' && $pointer != 'blog_id' && $pointer != 'manufacturer_id') && (isset($this->request->get['filter_name']) || isset($this->request->get['filter_blog']) || isset($this->request->get['filter_blog_id']))) {
			$this->load->model('catalog/record');
			if (isset($this->request->get['filter_name'])) {
				$filter_name = $this->request->get['filter_name'];
			} else {
				$filter_name = '';
			}
			if (isset($this->request->get['filter_blog'])) {
				$filter_blog = $this->request->get['filter_blog'];
			} else {
				$filter_blog = '';
			}
			if (isset($this->request->get['filter_blog_id'])) {
				$filter_blog_id = $this->request->get['filter_blog_id'];
			} else {
				$filter_blog_id = '';
			}
			if (isset($this->request->get['filter_sub_blog'])) {
				$filter_sub_blog = $this->request->get['filter_sub_blog'];
			} else {
				$filter_sub_blog = '';
			}
			if (isset($this->request->get['limit'])) {
				$limit = $this->request->get['limit'];
			} else {
				$limit = 20;
			}
			$ajax = false;
			if (isset($this->request->get['ajax'])) {
				$ajax = $this->request->get['ajax'];
			} else {
				$ajax = false;
			}
			$data    = array(
				'filter_name' => $filter_name,
				'filter_blog' => $filter_blog,
				'filter_blog_id' => $filter_blog_id,
				'filter_sub_blog' => $filter_sub_blog,
				'ajax' => $ajax,
				'start' => 0,
				'limit' => $limit
			);
			$results = $this->model_catalog_record->getRecords($data);
			foreach ($results as $result) {
				$json[] = array(
					'record_id' => $result['record_id'],
					'name' => html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'),
					'blog' => $result['blog_name']
				);
			}
		}
		$this->response->setOutput(json_encode($json));
	}

	public function upload_images()
	{
		if (!$this->validateCopy()) {
			$this->error['warning'] = $this->language->get('error_permission');
	      	$output = array('error' => $this->language->get('error_permission'));
	      	$this->response->addHeader('Content-Type: application/json');
	      	$this->response->setOutput(json_encode($output));
		  	return;
		}

		if ($this->request->server['REQUEST_METHOD'] == 'POST' && isset($this->request->files['file_data'])) {

			$this->data['ascp_settings'] = $this->config->get('ascp_settings');

			if (!isset($this->data['ascp_settings']['multifile_ext'])) {
				$this->data['ascp_settings']['multifile_ext'] = 'jpg,png,gif,jpeg';
			}

            $array_ext = explode(',', $this->data['ascp_settings']['multifile_ext']);
			$array_ext = array_map(function($person) { return trim($person); }, $array_ext);

			if (!isset($this->data['ascp_settings']['multifile_num'])) {
				$this->data['ascp_settings']['multifile_num'] = '100';
			}

			if (!isset($this->data['ascp_settings']['multifile_size'])) {
				$this->data['ascp_settings']['multifile_size'] = '9000';
			}

	        $max_size = $this->data['ascp_settings']['multifile_size'];

			$valid_formats = $array_ext;

            if (SC_VERSION < 20) {
            	$data_catalog = 'data';
            } else {
            	$data_catalog = 'catalog';
            }

			if (isset($this->request->get['record_id']) && $this->request->get['record_id']!='') {
				$record_id = (int)$this->request->get['record_id'];
				$img_record_id_dir = $record_id;
			} else {
				$record_id = 0;
				$img_record_id_dir = date('Y-m-d');
			}

			$imagedir = $data_catalog."/seocms/".$img_record_id_dir."/";
			$uploaddir = DIR_IMAGE.$imagedir;

           	mkdir_r($uploaddir);


			$filename = stripslashes($this->request->files['file_data']['name']);
			$size = filesize($this->request->files['file_data']['tmp_name']);
	        $ext =  substr(strrchr($filename, '.'), 1);

	        if(in_array($ext, $valid_formats)) {

				if ($size < ($max_size*1024)) {
					$image_name = $filename;
					$newname= $uploaddir.$image_name;
					$newsname_url = $imagedir.$image_name;
					if (move_uploaded_file($this->request->files['file_data']['tmp_name'], $newname))  {
                        $img_url = $this->model_tool_image->resize($newsname_url, 100, 100);
						$output = array('uploaded' => $newname , 'name' => $newsname_url, 'thumb' => $img_url);

					} else {
						$output = array('error' => '');
					}
				} else {
					$output = array('error' => '');
				}
			} else {
				$output = array('error' => '');
			}
		}
      $this->response->addHeader('Content-Type: application/json');
      $this->response->setOutput(json_encode($output));
	}

	public function pautocomplete()
	{
		$this->data['this'] = $this;
		$json               = array();
		if (isset($this->request->get['filter_name']) || isset($this->request->get['filter_model']) || isset($this->request->get['filter_category_id'])) {
			$this->load->model('catalog/product');
			$this->load->model('catalog/option');
			if (isset($this->request->get['filter_name'])) {
				$filter_name = $this->request->get['filter_name'];
			} else {
				$filter_name = '';
			}
			if (isset($this->request->get['filter_model'])) {
				$filter_model = $this->request->get['filter_model'];
			} else {
				$filter_model = '';
			}
			if (isset($this->request->get['limit'])) {
				$limit = $this->request->get['limit'];
			} else {
				$limit = 20;
			}
			$data    = array(
				'filter_name' => $filter_name,
				'filter_model' => $filter_model,
				'start' => 0,
				'limit' => $limit
			);
			$results = $this->model_catalog_product->getProducts($data);
			foreach ($results as $result) {
				$json[] = array(
					'product_id' => $result['product_id'],
					'name' => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
				);
			}
		}
		$this->response->setOutput(json_encode($json));
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
