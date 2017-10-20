<?php
/* All rights reserved belong to the module, the module developers http://opencartadmin.com */
// http://opencartadmin.com © 2011-2016 All Rights Reserved
// Distribution, without the author's consent is prohibited
// Commercial license
class ControllerRecordAddrewrite extends Controller
{
	protected $data;
	private  $ascp_settings;
	public function __construct($registry)
	{
		parent::__construct($registry);
		if (version_compare(phpversion(), '5.3.0', '<') == true) {
			exit('PHP5.3+ Required');
		}

        $this->ascp_settings = $this->config->get('ascp_settings');

        if (isset( $this->ascp_settings['latest_widget_status']) && $this->ascp_settings['latest_widget_status']) {
			if (!class_exists('ControllerCommonSeoBlog') &&
				(class_exists('ControllerCommonSeoUrl') ||
				 class_exists('ControllerCommonSeoPro') ||
				 class_exists('ControllerStartupSeoUrl') ||
				 class_exists('ControllerStartupSeoPro'))
				 && !$this->registry->get('admin_work')
				 ) {

					if (SC_VERSION < 20) {
						$hook = 'hook';
					} else {
	                   	$hook = 'rewrite';
					}

					if ($this->registry->get('url_old')) {
						$url = $this->registry->get('url_old');
						$class = get_class($url);
					} else {
						$url = $this->url;
						$class = get_class($url);
					}

					$reflection = new ReflectionClass($class);
					$priv_attr  = $reflection->getProperties(ReflectionProperty::IS_PRIVATE);

	                if ($reflection->hasProperty($hook)) {
						$reflectionProperty = $reflection->getProperty($hook);
						$reflectionProperty->setAccessible(true);
						$data_private = $reflectionProperty->getValue($url);

	                    if (is_array($data_private) && count($data_private) > 0) {
							$this->addrouter();
	                    }
	                    unset($data_private);
	                    unset($reflectionProperty);
					} else {
	                   $this->addrouter();
					}
	                unset($url);
	                unset($reflection);
			}
		}
		unset($this->ascp_settings);
	}

	public function addrouter() {
		require_once(DIR_APPLICATION . 'controller/common/seoblog.php');
		$seoBlog = new ControllerCommonSeoBlog($this->registry);
		if ($this->config->get('config_seo_url')) {
			$this->url->addRewrite($seoBlog);
		}

		if (!isset($this->ascp_settings['safe_loading']) || !$this->ascp_settings['safe_loading']) {
        	$seoBlog->router();
		}
	}
}
