<?php
/* All rights reserved belong to the module, the module developers http://opencartadmin.com */
// http://opencartadmin.com © 2011-2016 All Rights Reserved
// Distribution, without the author's consent is prohibited
// Commercial license
class ModelRecordAvatar extends Model
{
	public function getAvatar($customer_id)
	{
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int)$customer_id . "'");
		if (isset($query->row['avatar']))
		return $query->row['avatar'];
		else
		return;
	}

    public function editAvatar($avatar)
	{
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET avatar = '" . $this->db->escape($avatar) . "' WHERE customer_id = '" . (int)$this->customer->getId() . "'");
		$this->cache->delete('blog.module.view');
		$this->cache->delete('product');
		$this->cache->delete('record');
		$this->cache->delete('blog');
	}

    public function removeAvatar()
	{
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET avatar = NULL WHERE customer_id = '" . (int)$this->customer->getId() . "'");
		$this->cache->delete('blog');
	}

}
