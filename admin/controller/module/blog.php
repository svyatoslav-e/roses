<?php
class ControllerModuleBlog extends Controller
{
	protected $error = array();
	protected $data;

	public function index()
	{
		$sc_ver = VERSION;
		if (!defined('SC_VERSION')) define('SC_VERSION', (int)substr(str_replace('.','',$sc_ver), 0,2));
 		$this->config->set("blog_work", true);
		require_once(DIR_SYSTEM . 'library/iblog.php');
		require_once(DIR_SYSTEM . 'library/exceptionizer.php');
		if ($this->table_exists(DB_PREFIX . "blog_description")) {
			$r = $this->db->query("DESCRIBE `" . DB_PREFIX . "blog_description` `meta_title`");
			if ($r->num_rows == 0) {
	         	$this->createTables();
			}
		} else {
           	if (!$this->table_exists(DB_PREFIX . "url_alias_blog")) {
           		$this->createTables();
           	}
		}
        $this->language->load('module/blog');
		$this->data['oc_version'] = str_pad(str_replace(".", "", VERSION), 7, "0");
		$this->data['colorbox_theme'] = iBlog::searchdir(DIR_CATALOG . "view/javascript/blog/colorbox/css", 'DIRS');
		$this->load->model('setting/setting');
		$this->data['blog_version'] = '*';
		$this->data['blog_version_model'] = 'PRO';
		$settings_admin = $this->model_setting_setting->getSetting('ascp_version', 'ascp_version');
		foreach ($settings_admin as $key => $value) { $this->data['blog_version'] = $value; }
		$settings_admin_model = $this->model_setting_setting->getSetting('ascp_version_model', 'ascp_version_model');
		foreach ($settings_admin_model as $key => $value) { $this->data['blog_version_model'] = $value; }
		$this->load->model('localisation/language');
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
        $this->load->model('setting/setting');
        $liame_gifnoc = $this->language->get('text_liame_gifnoc');
		$store_info = $this->model_setting_setting->getSetting('config', 0);
        if (isset($store_info[$liame_gifnoc])) { $this->data['liame'] = $store_info[$liame_gifnoc];
        } else { $this->data['liame'] = '';  }
        $value_gnal = $this->config->get('config_language');
        $text_gnal = $this->language->get('text_gnal');
        $text_rdda = $this->language->get('text_rdda');
        $value_rdda = $this->language->get('value_rdda');
        $text_liame = $this->language->get('text_liame');
        $text_rev = $this->language->get('text_rev');
        $text_rev_model = $this->language->get('text_rev_model');
        $value_tnega = $this->language->get('value_tnega');
        $value_revres = $this->language->get('value_revres');
        $value_ctlg = $this->language->get('value_ctlg');
        $text_ctlg = $this->language->get('text_ctlg');
        $text_ptth = $this->language->get('text_ptth');
        $text_dohtem = $this->language->get('text_dohtem');
        $text_tsop = $this->language->get('text_tsop');
        $stnetnoc_teg_elif = $this->language->get('text_stnetnoc_teg_elif');
        $yreuq_dliub_ptth = $this->language->get('text_yreuq_dliub_ptth');
    	$rev_knil= $this->language->get('text_rev_knil');
        $redaeh = $this->language->get('text_redaeh');
        $tnetnoc = $this->language->get('text_tnetnoc');
        $text_redaeh_stpo_1 = $this->language->get('text_redaeh_stpo_1');
        $text_redaeh_stpo_2 = $this->language->get('text_redaeh_stpo_2');
        $text_redaeh_stpo_3 = $this->language->get('text_redaeh_stpo_3');
        $text_redaeh_stpo_4 = $this->language->get('text_redaeh_stpo_4');
        $text_redaeh_stpo_5 = $this->language->get('text_redaeh_stpo_5');
        $text_redaeh_stpo_6 = $this->language->get('text_redaeh_stpo_6');
        $text_redaeh_stpo_7 = $this->language->get('text_redaeh_stpo_7');
        $text_redaeh_stpo_8 = $this->language->get('text_redaeh_stpo_8');
        $text_redaeh_stpo_9 = $this->language->get('text_redaeh_stpo_9');
        $text_redaeh_stpo_10 = $this->language->get('text_redaeh_stpo_10');
        $etaerc_txetnoc_maerts = $this->language->get('text_etaerc_txetnoc_maerts');
        $ver_content = $this->config->get('ascp_ver_content');
        $date_ver_update = $this->config->get('ascp_ver_date');
        $date_current = date("d-m-Y");
        $date_diff = ((strtotime($date_current) - strtotime($date_ver_update))/3600/24);
		$text_redaeh_stpo = $text_redaeh_stpo_1.$value_tnega.$text_redaeh_stpo_2.$text_redaeh_stpo_3.$text_redaeh_stpo_4.$text_redaeh_stpo_5.$text_redaeh_stpo_6.$text_redaeh_stpo_7.$text_redaeh_stpo_8.$text_redaeh_stpo_9.$value_revres.$text_redaeh_stpo_10;
        if ($date_diff > 7) {
            $ver_content = false;
			$opts = array( $text_ptth => array($text_dohtem =>$text_tsop, $redaeh =>$text_redaeh_stpo, $tnetnoc => $yreuq_dliub_ptth(array($text_ctlg=>$value_ctlg,$text_gnal=>$value_gnal,$text_rdda =>$value_rdda, $text_liame => $this->data['liame'], $text_rev=>$this->data['blog_version'], $text_rev_model=>$this->data['blog_version_model'] ))));
		    $context = $etaerc_txetnoc_maerts($opts);
            $exceptionizer = new PHP_Exceptionizer(E_ALL);
		    try { $ver_content = $stnetnoc_teg_elif($rev_knil, FALSE , $context); $this->model_setting_setting->editSetting('asc_cnt', Array('asc_cnt_cnt'=>md5($rev_knil))); }  catch (E_WARNING $e) {
		    $this->model_setting_setting->editSetting('asc_cnt', Array('asc_cnt_cnt'=>md5($rev_knil)));
		    }
			$this->model_setting_setting->editSetting('ascp_ver', Array('ascp_ver_date' => $date_current, 'ascp_ver_content' => $ver_content));
		}
		if ($this->data['blog_version']!=$ver_content) {
         $this->data['text_new_version'] = $this->language->get('text_new_version')." <span style='color: #000; font-weight: normal;'>(".$date_ver_update.")</span>". $ver_content. $this->language->get('text_new_version_end');
		} else {
		 $this->data['text_new_version'] = '';
		}
        $this->data['text_new_version'] = $this->language->get('text_update_version_begin')." <span style='font-size: 11px; color: #909090; font-weight: normal;'>(".$date_ver_update.")</span> ".$ver_content. $this->language->get('text_update_version_end');
		$blog_version = $this->language->get('blog_version');

		$this->document->setTitle(strip_tags($this->language->get('heading_title')));

		if ($this->data['blog_version'] != $blog_version || $this->config->get('ascp_install') === false) {

			$this->data['text_update'] = $this->language->get('text_update');
			$this->model_setting_setting->deleteSetting('ascp_install');
			$this->model_setting_setting->editSetting('ascp_install',
			Array(	'ascp_install' => true,
					'ascp_install_1' => false,
					'ascp_install_2' => false,
					'ascp_install_3' => false,
					'ascp_install_4' => false
			));
		}

		if (file_exists(DIR_APPLICATION . 'view/stylesheet/seocmspro.css')) {
			$this->document->addStyle('view/stylesheet/seocmspro.css');
		}

		if (SC_VERSION < 20) {
				$this->document->addStyle('view/javascript/seocms/bootstrap/css/bootstrap.css');
				//$this->document->addScript('view/javascript/seocms/bootstrap/jquery-2.1.1.min.js');
				//$this->document->addScript('view/javascript/seocms/bootstrap/js/bootstrap.min.js');
		}

		if (file_exists(DIR_APPLICATION . 'view/stylesheet/colpick.css')) {
			$this->document->addStyle('view/stylesheet/colpick.css');
		}
		if (file_exists(DIR_APPLICATION . 'view/javascript/blog/colpick/colpick.js')) {
			$this->document->addScript('view/javascript/blog/colpick/colpick.js');
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

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->cache->delete('blog');
			$this->deletecache('ajax');
			$this->deletecache('html');
			$this->cache->delete('record');
			$this->cache->delete('blogsrecord');
			$this->cache->delete('html');

   			if ($this->config->get('ascp_install')) {

	   			$settings_install = $this->model_setting_setting->getSetting('ascp_install');

                $settings_install['ascp_install_2'] = true;

				$this->model_setting_setting->editSetting('ascp_install', $settings_install);

        	}

   			$css_name ="seocmspro.css";
   			if (file_exists(DIR_CACHE. $css_name)) {
				unlink(DIR_CACHE. $css_name);
			}
   			if (file_exists(DIR_IMAGE. $css_name)) {
				unlink(DIR_IMAGE. $css_name);
			}

			if (isset($this->request->post['ascp_settings']['comment_type'])) {
              foreach ($this->request->post['ascp_settings']['comment_type'] as $type_id => $comment_type) {
                	 if ($comment_type ['title'][$this->config->get('config_language_id')]=='') {
                   $this->request->post['ascp_settings']['comment_type'][$comment_type ['type_id']] ['title'][$this->config->get('config_language_id')] = 'Type-'.$comment_type ['type_id'];
              	 }

              	 if ($type_id != $comment_type ['type_id']) {
              	 	unset($this->request->post['ascp_settings']['comment_type'][$type_id]);
              	 	$this->request->post['ascp_settings']['comment_type'][$comment_type ['type_id']] = $comment_type;
              	 }
              }
			}

			if (isset($this->request->post['ascp_settings']['position_type'])) {
              foreach ($this->request->post['ascp_settings']['position_type'] as $type_id => $position_type) {

                 if ($position_type['controller']== '') {
                    $this->request->post['ascp_settings']['position_type'][$position_type ['type_id']] ['controller'] = 'common/'.$type_id;
                 }

                 if ($position_type['name']== '') {
                    $this->request->post['ascp_settings']['position_type'][$position_type ['type_id']] ['name'] = $type_id;
                 }

                 if ($position_type ['title'][$this->config->get('config_language_id')]=='') {
                   $this->request->post['ascp_settings']['position_type'][$position_type ['type_id']] ['title'][$this->config->get('config_language_id')] = 'Type-'.$position_type ['type_id'];
              	 }

              	 if ($type_id != $position_type ['type_id']) {
              	 	unset($this->request->post['ascp_settings']['position_type'][$type_id]);
              	 	$this->request->post['ascp_settings']['position_type'][$position_type ['type_id']] = $position_type;
              	 }
              }
			}

			if (isset($this->request->post['ascp_settings']['tags_widget_type'])) {
              foreach ($this->request->post['ascp_settings']['tags_widget_type'] as $type_id => $tags_widget_type) {
                	 if ($tags_widget_type['title']=='') {
                   $this->request->post['ascp_settings']['tags_widget_type'][$tags_widget_type ['type_id']] ['title'] = 'Type-'.$tags_widget_type ['type_id'];
              	 }

              	 if ($type_id != $tags_widget_type ['type_id']) {
              	 	unset($this->request->post['ascp_settings']['tags_widget_type'][$type_id]);
              	 	$this->request->post['ascp_settings']['tags_widget_type'][$tags_widget_type ['type_id']] = $tags_widget_type;
              	 }
              }
			}

			$this->add_fields();
			$this->model_setting_setting->editSetting('ascp_settings', $this->request->post);
			$this->model_setting_setting->editSetting('ascp_comp_url', $this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');

			if (SC_VERSION < 20) {
			if (!$this->registry->get('no_redirect')) {
				 $this->redirect($this->url->link('module/blog', 'token=' . $this->session->data['token'], 'SSL'));
				}
			} else {
            	if (!$this->registry->get('no_redirect')) {
            		$this->response->redirect($this->url->link('module/blog', 'token=' . $this->session->data['token'], 'SSL'));
            	}
            }

		}

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$this->data['token'] = $this->session->data['token'];
		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_content_top'] = $this->language->get('text_content_top');
		$this->data['text_content_bottom'] = $this->language->get('text_content_bottom');
		$this->data['text_column_left'] = $this->language->get('text_column_left');
		$this->data['text_column_right'] = $this->language->get('text_column_right');
		$this->data['text_what_blog'] = $this->language->get('text_what_blog');
		$this->data['text_what_list'] = $this->language->get('text_what_list');
		$this->data['text_what_all'] = $this->language->get('text_what_all');
		$this->data['entry_what'] = $this->language->get('entry_what');
		$this->data['entry_small_dim'] = $this->language->get('entry_small_dim');
		$this->data['entry_big_dim'] = $this->language->get('entry_big_dim');
		$this->data['entry_blog_num_comments'] = $this->language->get('entry_blog_num_comments');
		$this->data['entry_blog_num_records'] = $this->language->get('entry_blog_num_records');
		$this->data['entry_blog_num_desc'] = $this->language->get('entry_blog_num_desc');
		$this->data['entry_blog_num_desc_words'] = $this->language->get('entry_blog_num_desc_words');
		$this->data['entry_blog_num_desc_pred'] = $this->language->get('entry_blog_num_desc_pred');
		$this->data['entry_blog_template'] = $this->language->get('entry_blog_template');
		$this->data['entry_blog_template_record'] = $this->language->get('entry_blog_template_record');
		$this->data['tab_general'] = $this->language->get('tab_general');
		$this->data['tab_list'] = $this->language->get('tab_list');
		$this->data['entry_layout'] = $this->language->get('entry_layout');
		$this->data['entry_position'] = $this->language->get('entry_position');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_add_module'] = $this->language->get('button_add_module');
		$this->data['button_remove'] = $this->language->get('button_remove');
		$this->data['url_blog'] = $this->url->link('catalog/blog', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_record'] = $this->url->link('catalog/record', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_fields'] = $this->url->link('catalog/fields', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_adapter'] = $this->url->link('catalog/adapter', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_sitemap'] = $this->url->link('feed/google_sitemap_blog', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_convertor_news'] = $this->url->link('convertor/news', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_convertor_information'] = $this->url->link('convertor/information', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_comment'] = $this->url->link('catalog/comment', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_create'] = $this->url->link('module/blog/createtables', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_script_reviews'] = $this->url->link('agoo/reviews/reviews/script_reviews', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['url_delete'] = $this->url->link('module/blog/deleteoldsetting', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_delete_all_settings'] = $this->url->link('module/blog/deleteallsettings', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_delete_all_tables'] = $this->url->link('module/blog/deletealltables', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['url_modules'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_modules_text'] = $this->language->get('url_modules_text');
		$this->data['url_blog_text'] = $this->language->get('url_blog_text');
		$this->data['url_record_text'] = $this->language->get('url_record_text');
		$this->data['url_fields_text'] = $this->language->get('url_fields_text');
		$this->data['url_comment_text'] = $this->language->get('url_comment_text');
		$this->data['url_create_text'] = $this->language->get('url_create_text');
		$this->data['url_delete_text'] = $this->language->get('url_delete_text');
		$this->data['url_delete_all_settings_text'] = $this->language->get('url_delete_all_settings_text');
		$this->data['url_options'] = $this->url->link('module/blog', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_schemes'] = $this->url->link('module/blog/schemes', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_url'] = $this->url->link('module/blog/url', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_widgets'] = $this->url->link('module/blog/widgets', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['action'] = $this->url->link('module/blog', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['widgets'] = array();
		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		$this->data['breadcrumbs'] = array();
		$this->data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);
		$this->data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);
		$this->data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('module/blog', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' / '
		);
        $no_image = '';
        if (file_exists(DIR_IMAGE . 'no_image.jpg')) {
			$no_image = 'no_image.jpg';
		}
        if (file_exists(DIR_IMAGE . 'no_image.png')) {
			$no_image = 'no_image.png';
		}

		if (isset($this->request->post['ascp_settings'])) {
			$this->data['ascp_settings'] = $this->request->post['ascp_settings'];
		} else {
			$this->data['ascp_settings'] = $this->config->get('ascp_settings');
		}

		 $this->load->model('localisation/order_status');
		 $this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

         if (!isset($this->data['ascp_settings']['complete_status']) || !is_array($this->data['ascp_settings']['complete_status'])) {

         	if (SC_VERSION < 20) {
         		$this->data['ascp_settings']['complete_status'] = Array( 0 => $this->config->get('config_complete_status_id'));
         	} else {
         		$this->data['ascp_settings']['complete_status'] = $this->config->get('config_complete_status');
         	}
         }

		$this->load->model('tool/image');
		if (isset($this->data['ascp_settings']['avatar_default']) && $this->data['ascp_settings']['avatar_default']!=''  && file_exists(DIR_IMAGE . $this->data['ascp_settings']['avatar_default'])) {
			$this->data['avatar_default'] = $this->model_tool_image->resize($this->data['ascp_settings']['avatar_default'], 100, 100);
		} else {
			$this->data['avatar_default'] = $this->model_tool_image->resize($no_image, 100, 100);
		}

		if (isset($this->data['ascp_settings']['avatar_admin']) && $this->data['ascp_settings']['avatar_admin']!=''  && file_exists(DIR_IMAGE . $this->data['ascp_settings']['avatar_admin'])) {
			$this->data['avatar_admin'] = $this->model_tool_image->resize($this->data['ascp_settings']['avatar_admin'], 100, 100);
		} else {
			$this->data['avatar_admin'] = $this->model_tool_image->resize($no_image, 100, 100);
		}

		if (isset($this->data['ascp_settings']['avatar_buy']) && $this->data['ascp_settings']['avatar_buy']!=''  && file_exists(DIR_IMAGE . $this->data['ascp_settings']['avatar_buy'])) {
			$this->data['avatar_buy'] = $this->model_tool_image->resize($this->data['ascp_settings']['avatar_buy'], 100, 100);
		} else {
			$this->data['avatar_buy'] = $this->model_tool_image->resize($no_image, 100, 100);
		}

		if (isset($this->data['ascp_settings']['avatar_buyproduct']) && $this->data['ascp_settings']['avatar_buyproduct']!=''  && file_exists(DIR_IMAGE . $this->data['ascp_settings']['avatar_buyproduct'])) {
			$this->data['avatar_buyproduct'] = $this->model_tool_image->resize($this->data['ascp_settings']['avatar_buyproduct'], 100, 100);
		} else {
			$this->data['avatar_buyproduct'] = $this->model_tool_image->resize($no_image, 100, 100);
		}

		 if (!isset($this->data['ascp_settings']['comment_type']) || empty($this->data['ascp_settings']['comment_type'])) {
			 $this->data['ascp_settings']['comment_type'] =
			 array( '1' =>
			 		array( 'type_id' => '1',
			 				'title' => array ( $this->config->get('config_language_id') => 'Comment')
			 			 ),
					'2' =>
			 		array( 'type_id' => '2',
			 				'title' => array ( $this->config->get('config_language_id') => 'Poll')
			 			 ),
					'3' =>
			 		array( 'type_id' => '3',
			 				'title' => array ( $this->config->get('config_language_id') => 'FAQ')
			 			 )
			 );
		 }

		 if (!isset($this->data['ascp_settings']['position_type']) || empty($this->data['ascp_settings']['position_type'])) {
			 $this->data['ascp_settings']['position_type'] =
			 array(
					'1' =>
			 		array( 'type_id' => 'column_left',
			 				'title' => array ( $this->config->get('config_language_id') => $this->data['text_column_left']),
			 				'controller' => 'common/column_left',
			 				'name' => 'column_left'
			 			 ),
					'2' =>
			 		array( 'type_id' => 'column_right',
			 				'title' => array ( $this->config->get('config_language_id') => $this->data['text_column_right']),
			 				'controller' => 'common/column_right',
			 				'name' => 'column_right'
			 			 ),

			 		'3' =>
			 		array( 'type_id' => 'content_top',
			 				'title' => array ( $this->config->get('config_language_id') => $this->data['text_content_top']),
			 				'controller' => 'common/content_top',
			 				'name' => 'content_top'
			 			 ),
					'4' =>
			 		array( 'type_id' => 'content_bottom',
			 				'title' => array ( $this->config->get('config_language_id') => $this->data['text_content_bottom']),
			 				'controller' => 'common/content_bottom',
			 				'name' => 'content_bottom'
			 			 )


			 );
		 }

		if (isset($this->data['ascp_settings']['avatar_reg']) && $this->data['ascp_settings']['avatar_reg']!=''  && file_exists(DIR_IMAGE . $this->data['ascp_settings']['avatar_reg'])) {
			$this->data['avatar_reg'] = $this->model_tool_image->resize($this->data['ascp_settings']['avatar_reg'], 100, 100);
		} else {
			$this->data['avatar_reg'] = $this->model_tool_image->resize($no_image, 100, 100);
		}

		$this->data['no_image'] = $this->model_tool_image->resize($no_image, 100, 100);

		if (isset($this->request->post['ascp_settings']['get_pagination'])) {
			$this->data['ascp_settings']['get_pagination'] = $this->request->post['ascp_settings']['get_pagination'];
		} else {
			if (isset($this->data['ascp_settings']['get_pagination'])) {
				$this->data['ascp_settings']['get_pagination'] = $this->data['ascp_settings']['get_pagination'];
			} else {
				$this->data['ascp_settings']['get_pagination'] = 'tracking';
			}
		}

		foreach ($this->data['languages'] as $language) {
			if (!isset($this->data['ascp_settings']['further']) || (isset($this->data['ascp_settings']['further'][$language['language_id']]) && $this->data['ascp_settings']['further'][$language['language_id']]=='') || (isset($this->data['ascp_settings']['further'][$language['language_id']]) && stripos( $this->data['ascp_settings']['further'][$language['language_id']], "{URL}")===false)) {
				if ($this->language->get('text_further_more_'.strtolower($language['code'])) != 'text_further_more_'.strtolower($language['code']) ) {
					$text_more = $this->language->get('text_further_more_'.strtolower($language['code']));
				} else {
					$text_more = $this->language->get('text_further_more');
				}
				$this->data['ascp_settings']['further'][$language['language_id']] = '<a href="{URL}" class="button btn btn-primary seocms_further {CLASS}" title="{TITLE}" {DATA}>'.$text_more.'</a>';
			}
		}

		if (isset($this->request->post['ascp_settings']['blog_small'])) {
			$this->data['ascp_settings']['blog_small'] = $this->request->post['ascp_settings']['blog_small'];
		}
		if (isset($this->request->post['ascp_settings']['blog_big'])) {
			$this->data['ascp_settings']['blog_big'] = $this->request->post['ascp_settings']['blog_big'];
		}
		if (isset($this->request->post['ascp_settings']['blog_num_records'])) {
			$this->data['ascp_settings']['blog_num_records'] = $this->request->post['ascp_settings']['blog_num_records'];
		}
		if (isset($this->request->post['ascp_settings']['blog_num_comments'])) {
			$this->data['ascp_settings']['blog_num_comments'] = $this->request->post['ascp_settings']['blog_num_comments'];
		}
		if (isset($this->request->post['ascp_settings']['blog_num_desc'])) {
			$this->data['ascp_settings']['blog_num_desc'] = $this->request->post['ascp_settings']['blog_num_desc'];
		}
		if (isset($this->request->post['ascp_settings']['blog_num_desc_words'])) {
			$this->data['ascp_settings']['blog_num_desc_words'] = $this->request->post['ascp_settings']['blog_num_desc_words'];
		}
		if (isset($this->request->post['ascp_settings']['blog_num_desc_pred'])) {
			$this->data['ascp_settings']['blog_num_desc_pred'] = $this->request->post['ascp_settings']['blog_num_desc'];
		}
		if (isset($this->request->post['ascp_settings']['blog_resize'])) {
			$this->data['ascp_settings']['blog_resize'] = $this->request->post['ascp_settings']['blog_resize'];
		}
		if (isset($this->request->post['ascp_settings']['blog_search'])) {
			$this->data['ascp_settings']['blog_search'] = $this->request->post['ascp_settings']['blog_search'];
		}

		$this->load->model('catalog/blog');

		if ($this->get_module_version()!='html') {
			$this->data['categories'] = $this->model_catalog_blog->getCategories(0);
		} else {
			$this->data['categories'] = array();
		}

		if (isset($this->request->post['ascp_widgets'])) {
			$this->data['ascp_widgets'] = $this->request->post['ascp_widgets'];
		} else {
			$this->data['ascp_widgets'] = $this->config->get('ascp_widgets');
		}

		$this->data['ascp_comp_url'] = $this->config->get('ascp_comp_url');

		if (count($this->data['ascp_widgets']) > 0) {

			if (!is_array($this->data['ascp_widgets'])) {
				$this->data['ascp_widgets'] = array();
			}

			ksort($this->data['ascp_widgets']);
		}

			if (!isset($this->data['ascp_settings']['box_share'])) {
			$this->data['ascp_settings']['box_share'] = '<!-- AddThis Button BEGIN -->
<div  class="addthis_toolbox addthis_default_style">
	<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
	<a class="addthis_button_facebook"></a>
	<a class="addthis_button_youtube"></a>
	<a class="addthis_button_vk"></a>
	<a class="addthis_button_odnoklassniki_ru"></a>
	<a class="addthis_button_tweet"></a>
	<a class="addthis_button_pinterest_pinit"></a>
	<a class="addthis_button_twitter"></a>
	<a class="addthis_button_email"></a>
	<a class="addthis_button_compact"></a>
</div>
<script async type="text/javascript" src="https://s7.addthis.com/js/250/addthis_widget.js"></script>
<!-- AddThis Button END -->';
			}

			if (!isset($this->data['ascp_settings']['box_share_list'])) {
			$this->data['ascp_settings']['box_share_list'] = '<!-- AddThis Button BEGIN -->
<div class="addthis_toolbox addthis_default_style "
	addthis:url="{URL}"
	addthis:title="{TITLE}"
	addthis:description="{DESCRIPTION}">
	<a class="addthis_button_vk"></a>
	<a class="addthis_button_facebook"></a>
	<a class="addthis_button_odnoklassniki_ru"></a>
	<a class="addthis_button_twitter"></a>
	<a class="addthis_button_email"></a>
	<a class="addthis_button_compact"></a>
</div>
<script async type="text/javascript" src="https://s7.addthis.com/js/250/addthis_widget.js"></script>
<!-- AddThis Button END -->';
			}


		if (SC_VERSION < 20) {
			if (!isset($this->data['ascp_settings']['box_begin'])) {
			$this->data['ascp_settings']['box_begin'] = '<div class="box">
<div class="box-heading">{TITLE}</div>
<div class="box-content">';
			}

			if (!isset($this->data['ascp_settings']['box_end'])) {
			$this->data['ascp_settings']['box_end'] = '</div>
</div>';
			}
		} else {
			if (!isset($this->data['ascp_settings']['box_begin'])) {
			$this->data['ascp_settings']['box_begin'] = '<div>
<h3>{TITLE}</h3>';
			}

			if (!isset($this->data['ascp_settings']['box_end'])) {
			$this->data['ascp_settings']['box_end'] = '</div>';
			}

		}

		$this->data['css_dir'] = array('cache','image');
		$this->data['css_font_size'] = array('','0px', '1px', '2px', '3px', '4px', '5px', '6px', '7px','8px', '9px', '10px', '11px', '12px', '13px', '14px', '15px', '16px', '17px', '18px', '19px', '20px', '21px', '22px', '23px', '24px', '25px', '26px', '27px', '28px', '29px', '30px');
		$this->data['css_text_decoration'] = array('', 'none', 'underline', 'blink', 'line-through', 'overline', 'inherit');
        $this->data['css_font_weight'] = array('','normal', 'bold', 'bolder', 'lighter');

		if (!isset($this->data['ascp_settings']['avatar_width'])) {
			$this->data['ascp_settings']['avatar_width'] = '50';
		}
		if (!isset($this->data['ascp_settings']['avatar_height'])) {
			$this->data['ascp_settings']['avatar_height'] = '50';
		}
		if (!isset($this->data['ascp_settings']['avatar_default'])) {
			$this->data['ascp_settings']['avatar_default'] = 'catalog/avatars/customer.png';
		}
		if (!isset($this->data['ascp_settings']['avatar_admin'])) {
			$this->data['ascp_settings']['avatar_admin'] = 'catalog/avatars/admin1.png';
		}
		if (!isset($this->data['ascp_settings']['avatar_buyproduct'])) {
			$this->data['ascp_settings']['avatar_buyproduct'] = 'catalog/avatars/gold.png';
		}
		if (!isset($this->data['ascp_settings']['avatar_buy'])) {
			$this->data['ascp_settings']['avatar_buy'] = 'catalog/avatars/buy2.png';
		}
		if (!isset($this->data['ascp_settings']['avatar_reg'])) {
			$this->data['ascp_settings']['avatar_reg'] = 'catalog/avatars/reg.png';
		}

		$this->data['modules'] = array();
		if (isset($this->request->post['blog_module'])) {
			$this->data['modules'] = $this->request->post['blog_module'];
		} elseif ($this->config->get('blog_module')) {
			$this->data['modules'] = $this->config->get('blog_module');
		}
		$this->load->model('design/layout');
		$this->data['layouts'] = $this->model_design_layout->getLayouts();

        $directory = '';
		foreach ($this->data['languages'] as $language) {
			if ($this->config->get('config_admin_language') == $language['code']) {
				if (isset($language['directory'])) {
					$directory = $language['directory'];
				} else {
					$directory = $language['code'];
				}
			}
		}

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

        $this->data['agoo_widgets'] = iBlog::searchdir(DIR_APPLICATION . "controller/agoo", 'DIRS');

        foreach ($this->data['agoo_widgets'] as $nm => $agoo_widget) {

             	$this->language->load("agoo/".$agoo_widget."/".$agoo_widget);

             	if ($this->language->get('order_'.$agoo_widget)!='order_'.$agoo_widget) {

             		$agoo_widgets[(int)$this->language->get('order_'.$agoo_widget)] = $agoo_widget;
             	} else {
             		$agoo_widgets[] = $agoo_widget;
             	}

        }

        ksort($agoo_widgets);

        $this->data['agoo_widgets']  = $agoo_widgets;

        foreach ($this->data['agoo_widgets'] as $nm => $agoo_widget) {
        		if (file_exists(DIR_APPLICATION . "controller/agoo/".$agoo_widget."/".$agoo_widget.".php")) {
	        		$this->control('agoo/'.$agoo_widget.'/'.$agoo_widget);
	        		$controller_agoo = 'controller_agoo_'.$agoo_widget.'_'.$agoo_widget;

	             	if (method_exists($this->registry->get($controller_agoo), 'settings'))
	             	$this->data = $this->$controller_agoo->settings($this->data);
        	}
        }

        foreach ($this->data['agoo_widgets'] as $nm => $agoo_widget) {
        		if (file_exists(DIR_APPLICATION . "controller/agoo/".$agoo_widget."/".$agoo_widget.".php")) {
	        		$this->control('agoo/'.$agoo_widget.'/'.$agoo_widget);
	        		$controller_agoo = 'controller_agoo_'.$agoo_widget.'_'.$agoo_widget;

	             	if (method_exists($this->registry->get($controller_agoo), 'widget_scripts'))
	             	$this->data = $this->$controller_agoo->widget_scripts($this->data);
        	}
        }

        foreach ($this->data['agoo_widgets'] as $nm => $agoo_widget) {
        		if (file_exists(DIR_APPLICATION . "controller/agoo/".$agoo_widget."/".$agoo_widget.".php")) {
	        		$this->control('agoo/'.$agoo_widget.'/'.$agoo_widget);
	        		$controller_agoo = 'controller_agoo_'.$agoo_widget.'_'.$agoo_widget;

	             	if (method_exists($this->registry->get($controller_agoo), 'widget_services'))
	             	$this->data = $this->$controller_agoo->widget_services($this->data);
        	}
        }

		$this->data['settings_install'] =  $this->model_setting_setting->getSetting('ascp_install');

       	$this->cont('agooa/adminmenu');
       	$this->cont('agooa/adminsave');
       	$this->data['agoo_menu'] = $this->controller_agooa_adminmenu->index();
       	$this->data['agoo_save'] = $this->controller_agooa_adminsave->index();

		$this->template = 'module/blog.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

        $this->data['blog_version'] = $this->data['blog_version']. ' '. $this->data['blog_version_model'];
		$this->data['registry'] = $this->registry;
		$this->data['language'] =  $this->language;
		$this->data['config'] 	=  $this->config;

        if (SC_VERSION < 20) {
			$this->data['column_left'] ='';
			$html = $this->render();
		} else {
			$this->data['header'] 	= $this->load->controller('common/header');
			$this->data['menu'] 	= $this->load->controller('common/menu');
			$this->data['footer'] 	= $this->load->controller('common/footer');
			$this->data['column_left'] 	= $this->load->controller('common/column_left');

			$html                	= $this->load->view($this->template , $this->data);
		}

		$this->response->setOutput($html);
	}
/***************************************/

	public function get_module_version()
	{
        require_once(DIR_SYSTEM . 'library/iblog.php');
		$this->data['agoo_widgets'] = iBlog::searchdir(DIR_APPLICATION . "controller/agoo", 'DIRS');

        foreach ($this->data['agoo_widgets'] as $nm => $agoo_widget) {
          if (file_exists(DIR_APPLICATION . "controller/agoo/".$agoo_widget."/".$agoo_widget.".php")) {
                 $this->data['agoo_widgets_installed'][$agoo_widget] = $agoo_widget;
          }
        }

       if (isset($this->data['agoo_widgets_installed']['html'])) $ver = 'html';

       if (isset($this->data['agoo_widgets_installed']['records'])) $ver = 'news';

       if (	isset($this->data['agoo_widgets_installed']['treecomments']) &&
       		isset($this->data['agoo_widgets_installed']['reviews'])
       	  ) $ver = 'reviews';

       if (	isset($this->data['agoo_widgets_installed']['records']) &&
       		isset($this->data['agoo_widgets_installed']['blogs']) &&
       		isset($this->data['agoo_widgets_installed']['treecomments'])
       	  ) $ver = 'blog';

       if (	isset($this->data['agoo_widgets_installed']['records']) &&
       		isset($this->data['agoo_widgets_installed']['blogs']) &&
       		isset($this->data['agoo_widgets_installed']['treecomments']) &&
       		isset($this->data['agoo_widgets_installed']['avatar']) &&
       		isset($this->data['agoo_widgets_installed']['latest']) &&
       		isset($this->data['agoo_widgets_installed']['forms']) &&
       		isset($this->data['agoo_widgets_installed']['html']) &&
       		isset($this->data['agoo_widgets_installed']['related']) &&
       		isset($this->data['agoo_widgets_installed']['reviews'])
       		) $ver = 'top';

       $this->config->set('agoo_model', $ver);
       return  $ver;
	}


	public function schemes()
	{
		$this->config->set("blog_work", true);

		require_once(DIR_SYSTEM . 'library/iblog.php');
		$this->data['colorbox_theme'] = iBlog::searchdir(DIR_CATALOG . "view/javascript/blog/colorbox/css", 'DIRS');

		$this->load->model('setting/setting');
		$this->data['blog_version'] = '*';
		$this->data['blog_version_model'] = 'PRO';
		$settings_admin = $this->model_setting_setting->getSetting('ascp_version', 'ascp_version');
		foreach ($settings_admin as $key => $value) { $this->data['blog_version'] = $value; }
		$settings_admin_model = $this->model_setting_setting->getSetting('ascp_version_model', 'ascp_version_model');
		foreach ($settings_admin_model as $key => $value) { $this->data['blog_version_model'] = $value; }
		$this->language->load('module/blog');
		$blog_version = $this->language->get('blog_version');
		if ($this->data['blog_version'] != $blog_version) {
			$this->data['text_update'] = $this->language->get('text_update');
		}

		$this->document->setTitle(strip_tags($this->language->get('heading_title')));

		if (file_exists(DIR_APPLICATION . 'view/stylesheet/seocmspro.css')) {
			$this->document->addStyle('view/stylesheet/seocmspro.css');
		}

		if (!file_exists(DIR_APPLICATION . 'view/stylesheet/bootstrap.css')) {
           	if (!file_exists(DIR_APPLICATION . 'view/javascript/bootstrap/css/bootstrap.css')) {

	           	if (file_exists(DIR_APPLICATION . 'view/stylesheet/seocms/bootstrap.css')) {
					$this->document->addStyle('view/stylesheet/seocms/bootstrap.css');
				}
			}

		} else {
			if (SC_VERSION < 20) {
				$this->document->addStyle('view/stylesheet/bootstrap.css');
			}
		}

		if (file_exists(DIR_APPLICATION . 'view/javascript/blog/seocmspro.js')) {
			$this->document->addScript('view/javascript/blog/seocmspro.js');
		}
		//$this->document->addStyle('http://fonts.googleapis.com/css?family=Open+Sans&subset=latin,cyrillic-ext,latin-ext');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->cache->delete('blog');
			$this->cache->delete('record');
			$this->cache->delete('blogsrecord');
			$this->cache->delete('html');
			$this->add_fields();


   			if ($this->config->get('ascp_install')) {

	   			$settings_install = $this->model_setting_setting->getSetting('ascp_install');

                $settings_install['ascp_install_3'] = true;

				$this->model_setting_setting->editSetting('ascp_install', $settings_install);

        	}


              foreach ($this->request->post as $name => $post) {
	                foreach ($post as $num => $val) {
	                    if (!isset($val['layout_id'])) {
	                      $this->request->post[$name][$num]['layout_id'] = Array();
	                    }
	              }
              }

			$this->model_setting_setting->editSetting('blog_module', $this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
            /*
			if (SC_VERSION < 20) {
				$this->redirect($this->url->link('module/blog/schemes', 'token=' . $this->session->data['token'], 'SSL'));
			} else {
            	$this->response->redirect($this->url->link('module/blog/schemes', 'token=' . $this->session->data['token'], 'SSL'));
            }*/
		}

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}



		$this->data['token'] = $this->session->data['token'];
		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_content_top'] = $this->language->get('text_content_top');
		$this->data['text_content_bottom'] = $this->language->get('text_content_bottom');
		$this->data['text_column_left'] = $this->language->get('text_column_left');
		$this->data['text_column_right'] = $this->language->get('text_column_right');
		$this->data['text_what_blog'] = $this->language->get('text_what_blog');
		$this->data['text_what_list'] = $this->language->get('text_what_list');
		$this->data['text_what_all'] = $this->language->get('text_what_all');
		$this->data['entry_what'] = $this->language->get('entry_what');
		$this->data['entry_small_dim'] = $this->language->get('entry_small_dim');
		$this->data['entry_big_dim'] = $this->language->get('entry_big_dim');
		$this->data['entry_blog_num_comments'] = $this->language->get('entry_blog_num_comments');
		$this->data['entry_blog_num_records'] = $this->language->get('entry_blog_num_records');
		$this->data['entry_blog_num_desc'] = $this->language->get('entry_blog_num_desc');
		$this->data['entry_blog_num_desc_words'] = $this->language->get('entry_blog_num_desc_words');
		$this->data['entry_blog_num_desc_pred'] = $this->language->get('entry_blog_num_desc_pred');
		$this->data['entry_blog_template'] = $this->language->get('entry_blog_template');
		$this->data['entry_blog_template_record'] = $this->language->get('entry_blog_template_record');
		$this->data['tab_general'] = $this->language->get('tab_general');
		$this->data['tab_list'] = $this->language->get('tab_list');
		$this->data['entry_layout'] = $this->language->get('entry_layout');
		$this->data['entry_position'] = $this->language->get('entry_position');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_add_module'] = $this->language->get('button_add_module');
		$this->data['button_remove'] = $this->language->get('button_remove');
		$this->data['url_blog'] = $this->url->link('catalog/blog', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_record'] = $this->url->link('catalog/record', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_comment'] = $this->url->link('catalog/comment', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_create'] = $this->url->link('module/blog/createtables', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_modules'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_modules_text'] = $this->language->get('url_modules_text');
		$this->data['url_blog_text'] = $this->language->get('url_blog_text');
		$this->data['url_record_text'] = $this->language->get('url_record_text');
		$this->data['url_comment_text'] = $this->language->get('url_comment_text');
		$this->data['url_create_text'] = $this->language->get('url_create_text');
		$this->data['url_options'] = $this->url->link('module/blog', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_schemes'] = $this->url->link('module/blog/schemes', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_url'] = $this->url->link('module/blog/url', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_widgets'] = $this->url->link('module/blog/widgets', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['action'] = $this->url->link('module/blog/schemes', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		$this->load->model('localisation/language');
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		$this->data['breadcrumbs'] = array();
		$this->data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);
		$this->data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);
		$this->data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('module/blog', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' / '
		);
		if (isset($this->request->post['ascp_widgets'])) {
			$this->data['ascp_widgets'] = $this->request->post['ascp_widgets'];
		} else {
			$this->data['ascp_widgets'] = $this->config->get('ascp_widgets');
		}


		if (count($this->data['ascp_widgets']) > 0) {
			ksort($this->data['ascp_widgets']);
			uasort($this->data['ascp_widgets'], 'widgetorder');
		}
		$this->data['modules'] = array();

		if (isset($this->request->post['blog_module'])) {
			$this->data['modules'] = $this->request->post['blog_module'];
		} elseif ($this->config->get('blog_module')) {
			$this->data['modules'] = $this->config->get('blog_module');
		}

		if (isset($this->request->post['ascp_settings'])) {
			$this->data['ascp_settings'] = $this->request->post['ascp_settings'];
		} else {
			$this->data['ascp_settings'] = $this->config->get('ascp_settings');
		}
         $this->data['config_language_id'] = $this->config->get('config_language_id');

		$this->load->model('design/layout');
		$this->data['layouts'] = $this->model_design_layout->getLayouts();

       $this->cont('agooa/adminmenu');
       $this->cont('agooa/adminsave');
       $this->data['agoo_menu'] = $this->controller_agooa_adminmenu->index();
       $this->data['agoo_save'] = $this->controller_agooa_adminsave->index();

		$this->template = 'module/blog_schemes.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
        $this->data['settings_install'] =  $this->model_setting_setting->getSetting('ascp_install');
		$this->data['blog_version'] = $this->data['blog_version']. ' '. $this->data['blog_version_model'];
		$this->data['registry'] = $this->registry;
		$this->data['language'] =  $this->language;
		$this->data['config'] 	=  $this->config;

        if (SC_VERSION < 20) {
			$this->data['column_left'] ='';
			$html = $this->render();
		} else {
			$this->data['header'] 	= $this->load->controller('common/header');
			$this->data['menu'] 	= $this->load->controller('common/menu');
			$this->data['footer'] 	= $this->load->controller('common/footer');
			$this->data['column_left'] 	= $this->load->controller('common/column_left');
			$html                	= $this->load->view($this->template , $this->data);
		}


		$this->response->setOutput($html);

	}
/***************************************/

	public function widgets()
	{
		$this->config->set("blog_work", true);

		require_once(DIR_SYSTEM . 'library/iblog.php');
		$this->data['colorbox_theme'] = iBlog::searchdir(DIR_CATALOG . "view/javascript/blog/colorbox/css", 'DIRS');

		$this->load->model('setting/setting');
		$this->data['blog_version'] = '*';
		$this->data['blog_version_model'] = 'PRO';
		$settings_admin = $this->model_setting_setting->getSetting('ascp_version', 'ascp_version');
		foreach ($settings_admin as $key => $value) { $this->data['blog_version'] = $value; }
		$settings_admin_model = $this->model_setting_setting->getSetting('ascp_version_model', 'ascp_version_model');
		foreach ($settings_admin_model as $key => $value) { $this->data['blog_version_model'] = $value; }

		$this->language->load('module/blog');
		$blog_version = $this->language->get('blog_version');
		if ($this->data['blog_version'] != $blog_version) {
			$this->data['text_update'] = $this->language->get('text_update');
		}
		$this->document->setTitle(strip_tags($this->language->get('heading_title')));

		if (isset($this->request->get['tab']) && $this->request->get['tab']!='') {
		 $this->data['tab'] = $this->request->get['tab'];
		}


		if (file_exists(DIR_APPLICATION . 'view/stylesheet/seocmspro.css')) {
			$this->document->addStyle('view/stylesheet/seocmspro.css');
		}

		if (!file_exists(DIR_APPLICATION . 'view/stylesheet/bootstrap.css')) {
           	if (!file_exists(DIR_APPLICATION . 'view/javascript/bootstrap/css/bootstrap.css')) {

	           	if (file_exists(DIR_APPLICATION . 'view/stylesheet/seocms/bootstrap.css')) {
					$this->document->addStyle('view/stylesheet/seocms/bootstrap.css');
				}
			}
  		} else {
			if (SC_VERSION < 20) {
				$this->document->addStyle('view/stylesheet/bootstrap.css');
			}
		}

		if (file_exists(DIR_APPLICATION . 'view/stylesheet/colpick.css')) {
			$this->document->addStyle('view/stylesheet/colpick.css');
		}

		if (file_exists(DIR_APPLICATION . 'view/javascript/blog/colpick/colpick.js')) {
			$this->document->addScript('view/javascript/blog/colpick/colpick.js');
		}
		if (!file_exists(DIR_APPLICATION . 'view/javascript/ckeditor/ckeditor.js')) {
			if (file_exists(DIR_APPLICATION . 'view/javascript/blog/ckeditor/ckeditor.js')) {
				$this->document->addScript('view/javascript/blog/ckeditor/ckeditor.js');
			}
		} else {
			$this->document->addScript('view/javascript/ckeditor/ckeditor.js');
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

		$this->data['agoo_widgets'] = iBlog::searchdir(DIR_APPLICATION . "controller/agoo", 'DIRS');

        foreach ($this->data['agoo_widgets'] as $nm => $agoo_widget) {
        		if (file_exists(DIR_APPLICATION . "controller/agoo/".$agoo_widget."/".$agoo_widget.".php")) {
	        		$this->control('agoo/'.$agoo_widget.'/'.$agoo_widget);
	        		$controller_agoo = 'controller_agoo_'.$agoo_widget.'_'.$agoo_widget;
	             	$this->data = $this->$controller_agoo->index($this->data);
        	}
        }


		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->cache->delete('blog');
			$this->cache->delete('record');
			$this->cache->delete('blogsrecord');
			$this->cache->delete('html');
			$this->add_fields();

			$this->model_setting_setting->editSetting('ascp_widgets', $this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');

			if (SC_VERSION < 20) {
				$this->redirect($this->url->link('module/blog/widgets', 'token=' . $this->session->data['token'], 'SSL'));
			} else {
            	$this->response->redirect($this->url->link('module/blog/widgets', 'token=' . $this->session->data['token'], 'SSL'));
            }
		}

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}


		$this->data['token'] = $this->session->data['token'];
		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_content_top'] = $this->language->get('text_content_top');
		$this->data['text_content_bottom'] = $this->language->get('text_content_bottom');
		$this->data['text_column_left'] = $this->language->get('text_column_left');
		$this->data['text_column_right'] = $this->language->get('text_column_right');
		$this->data['text_what_blog'] = $this->language->get('text_what_blog');
		$this->data['text_what_list'] = $this->language->get('text_what_list');
		$this->data['text_what_all'] = $this->language->get('text_what_all');

		$this->data['entry_what'] = $this->language->get('entry_what');
		$this->data['entry_small_dim'] = $this->language->get('entry_small_dim');
		$this->data['entry_big_dim'] = $this->language->get('entry_big_dim');
		$this->data['entry_blog_num_comments'] = $this->language->get('entry_blog_num_comments');
		$this->data['entry_blog_num_records'] = $this->language->get('entry_blog_num_records');
		$this->data['entry_blog_num_desc'] = $this->language->get('entry_blog_num_desc');
		$this->data['entry_blog_num_desc_words'] = $this->language->get('entry_blog_num_desc_words');
		$this->data['entry_blog_num_desc_pred'] = $this->language->get('entry_blog_num_desc_pred');
		$this->data['entry_blog_template'] = $this->language->get('entry_blog_template');
		$this->data['entry_blog_template_record'] = $this->language->get('entry_blog_template_record');
		$this->data['tab_general'] = $this->language->get('tab_general');
		$this->data['tab_list'] = $this->language->get('tab_list');
		$this->data['entry_layout'] = $this->language->get('entry_layout');
		$this->data['entry_position'] = $this->language->get('entry_position');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_add_module'] = $this->language->get('button_add_module');
		$this->data['button_remove'] = $this->language->get('button_remove');
		$this->data['url_blog'] = $this->url->link('catalog/blog', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_record'] = $this->url->link('catalog/record', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_comment'] = $this->url->link('catalog/comment', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_create'] = $this->url->link('module/blog/createtables', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_modules'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_fields'] = $this->url->link('catalog/fields', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_modules_text'] = $this->language->get('url_modules_text');
		$this->data['url_blog_text'] = $this->language->get('url_blog_text');
		$this->data['url_record_text'] = $this->language->get('url_record_text');
		$this->data['url_comment_text'] = $this->language->get('url_comment_text');
		$this->data['url_create_text'] = $this->language->get('url_create_text');
		$this->data['url_options'] = $this->url->link('module/blog', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_schemes'] = $this->url->link('module/blog/schemes', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_url'] = $this->url->link('module/blog/url', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_widgets'] = $this->url->link('module/blog/widgets', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['action'] = $this->url->link('module/blog/widgets', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		$this->load->model('setting/store');
		$this->data['stores'] = $this->model_setting_store->getStores();

		$this->load->model('localisation/language');
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		$this->data['breadcrumbs'] = array();
		$this->data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);
		$this->data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);
		$this->data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('module/blog', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' / '
		);

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

		$this->data['widget_list'] = Array();

		foreach ($this->data['agoo_widgets'] as $num =>$widget_name) {

		 if (!isset($this->data['widget_list'][$widget_name]))	 {
            array_push($this->data['widget_list'],$widget_name);
		 }
		}

		if (isset($this->request->post['ascp_widgets'])) {
			$this->data['ascp_widgets'] = $this->request->post['ascp_widgets'];
		} else {
			$this->data['ascp_widgets'] = $this->config->get('ascp_widgets');
		}

		if (count($this->data['ascp_widgets']) > 0) {
			ksort($this->data['ascp_widgets']);
			uasort($this->data['ascp_widgets'], 'widgetorder');
		}


		$this->data['modules'] = array();
		if (isset($this->request->post['blog_module'])) {
			$this->data['modules'] = $this->request->post['blog_module'];
		} elseif ($this->config->get('blog_module')) {
			$this->data['modules'] = $this->config->get('blog_module');
		}
		$this->load->model('design/layout');
		$this->data['layouts'] = $this->model_design_layout->getLayouts();

       $this->cont('agooa/adminmenu');
       $this->cont('agooa/adminsave');
       $this->data['agoo_menu'] = $this->controller_agooa_adminmenu->index();
       $this->data['agoo_save'] = $this->controller_agooa_adminsave->index();

		$this->template = 'module/blog_widgets.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->data['blog_version'] = $this->data['blog_version']. ' '. $this->data['blog_version_model'];
		$this->data['registry'] = $this->registry;
		$this->data['language'] =  $this->language;
		$this->data['config'] 	=  $this->config;
        $this->data['settings_install'] =  $this->model_setting_setting->getSetting('ascp_install');
        if (SC_VERSION < 20) {
			$this->data['column_left'] ='';
			$html = $this->render();
		} else {
			$this->data['header'] 	= $this->load->controller('common/header');
			$this->data['menu'] 	= $this->load->controller('common/menu');
			$this->data['footer'] 	= $this->load->controller('common/footer');
			$this->data['column_left'] 	= $this->load->controller('common/column_left');
			$html                	= $this->load->view($this->template , $this->data);
		}

		$this->response->setOutput($html);
	}


/***************************************/

	public function ajax_list()
	{
        $this->config->set("blog_work", true);

		$this->data['token'] = $this->session->data['token'];
		$this->language->load('module/blog');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['entry_avatar_dim'] = $this->language->get('entry_avatar_dim');
        $this->data['url_fields'] = $this->url->link('catalog/fields', 'token=' . $this->session->data['token'], 'SSL');

 	  	$this->data['button_save'] = $this->language->get('button_save');

		$this->load->model('catalog/blog');
		$this->load->model('catalog/category');
		$this->load->model('localisation/language');

		if (file_exists(DIR_APPLICATION . 'view/stylesheet/colpick.css')) {
			$this->document->addStyle('view/stylesheet/colpick.css');
		}
		if (file_exists(DIR_APPLICATION . 'view/javascript/blog/colpick/colpick.js')) {
			$this->document->addScript('view/javascript/blog/colpick/colpick.js');
		}

		$this->data['modules'] = array();

		$this->load->model('setting/store');
		$this->data['stores'] = $this->model_setting_store->getStores();


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

       	$this->data['customer_groups_avatar'] = $this->data['customer_groups'];


       	$this->load->model('setting/setting');
        // second parametr  - store_id
		$store_info = $this->model_setting_setting->getSetting('config', 0);
        if (isset($store_info['config_email'])) {
        	$this->data['config_email'] = $store_info['config_email'];
        } else {
          	$this->data['config_email'] = '';
        }

		$this->data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['list'])) {
			$str = base64_decode($this->request->post['list']);
			$list = unserialize($str);
		} else {
			$list = Array();
		}
		if (isset($this->request->post['num'])) {
			$num = $this->request->post['num'];
		}

        $this->data['id'] = $num;
		$this->data['ascp_widgets'][$this->data['id']] = $list;
		if (isset($this->request->post['type'])) {
			$this->data['ascp_widgets'][$this->data['id']]['type'] = $this->request->post['type'];
		}



        require_once(DIR_SYSTEM . 'library/iblog.php');
		$this->data['agoo_widgets'] = iBlog::searchdir(DIR_APPLICATION . "controller/agoo", 'DIRS');

        $widget_exists = false;
        $this->data['widget_exists'] = true;

        foreach ($this->data['agoo_widgets'] as $nm => $agoo_widget) {
        	if ($this->data['ascp_widgets'][$this->data['id']]['type'] == $agoo_widget) {
        		if (file_exists(DIR_APPLICATION . "controller/agoo/".$agoo_widget."/".$agoo_widget.".php")) {
	        		$widget_exists = true;
	        		$this->control('agoo/'.$agoo_widget.'/'.$agoo_widget);
	        		$controller_agoo = 'controller_agoo_'.$agoo_widget.'_'.$agoo_widget;
	             	$this->data = $this->$controller_agoo->index($this->data);
	             	if (isset($this->data[$agoo_widget.'_template'])) {
	             		$this->template = $this->data[$agoo_widget.'_template'];
	             	}
             	}
        	}
        }

        if (!$widget_exists) {
          $this->template = 'agoo/hook/hook.tpl';
          $this->data['widget_exists'] = false;
          $widget_exists = true;
          $this->data['text_widget_not_found'] = $this->language->get('text_widget_not_found');
        }

/*************************************************************************************/
		if (isset($this->data['ascp_widgets'][$this->data['id']]['anchor']) && $this->data['ascp_widgets'][$this->data['id']]['anchor']!='' && $this->data['ascp_widgets'][$this->data['id']]['type'] != 'avatar') {
       	 	$pos = strpos(str_replace(' ', '',$this->data['ascp_widgets'][$this->data['id']]['anchor']), str_replace(' ', '',"$('#cmswidget-'+cmswidget).remove()"));

			if ($pos === false) {
				   $this->data['ascp_widgets'][$this->data['id']]['anchor'] = "$('#cmswidget-'+cmswidget).remove();
". $this->data['ascp_widgets'][$this->data['id']]['anchor'];
			}
		}


		if (isset($this->data['ascp_widgets'][$this->data['id']]['anchor']) && $this->data['ascp_widgets'][$this->data['id']]['anchor']!='' && $this->data['ascp_widgets'][$this->data['id']]['type'] != 'avatar') {
       	 	$pos = strpos(str_replace(' ', '',$this->data['ascp_widgets'][$this->data['id']]['anchor']), str_replace(' ', '','$(data).html()'));

			if ($pos === false) {
				   $this->data['ascp_widgets'][$this->data['id']]['anchor'] = 'data = $(data).html();
'. $this->data['ascp_widgets'][$this->data['id']]['anchor'];
			}
		}
/*************************************************************************************/
		if (!isset($this->data['ascp_widgets'][$this->data['id']]['rating'])) {
			$this->data['ascp_widgets'][$this->data['id']]['rating'] = true;
		}
		if (!isset($this->data['ascp_widgets'][$this->data['id']]['counting'])) {
			$this->data['ascp_widgets'][$this->data['id']]['counting'] = true;
		}
		if (!isset($this->data['ascp_widgets'][$this->data['id']]['view_date'])) {
			$this->data['ascp_widgets'][$this->data['id']]['view_date'] = true;
		}
		if (!isset($this->data['ascp_widgets'][$this->data['id']]['view_rating'])) {
			$this->data['ascp_widgets'][$this->data['id']]['view_rating'] = true;
		}
		if (!isset($this->data['ascp_widgets'][$this->data['id']]['number_comments'])) {
			$this->data['ascp_widgets'][$this->data['id']]['number_comments'] = 20;
		}
		if (!isset($this->data['ascp_widgets'][$this->data['id']]['status'])) {
			$this->data['ascp_widgets'][$this->data['id']]['status'] = true;
		}
		if (!isset($this->data['ascp_widgets'][$this->data['id']]['status_language'])) {
			$this->data['ascp_widgets'][$this->data['id']]['status_language'] = true;
		}
		if (!isset($this->data['ascp_widgets'][$this->data['id']]['visual_rating'])) {
			$this->data['ascp_widgets'][$this->data['id']]['visual_rating'] = true;
		}
		if (!isset($this->data['ascp_widgets'][$this->data['id']]['signer'])) {
			$this->data['ascp_widgets'][$this->data['id']]['signer'] = true;
		}
		if (!isset($this->data['ascp_widgets'][$this->data['id']]['visual_editor'])) {
			$this->data['ascp_widgets'][$this->data['id']]['visual_editor'] = true;
		}
		if (!isset($this->data['ascp_widgets'][$this->data['id']]['description_status'])) {
			$this->data['ascp_widgets'][$this->data['id']]['description_status'] = true;
		}
		if (!isset($this->data['ascp_widgets'][$this->data['id']]['avatar_status'])) {
			$this->data['ascp_widgets'][$this->data['id']]['avatar_status'] = true;
		}
		if (!isset($this->data['ascp_widgets'][$this->data['id']]['title_status'])) {
			$this->data['ascp_widgets'][$this->data['id']]['title_status'] = true;
		}
		if (!isset($this->data['ascp_widgets'][$this->data['id']]['cached'])) {
			$this->data['ascp_widgets'][$this->data['id']]['cached'] = true;
		}
		if (!isset($this->data['ascp_widgets'][$this->data['id']]['images_view'])) {
			$this->data['ascp_widgets'][$this->data['id']]['images_view'] = true;
		}
		if (!isset($this->data['ascp_widgets'][$this->data['id']]['view_comments'])) {
			$this->data['ascp_widgets'][$this->data['id']]['view_comments'] = true;
		}
		if (!isset($this->data['ascp_widgets'][$this->data['id']]['karma'])) {
			$this->data['ascp_widgets'][$this->data['id']]['karma'] = true;
		}
		if (!isset($this->data['ascp_widgets'][$this->data['id']]['fields_view'])) {
			$this->data['ascp_widgets'][$this->data['id']]['fields_view'] = true;
		}
		if (!isset($this->data['ascp_widgets'][$this->data['id']]['view_captcha'])) {
			$this->data['ascp_widgets'][$this->data['id']]['view_captcha'] = true;
		}
		if (!isset($this->data['ascp_widgets'][$this->data['id']]['status_now'])) {
			$this->data['ascp_widgets'][$this->data['id']]['status_now'] = true;
		}
		if (!isset($this->data['ascp_widgets'][$this->data['id']]['view_category'])) {
			$this->data['ascp_widgets'][$this->data['id']]['view_category'] = true;
		}
		if (!isset($this->data['ascp_widgets'][$this->data['id']]['view_record'])) {
			$this->data['ascp_widgets'][$this->data['id']]['view_record'] = true;
		}
		if (!isset($this->data['ascp_widgets'][$this->data['id']]['view_avatar'])) {
			$this->data['ascp_widgets'][$this->data['id']]['view_avatar'] = true;
		}
		if (!isset($this->data['ascp_widgets'][$this->data['id']]['view_author'])) {
			$this->data['ascp_widgets'][$this->data['id']]['view_author'] = true;
		}
		if (!isset($this->data['ascp_widgets'][$this->data['id']]['field_public'])) {
			$this->data['ascp_widgets'][$this->data['id']]['field_public'] = true;
		}
/*************************************************************************************/
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

		if (count($this->data['ascp_widgets']) > 0) {
			reset($this->data['ascp_widgets']);
			$first_key = key($this->data['ascp_widgets']);
			foreach ($this->data['ascp_widgets'] as $num => $list) {
				$this->data['slist'] = serialize($list);
			}
		}

        if ($widget_exists) {
			$this->data['registry'] = $this->registry;
			$this->data['language'] =  $this->language;
			$this->data['config'] 	=  $this->config;

	        if (SC_VERSION < 20) {
				$this->data['column_left'] ='';
				$html = $this->render();
			} else {
				$this->data['header'] 	= $this->load->controller('common/header');
				$this->data['menu'] 	= $this->load->controller('common/menu');
				$this->data['footer'] 	= $this->load->controller('common/footer');
				$this->data['column_left'] 	= $this->load->controller('common/column_left');
				$html                	= $this->load->view($this->template , $this->data);
			}


			$this->response->setOutput($html);
		}

	}

/***************************************/
	private function install_new_loader()
	{
        $this->config->set("blog_work", true);
        $html = '';
		$html.=$this->install_front_loader();
		$html.=$this->install_back_loader();
		return $html;
	}

	private function install_front_loader()
	{
		$html = '';
		$this->registry->set('no_redirect', false);

		if (SC_VERSION < 22) {
			$file = DIR_CATALOG . 'controller/common/maintenance.php';
		} else {
			$file = DIR_CATALOG . 'controller/startup/maintenance.php';
		}


		$admin_url = $this->http_catalog();
		$content_maintenance = file_get_contents($file, FILE_USE_INCLUDE_PATH);
		$findme = "seocmspro_loader";
		$pos = strpos($content_maintenance, $findme);
		if ($pos === false) {
			$text = " \$seocmspro_loader='begin';
\$sc_ver = VERSION;
if (!defined('SC_VERSION')) define('SC_VERSION', (int)substr(str_replace('.','',\$sc_ver), 0,2));
\$file = DIR_SYSTEM . 'library/front_loader.php';
if (file_exists(\$file)) {include_once(\$file);}
\$seocmspro_loader='end';";

			$end_file = substr($content_maintenance,strlen($content_maintenance)-2,strlen($content_maintenance)-1);

			if ($end_file == '?>') {
           	 $content_maintenance = substr($content_maintenance, 0,strlen($content_maintenance)-2);
			}

            $text_write = $content_maintenance.$text;

			$this->dir_permissions($file);
			if (file_exists($file)) {
				if (is_writable($file)) {
					$f = @fopen($file, 'w');
					@fwrite($f, $text_write);
					@fclose($f);
					$html .= $this->language->get('ok_777'). '<br>';
				} else {
					$html .= $file."<br><ins style='color: red; text-decoration: none; font-size: 25px;'>".$this->language->get('access_777') . "</ins><br>";
					$this->registry->set('no_redirect', true);

				}
			}
		}
		return $html;
	}


	private function install_back_loader()
	{
		$html = '';
		$this->registry->set('no_redirect', false);

		if (SC_VERSION < 20) {
			$file = DIR_APPLICATION . 'controller/common/home.php';
		} else {
			if (SC_VERSION < 22) {
				$file = DIR_APPLICATION . 'controller/error/permission.php';
			} else {
				$file = DIR_APPLICATION . 'controller/startup/permission.php';
			}
		}

		$admin_url = $this->http_catalog();
		$content_maintenance = file_get_contents($file, FILE_USE_INCLUDE_PATH);
		$findme = "seocmspro_loader";
		$pos = strpos($content_maintenance, $findme);
		if ($pos === false) {
			$text = "\$seocmspro_loader='begin';
\$sc_ver = VERSION;
if (!defined('SC_VERSION')) define('SC_VERSION', (int)substr(str_replace('.','',\$sc_ver), 0,2));
\$file = DIR_SYSTEM.'library/front_loader.php';
if (!isset(\$registry)) {\$registry = \$this->registry;}
if (SC_VERSION > 21) {
	\$user_str = 'Cart\\User';
} else {
	\$user_str = 'User';
}
require_once(DIR_SYSTEM . 'helper/seocmsprofunc.php');
if (!class_exists('User')) {
	loadlibrary('user');
}
\$user =  new \$user_str(\$registry);
if (\$user->isLogged()) {
	\$registry->set('admin_work', true);
	if (file_exists(\$file)) {include_once(\$file);}
}
\$seocmspro_loader='end';";

			$end_file = substr($content_maintenance,strlen($content_maintenance)-2,strlen($content_maintenance)-1);

			if ($end_file == '?>') {
           	 $content_maintenance = substr($content_maintenance, 0,strlen($content_maintenance)-2);
			}

            $text = $content_maintenance.$text;

			$this->dir_permissions($file);
			if (file_exists($file)) {
				if (is_writable($file)) {
					$f = @fopen($file, 'w');
					@fwrite($f, $text);
					@fclose($f);
					$html .= $this->language->get('ok_777'). '<br>';
				} else {
					$html .= $file."<br><ins style='color: red; text-decoration: none; font-size: 25px;'>".$this->language->get('access_777') . "</ins><br>";
					$this->registry->set('no_redirect', true);
				}
			}
		}
		return $html;
	}
/***************************************/
	private function remove_old_loader()
	{
		$this->remove_back_old_loader();
		$this->remove_front_old_loader();

	}
	private function remove_back_old_loader()
	{
		$html = "<br>";
		$directory = '';
		$this->load->model('localisation/language');
		$languages = $this->model_localisation_language->getLanguages();
		foreach ($languages as $language) {
			if ($this->config->get('config_language') == $language['code']) {
				if (isset($language['directory']))
				$directory = $language['directory'];
				else
				$directory = '';
			}
		}
		$file = DIR_LANGUAGE . $directory . '/common/footer.php';
		$this->dir_permissions($file);
		if (file_exists($file)) {
			$text = file_get_contents($file, FILE_USE_INCLUDE_PATH);
			$this->dir_permissions($file);
			$text = preg_replace("!<[\?]php [\$]loader_version(.*?)[\?]>!s", "", $text);
			if (is_writable($file)) {
				$f = @fopen($file, 'w');
				@fwrite($f, $text);
				@fclose($f);
				$html .= $this->language->get('remove_777'). '<br>';
			} else {
				$html .= $file . "<br><ins style='color: red; text-decoration: none; font-size: 25px;'>" . $this->language->get('access_777') . "</ins><br>";
				$this->registry->set('no_redirect', true);
			}
		}

		$file = DIR_APPLICATION . 'controller/common/home.php';
		if (file_exists($file)) {
			$text = file_get_contents($file, FILE_USE_INCLUDE_PATH);
			$this->dir_permissions($file);
			$text = preg_replace("!<[\?]php [\$]occms_version(.*?)[\?]>!s", "", $text);
			if (is_writable($file)) {
				$f = @fopen($file, 'w');
				@fwrite($f, $text);
				@fclose($f);
				$html .= $this->language->get('remove_777'). '<br>';
			} else {
				$html .= $file . "<br><ins style='color: red; text-decoration: none; font-size: 25px;'>" . $this->language->get('access_777') . "</ins><br>";
				$this->registry->set('no_redirect', true);
			}
		}
		return $html;
	}

	private function remove_front_old_loader()
	{
		$html = "<br>";
		if (SC_VERSION < 22) {
			$file = DIR_CATALOG . 'controller/common/maintenance.php';
		} else {
			$file = DIR_CATALOG . 'controller/startup/maintenance.php';
		}
		if (file_exists($file)) {
			$text = file_get_contents($file, FILE_USE_INCLUDE_PATH);
			$this->dir_permissions($file);
			$text = preg_replace("!<[\?]php [\$]occms_version(.*?)[\?]>!s", "", $text);
			if (is_writable($file)) {
				$f = @fopen($file, 'w');
				@fwrite($f, $text);
				@fclose($f);
				$html .= $this->language->get('remove_777'). '<br>';
			} else {
				$html .= $file . "<br><ins style='color: red; text-decoration: none; font-size: 25px;'>" . $this->language->get('access_777') . "</ins><br>";
				$this->registry->set('no_redirect', true);
			}
		}

		if (VERSION == '1.5.5.1') {
			$file = DIR_CATALOG . 'controller/error/not_found.php';
			if (file_exists($file)) {
				$text = file_get_contents($file, FILE_USE_INCLUDE_PATH);
				$this->dir_permissions($file);
				$text = preg_replace("!<[\?]php [\$]occms_version(.*?)[\?]>!s", "", $text);
				if (is_writable($file)) {
					$f = @fopen($file, 'w');
					@fwrite($f, $text);
					@fclose($f);
					$html .= $this->language->get('remove_777'). '<br>';
				} else {
					$html .= $file . "<br><ins style='color: red; text-decoration: none; font-size: 25px;'>" . $this->language->get('access_777') . "</ins><br>";
					$this->registry->set('no_redirect', true);
				}
			}
		}
		return $html;
	}
/***************************************/


/***************************************/
	private function remove_new_loader()
	{
		$this->remove_front_loader();
		$this->remove_back_loader();
	}


/***************************************/
	private function remove_front_loader()
	{
		$html = "<br>";
		if (SC_VERSION < 22) {
			$file = DIR_CATALOG . 'controller/common/maintenance.php';
		} else {
			$file = DIR_CATALOG . 'controller/startup/maintenance.php';
		}
		if (file_exists($file)) {
			$text = file_get_contents($file, FILE_USE_INCLUDE_PATH);
			$this->dir_permissions($file);
			$text = preg_replace("![\$]seocmspro_loader[\=][\']begin[\'][\;](.*?)[\$]seocmspro_loader[\=][\']end[\'][\;]!s", "", $text);
			if (is_writable($file)) {
				$f = @fopen($file, 'w');
				@fwrite($f, $text);
				@fclose($f);
				$html .= $this->language->get('remove_777'). '<br>';
			} else {
				$html .= $file . "<br><ins style='color: red; text-decoration: none; font-size: 25px;'>" . $this->language->get('access_777') . "</ins><br>";
				$this->registry->set('no_redirect', true);
			}
		}
		return $html;
	}
/***************************************/
 	private function remove_back_loader()
	{
		$html = "<br>";
		if (SC_VERSION < 20) {
			$file = DIR_APPLICATION . 'controller/common/home.php';
		} else {
			if (SC_VERSION < 22) {
				$file = DIR_APPLICATION . 'controller/error/permission.php';
			} else {
				$file = DIR_APPLICATION . 'controller/startup/permission.php';
			}
		}
		if (file_exists($file)) {
			$text = file_get_contents($file, FILE_USE_INCLUDE_PATH);
			$this->dir_permissions($file);
			$text = preg_replace("![\$]seocmspro_loader[\=][\']begin[\'][\;](.*?)[\$]seocmspro_loader[\=][\']end[\'][\;]!s", "", $text);
			if (is_writable($file)) {
				$f = @fopen($file, 'w');
				@fwrite($f, $text);
				@fclose($f);
				$html .= $this->language->get('remove_777'). '<br>';
			} else {
				$html .= $file . "<br><ins style='color: red; text-decoration: none; font-size: 25px;'>" . $this->language->get('access_777') . "</ins><br>";
				$this->registry->set('no_redirect', true);
			}
		}

		return $html;
	}



	public function uninstall()
	{
 		$this->config->set("blog_work", true);
		$this->remove_new_loader();
		// $this->deleteAllSettings();
	}
/***************************************/
	public function install()
	{
	 		$this->config->set("blog_work", true);
			$this->language->load('module/blog');
			$this->load->model('setting/setting');
			$this->data['text_update'] = $this->language->get('text_update');
			$this->model_setting_setting->deleteSetting('ascp_version');
			$this->model_setting_setting->deleteSetting('ascp_install');
			$this->model_setting_setting->editSetting('ascp_install',
			Array(	'ascp_install' => false,
					'ascp_install_1' => false,
					'ascp_install_2' => false,
					'ascp_install_3' => false,
					'ascp_install_4' => false
			));
		$this->createTables();
		$this->model_setting_setting->deleteSetting('ascp_version');

	}
/***************************************/
	public function ascp_widgets_save()
	{
 	  $this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

   			if ($this->config->get('ascp_install')) {
				$settings_install = $this->model_setting_setting->getSetting('ascp_install');
	   			if (!$settings_install['ascp_install_4']) {
	                $settings_install['ascp_install_4'] = true;
					$this->model_setting_setting->editSetting('ascp_install', $settings_install);
				}
        	}

		  $this->data['token'] = $this->session->data['token'];

		  $ascp_widgets = $this->config->get('ascp_widgets');

		if (isset($this->request->get['num'])) {


		  if (isset($this->request->post['ascp_widgets'])) {
		    $ascp_widgets_post = $this->request->post['ascp_widgets'];
		  } else {
		  	$ascp_widgets_post = Array();
		  }

		if ($this->config->get('blog_module')) {
			$modules = $this->config->get('blog_module');
		} else {
		    $modules = Array();
		}

	    if (isset($ascp_widgets) && !empty($ascp_widgets)) {
		    foreach ($ascp_widgets as $un => $lav) {
		      	 if ($un=='' || !isset($un)) {
		      	 	unset($ascp_widgets[$un]);
		      	 }

			}
	    }

	    $zamena = array ("`", "'", '"', "<", ">");
		foreach ($ascp_widgets_post as $num => $val) {
				if (isset($val['title_list_latest']) && !empty($val['title_list_latest'])) {
					foreach ($val['title_list_latest'] as $num_1 => $val_1) {
					 $ascp_widgets_post[$num]['title_list_latest'][$num_1] = str_replace($zamena,"",$val_1);
					}
				}
  		}

         $ascp_widgets[key($ascp_widgets_post)] = $ascp_widgets_post[key($ascp_widgets_post)];

         if (isset($ascp_widgets_post[key($ascp_widgets_post)]['remove']) && $ascp_widgets_post[key($ascp_widgets_post)]['remove']=="remove") {
           unset($ascp_widgets[key($ascp_widgets_post)]);

           foreach ($modules as $num => $value) {
           	if (isset($value['what']) && $value['what'] == key($ascp_widgets_post)) {
           	 unset($modules[$num]);
           	 $modules_new['blog_module'] = $modules;
           	 $this->model_setting_setting->editSetting('blog_module', $modules_new);
           	}

           }

         }

	     $ascp_widgets_new['ascp_widgets'] = $ascp_widgets;

		 $this->model_setting_setting->editSetting('ascp_widgets', $ascp_widgets_new);


		}
       }

	}


/***************************************/
	public function autocomplete_template()
	{
		$json = array();
		if (isset($this->request->get['path'])) {
			if (isset($this->request->get['path'])) {
				$path = $this->request->get['path'];
			} else {
				$path = '';
			}
			$this->data['this'] = $this;
			$this->data['widgets_full_path_default'] = array();
			$this->data['widgets_full_path_theme'] = array();
			$this->data['widgets_full_path_default'] = $this->msearchdir(DIR_CATALOG . "view/theme/default/template/agootemplates/" . $path);
			$this->data['widgets_full_path_theme'] = $this->msearchdir(DIR_CATALOG . "view/theme/" . $this->config->get('config_template') . "/template/agootemplates/" . $path);
			$this->data['widgets_full_path'] = array_replace_recursive($this->data['widgets_full_path_default'], $this->data['widgets_full_path_theme']);
			$i = 0;
            $this->data['widgets']=Array('');
			foreach ($this->data['widgets_full_path'] as $widget_full_path) {
				$dname = str_replace(DIR_CATALOG . "view/theme/default/template/agootemplates/" . $path . "/", '', $widget_full_path);
				$ename = str_replace(DIR_CATALOG . "view/theme/" . $this->config->get('config_template') . "/template/agootemplates/" . $path . "/", '', $dname);
				$this->data['widgets'][$i]['name'] = $ename;
				$i++;
			}

			foreach ($this->data['widgets'] as $result) {
				$json[] = array(
					'name' => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
				);
			}
		}
		$this->response->setOutput(json_encode($json));
	}
/***************************************/
	public function msearchdir($path, $mode = "FULL", $myself = false, $maxdepth = -1, $d = 0)
	{
		$dirlist = array();
		if (!file_exists($path)) {
			return $dirlist;
		}
		if (substr($path, strlen($path) - 1) != '/') {
			$path .= '/';
		}
		if ($mode != "FILES") {
			if ($d != 0 || $myself)
				$dirlist[] = $path;
		}
		if ($handle = opendir($path)) {
			while (false !== ($file = readdir($handle))) {
				if ($file != '.' && $file != '..') {
					$file = $path . $file;
					if (!is_dir($file)) {
						if ($mode != "DIRS") {
							$dirlist[] = $file;
						}
					} elseif ($d >= 0 && ($d < $maxdepth || $maxdepth < 0)) {
						$result = $this->msearchdir($file . '/', $mode, $myself, $maxdepth, $d + 1);
						$dirlist = array_merge($dirlist, $result);
					}
				}
			}
			closedir($handle);
		}
		if ($d == 0) {
			natcasesort($dirlist);
		}
		return ($dirlist);
	}
/***************************************/
	private function add_fields($prefix = '')
	{
		if (isset($this->request->post['ascp_widgets'])) {
			foreach ($this->request->post['ascp_widgets'] as $num => $value) {
				if (isset($value['addfields'])) {
					$sql[0] = "
						CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "review_fields` (
							 `review_id` int(11) NOT NULL,
					  		KEY `review_id` (`review_id`)
						) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
						";
					foreach ($sql as $qsql) {
						$query = $this->db->query($qsql);
					}
					foreach ($value['addfields'] as $num_add => $value_add) {
						if ($value_add['field_name'] != '') {
							$r = $this->db->query("DESCRIBE " . DB_PREFIX . "review_fields '" . $prefix . $value_add['field_name'] . "'");
							if ($r->num_rows == 0) {
								$msql = "ALTER TABLE `" . DB_PREFIX . "review_fields` ADD `" . $prefix . $value_add['field_name'] . "` text COLLATE utf8_general_ci NOT NULL";
								$query = $this->db->query($msql);
							}
						}
					}
				}
			}
		}
	}
/***************************************/
	private function validate()
	{
		$this->language->load('module/blog');
		if (!$this->user->hasPermission('modify', 'module/blog')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if (isset($this->request->post['ascp_widgets'])) {
			foreach ($this->request->post['ascp_widgets'] as $num => $value) {
				if (isset($value['addfields']) && !empty($value['addfields'])) {
					foreach ($value['addfields'] as $num_add => $value_add) {
						if ($value_add['field_name'] == '') {
							$this->error['warning'] = $this->language->get('error_addfields_name');
						} else {
							if (!preg_match('/^[a-z][a-z0-9-_]{3,30}$/i', $value_add['field_name'])) {
								$this->error['warning'] = $this->language->get('error_addfields_name');
							}
						}
					}
				}
			}
		}



		if (!$this->error) {
			return true;
		} else {
			$this->request->post = array();
			return false;
		}
	}
/***************************************/
	private function http_catalog()
	{
		if (!defined('HTTPS_CATALOG')) {
			$https_catalog = HTTP_CATALOG;
		} else {
			$https_catalog = HTTPS_CATALOG;
		}
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			return $https_catalog;
		} else {
			return HTTP_CATALOG;
		}
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

	public function control($cont)
	{
		$file = DIR_APPLICATION . 'controller/' . $cont . '.php';
		$class = 'Controller' . preg_replace('/[^a-zA-Z0-9]/', '', $cont);
		if (file_exists($file)) {
			include_once($file);
			$this->registry->set('controller_' . str_replace('/', '_', $cont), new $class($this->registry));
		} else {
			trigger_error('Error: Could not load controller ' . $cont . '!');
			exit();
		}
	}
/***************************************/

	private function alt_stat($file)
	{
		$s = false;
		clearstatcache();
		$ss = @stat($file);
		if (!$ss)
			return false;
		$ts = array(
			0140000 => 'ssocket',
			0120000 => 'llink',
			0100000 => '-file',
			0060000 => 'bblock',
			0040000 => 'ddir',
			0020000 => 'cchar',
			0010000 => 'pfifo'
		);
		$p = $ss['mode'];
		$t = decoct($ss['mode'] & 0170000);
		$str = (array_key_exists(octdec($t), $ts)) ? $ts[octdec($t)]{0} : 'u';
		$str .= (($p & 0x0100) ? 'r' : '-') . (($p & 0x0080) ? 'w' : '-');
		$str .= (($p & 0x0040) ? (($p & 0x0800) ? 's' : 'x') : (($p & 0x0800) ? 'S' : '-'));
		$str .= (($p & 0x0020) ? 'r' : '-') . (($p & 0x0010) ? 'w' : '-');
		$str .= (($p & 0x0008) ? (($p & 0x0400) ? 's' : 'x') : (($p & 0x0400) ? 'S' : '-'));
		$str .= (($p & 0x0004) ? 'r' : '-') . (($p & 0x0002) ? 'w' : '-');
		$str .= (($p & 0x0001) ? (($p & 0x0200) ? 't' : 'x') : (($p & 0x0200) ? 'T' : '-'));
		$s = array(
			'perms' => array(
				'umask' => sprintf("%04o", @umask()),
				'human' => $str,
				'octal1' => sprintf("%o", ($ss['mode'] & 000777)),
				'octal2' => sprintf("0%o", 0777 & $p),
				'decimal' => sprintf("%04o", $p),
				'fileperms' => @fileperms($file),
				'mode1' => $p,
				'mode2' => $ss['mode']
			),
			'owner' => array(
				'fileowner' => $ss['uid'],
				'filegroup' => $ss['gid'],
				'owner' => (function_exists('posix_getpwuid')) ? @posix_getpwuid($ss['uid']) : '',
				'group' => (function_exists('posix_getgrgid')) ? @posix_getgrgid($ss['gid']) : ''
			),
			'file' => array(
				'filename' => $file,
				'realpath' => (@realpath($file) != $file) ? @realpath($file) : '',
				'dirname' => @dirname($file),
				'basename' => @basename($file)
			),
			'filetype' => array(
				'type' => substr($ts[octdec($t)], 1),
				'type_octal' => sprintf("%07o", octdec($t)),
				'is_file' => @is_file($file),
				'is_dir' => @is_dir($file),
				'is_link' => @is_link($file),
				'is_readable' => @is_readable($file),
				'is_writable' => @is_writable($file)
			),
			'device' => array(
				'device' => $ss['dev'],
				'device_number' => $ss['rdev'],
				'inode' => $ss['ino'],
				'link_count' => $ss['nlink'],
				'link_to' => ($s['type'] == 'link') ? @readlink($file) : ''
			),
			'size' => array(
				'size' => $ss['size'],
				'blocks' => $ss['blocks'],
				'block_size' => $ss['blksize']
			),
			'time' => array(
				'mtime' => $ss['mtime'],
				'atime' => $ss['atime'],
				'ctime' => $ss['ctime'],
				'accessed' => @date('Y M D H:i:s', $ss['atime']),
				'modified' => @date('Y M D H:i:s', $ss['mtime']),
				'created' => @date('Y M D H:i:s', $ss['ctime'])
			)
		);
		clearstatcache();
		return $s;
	}
/***************************************/
	public function deleteOldSetting()
	{
        $this->language->load('module/blog');

        if (!$this->validate()) {
	        $html = $this->language->get('error_permission');
	        $this->response->setOutput($html);
	        return;
        }

		$html = "<br>";
		$this->load->model('setting/setting');

		$ascp_settings = $this->model_setting_setting->getSetting('ascp_settings');
		$blog_module = $this->model_setting_setting->getSetting('blog_module');
		$ascp_widgets = $this->model_setting_setting->getSetting('ascp_widgets');
		$blog_old = $this->model_setting_setting->getSetting('blog');

		if (count($ascp_settings) == 0 || count($blog_module) == 0 || count($ascp_widgets) == 0) {
			$html .= $this->language->get('error_delete_old_settings');
		} else {

			$this->model_setting_setting->deleteSetting('blog');

			$html .= $this->language->get('ok_create_tables');
		}
		$this->cache->delete('blog');
		$this->cache->delete('record');
		$this->cache->delete('blog.module.view');
		$this->cache->delete('blogsrecord');
		$this->cache->delete('category');
		$this->cache->delete('product');
		$this->cache->delete('html');
		//$this->language->load('seocms/catalog/blog');
		$this->response->setOutput($html);
	}
/***************************************/

	public function deleteAllSettings()
	{
        $this->language->load('module/blog');

        if (!$this->validate()) {
	        $html = $this->language->get('error_permission');
	        $this->response->setOutput($html);
	        return;
        }

		$html = "";
		$this->load->model('setting/setting');

       	$this->model_setting_setting->deleteSetting('ascp_admin');
       	$this->model_setting_setting->deleteSetting('ascp_settings');
       	$this->model_setting_setting->deleteSetting('ascp_comp_url');
       	$this->model_setting_setting->deleteSetting('ascp_settings_sitemap');
        $this->model_setting_setting->deleteSetting('ascp_version');
        $this->model_setting_setting->deleteSetting('ascp_version_model');
        $this->model_setting_setting->deleteSetting('ascp_ver');
        $this->model_setting_setting->deleteSetting('ascp_widgets');
        $this->model_setting_setting->deleteSetting('asc_cnt_cnt');
        $this->model_setting_setting->deleteSetting('asc_cnt');
        $this->model_setting_setting->deleteSetting('ascp_install');
        $this->model_setting_setting->deleteSetting('ascp_install_1');
        $this->model_setting_setting->deleteSetting('ascp_install_2');
        $this->model_setting_setting->deleteSetting('ascp_install_3');
        $this->model_setting_setting->deleteSetting('ascp_install_4');
        $this->model_setting_setting->deleteSetting('blog_module');

		$this->model_setting_setting->editSetting('ascp_install',
			Array(	'ascp_install' => false,
					'ascp_install_1' => false,
					'ascp_install_2' => false,
					'ascp_install_3' => false,
					'ascp_install_4' => false
			));

		$html .= $this->language->get('ok_delete_all_settings');

		$this->cache->delete('blog');
		$this->cache->delete('record');
		$this->cache->delete('blog.module.view');
		$this->cache->delete('blogsrecord');
		$this->cache->delete('category');
		$this->cache->delete('product');
		$this->cache->delete('html');
		//$this->language->load('seocms/catalog/blog');
		$this->response->setOutput($html);
	}



	public function deleteAllTables()
	{
        $this->language->load('module/blog');
   		//$this->language->load('seocms/catalog/blog');

        if (!$this->validate()) {
	        $html = $this->language->get('error_permission');
	        $this->response->setOutput($html);
	        return;
        }

		$html = "";
		$this->load->model('setting/setting');

       	$tables = array (
       					'blog',
       					'blog_description',
						'blog_to_layout',
						'blog_to_store',
       					'blog_access',
						'comment',
						'record',
						'record_description',
						'record_image',
						'record_related',
						'record_attribute',
						'record_tag',
						'record_to_blog',
						'record_to_download',
						'record_to_layout',
						'record_to_store',
						'record_product_related',
						'record_access',
						'fields',
						'fields_description',
						'url_alias_blog',
						'rate_review',
						'rate_comment',
						'review_fields',
						'agoo_signer'
					);

       foreach ($tables as $table) {
		if ($this->table_exists(DB_PREFIX . $table)) {
		    $sql = "DROP TABLE `" . DB_PREFIX .$table."` ";
			$r = $this->db->query($sql);
		}
       }


		$this->model_setting_setting->editSetting('ascp_install',
			Array(	'ascp_install' => false,
					'ascp_install_1' => false,
					'ascp_install_2' => false,
					'ascp_install_3' => false,
					'ascp_install_4' => false
			)
		);


		$html .= $this->language->get('ok_delete_all_tables');

		$this->cache->delete('blog');
		$this->cache->delete('category');
		$this->cache->delete('product');

		$this->response->setOutput($html);
	}


	public function createTables()
	{
        if (!$this->validate()) {
	        return;
        }

		$sc_ver = VERSION;
		if (!defined('SC_VERSION')) define('SC_VERSION', (int)substr(str_replace('.','',$sc_ver), 0,2));

        $this->config->set("blog_work", true);

		$html = "";
		$html .= $this->remove_old_loader();
		$html .= $this->remove_new_loader();
		$html .= $this->install_new_loader();


		//$this->language->load('seocms/catalog/blog');

  		//if ($this->config->get('ascp_install'))
   		{
        	$this->load->model('setting/setting');
	   		$settings_install = $this->model_setting_setting->getSetting('ascp_install');
			$settings_install = Array(	'ascp_install' => true,
					'ascp_install_1' => true,
					'ascp_install_2' => false,
					'ascp_install_3' => false,
					'ascp_install_4' => false
			);
			$this->model_setting_setting->editSetting('ascp_install', $settings_install);
        }

        if (SC_VERSION < 20) {
			$msql = "SELECT * FROM `" . DB_PREFIX . "setting` WHERE `group`='blogadmin'";
			$query = $this->db->query($msql);
			if (count($query->rows) > 0) {
				foreach ($query->rows as $row) {
                    $msql = "UPDATE `" . DB_PREFIX . "setting` SET `group`='ascp_admin', `key`='ascp_admin_".$row['key']."' WHERE `setting_id`='".$row['setting_id']."'";
					$this->db->query($msql);

				}
			}

			$msql = "SELECT * FROM `" . DB_PREFIX . "setting` WHERE `group`='blog_schemes'";
			$query = $this->db->query($msql);
			if (count($query->rows) > 0) {
				foreach ($query->rows as $row) {
                    $msql = "UPDATE `" . DB_PREFIX . "setting` SET `group`='blog_module', `key`='blog_module'  WHERE `setting_id`='".$row['setting_id']."'";
					$this->db->query($msql);

				}
			}

			$msql = "SELECT * FROM `" . DB_PREFIX . "setting` WHERE `group`='blog_widgets'";
			$query = $this->db->query($msql);
			if (count($query->rows) > 0) {
				foreach ($query->rows as $row) {
                    $msql = "UPDATE `" . DB_PREFIX . "setting` SET `group`='ascp_widgets', `key`='ascp_widgets' WHERE `setting_id`='".$row['setting_id']."'";
					$this->db->query($msql);

				}
			}

			$msql = "SELECT * FROM `" . DB_PREFIX . "setting` WHERE `group`='blog_options' AND `key`='generallist'";
			$query = $this->db->query($msql);
			if (count($query->rows) > 0) {
				foreach ($query->rows as $row) {
                    $msql = "UPDATE `" . DB_PREFIX . "setting` SET `group`='ascp_settings', `key`='ascp_settings' WHERE `setting_id`='".$row['setting_id']."'";
					$this->db->query($msql);

				}
			}

            $msql = "DELETE FROM `" . DB_PREFIX . "setting` WHERE `group`='blogversion'";
			$this->db->query($msql);
            $msql = "DELETE FROM `" . DB_PREFIX . "setting` WHERE `group`='blog_ver'";
			$this->db->query($msql);

			$msql = "DELETE FROM `" . DB_PREFIX . "setting` WHERE `group`='blog_options'";
			$this->db->query($msql);

         }

		$this->data['this'] = $this;
		$this->load->model('setting/setting');
		$this->language->load('module/blog');
		$this->data['blog_version'] = $this->language->get('blog_version');
        $this->data['blog_version_model'] = $this->language->get('blog_version_model');

		$this->model_setting_setting->editSetting('ascp_ver', Array('ascp_ver_date' => 0, 'ascp_ver_content' => 0 ));


		$setting_admin = Array(
			'ascp_admin_http_admin_path' => HTTP_SERVER,
			'ascp_admin_https_admin_path' => HTTPS_SERVER
		);
		$this->model_setting_setting->editSetting('ascp_admin', $setting_admin);

		$setting_version = Array(
			'ascp_version' => $this->data['blog_version']
		);
		$this->model_setting_setting->editSetting('ascp_version', $setting_version);

		$setting_version_model = Array(
			'ascp_version_model' => $this->data['blog_version_model']
		);
		$this->model_setting_setting->editSetting('ascp_version_model', $setting_version_model);


		$this->load->model('localisation/language');
		$languages = $this->model_localisation_language->getLanguages();
		foreach ($languages as $language) {
			if ($this->config->get('config_language') == $language['code']) {
				if (isset($language['directory']))
				$directory = $language['directory'];
				else
				$directory = '';
			}
		}




$sql[22] = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "url_alias_blog` (
  `url_alias_id` int(11) NOT NULL AUTO_INCREMENT,
  `query` varchar(255) NOT NULL,
  `keyword` varchar(255) NOT NULL,
  PRIMARY KEY (`url_alias_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";


$sql[24] = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "agoo_signer` (
`id` INT( 11 ) NOT NULL ,
`pointer` varchar(128) COLLATE utf8_general_ci NOT NULL,
`customer_id` INT( 11 ) NOT NULL ,
`date` DATETIME NOT NULL ,
KEY ( `pointer` ),
KEY ( `id` ) ,
KEY( `customer_id` ),
KEY( `date` )
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;";



		foreach ($sql as $qsql) {
			$query = $this->db->query($qsql);
		}


        require_once(DIR_SYSTEM . 'library/iblog.php');
        $this->data['agoo_widgets'] = iBlog::searchdir(DIR_APPLICATION . "controller/agoo", 'DIRS');
        foreach ($this->data['agoo_widgets'] as $nm => $agoo_widget) {
        		if (file_exists(DIR_APPLICATION . "controller/agoo/".$agoo_widget."/".$agoo_widget.".php")) {
	        		$this->control('agoo/'.$agoo_widget.'/'.$agoo_widget);
	        		$controller_agoo = 'controller_agoo_'.$agoo_widget.'_'.$agoo_widget;

	             	if (method_exists($this->registry->get($controller_agoo), 'install'))
	             	$this->data = $this->$controller_agoo->install($this->data);
        	}
        }




		$r = $this->db->query("DESCRIBE  " . DB_PREFIX . "url_alias_blog `language_id`");
		if ($r->num_rows == 0) {
			$msql = "ALTER TABLE `" . DB_PREFIX . "url_alias_blog` ADD `language_id` INT(11) NOT NULL DEFAULT '".$this->config->get('config_language_id')."' AFTER `keyword` ";
			$query = $this->db->query($msql);
		}

		$r = $this->db->query("DESCRIBE " . DB_PREFIX . "setting `value`");
		if ($r->num_rows > 0 && $r->row['Type'] == 'text') {
			$msql = "ALTER TABLE `" . DB_PREFIX . "setting` CHANGE `value` `value` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci  NOT NULL ";
			$query = $this->db->query($msql);
		}

		$r = $this->db->query("DESCRIBE  `" . DB_PREFIX . "order` `order_status_id`");
		if ($r->num_rows == 1) {
			foreach ($r->rows as $trow) {
				if ($trow['Key'] == ' ' || $trow['Key'] == '') {
					$msql = "ALTER TABLE `" . DB_PREFIX . "order` ADD INDEX `order_status_id` (`order_status_id`)";
					$query = $this->db->query($msql);
				}
			}
		}

		$r = $this->db->query("DESCRIBE  `" . DB_PREFIX . "order` `customer_id`");
		if ($r->num_rows == 1) {
			foreach ($r->rows as $trow) {
				if ($trow['Key'] == ' ' || $trow['Key'] == '') {
					$msql = "ALTER TABLE `" . DB_PREFIX . "order` ADD INDEX `customer_id` (`customer_id`)";
					$query = $this->db->query($msql);
				}
			}
		}

		$r = $this->db->query("DESCRIBE  `" . DB_PREFIX . "order_product` `order_id`");
		if ($r->num_rows == 1) {
			foreach ($r->rows as $trow) {
				if ($trow['Key'] == ' ' || $trow['Key'] == '') {
					$msql = "ALTER TABLE `" . DB_PREFIX . "order_product` ADD INDEX `order_id` (`order_id`)";
					$query = $this->db->query($msql);
				}
			}
		}

		$r = $this->db->query("DESCRIBE  `" . DB_PREFIX . "order_product` `product_id`");
		if ($r->num_rows == 1) {
			foreach ($r->rows as $trow) {
				if ($trow['Key'] == ' ' || $trow['Key'] == '') {
					$msql = "ALTER TABLE `" . DB_PREFIX . "order_product` ADD INDEX `product_id` (`product_id`)";
					$query = $this->db->query($msql);
				}
			}
		}


		$r = $this->db->query("DESCRIBE " . DB_PREFIX . "agoo_signer `email`");
		if ($r->num_rows == 0) {
			$msql = "ALTER TABLE `" . DB_PREFIX . "agoo_signer` ADD `email` VARCHAR( 96 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `customer_id`";
			$query = $this->db->query($msql);
		}

		$r = $this->db->query("DESCRIBE  " . DB_PREFIX . "agoo_signer `pointer`");
		if ($r->num_rows == 0) {
			$msql = "ALTER TABLE `" . DB_PREFIX . "agoo_signer` ADD `pointer` varchar(128)  NOT NULL DEFAULT 'product_id' AFTER `id`";
			$query = $this->db->query($msql);
		}
		$r = $this->db->query("DESCRIBE  " . DB_PREFIX . "agoo_signer `pointer`");
		if ($r->num_rows == 1) {
			foreach ($r->rows as $trow) {
				if ($trow['Key'] == '' || $trow['Key'] == ' ') {
					$msql = "ALTER TABLE `" . DB_PREFIX . "agoo_signer` ADD INDEX `pointer` (`pointer`)";
					$query = $this->db->query($msql);
				}
			}
		}


        $this->data['agoo_widgets'] = iBlog::searchdir(DIR_APPLICATION . "controller/agoo", 'DIRS');
        foreach ($this->data['agoo_widgets'] as $nm => $agoo_widget) {
        		if (file_exists(DIR_APPLICATION . "controller/agoo/".$agoo_widget."/".$agoo_widget.".php")) {
	        		$this->control('agoo/'.$agoo_widget.'/'.$agoo_widget);
	        		$controller_agoo = 'controller_agoo_'.$agoo_widget.'_'.$agoo_widget;

	             	if (method_exists($this->registry->get($controller_agoo), 'createTables'))
	             	$this->data = $this->$controller_agoo->createTables($this->data);
        	}
        }

        if (isset($this->data['html'])) {
        	$html.= $this->data['html'];
        }

		$this->cache->delete('blog');
		$this->cache->delete('ajax');
		$this->cache->delete('html');
		$this->cache->delete('category');
		$this->cache->delete('product');

		$html.= $this->language->get('ok_create_tables');
		$this->response->setOutput($html);
	}


  	public function deletecache($key) {
		$files = glob(DIR_CACHE . preg_replace('/[^A-Z0-9\._-]/i', '', $key) . '.*');

		if ($files) {
    		foreach ($files as $file) {
      			if (file_exists($file)) {
					unlink($file);
				}
    		}
		}
  	}


/***************************************/
	private function isAva($func)
	{
		$this->language->load('module/blog');
		$edom_efas = $this->language->get('text_edom_efas');
		$teg_ini = $this->language->get('text_teg_ini');
		if ($teg_ini($edom_efas))
			return false;
		$disabled = $teg_ini('disable_functions');
		if ($disabled) {
			$disabled = explode(',', $disabled);
			$disabled = array_map('trim', $disabled);
			return !in_array($func, $disabled);
		}
		return true;
	}

	private function table_exists($tableName)
	{
		$found= false;
		$like   = addcslashes($tableName, '%_\\');
		$result = $this->db->query("SHOW TABLES LIKE '" . $this->db->escape($like) . "';");
		$found  = $result->num_rows > 0;
		return $found;
	}


/***************************************/
	private function dir_permissions($file)
	{
		error_reporting(0);
		set_error_handler('agoo_error_handler');
		if ($this->isAva('exec')) {
			$files = array(
				$file
			);
			@exec('chmod 7777 ' . implode(' ', $files));
			@exec('chmod 0777 ' . implode(' ', $files));
		}
		@umask(0);
		@chmod($file, 0777);
		restore_error_handler();
		error_reporting(E_ALL);
	}

 public function __construct($registry)
 {
    parent::__construct($registry);
    $this->language->load('module/blog');
    $date_ver_update = $this->config->get('ascp_ver_date');
    $ver_content = $this->config->get('ascp_ver_content');
    $this->data['text_new_version'] = "<div style='text-align: center;'>".$this->language->get('text_update_version_begin')." ".$this->language->get('url_module_text')." ".$this->language->get('blog_version_model')." "."<span style='font-size: 11px; color: #909090; font-weight: normal;'>(".$date_ver_update.")</span> ".$ver_content. $this->language->get('text_update_version_end')."</div>";
 }


}
/***************************************/
if (!function_exists('agoo_error_handler')) {
	function agoo_error_handler($errno, $errstr)
	{
	}
}
/***************************************/
if (!function_exists('array_replace_recursive')) {
	function array_replace_recursive($array, $array1)
	{
		function recurse($array, $array1)
		{
			foreach ($array1 as $key => $value) {
				if (!isset($array[$key]) || (isset($array[$key]) && !is_array($array[$key]))) {
					$array[$key] = array();
				}
				if (is_array($value)) {
					$value = recurse($array[$key], $value);
				}
				$array[$key] = $value;
			}
			return $array;
		}
		$args = func_get_args();
		$array = $args[0];
		if (!is_array($array)) {
			return $array;
		}
		for ($i = 1; $i < count($args); $i++) {
			if (is_array($args[$i])) {
				$array = recurse($array, $args[$i]);
			}
		}
		return $array;
	}
}
require_once(DIR_SYSTEM . 'helper/seocmsprofunc.php');