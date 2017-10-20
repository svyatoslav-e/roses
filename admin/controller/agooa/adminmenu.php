<?php
/* All rights reserved belong to the module, the module developers http://opencartadmin.com */
// http://opencartadmin.com © 2011-2016 All Rights Reserved
// Distribution, without the author's consent is prohibited
// Commercial license
class ControllerAgooaAdminmenu extends Controller
{
	private $error = array();
	protected $data;
	public function index()
	{
	 	$this->config->set("blog_work", true);
        $this->data['ascp_settings'] = $this->config->get('ascp_settings');

        $html = '';

		$this->load->language('seocms/agooa/adminmenu');

  		if (isset($this->request->get['route'])) {
			$route = $this->request->get['route'];
		}
       $this->data['agoo_menu_block']   = 'agoo_first_menu_block';

       $this->data['agoo_menu_options']       = $this->language->get('agoo_menu_options');
       $this->data['agoo_menu_url_options']   = $this->url->link('module/blog', 'token=' . $this->session->data['token'], 'SSL');
       if ($route == 'module/blog') {
       	$this->data['agoo_menu_active_options']   = ' markactive';
       	$this->data['agoo_menu_block']   = 'agoo_first_menu_block';
       } else {
       	$this->data['agoo_menu_active_options']   = '';
       }

       $this->data['agoo_menu_layouts']       = $this->language->get('agoo_menu_layouts');
       $this->data['agoo_menu_url_layouts']   = $this->url->link('module/blog/schemes', 'token=' . $this->session->data['token'], 'SSL');
       if ($route == 'module/blog/schemes') {
       	$this->data['agoo_menu_active_layouts']   = ' markactive';
       	$this->data['agoo_menu_block']   = 'agoo_first_menu_block';
       } else {
       	$this->data['agoo_menu_active_layouts']   = '';
       }

       $this->data['agoo_menu_widgets']       = $this->language->get('agoo_menu_widgets');
       $this->data['agoo_menu_url_widgets']   = $this->url->link('module/blog/widgets', 'token=' . $this->session->data['token'], 'SSL');
       if ($route == 'module/blog/widgets') {
       	$this->data['agoo_menu_active_widgets']   = ' markactive';
       	$this->data['agoo_menu_block']   = 'agoo_first_menu_block';
       } else {
       	$this->data['agoo_menu_active_widgets']   = '';
       }

       $this->data['agoo_menu_modules']       = $this->language->get('agoo_menu_modules');
       $this->data['agoo_menu_url_modules']   = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

       $this->data['agoo_menu_categories']    = $this->language->get('agoo_menu_categories');
       $this->data['agoo_menu_url_categories']= $this->url->link('catalog/blog', 'token=' . $this->session->data['token'], 'SSL');
       if (strpos($route, 'catalog/blog') === false) {
       	$this->data['agoo_menu_active_categories']   = '';
       } else {
       	$this->data['agoo_menu_active_categories']   = ' markactive';
       	$this->data['agoo_menu_block']   = 'agoo_second_menu_block';
       }

       $this->data['agoo_menu_records']       = $this->language->get('agoo_menu_records');
       $this->data['agoo_menu_url_records']   = $this->url->link('catalog/record', 'token=' . $this->session->data['token'], 'SSL');
       if (strpos($route, 'catalog/record') === false) {
       	$this->data['agoo_menu_active_records']   = '';
       } else {
       	$this->data['agoo_menu_active_records']   = ' markactive';
       	$this->data['agoo_menu_block']   = 'agoo_second_menu_block';
       }

       $this->data['agoo_menu_comments']      = $this->language->get('agoo_menu_comments');
       $this->data['agoo_menu_url_comments']  = $this->url->link('catalog/comment', 'action=comment&token=' . $this->session->data['token'], 'SSL');
       if (strpos($route, 'catalog/comment') === false) {
       	$this->data['agoo_menu_active_comments']   = '';
       } else {
			if (isset($this->request->get['action']) && $this->request->get['action']=='comment') {
	       		$this->data['agoo_menu_active_comments']   = ' markactive';
	       		$this->data['agoo_menu_block']   = 'agoo_second_menu_block';
	       	} else {
	       	 	$this->data['agoo_menu_active_comments']   = '';
	       	}
       }

       $this->data['agoo_menu_reviews']       = $this->language->get('agoo_menu_reviews');
       $this->data['agoo_menu_url_reviews']   = $this->url->link('catalog/comment', 'action=review&token=' . $this->session->data['token'], 'SSL');
       if (strpos($route, 'catalog/comment') === false) {
       	$this->data['agoo_menu_active_reviews']   = '';
       } else {
			if (isset($this->request->get['action']) && $this->request->get['action']=='review') {
	       		$this->data['agoo_menu_active_reviews']   = ' markactive';
	       		$this->data['agoo_menu_block']   = 'agoo_second_menu_block';
	       	} else {
	       	 	$this->data['agoo_menu_active_reviews']   = '';
	       	}
       }


       $this->data['agoo_menu_adapter']       = $this->language->get('agoo_menu_adapter');
       $this->data['agoo_menu_url_adapter']   = $this->url->link('catalog/adapter', 'token=' . $this->session->data['token'], 'SSL');
       if (strpos($route, 'catalog/adapter') === false) {
       	$this->data['agoo_menu_active_adapter']   = '';
       } else {
       	$this->data['agoo_menu_active_adapter']   = ' markactive';
       	$this->data['agoo_menu_block']   = 'agoo_third_menu_block';
       }

       $this->data['agoo_menu_sitemap']       = $this->language->get('agoo_menu_sitemap');
       $this->data['agoo_menu_url_sitemap']   = $this->url->link('feed/google_sitemap_blog', 'token=' . $this->session->data['token'], 'SSL');
       if (strpos($route, 'feed/google_sitemap_blog') === false) {
       	$this->data['agoo_menu_active_sitemap']   = '';
       } else {
       	$this->data['agoo_menu_active_sitemap']   = ' markactive';
       	$this->data['agoo_menu_block']   = 'agoo_third_menu_block';
       }



       $this->data['agoo_menu_fields']       = $this->language->get('agoo_menu_fields');
       $this->data['agoo_menu_url_fields']   = $this->url->link('catalog/fields', 'token=' . $this->session->data['token'], 'SSL');
       if (strpos($route, 'catalog/fields') === false) {
       	$this->data['agoo_menu_active_fields']   = '';
       } else {
       	$this->data['agoo_menu_active_fields']   = ' markactive';
       	$this->data['agoo_menu_block']   = 'agoo_third_menu_block';
       }

		$this->template          = 'agooa/adminmenu.tpl';
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
