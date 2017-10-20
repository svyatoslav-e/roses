<?php
/* All rights reserved belong to the module, the module developers http://opencartadmin.com */
// http://opencartadmin.com © 2011-2016 All Rights Reserved
// Distribution, without the author's consent is prohibited
// Commercial license
class agooModelDesignLayout extends Controller
{
	protected  $sheme;

   public function __call($name, array $params)
   {
       $object = 'ModelDesignLayout';
       $route='';
       if (!class_exists('ModelDesignLayout')) {
		$file  = DIR_APPLICATION . 'model/design/layout.php';
		if (file_exists($file)) {
			include_once($file);
		}
       }

	   $this->sheme =  new $object($this->registry);

        $data = call_user_func_array(array($this->sheme , $name), $params);

        if ($name!='getLayoutModules') {
        	$route = $this->getRouteByLayoutId($data);
        } else {
       /*
		if (SC_VERSION > 15) {
			$tracer = debug_backtrace();
			foreach ($tracer as $trace) {
				if (isset($trace['file'])) {
				$pos = strpos($trace['file'], 'lib/module.php');
					if ($pos === false) {
					} else {
					    return array();
					}
				}
			}
			unset($tracer);
		}

			if ($this->registry->get('themeglobal_module')) {
				return array();
			}
        */
            $blog_module = $this->config->get('blog_module');


            $layout_id = $params[0];
            $position  = $params[1];
            if (is_array($blog_module) && !empty($blog_module)) {
	            foreach ($blog_module as $num=>$val) {
	            	if ($position == $val['position']) {
	            	  if (!is_array($val['layout_id'])) {
	            	     if ($layout_id == $val['layout_id'] && $val['status']) {
	                       $val['code'] ='blog';
	                       $this->config->set('blog_status', true);
	                       $this->registry->set('blog_position', $val['position'] );
	            	   	   $data[] = $val;
	            	   }
	            	  }
	            	}
	            }
            }

        }

       if ($route=='record/blog' || $route=='record/record') {
       	// проверяем схему в настройках для категории или записи
       		$data = $this->getLayoutAgoo($route);


       }

     if (is_array($data)) usort($data, 'commd');


        return $data;
   }


	public function getLayoutAgoo($route)
	{
  		if ($this->config->get("loader_old") && !$this->config->get("blog_work")) {
	        $this->registry->set('load', $this->config->get("loader_old"));
	        $this->config->set("loader_old", false );
        }
        $sql= "SELECT * FROM " . DB_PREFIX . "layout_route WHERE '" . $this->db->escape($route) . "' LIKE CONCAT(route, '%') AND `route`<>'' AND store_id = '" . (int) $this->config->get('config_store_id') . "' ORDER BY route DESC LIMIT 1";

		$query = $this->db->query($sql);
		$this->load->model('design/bloglayout');
		if ($route == 'record/blog' && isset($this->request->get['blog_id'])) {
			$path      = explode('_', (string) $this->request->get['blog_id']);
			$layout_id = $this->model_design_bloglayout->getBlogLayoutId(end($path));
			if ($layout_id)
				return $layout_id;
		} //$route == 'record/blog' && isset($this->request->get['blog_id'])
		if ($route == 'record/record' && isset($this->request->get['record_id'])) {
			$layout_id = $this->model_design_bloglayout->getRecordLayoutId($this->request->get['record_id']);
			if ($layout_id)
				return $layout_id;
		} //$route == 'record/record' && isset($this->request->get['record_id'])
		if ($query->num_rows) {
			return $query->row['layout_id'];
		} //$query->num_rows
		else {
			return 0;
		}
	}

	public function getRouteByLayoutId($layout_id)
	{
   		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "layout_route WHERE layout_id='" . (int)$layout_id . "' AND store_id = '" . (int) $this->config->get('config_store_id') . "' ORDER BY route ASC LIMIT 1");
        if ($query->num_rows) {
			return $query->row['route'];
		} //$query->num_rows
		else {
			return false;
		}

	}



}
require_once(DIR_SYSTEM . 'helper/seocmsprofunc.php');
?>