<?php
/* All rights reserved belong to the module, the module developers http://opencartadmin.com */
// http://opencartadmin.com © 2011-2016 All Rights Reserved
// Distribution, without the author's consent is prohibited
// Commercial license
class ControllerRecordRecord extends Controller
{
	private $error = array();
	private $code;
	protected $data;

	public function __construct($registry)
	{
		parent::__construct($registry);
		if (version_compare(phpversion(), '5.3.0', '<') == true) {
			exit('PHP5.3+ Required');
		}
		$this->cont('record/addrewrite');
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
		if (!$this->config->get('ascp_customer_group_id')) {
			$this->data['settings_general'] = $this->config->get('ascp_settings');
		} else {
			$this->data['settings_general'] = Array();
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
	}
	public function index()
	{

		$this->config->set("blog_work", true);
		$this->load->model('setting/setting');
		$this->data['blog_version']       = '';
		$this->data['blog_version_model'] = '';
		$settings_admin                   = $this->model_setting_setting->getSetting('ascp_version', 'ascp_version');
		foreach ($settings_admin as $key => $value) {
			$this->data['blog_version'] = $value;
		}
		$settings_admin_model = $this->model_setting_setting->getSetting('ascp_version_model', 'ascp_version_model');
		foreach ($settings_admin_model as $key => $value) {
			$this->data['blog_version_model'] = $value;
		}
		$this->data['blog_version']    = $this->data['blog_version'] . ' ' . $this->data['blog_version_model'];

		$this->data['config_template'] = $this->config->get('config_template');
		if (file_exists(DIR_APPLICATION . 'view/javascript/jquery/tabs.js')) {
			$this->document->addScript('catalog/view/javascript/jquery/tabs.js');
		} else {
			if (file_exists(DIR_APPLICATION . 'view/javascript/blog/tabs/tabs.js')) {
				$this->document->addScript('catalog/view/javascript/blog/tabs/tabs.js');
			}
		}
		$this->document->addScript('catalog/view/javascript/blog/blog.comment.js');
		require_once(DIR_SYSTEM . 'helper/utf8blog.php');


		if ((isset($this->request->get['sc_ajax']) && $this->request->get['sc_ajax'] == 2) || (isset($this->request->post['sc_ajax']) && $this->request->post['sc_ajax'] == 2)) {
			$this->data['ajax'] = true;
		} else {
			$this->data['ajax'] = false;
		}

		$this->language->load('seocms/record');
		$this->language->load('seocms/blog');
		$this->data['breadcrumbs']   = array();
		$this->data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home'),
			'separator' => false
		);
		if ($this->config->get('ascp_settings') != '') {
			$this->data['settings_general'] = $this->config->get('ascp_settings');
		} else {
			$this->data['settings_general'] = Array();
		}
		if (!isset($this->data['settings_general']['colorbox_theme'])) {
			$this->data['settings_general']['colorbox_theme'] = 0;
		}
		$this->cont('module/blog');
		$this->data = $this->controller_module_blog->ColorboxLoader($this->data['settings_general']['colorbox_theme'], $this->data);
		$http_image = getHttpImage($this);
		$this->load->model('record/blog');
	    $this->load->model('record/path');
		if (isset($this->request->get['record_id'])) {
			$record_id                    = $this->request->get['record_id'];
			$blog_path                    = $this->model_record_path->pathbyrecord($record_id);
			$this->request->get['blog_id'] = $blog_path['path'];
		} else {
			$record_id = false;
		}

		if (isset($blog_path['path'])) {
			$path = '';
			$path_array = explode('_',$blog_path['path']);
			$blog_id = end($path_array);
		} else {
			$blog_id = 0;
		}

		if (isset($this->request->get['blog_id'])) {
			$path = '';
			$path_array = explode('_', $this->request->get['blog_id']);
			foreach ($path_array as $path_id) {
				if (!$path) {
					$path = $path_id;
				} else {
					$path .= '_' . $path_id;
				}

				$blog_info = $this->model_record_blog->getBlog($path_id);

				if ($blog_info) {

					if (isset($blog_info['design']) && $blog_info['design'] != '') {
						$this->data['blog_design'] = unserialize($blog_info['design']);
					} else {
						$this->data['blog_design'] = Array();
					}

					if (isset($this->data['blog_design']['blog_short_path_category']) && $this->data['blog_design']['blog_short_path_category'] == 1) {
			      		unset($this->data['breadcrumbs']);
			      		$this->data['breadcrumbs'][] = array(
								'text' => $this->language->get('text_home'),
								'href' => $this->url->link('common/home'),
								'separator' => false
						);
					}

                   if (isset($blog_info['name']) && $blog_info['name']!='') {
						$this->data['breadcrumbs'][] = array(
							'text' => $blog_info['name'],
							'href' => $this->url->link('record/blog', 'blog_id=' . $path),
							'separator' => $this->language->get('text_separator')
						);
					}
				}
			}
		} else {
			$path = '';
		}

		$blog_info = $this->model_record_blog->getBlog($blog_id, false);
		if (isset($blog_info['design']) && $blog_info['design'] != '') {
			$this->data['blog_design'] = unserialize($blog_info['design']);
		} else {
			$this->data['blog_design'] = Array();
		}

		$sort_data = array(
			'rating',
			'comments',
			'popular',
			'latest',
			'sort'
		);

		$sort = 'p.sort_order';
		if (isset($this->data['blog_design']['order']) && in_array($this->data['blog_design']['order'], $sort_data)) {
			if ($this->data['blog_design']['order'] == 'rating') {
				$sort = 'rating';
			}
			if ($this->data['blog_design']['order'] == 'comments') {
				$sort = 'comments';
			}
			if ($this->data['blog_design']['order'] == 'latest') {
				$sort = 'p.date_available';
			}
			if ($this->data['blog_design']['order'] == 'sort') {
				$sort = 'p.sort_order';
			}
			if ($this->data['blog_design']['order'] == 'popular') {
				$sort = 'p.viewed';
			}
		}
		$order = 'DESC';
		if (isset($this->data['blog_design']['order_ad'])) {
			if (strtoupper($this->data['blog_design']['order_ad']) == 'ASC') {
				$order = 'ASC';
			}
			if (strtoupper($this->data['blog_design']['order']) == 'DESC') {
				$order = 'DESC';
			}
		}
		$this->load->model('record/record');
		$data                = array(
			'filter_blog_id' => $blog_id,
			'sort' => $sort,
			'order' => $order
		);

		if (!isset ($this->data['blog_design']['next_status']) || (isset ($this->data['blog_design']['next_status']) && $this->data['blog_design']['next_status'] )) {
			$result_prevnext_records = $this->model_record_record->getRecords($data);
			if ($result_prevnext_records) {
				$previousKey                           = false;
				$nextKey                               = false;
				$next_flag                             = false;
				$this->data['record_previous']['url']  = '';
				$this->data['record_previous']['name'] = '';
				$this->data['record_next']['url']      = '';
				$this->data['record_next']['name']     = '';
				foreach ($result_prevnext_records as $num => $rec) {
					if ($next_flag) {
						$this->data['record_next']['url']  = $this->url->link('record/record', '&record_id=' . $result_prevnext_records[$num]['record_id']);
						$this->data['record_next']['name'] = $result_prevnext_records[$num]['name'];
						$next_flag                         = false;
					}
					if ($rec['record_id'] == $record_id) {
						$next_flag = true;
						if ($previousKey) {
							if (isset($result_prevnext_records[$previousKey])) {
								$this->data['record_previous']['url']  = $this->url->link('record/record', '&record_id=' . $result_prevnext_records[$previousKey]['record_id']);
								$this->data['record_previous']['name'] = $result_prevnext_records[$previousKey]['name'];
							}
						}
					}
					$previousKey = $num;
				}
			}
		}
		if (isset($this->request->get['filter_name']) || isset($this->request->get['filter_tag'])) {
			$url = '';
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}
			if (isset($this->request->get['filter_tag'])) {
				$url .= '&filter_tag=' . $this->request->get['filter_tag'];
			}
			if (isset($this->request->get['filter_description'])) {
				$url .= '&filter_description=' . $this->request->get['filter_description'];
			}
			if (isset($this->request->get['filter_blog_id'])) {
				$url .= '&filter_blog_id=' . $this->request->get['filter_blog_id'];
			}
			$this->data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_search'),
				'href' => $this->url->link('record/blog', $url),
				'separator' => $this->language->get('text_separator')
			);
		}
		if (isset($this->request->get['record_id'])) {
			$record_id = (int)$this->request->get['record_id'];
		} else {
			$record_id = 0;
		}
		$this->load->model('record/record');
		$record_info = $this->model_record_record->getRecord($record_id);
		if ($record_info) {
			$url = '';
			if (isset($this->request->get['blog_id'])) {
				$url .= '&blog_id=' . $this->request->get['blog_id'];
			}
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}
			if (isset($this->request->get['filter_tag'])) {
				$url .= '&filter_tag=' . $this->request->get['filter_tag'];
			}
			if (isset($this->request->get['filter_description'])) {
				$url .= '&filter_description=' . $this->request->get['filter_description'];
			}
			if (isset($this->request->get['filter_blog_id'])) {
				$url .= '&filter_blog_id=' . $this->request->get['filter_blog_id'];
			}
			$this->data['breadcrumbs'][] = array(
				'text' => $record_info['name'],
				'href' => $this->url->link('record/record', '&record_id=' . $this->request->get['record_id']),
				'separator' => $this->language->get('text_separator')
			);



			$this->data['text_welcome']         = sprintf($this->language->get('text_welcome'), $this->url->link('account/login', '', 'SSL'), $this->url->link('account/register', '', 'SSL'));
			$this->data['text_select']          = $this->language->get('text_select');
			$this->data['text_or']              = $this->language->get('text_or');
			$this->data['text_write']           = $this->language->get('text_write');
			$this->data['text_note']            = $this->language->get('text_note');
			$this->data['text_share']           = $this->language->get('text_share');
			$this->data['text_wait']            = $this->language->get('text_wait');
			$this->data['text_tags']            = $this->language->get('text_tags');
			$this->data['text_viewed']          = $this->language->get('text_viewed');
			$this->data['entry_name']           = $this->language->get('entry_name');
			$this->data['entry_comment']        = $this->language->get('entry_comment');
			$this->data['entry_rating']         = $this->language->get('entry_rating');
			$this->data['entry_good']           = $this->language->get('entry_good');
			$this->data['entry_bad']            = $this->language->get('entry_bad');
			$this->data['entry_captcha']        = $this->language->get('entry_captcha');
			$this->data['entry_captcha_title']  = $this->language->get('entry_captcha_title');
			$this->data['entry_captcha_update'] = $this->language->get('entry_captcha_update');
			$this->data['button_cart']          = $this->language->get('button_cart');
			$this->data['button_wishlist']      = $this->language->get('button_wishlist');
			$this->data['button_compare']       = $this->language->get('button_compare');
			$this->data['button_upload']        = $this->language->get('button_upload');
			$this->data['button_write']         = $this->language->get('button_write');
			$this->data['tab_description']      = $this->language->get('tab_description');
			$this->data['tab_attribute']        = $this->language->get('tab_attribute');
			$this->data['tab_advertising']      = $this->language->get('tab_advertising');
			$this->data['tab_comment']          = $this->language->get('tab_comment');
			$this->data['tab_images']           = $this->language->get('tab_images');
			$this->data['tab_related']          = $this->language->get('tab_related');
			$this->data['tab_product_related']  = $this->language->get('tab_product_related');
			$this->data['text_author']          = $this->language->get('text_author');
			$this->data['record_id']            = $this->request->get['record_id'];

			$this->load->model('record/comment');
			$this->data['comment_count']        = $this->model_record_comment->getTotalCommentsByRecordId($this->request->get['record_id']);

			$this->load->model('tool/image');
			if ($record_info['image']) {
				$this->data['popup'] = $http_image . $record_info['image'];
			} else {
				$this->data['popup'] = '';
			}
			if ($record_info['image']) {
				if (isset($this->data['blog_design']['image_adaptive_resize']) && $this->data['blog_design']['image_adaptive_resize']) {
					$image_adaptive_resize = $this->data['blog_design']['image_adaptive_resize'];
				} else {
					$image_adaptive_resize = false;
				}
				if (isset($this->data['blog_design']['thumb_image']['width']) && $this->data['blog_design']['thumb_image']['width'] != '') {
					$width = $this->data['blog_design']['thumb_image']['width'];
				} else {
					$width = $this->config->get('config_image_thumb_width');
				}
				if (isset($this->data['blog_design']['thumb_image']['height']) && $this->data['blog_design']['thumb_image']['height'] != '') {
					$height = $this->data['blog_design']['thumb_image']['height'];
				} else {
					$height = $this->config->get('config_image_thumb_height');
				}

				$this->data['thumb'] = $this->model_tool_image->resizeme($record_info['image'], $width, $height, $image_adaptive_resize);
				$this->data['thumb_dim']['width'] = $width;
				$this->data['thumb_dim']['height'] = $height;
			} else {
				$this->data['thumb'] = '';
				$this->data['thumb_dim']['width'] = '';
				$this->data['thumb_dim']['height'] = '';
			}
			$this->data['href'] = $this->url->link('record/record', 'record_id=' . $this->request->get['record_id']);

			if (isset($this->data['settings_general']['blog_search']) && $this->data['settings_general']['blog_search']) {
				$this->data['blog_search']['href'] = $this->data['settings_general']['blog_search'];
			} else {
				$this->data['blog_search']['href'] = false;
			}
			$this->document->addLink($this->data['thumb'], 'image_src');

			$this->data['images'] = array();
			if (!isset($this->data['blog_design']['images']))
				$this->data['blog_design']['images'] = array();
			if (!isset($this->data['blog_design']['product_image']))
				$this->data['blog_design']['product_image'] = $this->data['blog_design']['images'];
			if (!isset($this->data['blog_design']['gallery_image']))
				$this->data['blog_design']['gallery_image'] = $this->data['blog_design']['product_image'];
			$this->data['images'] = $this->getRecordImages($this->request->get['record_id'], $this->data['blog_design']);
			if (isset($this->data['settings_general']['box_share']) && $this->data['settings_general']['box_share'] != '') {
				$this->data['box_share'] = html_entity_decode($this->data['settings_general']['box_share']);
			} else {
				$this->data['box_share'] = '';
			}
			$this->data['options']        = array();
			$this->data['text_comments']  = sprintf($this->language->get('text_comments'), (int) $record_info['comments']);
			$this->data['comments']       = (int) $record_info['comments'];
			$record_comment               = unserialize($record_info['comment']);
			$this->data['record_comment'] = $record_comment;
			$this->data['comment_status'] = $record_comment['status'];
			if ($this->customer->isLogged()) {
				$this->data['text_login']     = $this->customer->getFirstName() . " " . $this->customer->getLastName();
				$this->data['captcha_status'] = false;
				$this->data['customer_id']    = $this->customer->getId();
			} else {
				$this->data['text_login']     = $this->language->get('text_anonymus');
				$this->data['captcha_status'] = true;
				$this->data['customer_id']    = false;
				$this->data['signer_code']    = 'customer_id';
				$this->language->load('account/login');
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
			$this->language->load('seocms/signer');
			$this->data['pointer'] = 'record_id';
			$this->load->model('agoo/signer/signer');
			if (isset($_COOKIE['email_subscribe_record_id']) && isset($this->data['pointer'])) {
				$email_subscribe = unserialize(base64_decode($_COOKIE['email_subscribe_' . $this->data['pointer']]));
				if (isset($email_subscribe[$this->data['record_id']])) {
					$email_subscribe = $email_subscribe[$this->data['record_id']];
				} else {
					$email_subscribe = '';
				}
			} else {
				$email_subscribe = false;
			}
			$this->data['signer_status'] = $this->model_agoo_signer_signer->getStatus($this->request->get['record_id'], $this->data['customer_id'], 'record_id', $email_subscribe);
			$this->data['viewed']        = $record_info['viewed'];
			$this->data['date_created']  = $record_info['date_added'];
			if (!isset($record_info['date_available'])) {
				$this->data['date'] = $this->data['date_available'] = $record_info['date_available'] = $record_info['date_added'];
			} else {
				$this->data['date'] = $this->data['date_available'] = $record_info['date_available'];
			}
			$this->data['author']             = $record_info['author'];
			$this->data['author_search_link'] = $this->url->link('record/blog', 'blog_id=' . $this->data['blog_search']['href'] . '&filter_author=' . $this->data['author']);
			$this->data['author_customer_id'] = $record_info['customer_id'];
			if (isset($this->data['settings_general']['format_date'])) {
			} else {
				$this->data['settings_general']['format_date'] = $this->language->get('text_date');
			}
			if (isset($this->data['settings_general']['format_hours'])) {
			} else {
				$this->data['settings_general']['format_hours'] = $this->language->get('text_hours');
			}
			if (isset($this->data['settings_general']['format_time']) && $this->data['settings_general']['format_time'] && date($this->data['settings_general']['format_date']) == date($this->data['settings_general']['format_date'], strtotime($record_info['date_available']))) {
				$date_str = $this->language->get('text_today');
			} else {
				$date_str = rdate($this, $this->data['settings_general']['format_date'], strtotime($record_info['date_available']));
			}
			$date_available = $date_str . (rdate($this, $this->data['settings_general']['format_hours'], strtotime($record_info['date_available'])));
			if (!isset($this->data['blog_design']['view_date'])) {
				$this->data['blog_design']['view_date'] = 1;
			}
			if (!isset($this->data['blog_design']['view_share'])) {
				$this->data['blog_design']['view_share'] = 1;
			}
			if (!isset($this->data['blog_design']['view_viewed'])) {
				$this->data['blog_design']['view_viewed'] = 1;
			}
			if (!isset($this->data['blog_design']['view_rating'])) {
				$this->data['blog_design']['view_rating'] = 1;
			}
			if (!isset($this->data['blog_design']['view_comments'])) {
				$this->data['blog_design']['view_comments'] = 1;
			}
			if (isset($this->data['blog_design']['view_captcha']) && !$this->data['blog_design']['view_captcha']) {
				$this->data['captcha_status'] = false;
			}
			$date_added                     = $date_available;
			$this->data['date_added']       = $date_added;
			$this->data['rating']           = (int) $record_info['rating'];
			$this->data['description']      = html_entity_decode($record_info['description'], ENT_QUOTES, 'UTF-8');
			$this->data['attribute_groups'] = $this->model_record_record->getRecordAttributes($this->request->get['record_id']);
			$this->data['products']         = array();
			$results                        = $this->model_record_record->getProductRelated($this->request->get['record_id'], 'product_id');
			if (isset($this->data['blog_design']['image_product_adaptive_resize']) && $this->data['blog_design']['image_product_adaptive_resize']) {
				$image_product_adaptive_resize = $this->data['blog_design']['image_product_adaptive_resize'];
			} else {
				$image_product_adaptive_resize = false;
			}
			foreach ($results as $result) {
				if ($result['image']) {
					if (isset($this->data['blog_design']['product_image']['width']) && $this->data['blog_design']['product_image']['width'] != '') {
						$width = $this->data['blog_design']['product_image']['width'];
					} else {
						$this->data['blog_design']['product_image']['width'] = $width = $this->config->get('config_image_related_width');
					}
					if (isset($this->data['blog_design']['product_image']['height']) && $this->data['blog_design']['product_image']['height'] != '') {
						$height = $this->data['blog_design']['product_image']['height'];
					} else {
						$this->data['blog_design']['product_image']['height'] = $height = $this->config->get('config_image_related_height');
					}
					$image = $this->model_tool_image->resizeme($result['image'], $width, $height, $image_product_adaptive_resize);
				} else {
					$image = false;
				}
				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$price = false;
				}
				if ((float) $result['special']) {
					$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$special = false;
				}
				$rating = (int) $result['rating'];
				if (isset($result['description_blog']) && $result['description_blog']) {
					$flag_desc = 'pred';
					$amount    = 1;
					if (isset($this->data['blog_design']['blog_num_desc'])) {
						$this->data['blog_num_desc'] = $this->data['blog_design']['blog_num_desc'];
					} else {
						$this->data['blog_num_desc'] = $this->data['settings_general']['blog_num_desc'];
					}
					if ($this->data['blog_num_desc'] == '') {
						$this->data['blog_num_desc'] = 50;
					} else {
						$amount    = $this->data['blog_num_desc'];
						$flag_desc = 'symbols';
					}
					if (isset($this->data['blog_design']['blog_num_desc_words'])) {
						$this->data['blog_num_desc_words'] = $this->data['blog_design']['blog_num_desc_words'];
					} else {
						$this->data['blog_num_desc_words'] = $this->data['settings_general']['blog_num_desc_words'];
					}
					if ($this->data['blog_num_desc_words'] == '') {
						$this->data['blog_num_desc_words'] = 10;
					} else {
						$amount    = $this->data['blog_num_desc_words'];
						$flag_desc = 'words';
					}
					if (isset($this->data['blog_design']['blog_num_desc_pred'])) {
						$this->data['blog_num_desc_pred'] = $this->data['blog_design']['blog_num_desc_pred'];
					} else {
						$this->data['blog_num_desc_pred'] = $this->data['settings_general']['blog_num_desc_pred'];
					}
					if ($this->data['blog_num_desc_pred'] == '') {
						$this->data['blog_num_desc_pred'] = 3;
					} else {
						$amount    = $this->data['blog_num_desc_pred'];
						$flag_desc = 'pred';
					}
					switch ($flag_desc) {
						case 'symbols':
							$pattern = ('/((.*?)\S){0,' . $amount . '}/isu');
							preg_match_all($pattern, strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), $out);
							$description = $out[0][0];
							break;
						case 'words':
							$pattern = ('/((.*?)\x20){0,' . $amount . '}/isu');
							preg_match_all($pattern, strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), $out);
							$description = $out[0][0];
							break;
						case 'pred':
							$pattern = ('/((.*?)\.){0,' . $amount . '}/isu');
							preg_match_all($pattern, strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), $out);
							$description = $out[0][0];
							break;
					}
				} else {
					$description = false;
				}
				if ($this->config->get('config_product_description_length')) {
					$how = $this->config->get('config_product_description_length');
				} else {
					$how = 100;
				}
				$description = utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $how);
				unset($result['description']);
				$this->data['products'][] = array(
					'product_id' => $result['product_id'],
					'thumb' => $image,
					'name' => $result['name'],
					'description' => $description . '..',
					'price' => $price,
					'special' => $special,
					'rating' => $rating,
					'href' => $this->url->link('product/product', 'product_id=' . $result['product_id'])
				);
			}
			$this->data['records'] = array();
			$results               = $this->model_record_record->getRecordRelated($this->request->get['record_id']);
			if (isset($this->data['blog_design']['image_record_adaptive_resize']) && $this->data['blog_design']['image_record_adaptive_resize']) {
				$image_record_adaptive_resize = $this->data['blog_design']['image_record_adaptive_resize'];
			} else {
				$image_record_adaptive_resize = false;
			}
			foreach ($results as $result) {
				if ($result['image']) {
					if (isset($this->data['blog_design']['record_image']['width']) && $this->data['blog_design']['record_image']['width'] != '') {
						$width = $this->data['blog_design']['record_image']['width'];
					} else {
						$this->data['blog_design']['record_image']['width'] = $width = $this->config->get('config_image_related_width');
					}
					if (isset($this->data['blog_design']['record_image']['height']) && $this->data['blog_design']['record_image']['height'] != '') {
						$height = $this->data['blog_design']['record_image']['height'];
					} else {
						$this->data['blog_design']['record_image']['height'] = $height = $this->config->get('config_image_related_height');
					}
					$image = $this->model_tool_image->resizeme($result['image'], $width, $height, $image_record_adaptive_resize);
				} else {
					$image = false;
				}
				if ($result['comment']) {
					$rating = (int) $result['rating'];
				} else {
					$rating = false;
				}
				$record_comment_info = unserialize($result['comment']);
				if ($this->config->get('config_product_description_length')) {
					$how = $this->config->get('config_product_description_length');
				} else {
					$how = 100;
				}
				$rdescription = utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $how);
				unset($result['description']);
				$this->data['records'][] = array(
					'record_id' => $result['record_id'],
					'thumb' => $image,
					'name' => $result['name'],
					'description' => $rdescription . '..',
					'author' => $result['author'],
					'customer_id' => $result['customer_id'],
					'viewed' => $result['viewed'],
					'rating' => $rating,
					'comment_status' => $record_comment_info['status'],
					'comments' => sprintf($this->language->get('text_comments'), (int) $result['comments']),
					'href' => $this->url->link('record/record', 'record_id=' . $result['record_id'])
				);
			}
			$this->data['tags'] = array();
			if (isset($this->data['settings_general']['blog_search']) && $this->data['settings_general']['blog_search']) {
				$this->data['blog_search']['href'] = $this->data['settings_general']['blog_search'];
			} else {
				$this->data['blog_search']['href'] = false;
			}
			$results = $this->model_record_record->getRecordTags($this->request->get['record_id']);
			foreach ($results as $result) {
				$this->data['tags'][] = array(
					'tag' => trim($result['tag']),
					'href' => $this->url->link('record/blog', 'blog_id=' . $this->data['blog_search']['href'] . '&filter_tag=' . $result['tag'])
				);
			}
			$this->model_record_record->updateViewed($this->request->get['record_id']);
			if (isset($this->data['blog_design']['blog_template_record']) && $this->data['blog_design']['blog_template_record'] != '') {
				$template = $this->data['blog_design']['blog_template_record'];
			} else {
				$template = 'record.tpl';
			}
			if (isset($this->request->get['template_modal']) && $this->request->get['template_modal'] != '') {
				$template = $this->request->get['template_modal'];
			}

			if ((isset($this->request->get['cmswidget']) && $this->request->get['cmswidget'] != '') || (isset($this->request->post['cmswidget']) && $this->request->post['cmswidget'] != '')) {
				if (isset($this->request->get['cmswidget'])) {
					$this->data['cmswidget']       = (int) $this->request->get['cmswidget'];
				} else {
					$this->data['cmswidget']       = (int) $this->request->post['cmswidget'];
				}
				$this->data['ascp_widgets']    = $this->config->get('ascp_widgets');
				$this->data['settings_widget'] = $this->data['ascp_widgets'][$this->data['cmswidget']];

			}

         $this->data['product_tags'] = false;
         $tags_scripts = '';
		 if (SC_VERSION > 15) {
              if (isset($record_info['tag_product']) && $record_info['tag_product']!='' && isset($this->data['settings_general']['tags_widget_status']) && $this->data['settings_general']['tags_widget_status'])
              {
				$this->request->get['route'] = 'product/search';

		        if ($record_info['tag_search']==1) {
		      	 	$token_tags = 'tag';
		        }

		        if ($record_info['tag_search']==2) {
		      	 	$token_tags = 'search';
		      	 	$this->request->get['description']='true';
		        } else {
		         	$token_tags = 'tag';
		        }

				$this->request->get[$token_tags] = trim($record_info['tag_product']);

				$this->registry->set('returnResponseSetOutput', true);
				$this->load->controller('product/search');
	            $this->data['product_tags'] =  $this->registry->get('returnResponseSetOutput');
	            $this->registry->set('returnResponseSetOutput', false);

	            // здесь обработать
				if ($this->data['product_tags']!='') {

					$this->load->library('parser/simple_html_dom');

			        $html_dom = new simple_html_dom();
					$html_dom->load($this->data['product_tags'], true, false, DEFAULT_TARGET_CHARSET, true);


                   if (isset($this->data['settings_general']['tags_widget_status_scripts']) && $this->data['settings_general']['tags_widget_status_scripts']) {
						$html_dom_s  = $html_dom->find('script');
	                    if ($html_dom_s) {
							foreach ($html_dom_s as $nm => $b) {
								$tags_scripts.= $b->outertext;
							}
		                }
                    }

                    foreach ($this->data['settings_general']['tags_widget_type'] as $id => $type) {
						if (trim($type['number'])!='') {
								$number = (int)$type['number'];
						}

						$html_dom_p  = $html_dom->find($this->data['settings_general']['tags_widget_content'].' '.$type['title']);

						if ($html_dom_p) {
							foreach ($html_dom_p as $nm => $a) {
								if (trim($type['number'])!='') {
									if ($nm == $number) {
										$a->outertext = '';
									}
								} else {
									$a->outertext = '';
								}

							}
	                    }
                    }


					$html_dom_found = $html_dom->find($this->data['settings_general']['tags_widget_content'], 0);


	        		unset($html_dom);
			        $this->data['product_tags'] = $html_dom_found->innertext.$tags_scripts;
	                unset($html_dom_found);
                }
	                $this->request->get['route'] = 'record/record';
	                unset($this->request->get[$token_tags]);

	                if ($token_tags == 'search') {
	  		      	 	unset($this->request->get['description']);
			        }

              }

	     }
            $this->document->removeLink($this->url->link('product/search'));
			$this->document->addLink($this->url->link('record/record', 'record_id=' . $this->request->get['record_id']), 'canonical');

			if (isset($record_info['meta_title']) && $record_info['meta_title'] != '') {
				$this->document->setTitle($record_info['meta_title']);
			} else {
				$this->document->setTitle($record_info['name'] . " - " . $this->config->get('config_title'));
			}
			if (isset($record_info['meta_h1']) && $record_info['meta_h1'] != '') {
				$this->data['heading_title'] = $record_info['meta_h1'];
			} else {
				$this->data['heading_title'] = $record_info['name'];
			}
			$this->data['name'] = $record_info['name'];
			$this->document->setDescription($record_info['meta_description']);
			$this->document->setKeywords($record_info['meta_keyword']);

			$this->load->library('document');


			if (method_exists($this->document, 'setOgImage') && $this->data['thumb'] != '') {
				$this->document->setOgImage($this->data['thumb']);
			}
			if (method_exists($this->document, 'setOgTitle')) {
				$this->document->setOgTitle($this->document->getTitle());
			}
			if (method_exists($this->document, 'setOgDescription')) {
				$this->document->setOgDescription($this->document->getDescription());
			}
			if (method_exists($this->document, 'setOgUrl')) {
				$this->document->setOgUrl($this->data['href']);
			}
			if (method_exists($this->document, 'setOgType')) {
				$this->document->setOgType('website');
			}

			if (isset($record_info['index_page']) && $record_info['index_page'] != '') {
				$this->data['robots'] = $record_info['index_page'];
			} else {
				$this->data['robots'] = '';
			}
			if (method_exists($this->document, 'setRobots') && $this->data['robots'] != '') {
				$this->document->setRobots($this->data['robots']);
			}


			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/agootemplates/record/' . $template)) {
				$this_template = $this->config->get('config_template') . '/template/agootemplates/record/' . $template;
			} else {
				if (file_exists(DIR_TEMPLATE . 'default/template/agootemplates/record/' . $template)) {
					$this_template = 'default/template/agootemplates/record/' . $template;
				} else {
					$this_template = 'default/template/agootemplates/record/record.tpl';
				}
			}

			$this->data['settings_blog'] = $this->data['blog_design'];
			$this->children              = array();
			if ($this->data['ajax']) {
				$this->data['header']         = '';
				$this->data['column_left']    = '';
				$this->data['column_right']   = '';
				$this->data['content_top']    = '';
				$this->data['content_bottom'] = '';
				$this->data['footer']         = '';

				if (isset($this->data['settings_widget']['positions']) && $this->data['settings_widget']['positions'] != '') {
					foreach ($this->data['settings_widget']['positions'] as $num => $position) {
						if (SC_VERSION > 15) {
							$this->data[$position] = $this->load->controller('common/' . $position);
						} else {
							array_push($this->children, 'common/' . $position);
						}
					}
				}

			} else {
				if (SC_VERSION < 20) {

						$this->children = array(
							'common/footer',
							'common/header'
						);

						foreach ($this->data['settings_general']['position_type'] as $position_type_type => $position_type_name) {
		    	        	array_unshift($this->children, $position_type_name['controller']);
						}

				} else {
                    /*
					$this->data['column_left']    = $this->load->controller('common/column_left');
					$this->data['column_right']   = $this->load->controller('common/column_right');
					$this->data['content_top']    = $this->load->controller('common/content_top');
					$this->data['content_bottom'] = $this->load->controller('common/content_bottom');
					*/

					foreach ($this->data['settings_general']['position_type'] as $position_type_type => $position_type_name) {
    	        		$this->data[$position_type_name['name']] = $this->load->controller($position_type_name['controller']);
					}

					$this->data['footer']         = $this->load->controller('common/footer');
					$this->data['header']         = $this->load->controller('common/header');
				}
			}

		if (is_file(DIR_IMAGE . $this->config->get('config_logo'))) {
				$this->data['publisher_logo'] = $this->model_tool_image->resize($this->config->get('config_logo'), 100, 100);
				$this->data['publisher_logo_dim']['width'] = '100';
				$this->data['publisher_logo_dim']['height'] = '100';
		} else {
  			if ($record_info['image']) {
                $this->data['publisher_logo'] = $this->data['thumb'];
				$this->data['publisher_logo_dim'] = $this->data['thumb_dim']['width'];
				$this->data['publisher_logo_dim']= $this->data['thumb_dim']['height'];
            } else {
                $this->data['publisher_logo'] = '';
				$this->data['publisher_logo_dim'] = '';
				$this->data['publisher_logo_dim']='';
            }
		}


			$this->data['language'] = $this->language;
			$this->data['config'] = $this->config;

			$this->data['theme']    = $this->config->get('config_template');
			$this->config->set("blog_work", false);
			$this->data['theme_stars'] = $this->getThemeStars('image/blogstars-1.png');
			$this->template            = $this_template;


            $this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . '/1.1 200 OK');

			if (SC_VERSION < 20) {
				$html = $this->render();
				$this->response->setOutput($html);
			} else {
				$html = $this->load->view($this->template, $this->data);
				$this->response->setOutput($html);
				return $html;
			}

		} else {
			$url = '';
			if (isset($this->request->get['blog_id'])) {
			}
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}
			if (isset($this->request->get['filter_tag'])) {
				$url .= '&filter_tag=' . $this->request->get['filter_tag'];
			}
			if (isset($this->request->get['filter_description'])) {
				$url .= '&filter_description=' . $this->request->get['filter_description'];
			}
			if (isset($this->request->get['filter_blog_id'])) {
				$url .= '&filter_blog_id=' . $this->request->get['filter_blog_id'];
			}
			$this->data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_error'),
				'href' => $this->url->link('record/record', $url . '&record_id=' . $record_id),
				'separator' => $this->language->get('text_separator')
			);
			$this->document->setTitle($this->language->get('text_error'));
			$this->data['heading_title']   = $this->language->get('text_error');
			$this->data['text_error']      = $this->language->get('text_error');
			$this->data['button_continue'] = $this->language->get('button_continue');
			$this->data['continue']        = $this->url->link('common/home');
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
				$this_template = $this->config->get('config_template') . '/template/error/not_found.tpl';
			} else {
				$this_template = 'default/template/error/not_found.tpl';
			}
           if (SC_VERSION < 20) {
				$this->children = array(
					'common/footer',
					'common/header'
				);

				foreach ($this->data['settings_general']['position_type'] as $position_type_type => $position_type_name) {
    	        	array_unshift($this->children, $position_type_name['controller']);
				}
			}
			$this->data['language'] = $this->language;

			if (SC_VERSION > 15) {
                    /*
					$this->data['column_left']    = $this->load->controller('common/column_left');
					$this->data['column_right']   = $this->load->controller('common/column_right');
					$this->data['content_top']    = $this->load->controller('common/content_top');
					$this->data['content_bottom'] = $this->load->controller('common/content_bottom');
					*/

					foreach ($this->data['settings_general']['position_type'] as $position_type_type => $position_type_name) {
    	        		$this->data[$position_type_name['name']] = $this->load->controller($position_type_name['controller']);
					}

					$this->data['footer']         = $this->load->controller('common/footer');
					$this->data['header']         = $this->load->controller('common/header');
			}

			if (!isset($this->request->post['ajax_file'])) {
				$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . '/1.1 404 Not Found');
			}

			$this->config->set("blog_work", false);
			$this->template = $this_template;


			if (!isset($this->request->get['ajax_file'])) {
				if (SC_VERSION < 20) {
					$html = $this->render();
					$this->response->setOutput($html);
				} else {
					$html = $this->load->view($this->template, $this->data);
					$this->response->setOutput($html);
					return $html;
				}

			}
		}
	}
	private function getRecordImages($record_id, $settings)
	{
		$images = array();
		if (!$this->config->get('config_image_additional_width')) {
			$this->config->set('config_image_additional_width', '120');
		}

		if (!$this->config->get('config_image_additional_height')) {
			$this->config->set('config_image_additional_height', '200');
		}
		if (!isset($settings['gallery_image']['width']) || $settings['gallery_image']['width'] == '')
			$settings['gallery_image']['width'] = $this->config->get('config_image_additional_width');
		;
		if (!isset($settings['gallery_image']['height']) || $settings['gallery_image']['height'] == '')
			$settings['gallery_image']['height'] = $this->config->get('config_image_additional_height');
		$width  = $settings['gallery_image']['width'];
		$height = $settings['gallery_image']['height'];
		if (isset($settings['images_adaptive_resize']) && $settings['images_adaptive_resize']) {
			$images_adaptive_resize = $settings['images_adaptive_resize'];
		} else {
			$images_adaptive_resize = false;
		}
		if (isset($settings['images_number']) && $settings['images_number'] != '' && (isset($settings['images_number_hide']) && !$settings['images_number_hide'])) {
			$images_number = $settings['images_number'];
		} else {
			$images_number = false;
		}
		$results = $this->model_record_record->getRecordImages($record_id, $images_number);
		foreach ($results as $res) {
			$image_options = unserialize(base64_decode($res['options']));
			if (isset($image_options['title'][$this->config->get('config_language_id')])) {
				$image_title = html_entity_decode($image_options['title'][$this->config->get('config_language_id')], ENT_QUOTES, 'UTF-8');
			} else {
				$image_title = getHttpImage($this) . $res['image'];
			}
			if (isset($image_options['description'][$this->config->get('config_language_id')])) {
				$image_description = $description = html_entity_decode($image_options['description'][$this->config->get('config_language_id')], ENT_QUOTES, 'UTF-8');
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

	public function getAllProducts() {

		$sql = "SELECT p.product_id FROM " . DB_PREFIX . "product p WHERE  p.status = '1' AND p.date_available <= NOW() ";

		$product_data = array();

		$query = $this->db->query($sql);

		foreach ($query->rows as $result) {
			$product_data[$result['product_id']] = $this->getProduct($result['product_id']);
		}

		return $product_data;
	}


	/*
	private function getBlogSettingsbyRecordID($record_id)
	{
		$this->load->model('record/path');
		if (isset($record_id)) {
			$blog_path = $this->model_record_path->pathbyrecord($record_id);
			$blog_id   = $blog_path['path'];
		}

		if (isset($blog_id)) {
			foreach (explode('_', $blog_id) as $path_id) {
				$path_id = $path_id;
			}
		}
		$this->load->model('record/blog');
		$blog_info = $this->model_record_blog->getBlog($path_id, false);
		if (isset($blog_info['design']) && $blog_info['design'] != '') {
			$this->data['blog_design'] = unserialize($blog_info['design']);
		} else {
			$this->data['blog_design'] = Array();
		}
		return $this->data['blog_design'];
	}
	*/

	public function upload()
	{
		$this->language->load('seocms/record');
		$json = array();
		if (!empty($this->request->files['file']['name'])) {
			$filename = basename(html_entity_decode($this->request->files['file']['name'], ENT_QUOTES, 'UTF-8'));
			if ((strlen($filename) < 3) || (strlen($filename) > 128)) {
				$json['error'] = $this->language->get('error_filename');
			}
			$allowed   = array();
			$filetypes = explode(',', $this->config->get('config_upload_allowed'));
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
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && !isset($json['error'])) {
			if (is_uploaded_file($this->request->files['file']['tmp_name']) && file_exists($this->request->files['file']['tmp_name'])) {
				$file = basename($filename) . '.' . md5(rand());
				$this->load->library('encryption');
				$encryption   = new Encryption($this->config->get('config_encryption'));
				$json['file'] = $encryption->encrypt($file);
				move_uploaded_file($this->request->files['file']['tmp_name'], DIR_DOWNLOAD . $file);
			}
			$json['success'] = $this->language->get('text_upload');
		}
		$this->response->setOutput(json_encode($json));
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
}

