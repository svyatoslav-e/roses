<?php
/* All rights reserved belong to the module, the module developers http://opencartadmin.com */
// http://opencartadmin.com © 2011-2016 All Rights Reserved
// Distribution, without the author's consent is prohibited
// Commercial license
class ControllerRecordSigner extends Controller
{
	protected $data;

	public function __construct($registry)
	{
		parent::__construct($registry);
		if (version_compare(phpversion(), '5.3.0', '<') == true) {
			exit('PHP5.3+ Required');
		}
		$this->cont('record/addrewrite');
		if (!$this->config->get('ascp_customer_groups')) {
			$this->cont('record/customer');
			$this->data = $this->controller_record_customer->customer_groups($this->data);
			$this->config->set('ascp_customer_groups', $this->data['customer_groups']);
		} else {
			$this->data['customer_groups'] = $this->config->get('ascp_customer_groups');
		}
	}

	public function signer($product_id, $record_info, $settings, $mark_id)
	{
		$record_settings = $settings;
		$pointer_answer  = '';

		$this->load->model('agoo/signer/signer');

		if (defined('DIR_CATALOG')) {
			$this->load->model('record/fields', array(), DIR_CATALOG);
		} else {			$this->load->model('record/fields');
		}

		if ($this->config->get('ascp_settings') != '') {
			$this->data['settings_general'] = $this->config->get('ascp_settings');
		} else {
			$this->data['settings_general'] = Array();
		}
		if (!isset($record_info['name']))
			$record_info['name'] = '';
		if (isset($record_info['comment_id'])) {
			$comment_info = $this->model_agoo_signer_signer->getComment($record_info['comment_id'], $mark_id);
		} else {
			$comment_info = Array();
		}
		if (isset($this->request->post['notify']) && $this->request->post['notify'] && $this->validateDelete()) {
			$notify_status = true;
		} else {
			$notify_status = false;
			;
		}
		$this->data['comment_id'] = $record_info['comment_id'];
		if ($settings['signer'] || $settings['signer_answer'] || $notify_status || $settings['comments_email'] != '') {
			$this->data['product_id']  = $product_id;
			$this->data['record_info'] = $record_info;
			if ($mark_id == 'product_id') {
				$route = 'product/product';
				if ($settings['signer_answer']) {
					$pointer_answer = 'review_id';
					$pointer_id     = $comment_info['parent_id'];
				}
			}
			if ($mark_id == 'record_id') {
				$route = 'record/record';
				if ($settings['signer_answer']) {
					$pointer_answer = 'comment_id';
					$pointer_id     = $comment_info['parent_id'];
				}
			}
			if ($this->registry->get('admin_work')) {
				if ($mark_id == 'record_id') {
					require_once(DIR_CATALOG . 'controller/common/seoblog.php');
					$seoUrl = new ControllerCommonSeoBlog($this->registry);
				} else {
					$seo_type = $this->config->get('config_seo_url_type');
					if (!$seo_type) {
						$seo_type = 'seo_url';
					}
					require_once(DIR_CATALOG . 'controller/common/' . $seo_type . '.php');
					$classSeo = 'ControllerCommon' . str_replace('_', '', $seo_type);
					$seoUrl   = new $classSeo($this->registry);
				}
				$urlToCatalog = new Url(HTTP_CATALOG, $this->config->get('config_secure') ? HTTPS_CATALOG : HTTP_CATALOG);
				$urlToCatalog->addRewrite($seoUrl);
				$correct_URL = $urlToCatalog->link($route, '&' . $mark_id . '=' . $this->data['product_id']);
				$pos         = strpos($correct_URL, 'http');
				if ($pos === false) {
					$correct_URL = ($this->config->get('config_secure') ? HTTPS_CATALOG : HTTP_CATALOG) . $correct_URL;
				}
				$this->data['record_info']['link'] = $correct_URL;
			} else {
				if (SC_VERSION > 15) {
					$this->load->controller('common/seoblog');
				} else {
					$this->getChild('common/seoblog');
				}
				$this->data['record_info']['link'] = $this->url->link($route, '&' . $mark_id . '=' . $this->data['product_id']);
			}
			if (!class_exists('Customer')) {
				if (file_exists(DIR_SYSTEM . 'library/customer.php')) {
					require_once(DIR_SYSTEM . 'library/customer.php');
				}
			}
			$obj = $this->registry->get('customer');
			if (!is_object($obj)) {
				$this->registry->set('customer', new Customer($this->registry));
			}
			unset($obj);
			$this->language->load('agoo/signer/signer');
			if (isset($settings['langfile']) && $settings['langfile'] != '') {
				$this->language->load($settings['langfile']);
			}
			$this->data['login']       = $this->customer->getFirstName() . " " . $this->customer->getLastName();
			$this->data['customer_id'] = $this->customer->getId();
			if ($this->config->get('config_logo') && file_exists(DIR_IMAGE . $this->config->get('config_logo'))) {
				$this->data['logo'] = $this->getHttpImage() . $this->config->get('config_logo');
			} else {
				$this->data['logo'] = false;
			}
			if (isset($this->request->post['text'])) {
				$this->request->post['text'] = strip_tags($this->request->post['text']);
			} else {
				$this->request->post['text'] = '';
			}
			$text  = $this->request->post['text'];
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
			$text = $parser->getAsHtml();
			if (isset($this->data['settings_general']['format_date'])) {
			} else {
				$this->data['settings_general']['format_date'] = $this->language->get('text_date');
			}
			if (isset($this->data['settings_general']['format_hours'])) {
			} else {
				$this->data['settings_general']['format_hours'] = $this->language->get('text_hours');
			}
			if (isset($this->data['settings_general']['format_time']) && $this->data['settings_general']['format_time']) {
				$date_str = $this->language->get('text_today');
			} else {
				$date_str = rdate($this, $this->data['settings_general']['format_date'], strtotime(date($this->data['settings_general']['format_date'] . $this->data['settings_general']['format_hours'])));
			}
			$date_added = $date_str . (rdate($this, $this->data['settings_general']['format_hours'], strtotime(date($this->data['settings_general']['format_date'] . $this->data['settings_general']['format_hours']))));
			$fields     = Array();
			if (isset($this->request->post['af'])) {				$addfields = $this->model_record_fields->getFieldsDesc();
				$f_name    = '';
				foreach ($this->request->post['af'] as $num => $value) {
					if (trim($value) != '') {
						if (trim($value) != '0') {
							if (isset($record_settings['addfields'])) {
								foreach ($addfields as $nm => $vl) {
									if ($vl['field_name'] == $num) {
										$f_name = $vl['field_description'];
									}
								}
							} else {
								$field_info = $this->model_record_fields->getFieldByName($num);
								$f_name     = $field_info['field_description'];
							}
							$fields[$this->db->escape(strip_tags($num))]['field_name'] = $f_name;
							$fields[$this->db->escape(strip_tags($num))]['text']       = $this->db->escape(strip_tags($value));
						}
					}
				}
			}
			$subject        = sprintf($this->language->get('text_subject'), $this->config->get('config_name'));
			$answer_signers = array();
			$record_signers = array();
			$admin_signers  = array();
			if ((isset($record_settings['status_now']) && $record_settings['status_now']) || $notify_status) {
				$record_signers = $this->model_agoo_signer_signer->getStatusId($this->data['product_id'], $mark_id);
				if ($settings['signer_answer']) {
					$answer_signers = $this->model_agoo_signer_signer->getStatusId($pointer_id, $pointer_answer);
				}
				$record_signers = array_merge($record_signers, $answer_signers);
			} else {
				$record_signers = array();
			}
			$this->data['answer_signers'] = $answer_signers;
			$this->data['record_signers'] = $record_signers;
			if (isset($settings['comments_email']) && $settings['comments_email'] != '') {
				$comments_email = explode(";", $settings['comments_email']);
				foreach ($comments_email as $num => $email) {
					$email = trim($email);
					array_push($admin_signers, Array(
						'id' => $this->data['product_id'],
						'pointer' => $mark_id,
						'customer_id' => $email,
						'admin' => true
					));
				}
			}
			if (!empty($admin_signers)) {
				foreach ($admin_signers as $par => $singers) {
					$template = '/template/agootemplates/module/blog_signer_mail.tpl';
					if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . $template)) {
						$this->template = $this->config->get('config_template') . $template;
					} else {
						$this->template = 'default' . $template;
					}
					$this->data['theme'] = $this->config->get('config_template');
					if (isset($singers['admin']) && $singers['admin']) {
						$customer['email']     = $singers['customer_id'];
						$customer['firstname'] = 'admin';
						$customer['lastname']  = '';
					} else {
						$customer['email']     = '';
						$customer['firstname'] = '';
						$customer['lastname']  = '';
					}
					$this->data['data']     = array(
						'text' => $text,
						'settings' => $record_settings,
						'fields' => $fields,
						'comment' => $this->request->post,
						'comment_db' => $comment_info,
						'record' => $this->data['record_info'],
						'date' => $date_added,
						'shop' => $this->config->get('config_name'),
						'signers' => serialize($singers),
						'signer_customer' => $customer
					);
					$this->data['language'] = $this->language;
					if (SC_VERSION < 20) {
						$html = $this->render();
					} else {
						if (!is_array($this->data))
							$this->data = array();
						$html = $this->load->view($this->template, $this->data);
					}
					$message                     = $html;
					$data_mail['customer_email'] = $customer['email'];
					$data_mail['message']        = $message;
					$data_mail['subject']        = $subject;
					$this->send_mail($data_mail);
					unset($data_mail);
				}
			}


			if (!empty($record_signers)) {
				$customer_email_array = array();
				foreach ($record_signers as $par => $singers) {
					$template = '/template/agootemplates/module/blog_signer_mail.tpl';
					if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . $template)) {
						$this->template = $this->config->get('config_template') . $template;
					} else {
						$this->template = 'default' . $template;
					}
					$this->data['theme'] = $this->config->get('config_template');
					if ($singers['customer_id'] == "0") {
						$customer['email']     = $singers['email'];
						$customer['firstname'] = $this->language->get('text_ghost');
						$customer['lastname']  = '';
					} else {
						$customer = $this->model_agoo_signer_signer->getCustomer($singers['customer_id']);
					}
					$this->data['data']     = array(
						'text' => $text,
						'settings' => $record_settings,
						'fields' => $fields,
						'comment' => $this->request->post,
						'comment_db' => $comment_info,
						'record' => $this->data['record_info'],
						'date' => $date_added,
						'shop' => $this->config->get('config_name'),
						'signers' => serialize($singers),
						'signer_customer' => $customer
					);
					$this->data['language'] = $this->language;
					if (SC_VERSION < 20) {
						$html = $this->render();
					} else {
						if (!is_array($this->data))
							$this->data = array();
						$html = $this->load->view($this->template, $this->data);
					}
					$message = $html;
					$subject = sprintf($this->language->get('text_subject'), $this->config->get('config_name'));
					if (((isset($comment_info['status']) && $comment_info['status']) && (isset($record_settings['comment_signer']) && $record_settings['comment_signer'])) && ($singers['customer_id'] != $this->data['customer_id']) && isset($customer['email']) || $notify_status) {
						if (!isset($customer_email_array[$customer['email']])) {
							$data_mail['customer_email'] = $customer['email'];
							$data_mail['message']        = $message;
							$data_mail['subject']        = $subject;
							$this->send_mail($data_mail);
							unset($data_mail);
							$customer_email_array[$customer['email']] = $customer['email'];
						}
					}
				}
			}
		}
	}
	public function send_mail($data)
	{
		$ver = VERSION;
		$ver = str_replace('.', '', $ver);
		$ver = (int) substr($ver, 0, 3);
		if (SC_VERSION < 20) {
			$mail            = new Mail();
			$mail->protocol  = $this->config->get('config_mail_protocol');
			$mail->parameter = $this->config->get('config_mail_parameter');
			$mail->hostname  = $this->config->get('config_smtp_host');
			$mail->username  = $this->config->get('config_smtp_username');
			$mail->password  = $this->config->get('config_smtp_password');
			$mail->port      = $this->config->get('config_smtp_port');
			$mail->timeout   = $this->config->get('config_smtp_timeout');
		} else {
			$mail = new Mail();
			if ($ver >= 203) {
				$mail->protocol      = $this->config->get('config_mail_protocol');
				$mail->parameter     = $this->config->get('config_mail_parameter');
				$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
				$mail->smtp_username = $this->config->get('config_mail_smtp_username');
				$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
				$mail->smtp_port     = $this->config->get('config_mail_smtp_port');
				$mail->smtp_timeout  = $this->config->get('config_mail_smtp_timeout');
			}
		}
		$mail->setFrom($this->config->get('config_email'));
		$mail->setSender($this->config->get('config_name'));
		$mail->setTo($data['customer_email']);
		$mail->setSubject(html_entity_decode($data['subject'], ENT_QUOTES, 'UTF-8'));
		$mail->setHtml(html_entity_decode($data['message'], ENT_QUOTES, 'UTF-8'));
		$mail->send();
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
	public function subscribe($comment_id = false, $mark = 'comment_id')
	{
		$this->cache->delete('blog');
		if (SC_VERSION > 15) {
			$this->load->controller('common/seoblog');
		} else {
			$this->getChild('common/seoblog');
		}
		$this->language->load('account/login');
		$this->language->load('seocms/signer');
		$signer_status             = false;
		$signer_status_answer      = false;
		$html                      = "<script>var sdata = new Array();
					sdata['code'] 	 = 'error';
					sdata['error'] 	 = 'error';
				 </script>";
		$this->data['signer_code'] = false;
		$this->data['href']        = "#";
		$this->data['email_error'] = '';
		if (isset($this->request->post['email_ghost']) && $this->request->post['email_ghost'] != '') {
			$this->data['email_ghost'] = $this->request->post['email_ghost'];
			if (preg_match("|^[-0-9a-z_\.]+@[-0-9a-z_^\.]+\.[a-z]{2,6}$|i", $this->data['email_ghost'])) {
				if ($comment_id) {
					$signer_status_answer = true;
				} else {
					$signer_status_answer = false;
				}
			} else {
				$email_subscribe           = $this->data['email_ghost'];
				$this->data['email_ghost'] = false;
				$this->data['email_error'] = 'email';
				$html                      = "<script>var sdata = new Array();
					sdata['code'] 	 = 'error';
					sdata['error'] 	 = 'email';
				 </script>";
				$signer_status_answer      = false;
			}
		} else {
			$this->data['email_ghost'] = false;
			if (isset($this->request->post['signer_answer']) && $this->request->post['signer_answer']) {
				if ($comment_id) {
					$signer_status_answer = true;
				} else {
					$signer_status_answer = false;
				}
			} else {
				if (isset($this->request->post['email_ghost'])) {
					$this->data['email_error'] = 'noemail';
				} else {
					$signer_status_answer = false;
				}
			}
		}
		if (isset($this->request->get['id'])) {
			$this->data['id'] = $this->request->get['id'];
		} else {
			if ($comment_id) {
				$this->data['id'] = $comment_id;
			} else {
				$this->data['id'] = false;
			}
		}
		if (isset($this->request->get['cmswidget'])) {
			$this->data['cmswidget'] = $this->request->get['cmswidget'];
		} else {
			$this->data['cmswidget'] = '';
		}
		if (isset($this->request->get['pointer'])) {
			$this->data['pointer'] = $this->request->get['pointer'];
		} else {
			if ($comment_id) {
				if ($mark == 'product_id') {
					$this->data['pointer'] = 'review_id';
				}
				if ($mark == 'record_id') {
					$this->data['pointer'] = 'comment_id';
				}
			} else {
				$this->data['pointer'] = false;
			}
		}
		$allow_pointers = array(
			'record_id',
			'product_id',
			'blog_id',
			'review_id',
			'comment_id'
		);
		if (!in_array($this->data['pointer'], $allow_pointers)) {
			$this->data['pointer'] = false;
		}
		$this->data['href'] = false;
		if ($this->data['pointer'] == 'product_id') {
			$this->data['href'] = $this->url->link('product/product', 'product_id=' . $this->data['id']);
		}
		if ($this->data['pointer'] == 'record_id') {
			$this->data['href'] = $this->url->link('record/record', 'record_id=' . $this->data['id']);
		}
		if ($this->data['pointer'] == 'blog_id') {
			$this->data['href'] = $this->url->link('record/blog', 'blog_id=' . $this->data['id']);
		}
		if (($this->customer->isLogged() || $this->data['email_ghost']) && $this->data['id'] && $this->data['pointer']) {
			if ($this->data['pointer'] == 'record_id') {
				$this->load->model('record/record');
				$record_info        = $this->model_record_record->getRecord($this->data['id']);
				$this->data['href'] = $this->url->link('record/record', 'record_id=' . $this->data['id']);
				if (isset($record_info['comment'])) {
					$record_comment = unserialize($record_info['comment']);
				} else {
					$record_comment = false;
				}
			}
			if ($this->data['pointer'] == 'product_id' || $this->data['pointer'] == 'comment_id' || $this->data['pointer'] == 'review_id') {
				$record_info              = true;
				$record_comment['signer'] = true;
			}
			if ($record_info) {
				if (isset($record_comment['signer']) && $record_comment['signer']) {
					if ($this->customer->isLogged()) {
						$this->data['customer_id'] = $this->customer->getId();
					} else {
						$this->data['customer_id'] = false;
					}
					if ($this->data['id']) {
						$this->load->model('agoo/signer/signer');
						$signer_status = $this->model_agoo_signer_signer->getStatus($this->data['id'], $this->data['customer_id'], $this->data['pointer'], $this->data['email_ghost']);
						if ($comment_id && $signer_status_answer) {
							$signer_status = false;
						} else {
							if ($this->data['pointer'] == 'review_id' || $this->data['pointer'] == 'comment_id') {
								$signer_status = true;
							}
						}
						if (!$signer_status) {
							$this->model_agoo_signer_signer->setStatus($this->data['id'], $this->data['customer_id'], $this->data['pointer'], $this->data['email_ghost']);
							if ($this->data['email_ghost']) {
								if (isset($_COOKIE['email_subscribe_' . $this->data['pointer']])) {
									$email_subscribe = unserialize(base64_decode($_COOKIE['email_subscribe_' . $this->data['pointer']]));
								} else {
									$email_subscribe = Array();
								}
								$email_subscribe[$this->data['id']] = $this->data['email_ghost'];
								setcookie("email_subscribe_" . $this->data['pointer'], base64_encode(serialize($email_subscribe)), time() + 60 * 60 * 24 * 555, '/', $this->request->server['HTTP_HOST']);
							}
							$html  = "<script>var sdata = new Array();
									sdata['code'] 	 = 'success';
									sdata['success'] = 'set';
						  		</script>";
							$this->data['signer_code'] = 'set';
						} else {
							$this->model_agoo_signer_signer->removeStatus($this->data['id'], $this->data['customer_id'], $this->data['pointer'], $this->data['email_ghost']);
							if (isset($_COOKIE['email_subscribe_' . $this->data['pointer']])) {
								$email_subscribe = unserialize(base64_decode($_COOKIE['email_subscribe_' . $this->data['pointer']]));
							} else {
								$email_subscribe = Array();
							}
							if (isset($email_subscribe[$this->data['id']])) {
								unset($email_subscribe[$this->data['id']]);
							}
							if (empty($email_subscribe)) {
								$email_subscribe = '';
							} else {
								$email_subscribe = base64_encode(serialize($email_subscribe));
							}
							setcookie("email_subscribe_" . $this->data['pointer'], $email_subscribe, time() + 60 * 60 * 24 * 555, '/', $this->request->server['HTTP_HOST']);
							$html = "<script>var sdata = new Array();
									sdata['code'] 	 = 'success';
									sdata['success'] 	 = 'remove';
						  		</script>";
							$this->data['signer_code'] = 'remove';
						}
					} else {
						$html  = "<script>var sdata = new Array();
								sdata['code'] 	 = 'error';
								sdata['error'] 	 = 'record_id';
						  </script>";
						$this->data['signer_code'] = 'record_id';
					}
				} else {
					$html = "<script>var sdata = new Array();
								sdata['code'] 	 = 'error';
								sdata['error'] 	 = 'no_signer';
						  </script>";
					$this->data['signer_code'] = 'no_signer';
				}
			}
		} else {
			$html = "<script>var sdata = new Array();
							sdata['code'] 	 = 'error';
							sdata['error'] 	 = 'customer_id';
					  </script>";
			$this->data['signer_code']    = 'customer_id';
			$this->data['text_subscribe'] = $this->language->get('text_subscribe');
			if (isset($_COOKIE['email_subscribe_' . $this->data['pointer']])) {
				$email_subscribe = unserialize(base64_decode($_COOKIE['email_subscribe_' . $this->data['pointer']]));
				if (isset($email_subscribe[$this->data['id']])) {
					$email_subscribe = $email_subscribe[$this->data['id']];
				} else {
					$email_subscribe = '';
				}
			} else {
				if (isset($email_subscribe) && $email_subscribe != '') {
				} else {
					$email_subscribe = '';
				}
			}
			if ((isset($email_subscribe) && $email_subscribe != '') && $this->data['email_error'] != 'email' || $signer_status) {
				$this->data['text_subscribe'] = $this->language->get('text_unsubscribe');
				$this->data['text_or_email']  = $this->language->get('text_un_email');
				$this->data['signer_status']  = true;
				$this->data['email_ghost']    = $email_subscribe;
			} else {
				$this->data['signer_status']  = false;
				$this->data['text_subscribe'] = $this->language->get('text_subscribe');
				$this->data['text_or_email']  = $this->language->get('text_or_email');
				$this->data['email_ghost']    = $email_subscribe;
			}
			$this->data['text_new_customer']            = $this->language->get('text_new_customer');
			$this->data['text_register']                = $this->language->get('text_register');
			$this->data['text_register_account']        = $this->language->get('text_register_account');
			$this->data['text_returning_customer']      = $this->language->get('text_returning_customer');
			$this->data['text_i_am_returning_customer'] = $this->language->get('text_i_am_returning_customer');
			$this->data['text_forgotten']               = $this->language->get('text_forgotten');
			$this->data['hide_block']                   = $this->language->get('hide_block');
			$this->data['error_register']               = $this->language->get('error_register');
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
			if ($comment_id) {
				return $this->data['email_error'];
			}
		}
		$this->data['success_remove']     = $this->language->get('success_remove');
		$this->data['success_set']        = $this->language->get('success_set');
		$this->data['error_no_signer']    = $this->language->get('error_no_signer');
		$this->data['error_record_id']    = $this->language->get('error_record_id');
		$this->data['text_email_error']   = $this->language->get('text_email_error');
		$this->data['text_noemail_error'] = $this->language->get('text_noemail_error');
		$this->data['error_register']     = $this->language->get('error_register');
		$this->data['hide_block']         = $this->language->get('hide_block');
		if (!$comment_id) {
			$template = '/template/agootemplates/module/blog_signer.tpl';
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . $template)) {
				$this->template = $this->config->get('config_template') . $template;
			} else {
				$this->template = 'default' . $template;
			}
			$this->data['theme']    = $this->config->get('config_template');
			$this->data['language'] = $this->language;
			if (SC_VERSION < 20) {
				$html .= $this->render();
			} else {
				if (!is_array($this->data))
					$this->data = array();
				$html .= $this->load->view($this->template, $this->data);
			}
			return $this->response->setOutput($html);
		} else {
			return true;
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
	public function cont($cont)
	{
	    if ($this->registry->get('admin_work')) {
			$dir_catalog =	DIR_CATALOG;
		} else {			$dir_catalog =	DIR_APPLICATION;
		}

		$file  = $dir_catalog . 'controller/' . $cont . '.php';
		$class = 'Controller' . preg_replace('/[^a-zA-Z0-9]/', '', $cont);
		if (file_exists($file)) {
			include_once($file);
			$this->registry->set('controller_' . str_replace('/', '_', $cont), new $class($this->registry));
		} else {
			trigger_error('Error: Could not load controller ' . $cont . '! File: '.$file);
			exit();
		}
	}
}
