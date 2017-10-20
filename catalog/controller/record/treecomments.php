<?php
/* All rights reserved belong to the module, the module developers http://opencartadmin.com */
// http://opencartadmin.com © 2011-2016 All Rights Reserved
// Distribution, without the author's consent is prohibited
// Commercial license
class ControllerRecordTreeComments extends Controller
{
	private $error = array();
	protected $data;

	public function __construct($registry)
	{
		parent::__construct($registry);
		if (version_compare(phpversion(), '5.3.0', '<') == true) {
			exit('PHP5.3+ Required');
		}
		$this->cont('record/addrewrite');
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
	public function comment()
	{
		$this->config->set("blog_work", true);
		if (SC_VERSION > 15) {
			$this->load->controller('common/seoblog');
		} else {
			$this->getChild('common/seoblog');
		}
		if (isset($this->request->get['prefix'])) {
			$this->data['prefix'] = $this->request->get['prefix'];
		} else {
			if ($this->registry->get("prefix") != '') {
				$this->data['prefix'] = $this->registry->get("prefix");
			} else {
				$this->data['prefix'] = '';
			}
		}
		$this->load->model('setting/setting');
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$settings_admin = $this->model_setting_setting->getSetting('ascp_admin', 'ascp_admin_https_admin_path');
		} else {
			$settings_admin = $this->model_setting_setting->getSetting('ascp_admin', 'ascp_admin_http_admin_path');
		}
		foreach ($settings_admin as $key => $value) {
			$this->data['admin_path'] = $value;
		}

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
		} else {
			$this->data['userLogged'] = false;
		}
		if (isset($this->request->get['ascp_widgets_position'])) {
			$this->data['cmswidget'] = $this->request->get['cmswidget'] = (int) $this->request->get['ascp_widgets_position'];
		}
		if (isset($this->request->post['thislist']) || isset($this->request->get['thislist'])) {
			if (isset($this->request->get['thislist'])) {
				$str = base64_decode($this->request->get['thislist']);
			} else {
				$str = base64_decode($this->request->post['thislist']);
			}
		} else {
			$numargs = func_num_args();
			if ($numargs >= 1) {
				$this->data['cmswidget'] = func_get_arg(0);
			} else {
				$this->data['cmswidget'] = false;
			}
		}
		$this->data['http_image']         = getHttpImage($this);
		$this->data['config_language_id'] = $this->config->get('config_language_id');
		$this->data['ascp_widgets']       = $this->config->get('ascp_widgets');
		$this->data['cmswidget']          = (int) $this->data['cmswidget'];
		if (isset($this->data['ascp_widgets'][$this->data['cmswidget']])) {
			$this->data['thislist'] = $this->data['ascp_widgets'][$this->data['cmswidget']];
		} else {
			$this->data['thislist'] = array();
		}
		$this->language->load('product/product');
		$this->language->load('seocms/blog');
		$this->language->load('seocms/record');
		if (isset($this->data['thislist']['langfile']) && $this->data['thislist']['langfile'] != '') {
			$this->language->load($this->data['thislist']['langfile']);
		}
		if (isset($this->request->get['product_id']) || isset($this->request->get['record_id']) || isset($this->data['thislist']['recordid'])) {
			$comments_settings      = Array();
			$record_info            = Array();
			$record_info['comment'] = Array();
			$this->data['mark']     = false;
			if (isset($this->request->get['product_id'])) {
				$this->data['mark']       = 'product_id';
				$this->data['product_id'] = $this->request->get['product_id'];
				$mark_route               = 'product/product';
			}
			if (isset($this->request->get['record_id'])) {
				$this->data['mark']       = 'record_id';
				$this->data['product_id'] = $this->request->get['record_id'];
				$mark_route               = 'record/record';
			}
			if (isset($this->data['thislist']['recordid']) && $this->data['thislist']['recordid'] != '') {
				$this->data['mark']       = 'record_id';
				$this->data['product_id'] = $this->data['thislist']['recordid'];
				$mark_route               = 'record/record';
				$this->load->model('record/record');
				$this->data['record'] = $this->data['mark_info'] = $this->model_record_record->getRecord($this->data['product_id']);
			} else {
				$this->data['record'] = '';
			}
			$this->data['url']                      = $this->url->link($mark_route, $this->data['mark'] . '=' . $this->data['product_id']);
			$this->data['mark_id']                  = $this->data['product_id'];
			$this->data['entry_sorting']            = $this->language->get('entry_sorting');
			$this->data['text_sorting_desc']        = $this->language->get('text_sorting_desc');
			$this->data['text_sorting_asc']         = $this->language->get('text_sorting_asc');
			$this->data['text_rollup']              = $this->language->get('text_rollup');
			$this->data['text_rollup_down']         = $this->language->get('text_rollup_down');
			$this->data['text_no_comments']         = $this->language->get('text_no_comments');
			$this->data['text_reply_button']        = $this->language->get('text_reply_button');
			$this->data['text_signer_answer']       = $this->language->get('text_signer_answer');
			$this->data['text_signer_answer_email'] = $this->language->get('text_signer_answer_email');
			/*  todo
			$this->data['text_edit_button']   = $this->language->get('text_edit_button');
			$this->data['text_delete_button'] = $this->language->get('text_delete_button');
			*/
			if ($this->customer->isLogged()) {
				$this->data['text_login']     = $this->customer->getFirstName() . " " . $this->customer->getLastName();
				$this->data['captcha_status'] = false;
				$this->data['customer_id']    = $this->customer->getId();
			} else {
				$this->data['text_login']     = $this->language->get('text_anonymus');
				$this->data['captcha_status'] = true;
				$this->data['customer_id']    = false;
			}
			$this->load->model('record/treecomments');
			if (!class_exists('ModelCatalogProduct')) {
				$this->load->model('catalog/product');
			}
			$this->load->model('record/record');
			$this->load->model('record/blog');
			$this->load->model('record/path');
			if ($this->data['mark'] == 'product_id') {
				$mark_path = $this->model_record_path->pathbyproduct($this->data['mark_id']);
				$mark_info = $this->model_catalog_product->getProduct($this->data['mark_id']);
			}
			if ($this->data['mark'] == 'record_id') {
				$mark_path   = $this->model_record_path->pathbyrecord($this->data['mark_id']);
				$record_info = $mark_info = $this->model_record_record->getRecord($this->data['mark_id']);
			}
			$category_path = $mark_path['path'];
			if (isset($category_path)) {
				$array_path  = explode('_', $category_path);
				$category_id = end($array_path);
			}
			if (!isset($category_id)) {
				$category_id = false;
			}
			if ($category_id) {
				$category_info = $this->model_record_treecomments->getCategory($category_id, $this->data['mark']);
			} else {
				$category_info = Array();
			}
			if (isset($category_info['design']) && $category_info['design'] != '') {
				$this->data['category_design'] = @unserialize($category_info['design']);
			} else {
				$this->data['category_design'] = Array();
			}
			if ($this->config->get('ascp_settings') != '') {
				$this->data['settings_general'] = $this->config->get('ascp_settings');
			} else {
				$this->data['settings_general'] = Array();
			}
			if (!isset($this->data['settings_general']['colorbox_theme'])) {
				$this->data['settings_general']['colorbox_theme'] = 0;
			}
			$get = $this->request->get;
			if (isset($this->data['settings_general']['get_pagination'])) {
				$get_pagination = $this->data['settings_general']['get_pagination'];
			} else {
				$get_pagination = 'tracking';
			}
			if (isset($get['ascp_widgets_position'])) {
				$this->data['ascp_widgets_position'] = $get['ascp_widgets_position'];
			} else {
				$this->data['ascp_widgets_position'] = $this->registry->get('ascp_widgets_position');
			}
			$cmswidget      = $this->data['ascp_widgets_position'];
			$cmswidget_flag = false;
			if (isset($get[$get_pagination])) {
				$tracking = $get[$get_pagination];
			} else {
				$tracking = '';
			}
			if ($tracking != '') {
				$parts = explode('_', trim(utf8_strtolower($tracking)));
				foreach ($parts as $num => $val) {
					$aval = explode("-", $val);
					if (isset($aval[0]) && $aval[0] == 'cmswidget') {
						if (isset($aval[1]) && $aval[1] == $cmswidget) {
							$cmswidget_flag = true;
						}
					}
				}
				if ($cmswidget_flag) {
					foreach ($parts as $num => $val) {
						$aval = explode("-", $val);
						if (isset($aval[0])) {
							$getquery = $aval[0];
							if (isset($aval[1])) {
								$getpar         = $aval[1];
								$get[$getquery] = $getpar;
							}
						}
					}
				}
			}
			if (isset($get['wpage']) && isset($get['cmswidget']) && $get['cmswidget'] == $cmswidget) {
				$page = $get['wpage'];
			} else {
				$page = 1;
			}
			if (isset($get['sc_ajax']) && $get['sc_ajax'] == '1' && isset($get['wpage'])) {
				$page = $get['wpage'];
			}
			$this->data['wpage'] = $this->data['page'] = $page;
			if (isset($record_info['comment']) && !empty($record_info['comment'])) {
				$comments_settings_record = unserialize($record_info['comment']);
			} else {
				$comments_settings_record = Array();
			}
			$comments_settings     = $comments_settings_record + $this->data['thislist'];
			$this->data['sorting'] = 'desc';
			$comments_order        = 'comment_id';
			if (isset($comments_settings['order_ad']) && $comments_settings['order_ad'] != '') {
				$this->data['sorting'] = strtolower($comments_settings['order_ad']);
			}
			if (isset($comments_settings['order']) && $comments_settings['order'] != '') {
				$this->data['order'] = strtolower($comments_settings['order']);
			}
			if (isset($this->data['order']) && $this->data['order'] == 'sort') {
				$comments_order = 'comment_id';
			}
			if (isset($this->data['order']) && $this->data['order'] == 'date') {
				$comments_order = 'date_available';
			}
			if (isset($this->data['order']) && $this->data['order'] == 'rating') {
				$comments_order = 'rating';
			}
			if (isset($this->data['order']) && $this->data['order'] == 'rate') {
				$comments_order = 'delta';
			}
			if (isset($get['sorting'])) {
				if ($get['sorting'] == 'none') {
					$this->data['sorting'] = $this->data['sorting'];
				} else
					$this->data['sorting'] = $get['sorting'];
			}
			if (isset($this->data['thislist']['view_captcha']) && $this->data['thislist']['view_captcha'] == 0) {
				$this->data['captcha_status'] = false;
			}
			if (((isset($this->data['thislist']['visual_editor']) && isset($this->data['thislist']['comment_must']) && $this->data['thislist']['comment_must'] && $this->data['thislist']['visual_editor'])) || !isset($this->data['thislist']['visual_editor'])) {
				$this->data['visual_editor'] = true;
				$this->document->addScript('catalog/view/javascript/wysibb/jquery.wysibb.min.js');
				$this->document->addStyle('catalog/view/javascript/wysibb/theme/default/wbbtheme.css');
				$scriptfile = 'view/javascript/wysibb/lang/' . $this->config->get('config_language') . '.js';
				if (file_exists(DIR_APPLICATION . $scriptfile)) {
					$this->document->addScript('catalog/' . $scriptfile);
				}
				$this->document->addScript('catalog/view/javascript/blog/blog.bbimage.js');
				$this->document->addScript('catalog/view/javascript/blog/rating/jquery.rating.js');
				$this->document->addStyle('catalog/view/javascript/blog/rating/jquery.rating.css');
			} else {
				$this->data['visual_editor'] = false;
			}
			$thislist                     = $this->data['thislist'];
			$this->data['record_comment'] = $thislist;
			if (isset($thislist['order_ad']) && $thislist['order_ad'] != '') {
				$this->data['sorting'] = strtolower($thislist['order_ad']);
			}
			if (isset($get['sorting'])) {
				if ($get['sorting'] == 'none') {
					$this->data['sorting'] = $this->data['sorting'];
				} else
					$this->data['sorting'] = $get['sorting'];
			}
			$this->data['comments'] = array();
			if (isset($thislist['status_language'])) {
				if ($thislist['status_language']) {
					$this->registry->set("status_language", true);
				} else {
					$this->registry->set("status_language", false);
				}
			} else {
				$this->registry->set("status_language", true);
			}
			$this->data['comment_total'] = $comment_total = $this->model_record_treecomments->getTotalCommentsByMarkId($this->data['mark_id'], $this->data['mark'], $this->data['thislist']);
			if (isset($thislist['number_comments']))
				$this->data['number_comments'] = $thislist['number_comments'];
			else
				$this->data['number_comments'] = '';
			if ($this->data['number_comments'] == '')
				$this->data['number_comments'] = 10;
			if (isset($_COOKIE["karma_" . $this->data['mark']])) {
				$karma_cookie = unserialize(base64_decode($_COOKIE["karma_" . $this->data['mark']]));
			} else {
				$karma_cookie = Array();
			}
			$mark = $this->data['mark'];
			if (!isset($this->data['settings_general']['complete_status']))
				$this->data['settings_general']['complete_status'] = false;
			$data    = array(
				'status' => $this->data['settings_general']['complete_status'],
				$mark => $this->data['mark_id'],
				'start' => ($page - 1) * $this->data['number_comments'],
				'limit' => $this->data['number_comments']
			);
			/***********************************************************************************************************/
			$results = $this->model_record_treecomments->getCommentsByMarkId($data, $mark, $this->data['thislist']);
			if (isset($this->data['thislist']['admin_name']) && $this->data['thislist']['admin_name'] != '') {
				$this->data['admin_name'] = array_flip(explode(";", trim($this->data['thislist']['admin_name'])));
			} else {
				$this->data['admin_name'] = array();
			}
			if ($this->customer->isLogged()) {
				$customer_id = $this->customer->getId();
			} else {
				$customer_id = false;
			}
			$this->data[$this->data['mark']] = $this->data['mark_id'];
			$results_rates                   = $this->model_record_treecomments->getRatesByMarkId($this->data['mark_id'], $customer_id, $this->data['mark']);
			if (!$customer_id == -1) {
				$customer_id = false;
			}
			if (is_array($results) && count($results) > 0) {
				$this->data['fields'] = array();
				if (isset($thislist['addfields'])) {
					usort($thislist['addfields'], 'comp_field');
					$this->data['fields'] = $thislist['addfields'];
				}
				$this->load->model('record/fields');
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
				$resa = NULL;
				foreach ($results as $num => $res1) {
					$resa[$num] = $res1;
					if (isset($results_rates[$res1['review_id']])) {
						$resa[$num]['delta']                 = $results_rates[$res1['review_id']]['rate_delta'];
						$resa[$num]['rate_count']            = $results_rates[$res1['review_id']]['rate_count'];
						$resa[$num]['rate_count_blog_plus']  = $results_rates[$res1['review_id']]['rate_delta_blog_plus'];
						$resa[$num]['rate_count_blog_minus'] = $results_rates[$res1['review_id']]['rate_delta_blog_minus'];
						$resa[$num]['customer_delta']        = $results_rates[$res1['review_id']]['customer_delta'];
					} else {
						$resa[$num]['customer_delta']        = 0;
						$resa[$num]['delta']                 = 0;
						$resa[$num]['rate_count']            = 0;
						$resa[$num]['rate_count_blog_plus']  = 0;
						$resa[$num]['rate_count_blog_minus'] = 0;
					}
					$resa[$num]['hsort'] = '';
					$mmm                 = NULL;
					$kkk                 = '';
					$wh                  = strlen($res1['sorthex']) / 4;
					for ($i = 0; $i < $wh; $i++) {
						$mmm[$i] = str_pad(dechex(65535 - hexdec(substr($res1['sorthex'], $i * 4, 4))), 4, "F", STR_PAD_LEFT);
						$sortmy  = substr($res1['sorthex'], $i * 4, 4);
						$kkk     = $kkk . $sortmy;
					}
					$ssorthex = '';
					if (is_array($mmm)) {
						foreach ($mmm as $num1 => $val) {
							$ssorthex = $ssorthex . $val;
						}
					}
					if ($this->data['sorting'] != 'asc') {
						$resa[$num]['sorthex'] = $ssorthex;
					} else {
						$resa[$num]['sorthex'] = $kkk;
					}
					$resa[$num]['hsort'] = $kkk;
				}
				$results = NULL;
				$results = $resa;
				uasort($results, 'sdesc');
				$i = 0;
				foreach ($results as $num => $result) {
					$f         = 0;
					$addfields = array();
					foreach ($result as $field_key => $field) {
						foreach ($this->data['fields'] as $num_db => $field_db) {
							if (trim($field_key) == trim($field_db['field_name'])) {
								$field_db['value'] = $field_db['text'] = $result[$field_key];
								$addfields[$f]     = $field_db;
								break;
							} else {
							}
						}
						$f++;
					}
					usort($addfields, 'comp_field');
					if (!isset($result['date_available']))
						$result['date_available'] = $result['date_added'];
					if (isset($this->data['settings_general']['format_date'])) {
					} else {
						$this->data['settings_general']['format_date'] = $this->language->get('text_date');
					}
					if (isset($this->data['settings_general']['format_hours'])) {
					} else {
						$this->data['settings_general']['format_hours'] = $this->language->get('text_hours');
					}
					if (isset($this->data['settings_general']['format_time']) && $this->data['settings_general']['format_time'] && date($this->data['settings_general']['format_date']) == date($this->data['settings_general']['format_date'], strtotime($result['date_added']))) {
						$date_str = $this->language->get('text_today');
					} else {
						$date_str = rdate($this, $this->data['settings_general']['format_date'], strtotime($result['date_added']));
					}
					$date_added = $date_str . (rdate($this, $this->data['settings_general']['format_hours'], strtotime($result['date_added'])));
					$text       = strip_tags($result['text']);
					$text       = nl2br($text);
					if ($this->data['visual_editor']) {
						if (isset($this->data['thislist']['bbwidth']) && $this->data['thislist']['bbwidth'] != '') {
							$width = $this->data['thislist']['bbwidth'];
						} else {
							$width = '160px';
						}
						require_once(DIR_SYSTEM . 'library/bbcode/Parser.php');
						$parser = new JBBCode\Parser();
						//$parser->addBBCode("\r\n", '', true, true);
						$parser->addBBCode("quote", '<div class="quote">{param}</div>', true, true);
						$parser->addBBCode("quote", '<div class="quote">{param}</div>', false, false);
						$parser->addBBCode("size", '<span style="font-size:{option}%;">{param}</span>', true, true);
						$parser->addBBCode("code", '<pre class="code">{param}</pre>', false, false, 1);
						$parser->addBBCode("video", '<div style="overflow:hidden; "><iframe width="300" height="200" src="https://www.youtube.com/embed/{param}" frameborder="0" allowfullscreen></iframe></div>', false, false, 1);
						$parser->addBBCode("img", '<a href="{param}" class="imagebox" rel="imagebox" style="overflow: hidden;"><img class="bbimage" alt="" width="' . $width . '" src="{param}"></a>');
						$parser->addBBCode("url", '<a href="{param}" target="_blank" rel="nofollow">{param}</a>', false, false);
						$parser->addBBCode("url", '<a href="{option}" target="_blank" rel="nofollow">{param}</a>', true, true);
						$parser->addCodeDefinitionSet(new JBBCode\DefaultCodeDefinitionSet());
						$parser->parse($text);
						$text = $parser->getAsHtml();
					}
					$this->data['voted'] = false;
					if (!$customer_id) {
						if (!empty($karma_cookie)) {
							if (isset($karma_cookie[$result['review_id']])) {
								$this->data['voted'] = true;
							}
						}
					}
					if ($customer_id) {
						$this->data['voted'] = $result['customer_delta'];
					}
					if (!isset($result['buyproduct']))
						$result['buyproduct'] = false;
					if (isset($result['avatar'])) {
						$this->data['avatar'] = $result['avatar'];
					} else {
						$this->data['avatar'] = '';
					}
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
					if ($this->data['avatar'] == '') {
						if (file_exists(DIR_IMAGE . 'no_image.jpg')) {
							$no_image = 'no_image.jpg';
						}
						if (file_exists(DIR_IMAGE . 'no_image.png')) {
							$no_image = 'no_image.png';
						}
						if (isset($this->data['settings_general']['avatar_admin']) && $this->data['settings_general']['avatar_admin'] != '' && isset($this->data['admin_name'][trim($result['author'])])) {
							$this->data['avatar'] = $this->model_tool_image->resizeme($this->data['settings_general']['avatar_admin'], $this->data['avatar_width'], $this->data['avatar_height']);
						} else {
							if (isset($this->data['settings_general']['avatar_buyproduct']) && $this->data['settings_general']['avatar_buyproduct'] != '' && isset($result['buyproduct']) && $result['buyproduct'] != '') {
								$this->data['avatar'] = $this->model_tool_image->resizeme($this->data['settings_general']['avatar_buyproduct'], $this->data['avatar_width'], $this->data['avatar_height']);
							} else {
								if (isset($this->data['settings_general']['avatar_buy']) && $this->data['settings_general']['avatar_buy'] != '' && isset($result['buy']) && $result['buy'] != '') {
									$this->data['avatar'] = $this->model_tool_image->resizeme($this->data['settings_general']['avatar_buy'], $this->data['avatar_width'], $this->data['avatar_height']);
								} else {
									if (isset($this->data['settings_general']['avatar_reg']) && $this->data['settings_general']['avatar_reg'] != '' && isset($result['customer_id']) && $result['customer_id'] > 0) {
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
						}
					} else {
						$this->data['avatar'] = $this->model_tool_image->resizeme($this->data['avatar'], $this->data['avatar_width'], $this->data['avatar_height']);
					}
					if ($result['rating_mark'] != '0') {
						$result['rating'] = 0;
					}
					$this->data['comments'][] = array(
						'comment_id' => $result['review_id'],
						'avatar' => $this->data['avatar'],
						'sorthex' => $result['sorthex'],
						'buy' => $result['buy'],
						'buyproduct' => $result['buyproduct'],
						'customer_id' => $result['customer_id'],
						'customer' => $customer_id,
						'voted' => $this->data['voted'],
						'customer_delta' => $result['customer_delta'],
						'level' => (strlen($result['sorthex']) / 4) - 1,
						'parent_id' => $result['parent_id'],
						'author' => $result['author'],
						'text' => $text,
						'rating' => (int) $result['rating'],
						'rating_mark' => (int) $result['rating_mark'],
						'hsort' => $result['hsort'],
						'myarray' => $mmm,
						'fields' => $addfields,
						'delta' => $result['delta'],
						'rate_count' => $result['rate_count'],
						'rate_count_blog_plus' => $result['rate_count_blog_plus'],
						'rate_count_blog_minus' => $result['rate_count_blog_minus'],
						'comments' => sprintf($this->language->get('text_comments'), (int) $comment_total),
						'date_added' => $date_added,
						'date_available' => $result['date_available']
					);
					$i++;
				}
			}
			if (!function_exists('my_sort_div_mark')) {
				function my_sort_div_mark($data, $parent = 0, $sorting, $field, $lev = -1)
				{
					$arr = $data[$parent];
					usort($arr, array(
						new cmp_my_comment($field, $sorting),
						"my_cmp"
					));
					$lev = $lev + 1;
					for ($i = 0; $i < count($arr); $i++) {
						$arr[$i]['level']               = $lev;
						$z[]                            = $arr[$i];
						$z[count($z) - 1]['flag_start'] = 1;
						$z[count($z) - 1]['flag_end']   = 0;
						if (isset($data[$arr[$i]['comment_id']])) {
							$m = my_sort_div_mark($data, $arr[$i]['comment_id'], $sorting, $field, $lev);
							$z = array_merge($z, $m);
						}
						if (isset($z[count($z) - 1]['flag_end']))
							$z[count($z) - 1]['flag_end']++;
						else
							$z[count($z) - 1]['flag_end'] = 1;
					}
					return $z;
				}
			}
			if (count($this->data['comments']) > 0) {
				for ($i = 0, $c = count($this->data['comments']); $i < $c; $i++) {
					$new_arr[$this->data['comments'][$i]['parent_id']][] = $this->data['comments'][$i];
				}
				$mycomments = my_sort_div_mark($new_arr, 0, $this->data['sorting'], $comments_order);
				$i          = 0;
				foreach ($mycomments as $num => $result) {
					if (($i >= (($page - 1) * $this->data['number_comments'])) && ($i < ((($page - 1) * $this->data['number_comments']) + $this->data['number_comments']))) {
						$this->data['mycomments'][$i] = $result;
					}
					$i++;
				}
			} else {
				$this->data['mycomments'] = Array();
			}
			if (!isset($this->data['mycomments'])) {
				$this->data['mycomments'] = array();
			}
			$this->data['karma_voted'] = false;
			if (!$customer_id) {
				if (isset($_COOKIE["karma_" . $this->data['mark']])) {
					$karma_cookie = unserialize(base64_decode($_COOKIE["karma_" . $this->data['mark']]));
				} else {
					$karma_cookie = Array();
				}
				if (!empty($karma_cookie)) {
					foreach ($karma_cookie as $id => $mark_id) {
						if (isset($mark_id['id'])) {
							if ($mark_id['id'] == $this->data['mark_id']) {
								$this->data['karma_voted'] = true;
							}
						} else {
							setcookie("karma_" . $this->data['mark'], '', time() + 60 * 60 * 24 * 555, '/', $this->request->server['HTTP_HOST']);
						}
					}
				}
			} else {
				$check_rate_num = $this->model_record_treecomments->checkRateNum($this->data, $this->data['mark']);
				foreach ($check_rate_num as $id => $mark_id) {
					if ($id == $this->data['mark'] && $mark_id == $this->data['mark_id']) {
						$this->data['karma_voted'] = true;
					}
				}
			}
			$url_end = "";
			foreach ($this->request->get as $get_key => $get_val) {
				if ($get_key != 'route' && $get_key != 'prefix' && $get_key != '_route_' && $get_key != 'wpage' && $get_key != 'cmswidget' && $get_key != $get_pagination) {
					$url_end .= "&" . (string) $get_key . "=" . (string) $get_val;
				}
			}
			$this->data['cmswidget']  = $cmswidget;
			$link_url                 = $this->url->link($mark_route, $this->data['mark'] . '=' . $this->data['mark_id'] . '&' . $get_pagination . '=cmswidget-' . $cmswidget . '_sorting-' . $this->data['sorting'] . '_wpage-{page}' . '#cmswidget-' . $cmswidget);
			$pagination               = new Pagination();
			$pagination->total        = $comment_total;
			$pagination->page         = $page;
			$pagination->limit        = $this->data['number_comments'];
			$pagination->text         = $this->language->get('text_pagination');
			$pagination->url          = $link_url;
			$this->data['pagination'] = $pagination->render();
			$data_statistics          = $this->ratingStatistics($this->data);
			$template                 = 'rozetka.tpl';
			if (isset($thislist['blog_template_comment']) && $thislist['blog_template_comment'] != '') {
				$template = $thislist['blog_template_comment'];
			}
			if (isset($this->data['category_design']['blog_template_comment']) && $this->data['category_design']['blog_template_comment'] != '') {
				$template = $this->data['category_design']['blog_template_comment'];
			}
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/agootemplates/module/treecomments/' . $template)) {
				$this_template = $this->config->get('config_template') . '/template/agootemplates/module/treecomments/' . $template;
			} else {
				if (file_exists(DIR_TEMPLATE . 'default/template/agootemplates/module/treecomments/' . $template)) {
					$this_template = 'default/template/agootemplates/module/treecomments/' . $template;
				} else {
					$this_template = 'default/template/agootemplates/module/treecomments/rozetka.tpl';
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
			$this->data['text_wait']                = $this->language->get('text_wait');
			$this->data['theme']                    = $this->config->get('config_template');
			$this->data['ascp_widgets']             = $this->config->get('ascp_widgets');
			$this->data['settings_widget']          = $this->data['thislist'];
			$this->data['theme_stars']              = $this->getThemeStars('image/blogstars-1.png');
			if (isset($this->session->data['token'])) {
				$this->data['token'] = $this->session->data['token'];
			} else {
				$this->data['token'] = '';
			}
			$this->template         = $this_template;
			$this->data['language'] = $this->language;
			if (SC_VERSION < 20) {
				$html = $this->render();
			} else {
				if (!is_array($this->data))
					$this->data = array();
				$html = $this->load->view($this->template, $this->data);
			}
			if (isset($get['sc_ajax']) && $get['sc_ajax'] == 1) {
				$this->response->setOutput($html);
				//return $html;
			} else {
				return $html;
			}
		}
	}
	public function ratingStatistics($data)
	{
		$this->data                                            = $data;
		$this->data['comments_stat']['count_comments']         = count($data['comments']);
		$this->data['comments_stat']['count_ratings']          = 0;
		$this->data['comments_stat']['count_ratings_exelent']  = 0;
		$this->data['comments_stat']['count_ratings_good']     = 0;
		$this->data['comments_stat']['count_ratings_negative'] = 0;
		$this->data['comments_stat']['count_rate']             = 0;
		$this->data['comments_stat']['count_rate_plus']        = 0;
		$this->data['comments_stat']['count_rate_minus']       = 0;
		foreach ($data['comments'] as $num => $comment) {
			if ($comment['rating_mark'] == 0) {
				$this->data['comments_stat']['count_ratings']++;
				if ($comment['rating'] > 0 && $comment['rating'] < 3) {
					$this->data['comments_stat']['count_ratings_negative']++;
				}
				if ($comment['rating'] > 2 && $comment['rating'] < 4) {
					$this->data['comments_stat']['count_ratings_good']++;
				}
				if ($comment['rating'] > 3) {
					$this->data['comments_stat']['count_ratings_exelent']++;
				}
			}
			$this->data['comments_stat']['count_rate'] = $this->data['comments_stat']['count_rate'] + $comment['rate_count'];
			$this->data['comments_stat']['count_rate_plus'] += $comment['rate_count_blog_plus'];
			$this->data['comments_stat']['count_rate_minus'] += $comment['rate_count_blog_minus'];
			foreach ($comment['fields'] as $f_num => $field) {
				if ($field['field_type'] == 'rating') {
					if ($field['value'] != '' && $field['value'] > 0) {
						$this->data['comments_stat']['fields'][$field['field_name']]['field_description'] = $field['field_description'][$this->config->get('config_language_id')];
						if (!isset($this->data['comments_stat']['fields'][$field['field_name']]['count_ratings']))
							$this->data['comments_stat']['fields'][$field['field_name']]['count_ratings'] = 0;
						$this->data['comments_stat']['fields'][$field['field_name']]['count_ratings']++;
						if (!isset($this->data['comments_stat']['fields'][$field['field_name']]['count_value']))
							$this->data['comments_stat']['fields'][$field['field_name']]['count_value'] = 0;
						$this->data['comments_stat']['fields'][$field['field_name']]['count_value'] += $field['value'];
					}
				}
			}
		}
		//print_my($this->data['comments_stat'] );
		//print_my($this->data['comments'] );
		return $this->data;
	}
	public function write()
	{
		//print_my($this->request->post);
		$this->config->set("blog_work", true);
		$this->request->post['rating_mark'] = 0;
		$this->data['settings']             = array();
		$this->data['mark']                 = false;
		$product_id                         = 0;
		$this->data['config_language_id']   = $this->config->get('config_language_id');
		$this->data['http_image']           = getHttpImage($this);
		if (isset($this->request->get['product_id'])) {
			$this->data['mark'] = 'product_id';
			$mark_route         = 'product/product';
			$product_id         = $this->request->get['product_id'];
		}
		if (isset($this->request->get['record_id'])) {
			$this->data['mark'] = 'record_id';
			$mark_route         = 'record/record';
			$product_id         = $this->request->get['record_id'];
			$this->load->model('record/blog');
			$this->load->model('record/path');
			$blog_info                     = $this->model_record_path->pathbyrecord($product_id);
			$this->request->get['blog_id'] = $blog_info['path'];
			if (isset($blog_info['path'])) {
				$path = '';
				foreach (explode('_', $blog_info['path']) as $path_id) {
					$blog_id = $path_id;
				}
				$blog_info = $this->model_record_blog->getBlog($blog_id);
			} else {
				$blog_id = false;
			}
			if (isset($blog_info['design']) && $blog_info['design'] != '') {
				$this->data['settings_blog'] = unserialize($blog_info['design']);
			} else {
				$this->data['settings_blog'] = Array();
			}
			$this->load->model('record/record');
			$record_info = $this->model_record_record->getRecord($product_id);
			if ($record_info) {
				$this->data['settings_record'] = unserialize($record_info['comment']);
			} else {
				$this->data['settings_record'] = array();
			}
			$this->data['settings'] = array_merge($this->data['settings_blog'], $this->data['settings_record']);
		}
		$json = array();
		$html = "<script>var wdata = new Array()
							wdata['code'] 	 = 'error'
							wdata['message'] = 'Error'</script>";
		$this->load->model('record/treecomments');
		if (isset($this->request->get['parent'])) {
			if ($this->request->get['parent'] == '')
				$this->request->get['parent'] = 0;
		} else {
			$this->request->get['parent'] = 0;
		}
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'p.sort_order';
		}
		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
		}
		if (isset($this->request->get['wpage'])) {
			$page = $this->request->get['wpage'];
		} else {
			$page = 1;
		}
		if (isset($this->request->get['limit'])) {
			$limit = $this->request->get['limit'];
		} else {
			$limit = $this->config->get('config_catalog_limit');
		}
		if (SC_VERSION > 15) {
			$get_Customer_GroupId = 'getGroupId';
		} else {
			$get_Customer_GroupId = 'getCustomerGroupId';
		}
		if ($this->customer->isLogged()) {
			$customer_group_id = $this->customer->$get_Customer_GroupId();
			$captcha_status    = false;
			$customer_id       = $this->customer->getId();
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
			$captcha_status    = true;
			$customer          = false;
			$customer_id       = false;
		}
		$this->data['ascp_widgets'] = $this->config->get('ascp_widgets');
		if (isset($this->request->get['ascp_widgets_position'])) {
			$ascp_widgets_position = $this->request->get['ascp_widgets_position'];
		} else {
			$ascp_widgets_position = 0;
		}
		if (isset($this->request->get['ascp_widgets_position'])) {
			$this->data['cmswidget'] = $this->request->get['cmswidget'] = (int) $this->request->get['ascp_widgets_position'];
		}
		$set_thislist = Array(
			'status' => '1',
			'status_reg' => '0',
			'status_now' => '0'
		);
		if (isset($this->data['ascp_widgets'][$ascp_widgets_position]) && !empty($this->data['ascp_widgets'][$ascp_widgets_position])) {
			$thislist = $this->data['ascp_widgets'][$ascp_widgets_position];
		} else {
			$thislist = Array(
				'status' => '1',
				'status_reg' => '0',
				'status_now' => '0',
				'rating_must' => '1'
			);
		}
		$thislist                                     = $thislist + $set_thislist;
		$thislist['comment_signer']                   = $thislist['status_now'];
		$thislist                                     = $this->data['settings'] + $thislist;
		$k                                            = serialize($thislist);
		$this->data['comment_status']                 = $thislist['status'];
		$this->data['comment_status_reg']             = $thislist['status_reg'];
		$this->data['comment_status_now']             = $thislist['status_now'];
		$this->data['comment']                        = $thislist;
		$this->request->post['comment']['status']     = $thislist['status'];
		$this->request->post['comment']['status_reg'] = $thislist['status_reg'];
		$this->request->post['comment']['status_now'] = $thislist['status_now'];
		$this->request->post['status']                = $thislist['status_now'];
		$this->language->load('seocms/record');
		$this->language->load('product/product');
		if (isset($thislist['langfile']) && $thislist['langfile'] != '') {
			$this->language->load($thislist['langfile']);
		} else {
			$this->language->load('seocms/blog');
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
		$this->load->model('record/fields');
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
		if (isset($this->request->post['email_ghost']) && $this->request->post['email_ghost'] != '') {
			if (preg_match("|^[-0-9a-z_\.]+@[-0-9a-z_^\.]+\.[a-z]{2,6}$|i", $this->request->post['email_ghost'])) {
			} else {
				$json['error'] = $this->language->get('text_error_email');
				$html          = "<script>var wdata = new Array()
								wdata['code'] 	 = 'error'
								wdata['message'] = '" . $this->language->get('text_error_email') . "'</script>";
			}
		}
		if ((isset($thislist['signer_answer']) && $thislist['signer_answer']) && (isset($thislist['signer_answer_require']) && $thislist['signer_answer_require'])) {
			$signer_answer_error = false;
			if (!$this->customer->isLogged()) {
				if ((!isset($this->request->post['email_ghost']) || (utf8_strlen($this->request->post['email_ghost']) < 5 || utf8_strlen($this->request->post['email_ghost']) > 256))) {
					$signer_answer_error = true;
				}
			} else {
				if (!isset($this->request->post['signer_answer']) || !$this->request->post['signer_answer']) {
					$signer_answer_error = true;
				}
			}
			if ($signer_answer_error) {
				$json['error'] = $this->language->get('error_text');
				$html          = "<script>var wdata = new Array()
									wdata['code'] 	 = 'error'
									wdata['message'] = '" . $this->language->get('signer_answer_require') . "'</script>";
			}
		}
		if (!isset($this->request->post['name']) || ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 33))) {
			$json['error'] = $this->language->get('error_name');
			$html          = "<script>var wdata = new Array()
							wdata['code'] 	 = 'error'
							wdata['message'] = '" . $this->language->get('error_name') . "'</script>";
		} else {
			$json['login'] = $this->request->post['name'];
		}
		if ((isset($thislist['comment_must']) && $thislist['comment_must']) || !isset($thislist['comment_must'])) {
			if (!isset($this->request->post['text']) || (utf8_strlen($this->request->post['text']) < 3 || utf8_strlen($this->request->post['text']) > 1000)) {
				$json['error'] = $this->language->get('error_text');
				$html          = "<script>var wdata = new Array()
								wdata['code'] 	 = 'error'
								wdata['message'] = '" . $this->language->get('error_text') . "'</script>";
			}
		}
		if (!isset($this->request->post['rating']) && $thislist['rating_must'] == 1) {
			$json['error'] = $this->language->get('error_rating');
			$html          = "<script>var wdata = new Array()
							wdata['code'] 	 = 'error'
							wdata['message'] = '" . $this->language->get('error_rating') . "'</script>";
		}
		if (isset($thislist['rating_must']) && $thislist['rating_must'] == 0 && !isset($this->request->post['rating'])) {
			$this->request->post['rating']      = 5;
			$this->request->post['rating_mark'] = 1;
		}
		if (!isset($this->session->data['captcha']) || (isset($this->request->post['captcha']) && strtolower($this->session->data['captcha']) != strtolower($this->request->post['captcha']))) {
			if ($captcha_status) {
				$json['error'] = $this->language->get('error_captcha');
				$html          = "<script>var wdata = new Array()
							wdata['code'] 	 = 'error'
							wdata['message'] = '" . $this->language->get('error_captcha') . "'</script>";
			}
		}
		if ($thislist['status_reg'] && !$this->customer->isLogged()) {
			$error_reg     = sprintf($this->language->get('error_reg'), $this->url->link('account/login'), $this->url->link('account/register'));
			$json['error'] = $error_reg;
			$html          = "<script>var wdata = new Array()
							wdata['code'] 	 = 'error'
							wdata['message'] = '" . $error_reg . "'</script>";
		}
		$error = '';
		foreach ($this->data['fields'] as $num => $field) {
			if (isset($this->request->post['af'][$field['field_name']]) && $this->request->post['af'][$field['field_name']] == '' && isset($field['field_must']) && $field['field_must']) {
				if (isset($field['field_error'][$this->config->get('config_language_id')])) {
					$error = $error . (preg_replace("/(\r\n)+/i", "", html_entity_decode($field['field_error'][$this->config->get('config_language_id')], ENT_QUOTES, 'UTF-8'))) . "<br>";
					$error = preg_replace("/(\')+/i", '"', $error);
				}
				$json['error'] = $error;
				$html          = "<script>var wdata = new Array()
							wdata['code'] 	 = 'error'
							wdata['message'] = '" . $error . "'</script>";
			}
		}
		if (!isset($json['login']) || $json['login'] == '') {
			if ($this->customer->isLogged()) {
				$json['login']       = $this->customer->getFirstName() . " " . $this->customer->getLastName();
				$json['customer_id'] = $this->data['customer_id'] = $this->customer->getId();
			} else {
				$json['login']       = $this->language->get('text_anonymus');
				$json['customer_id'] = false;
			}
		}
		$this->load->model('record/treecomments');
		$this->data['karma_voted'] = false;
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && !isset($json['error'])) {
			/*********************************************************************************************************************/
			$this->request->post['cmswidget'] = $ascp_widgets_position;
			$comment_id                       = $this->model_record_treecomments->addComment($this->request->get[$this->data['mark']], $this->request->post, $this->request->get, $this->data['mark']);
			if (!$customer_id) {
				if (isset($_COOKIE["karma_" . $this->data['mark']])) {
					$karma_cookie = unserialize(base64_decode($_COOKIE["karma_" . $this->data['mark']]));
				} else {
					$karma_cookie = Array();
				}
				$karma_cookie[$comment_id]['id'] = $product_id;
				foreach ($karma_cookie as $id => $mark_id) {
					if ($mark_id['id'] == $product_id) {
						$this->data['karma_voted'] = true;
					}
				}
				setcookie("karma_" . $this->data['mark'], base64_encode(serialize($karma_cookie)), time() + 60 * 60 * 24 * 555, '/', $this->request->server['HTTP_HOST']);
			}
			$this->data['comment_count'] = $this->model_record_treecomments->getTotalCommentsByMarkId($product_id, $this->data['mark'], $thislist);
			if ($this->data['mark'] == 'product_id') {
				if (!class_exists('ModelCatalogProduct')) {
					$this->load->model('catalog/product');
				}
				$mark_info = $this->model_catalog_product->getProduct($product_id);
			}
			if ($this->data['mark'] == 'record_id') {
				$this->load->model('record/record');
				$mark_info = $this->model_record_record->getRecord($product_id);
			}
			$mark_info['comment_id'] = $comment_id;
			$this->cont('record/signer');
			$subscribeAnswerStatus = $this->controller_record_signer->subscribe($comment_id, $this->data['mark']);
			$this->controller_record_signer->signer($product_id, $mark_info, $thislist, $this->data['mark']);
			if (isset($thislist['langfile']) && $thislist['langfile'] != '') {
				$this->language->load($thislist['langfile']);
			} else {
				$this->language->load('seocms/blog');
			}
			$this->data['form_post'] = $this->request->post;
			$this->data['form_get']  = $this->request->get;
			if (isset($thislist['handler']) && $thislist['handler'] != '') {
				$exec = $this->exec_handler($thislist, $this->data);
			} else {
				$exec = '';
			}
			$review_count = sprintf($this->language->get('tab_review'), $this->data['comment_count']);
			if ($thislist['status_now']) {
				$json['success'] = $this->language->get('text_success_now');
				$html            = "<script>var wdata = new Array();
							wdata['code'] 	 = 'success';
							wdata['message'] = '" . $this->language->get('text_success_now') . "';
							wdata['login'] = '" . $json['login'] . "';

							wdata['review_count'] = '" . $review_count . "';
							</script>
							" . $exec;
			} else {
				$json['success'] = $this->language->get('text_success');
				$html            = "<script>var wdata = new Array();
							wdata['code'] 	 = 'success';
							wdata['message'] = '" . $this->language->get('text_success') . "';
							wdata['login'] = '" . $json['login'] . "';

							wdata['review_count'] = '" . $review_count . "';
							</script>
							" . $exec;
			}
		}
		$this->response->setOutput($html);
	}
	public function exec_handler($thislist, $data)
	{
		$this->data              = $data;
		$this->data['exec']      = html_entity_decode($thislist['handler'], ENT_QUOTES, 'UTF-8');
		$html_name               = "exec." . md5(serialize($thislist)) . "." . $this->config->get('config_language_id') . ".php";
		$file                    = DIR_CACHE . $html_name;
		$this->data['form_data'] = $data;
		//$this->deletecache('exec');
		//if (!file_exists($file) || (isset($thislist['cached']) && !$thislist['cached'])) {
		$handle                  = fopen($file, 'w');
		fwrite($handle, $this->data['exec']);
		fclose($handle);
		//}
		if (file_exists($file)) {
			$this->data['mark'] = "Mark";
			extract($this->data);
			ob_start();
			require($file);
			$exec = ob_get_contents();
			ob_end_clean();
		}
		return $exec;
	}
	private function deletecache($key)
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
	public function comments_vote()
	{
		$this->config->set("blog_work", true);
		if (isset($this->request->get['mark']) && $this->request->get['mark'] != '') {
			$this->data['mark'] = $this->request->get['mark'];
		} else {
			$this->data['mark'] = 'record_id';
		}
		$html             = "<script>var cvdata = new Array()
							 cvdata['code']    = 'error'
							 cvdata['message'] = 'Error'</script>";
		$json             = array();
		$json['messages'] = 'ok';
		$this->load->model('record/treecomments');
		if (isset($this->request->post['comment_id'])) {
			$comment_id = $this->request->post['comment_id'];
		} else {
			$comment_id = 0;
		}
		if (isset($this->request->post['delta'])) {
			$delta = $this->request->post['delta'];
			if ($delta > 1) {
				$delta = 1;
			}
			if ($delta < -1) {
				$delta = -1;
			}
		} else {
			$delta = 0;
		}
		if ($this->customer->isLogged()) {
			$customer_id = $this->customer->getId();
		} else {
			$customer_id = false;
		}
		$json['customer_id']        = $customer_id;
		$this->data['comment_id']   = $comment_id;
		$this->data['customer_id']  = $customer_id;
		$this->data['delta']        = $delta;
		$this->data['ascp_widgets'] = $this->config->get('ascp_widgets');
		if (isset($this->request->get['ascp_widgets_position'])) {
			$ascp_widgets_position = $this->request->get['ascp_widgets_position'];
		} else {
			$ascp_widgets_position = 0;
		}
		$set_thislist = Array(
			'status' => '1',
			'status_reg' => '0',
			'status_now' => '0',
			'rating_num' => ''
		);
		if (isset($this->data['ascp_widgets'][$ascp_widgets_position]) && !empty($this->data['ascp_widgets'][$ascp_widgets_position])) {
			$thislist = $this->data['ascp_widgets'][$ascp_widgets_position];
		} else {
			$thislist = Array(
				'status' => '1',
				'status_reg' => '0',
				'status_now' => '0',
				'rating_num' => ''
			);
		}
		$thislist = $thislist + $set_thislist;
		$this->language->load('seocms/record');
		$this->language->load('seocms/signer');
		if (isset($thislist['langfile']) && $thislist['langfile'] != '') {
			$this->language->load($thislist['langfile']);
		}
		$this->load->model('record/treecomments');
		$mark_info = $this->model_record_treecomments->getMarkbyComment($this->data, $this->data['mark']);
		if (isset($mark_info[$this->data['mark']]) && $mark_info[$this->data['mark']] != '') {
			$this->data[$this->data['mark']] = $mark_info[$this->data['mark']];
		} else {
			$this->data[$this->data['mark']] = '';
		}
		$check_rate_num['rating_num'] = 0;
		$rating_num                   = 0;
		$check_rate                   = $this->model_record_treecomments->checkRate($this->data, $this->data['mark']);
		$check_rate_self              = $this->model_record_treecomments->getCommentSelf($this->data, $this->data['mark']);
		$check_rate_num               = $this->model_record_treecomments->checkRateNum($this->data, $this->data['mark']);
		$record_settings              = $thislist;
		if (isset($thislist['karma_reg']) && $thislist['karma_reg'] == 0 && !$customer_id) {
			if (isset($_COOKIE["karma_" . $this->data['mark']])) {
				$karma_cookie = unserialize(base64_decode($_COOKIE["karma_" . $this->data['mark']]));
			} else {
				$karma_cookie = Array();
			}
			$check_rate_num['rating_num'] = 0;
			$num                          = 0;
			foreach ($karma_cookie as $id => $mark_id) {
				if ($mark_id['id'] == $this->data[$this->data['mark']]) {
					$num++;
					$check_rate_num['rating_num'] = $num;
				}
			}
			if (!isset($karma_cookie[$comment_id])) {
				$karma_cookie[$comment_id]['id'] = $this->data[$this->data['mark']];
				setcookie("karma_" . $this->data['mark'], base64_encode(serialize($karma_cookie)), time() + (60 * 60 * 24 * 555), '/', $this->request->server['HTTP_HOST']);
			} else {
				$check_rate = true;
			}
		}
		if (isset($record_settings['rating_num']) && $record_settings['rating_num'] != '') {
			$rating_num = $record_settings['rating_num'];
		} else {
			$rating_num = 10000;
		}
		if (isset($check_rate_num['rating_num']) && $check_rate_num['rating_num'] != '') {
			$voted_num = $check_rate_num['rating_num'];
		} else {
			$voted_num = $rating_num - 1;
		}
		if (!$check_rate && !$check_rate_self && ($voted_num < $rating_num)) {
			$this->model_record_treecomments->addRate($this->data, $this->data['mark']);
			$rate_info       = $this->model_record_treecomments->getRatesByCommentId($comment_id, $this->data['mark']);
			$json['success'] = $rate_info[0];
			$blog_plus       = "";
			if ($json['success']['rate_delta'] > 0)
				$blog_plus = "+";
			$json['success']['rate_delta'] = sprintf($blog_plus . "%d", $json['success']['rate_delta']);
		} else {
			if ($check_rate_self) {
				$json['messages'] = '';
				$json['success']  = $this->language->get('text_vote_self');
			} else {
				if ($customer_id || $check_rate) {
					$json['messages'] = '';
					$json['success']  = $this->language->get('text_voted');
				} else {
					$json['messages'] = '';
					$json['success']  = $this->language->get('text_vote_reg');
				}
			}
		}
		return $this->response->setOutput(json_encode($json));
	}
	public function captchadel()
	{
	}
	public function captcham()
	{
		$this->config->set("blog_work", true);
		$this->load->library('captcham5');
		if (!class_exists('Captcha')) {
			require_once(DIR_SYSTEM . 'library/captcham5.php');
		}
		$this->language->load('seocms/record');
		$this->data['entry_captcha']        = $this->language->get('entry_captcha');
		$this->data['entry_captcha_title']  = $this->language->get('entry_captcha_title');
		$this->data['entry_captcha_update'] = $this->language->get('entry_captcha_update');
		if ($this->customer->isLogged()) {
			$this->data['captcha_status'] = false;
		} else {
			$this->data['captcha_status']   = true;
			$captcha                        = new Captcha();
			$this->session->data['captcha'] = $this->code = $captcha->getCode();
			$this->data['captcha_keys']     = "";
			for ($i = 0; $i < strlen($this->session->data['captcha']); $i++) {
				$k   = rand(0, 1);
				$pos = strpos($this->data['captcha_keys'], $this->session->data['captcha'][$i]);
				if ($pos === false) {
					if ($k == 1)
						$this->data['captcha_keys'] = $this->data['captcha_keys'] . $this->session->data['captcha'][$i];
					else
						$this->data['captcha_keys'] = $this->session->data['captcha'][$i] . $this->data['captcha_keys'];
				}
			}
		}
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/agootemplates/module/captcham5.tpl')) {
			$this_template = $this->config->get('config_template') . '/template/agootemplates/module/captcham5.tpl';
		} else {
			$this_template = 'default/template/agootemplates/module/captcham5.tpl';
		}
		$this->data['theme'] = $this->config->get('config_template');
		$this->template      = $this_template;
		if (SC_VERSION < 20) {
			$html = $this->render();
		} else {
			if (!is_array($this->data))
				$this->data = array();
			$html = $this->load->view($this->template, $this->data);
		}
		$this->response->setOutput($html);
	}
	public function captcham5()
	{
		$this->config->set("blog_work", true);
		$this->load->library('captcham5');
		if (!class_exists('Captcha')) {
			require_once(DIR_SYSTEM . 'library/captcham5.php');
		}
		$this->language->load('seocms/record');
		$this->data['entry_captcha']        = $this->language->get('entry_captcha');
		$this->data['entry_captcha_title']  = $this->language->get('entry_captcha_title');
		$this->data['entry_captcha_update'] = $this->language->get('entry_captcha_update');
		if ($this->customer->isLogged()) {
			$this->data['captcha_status'] = false;
		} else {
			$this->data['captcha_status'] = true;
			$captcha                      = new Captcha();
			if (!isset($this->session->data['captcha'])) {
				$this->session->data['captcha'] = '';
			}
			$captcha->setCode($this->session->data['captcha']);
			$this->data['captcha_keys'] = "";
			for ($i = 0; $i < strlen($this->session->data['captcha']); $i++) {
				$k   = rand(0, 1);
				$pos = strpos($this->data['captcha_keys'], $this->session->data['captcha'][$i]);
				if ($pos === false) {
					if ($k == 1)
						$this->data['captcha_keys'] = $this->data['captcha_keys'] . $this->session->data['captcha'][$i];
					else
						$this->data['captcha_keys'] = $this->session->data['captcha'][$i] . $this->data['captcha_keys'];
				}
			}
		}
		$this->data['theme'] = $this->config->get('config_template');
		$captcha->captcha();
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
			$dir_catalog = DIR_APPLICATION;
		else
			$dir_catalog = DIR_CATALOG;
		$file = $dir_catalog . 'controller/' . $cont . '.php';
		if (file_exists($file)) {
			$this->cont_loading($cont, $file);
			return true;
		} else {
			$file = DIR_APPLICATION . 'controller/' . $cont . '.php';
			if (file_exists($file)) {
				$this->cont_loading($cont, $file);
			} else {
				trigger_error('Error: Could not load controller ' . $cont . '!');
				exit();
			}
		}
	}
	private function cont_loading($cont, $file)
	{
		$class = 'Controller' . preg_replace('/[^a-zA-Z0-9]/', '', $cont);
		include_once($file);
		$this->registry->set('controller_' . str_replace('/', '_', $cont), new $class($this->registry));
	}
	public function getHttpImage()
	{
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
		return $http_image;
	}
}
if (!class_exists('cmp_my_comment')) {
	class cmp_my_comment
	{
		var $key;
		var $ord;
		function __construct($key, $ord)
		{
			$this->key = $key;
			$this->ord = $ord;
		}
		function my_cmp($a, $b)
		{
			$key = $this->key;
			$ord = $this->ord;
			if ($key == 'date_available') {
				if (strtotime($a[$key]) > strtotime($b[$key])) {
					if ($ord == 'asc')
						return 1;
					if ($ord == 'desc')
						return -1;
				}
				if (strtotime($b[$key]) > strtotime($a[$key])) {
					if ($ord == 'asc')
						return -1;
					if ($ord == 'desc')
						return 1;
				}
			}
			if ($a[$key] > $b[$key]) {
				if ($ord == 'asc')
					return 1;
				if ($ord == 'desc')
					return -1;
			}
			if ($b[$key] > $a[$key]) {
				if ($ord == 'asc')
					return -1;
				if ($ord == 'desc')
					return 1;
			}
			return 0;
		}
	}
}

