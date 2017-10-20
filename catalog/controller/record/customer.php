<?php
/* All rights reserved belong to the module, the module developers http://opencartadmin.com */
// http://opencartadmin.com © 2011-2016 All Rights Reserved
// Distribution, without the author's consent is prohibited
// Commercial license
class ControllerRecordCustomer extends Controller
{
	protected  $data;

	public function customer_groups($data, $gr = 'customer_groups')
	{
        if (SC_VERSION > 15) {
			$get_Customer_GroupId = 'getGroupId';
		} else {
			$get_Customer_GroupId = 'getCustomerGroupId';
		}

		$this->data = $data;
	    $customer_order = false;
		$this->data[$gr] = Array();

		if (is_object($this->customer) &&  $this->customer->isLogged()) {
			$this->data['customer_group_id'] =  $this->customer->$get_Customer_GroupId();
			$this->data['customer_id'] = $this->customer->getId();
			array_push($this->data[$gr], -1);
		} else {
			$this->data['customer_group_id'] = $this->config->get('config_customer_group_id');
			$this->data['customer_id'] = false;
		}


		array_push($this->data[$gr], $this->data['customer_group_id']);

		$this->load->model('record/blog');

	   	if (!isset($this->data['settings_general']['complete_status'])) {
	    	$this->data['settings_general']['complete_status'] = $this->config->get('config_complete_status_id');
	   	}

	   	if (is_object($this->customer) &&  $this->customer->isLogged()) {
	   		$customer_order = $this->model_record_blog->getCustomerOrder($this->data['customer_id'], $this->data['settings_general']['complete_status']);
	   	}

	   	if ($customer_order > 0) {
		   	array_push($this->data[$gr], -2);
	   	}

       	if (isset($this->request->get['product_id'])) {
       		if (is_object($this->customer) &&  $this->customer->isLogged()) {
       			$customer_order = $this->model_record_blog->getCustomerOrder($this->data['customer_id'], $this->data['settings_general']['complete_status'], $this->request->get['product_id']);
       		}

		   if ($customer_order > 0) {
			   	array_push($this->data[$gr], -3);
		   }
	   	}

	   	// $this->registry->set('getCustomerOrder', $this->data);
        // $this->config->set('ascp_customer_groups_hash', md5(serialize($this->data)));

	   	return $this->data;

	}

}
