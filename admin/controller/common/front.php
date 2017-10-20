<?php
/* All rights reserved belong to the module, the module developers http://opencartadmin.com */
// http://opencartadmin.com © 2011-2016 All Rights Reserved
// Distribution, without the author's consent is prohibited
// Commercial license
class ControllerCommonFront extends Controller
{
	public function install()
	{
		$sc_ver = VERSION;
		if (!defined('SC_VERSION'))
			define('SC_VERSION', (int) substr(str_replace('.', '', $sc_ver), 0, 2));
		if ($this->config->get('ascp_settings') != '') {
			$settings_general = $this->config->get('ascp_settings');
		} else {
			$settings_general = Array();
		}
		if (isset($settings_general['langmark_widget_status']) && $settings_general['langmark_widget_status'] && !$this->registry->get('admin_work')) {
			if (!class_exists('agooMultilang')) {
				loadlibrary('agoo/multilang');
			}
			if (!class_exists('agooUrl')) {
				loadlibrary('agoo/url');
			}
			$Url_old = $this->registry->get('url');
			$this->registry->set('url_old', $Url_old);
			$agooUrl = new agooUrl($this->registry);
			$this->registry->set('url', $agooUrl);
		}

		if (!class_exists('ModelToolImage')) {
			$this->load->model('tool/image');
		}
		if (!class_exists('ModelDesignLayout')) {
			$this->load->model('design/layout');
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

		if ($this->user->isLogged() || $this->registry->get('admin_work')) {
			$is_admin = true;
		} else {
			$is_admin = false;
		}
		if ($this->config->get('config_theme') == 'theme_default') {
			$theme_directory = $this->config->get('theme_default_directory');
		} else {
			$theme_directory = $this->config->get('config_theme');
		}
		$this->registry->set('theme_directory', $theme_directory);
		if (!$this->config->get('config_image_thumb_height')) {
			$this->config->set('config_image_thumb_height', '200');
		}
		if (!$this->config->get('config_image_thumb_width')) {
			$this->config->set('config_image_thumb_width', '100');
		}



		if (!$this->config->get('config_maintenance') || $is_admin) {
			loadlibrary('agoo/response');
			$loader_old = $this->registry->get('load');
			$this->registry->set('load_old', $loader_old);
			loadlibrary('agoo/loader');
			$agooloader = new agooLoader($this->registry);
			$this->registry->set('load', $agooloader);

			loadlibrary('agoo/document');
			$Document = $this->registry->get('document');
			$this->registry->set('document_old', $Document);
			$agooDocument = new agooDocument($this->registry);
			$this->registry->set('document', $agooDocument);

            if (SC_VERSION > 21) {
				loadlibrary('agoo/language');
				$Language = $this->registry->get('language');
				$this->registry->set('language_old', $Language);
				$agooLanguage = new agooLanguage($this->registry);
				$this->registry->set('language', $agooLanguage);
			}

			loadlibrary('agoo/cache');
			$Cache = $this->registry->get('cache');
			$this->registry->set('cache_old', $Cache);
			$agooCache = new agooCache($this->registry);
			$this->registry->set('cache', $agooCache);
			$this->registry->set('config_ascp_settings', $this->config->get('ascp_settings'));
			if (!$this->registry->get('loader_loading')) {
				loadlibrary('agoo/config');
				$Config = $this->registry->get('config');
				$this->registry->set('config_old', $Config);
				$agooConfig = new agooConfig($this->registry);
				$this->registry->set('config', $agooConfig);
				loadlibrary('agoo/response');
				$Response = $this->registry->get('response');
				$this->registry->set('response_old', $Response);
				$agooResponse = new agooResponse($this->registry);
				$this->registry->set('response', $agooResponse);
			}

			$this->registry->set('loader_loading', true);
		} else {
			if (SC_VERSION > 15) {
				return $this->load->controller('common/maintenance');
			}
		}
	}
}