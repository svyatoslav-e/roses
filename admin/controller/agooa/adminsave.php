<?php
/* All rights reserved belong to the module, the module developers http://opencartadmin.com */
// http://opencartadmin.com © 2011-2016 All Rights Reserved
// Distribution, without the author's consent is prohibited
// Commercial license
class ControllerAgooaAdminSave extends Controller
{
	private $error = array();
	protected $data;
	public function index()
	{
		 $this->config->set("blog_work", true);


        $html = '';

		$this->load->language('module/blog');

  		if (isset($this->request->get['route'])) {
			$route = $this->request->get['route'];
		}


		 $this->data['settings_install'] = $this->model_setting_setting->getSetting('ascp_install');

        if (isset($this->data['settings_install']['ascp_install']) && $this->data['settings_install']['ascp_install'] &&
        	isset($this->data['settings_install']['ascp_install_1']) && $this->data['settings_install']['ascp_install_1'] &&
        	isset($this->data['settings_install']['ascp_install_2']) && $this->data['settings_install']['ascp_install_2'] &&
        	isset($this->data['settings_install']['ascp_install_3']) && $this->data['settings_install']['ascp_install_3'] &&
        	isset($this->data['settings_install']['ascp_install_4']) && $this->data['settings_install']['ascp_install_4']) {

	         $this->model_setting_setting->deleteSetting('ascp_install');
	         $this->data['settings_install'] = array();

        	}



		$this->data['modules'] = array();
		if ($route == 'module/blog/schemes') {

			if (isset($this->request->post['blog_module'])) {
				$this->data['modules'] = $this->request->post['blog_module'];
			} elseif ($this->config->get('blog_module')) {
				$this->data['modules'] = $this->config->get('blog_module');
			}
		} else {
			$this->data['modules'] = array();
		}

		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		$this->template          = 'agooa/adminsave.tpl';
		$this->children          = array();

		$this->data['language']  = $this->language;

		if (SC_VERSION < 20) {
			$html                      = $this->render();
		} else {
			$this->data['header']      = '';
			$this->data['menu']        = '';
			$this->data['footer']      = '';
			$this->data['column_left'] = '';
			$html                      = $this->load->view($this->template, $this->data);
		}
		return $html;
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
}
require_once(DIR_SYSTEM . 'helper/seocmsprofunc.php');