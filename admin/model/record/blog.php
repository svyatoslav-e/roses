<?php
/* All rights reserved belong to the module, the module developers http://opencartadmin.com */
// http://opencartadmin.com © 2011-2016 All Rights Reserved
// Distribution, without the author's consent is prohibited
// Commercial license
class ModelRecordBlog extends Model
{
	public function getBlog($blog_id, $gaccess = true)
	{
		$cdata = array();
		if ($gaccess) {
			$ascp_customer_groups = $this->config->get('ascp_customer_groups');
			if (!empty($ascp_customer_groups)) {
				$customer_query_in = "(" . implode($this->config->get('ascp_customer_groups'), ',') . ")";
			} else {
				$customer_query_in = "(-999)";
			}
			$customer_query = " AND ba.customer_group_id IN " . $customer_query_in . " ";
			$status_query   = " AND c.status = '1' ";
		} else {
			$customer_query_in = $customer_query = '';
			$status_query      = '';
		}
		$hash_groups = md5($customer_query_in . $customer_query);
		$cache_name  = 'blog.getblog.' . (int) $this->config->get('config_language_id') . "." . (int) $this->config->get('config_store_id') . "." . $hash_groups . "." . (int) $gaccess;
		$cdata       = $this->cache->get($cache_name);
		if (!isset($cdata[$blog_id])) {
			$query           = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "blog c
			LEFT JOIN " . DB_PREFIX . "blog_description cd ON (c.blog_id = cd.blog_id)
			LEFT JOIN " . DB_PREFIX . "blog_to_store c2s ON (c.blog_id = c2s.blog_id)
			LEFT JOIN " . DB_PREFIX . "blog_access ba ON (c.blog_id = ba.blog_id)
			WHERE
			c.blog_id = '" . (int) $blog_id . "'
			AND
			cd.language_id = '" . (int) $this->config->get('config_language_id') . "'
			AND
			c2s.store_id = '" . (int) $this->config->get('config_store_id') . "'
			" . $status_query . "
			" . $customer_query . "
			");
			$cdata[$blog_id] = $query->row;
			$this->cache->set($cache_name, $cdata);
		}
		return $cdata[$blog_id];
	}
	public function getBlogies($parent_id = 0)
	{
		$blogs                = array();
		$ascp_customer_groups = $this->config->get('ascp_customer_groups');
		if (!empty($ascp_customer_groups)) {
			$customer_query_in = "(" . implode($this->config->get('ascp_customer_groups'), ',') . ")";
		} else {
			$customer_query_in = "(-999)";
		}
		$customer_query = " AND ba.customer_group_id IN " . $customer_query_in . " ";
		$sql            = "
		SELECT * FROM " . DB_PREFIX . "blog c
		LEFT JOIN " . DB_PREFIX . "blog_description cd ON (c.blog_id = cd.blog_id)
		LEFT JOIN " . DB_PREFIX . "blog_to_store c2s ON (c.blog_id = c2s.blog_id)
		LEFT JOIN " . DB_PREFIX . "blog_access ba ON (c.blog_id = ba.blog_id)
		WHERE
		c.parent_id = '" . (int) $parent_id . "'
		AND
		cd.language_id = '" . (int) $this->config->get('config_language_id') . "'
		AND
		c2s.store_id = '" . (int) $this->config->get('config_store_id') . "'
		AND
		c.status = '1'
		" . $customer_query . "
		ORDER BY c.sort_order, LCASE(cd.name)";
		$query          = $this->db->query($sql);
		foreach ($query->rows as $num => $blog) {
			$blogs[$blog['blog_id']] = $blog;
		}
		return $blogs;
	}
	public function getBlogs()
	{
		$blogs                = array();
		$ascp_customer_groups = $this->config->get('ascp_customer_groups');
		if (!empty($ascp_customer_groups)) {
			$customer_query_in = "(" . implode($this->config->get('ascp_customer_groups'), ',') . ")";
		} else {
			$customer_query_in = "(-999)";
		}
		$customer_query = " AND ba.customer_group_id IN " . $customer_query_in . " ";
		$sql            = "
		SELECT * FROM " . DB_PREFIX . "blog c
		LEFT JOIN " . DB_PREFIX . "blog_description cd ON (c.blog_id = cd.blog_id)
		LEFT JOIN " . DB_PREFIX . "blog_to_store c2s ON (c.blog_id = c2s.blog_id)
		LEFT JOIN " . DB_PREFIX . "blog_access ba ON (c.blog_id = ba.blog_id)

		WHERE
		cd.language_id = '" . (int) $this->config->get('config_language_id') . "'
		AND
		c2s.store_id = '" . (int) $this->config->get('config_store_id') . "'
		AND
		c.status = '1'
		" . $customer_query . "
		ORDER BY c.sort_order, LCASE(cd.name)";
		$query          = $this->db->query($sql);
		foreach ($query->rows as $num => $blog) {
			$blogs[$blog['blog_id']] = $blog;
		}
		return $blogs;
	}

	public function getBlogiesByParentId($blog_id)
	{
		$blog_data  = array();
		$blog_query = $this->db->query("SELECT blog_id FROM " . DB_PREFIX . "blog WHERE parent_id = '" . (int) $blog_id . "'");
		foreach ($blog_query->rows as $blog) {
			$blog_data[] = $blog['blog_id'];
			$children    = $this->getBlogiesByParentId($blog['blog_id']);
			if ($children) {
				$blog_data = array_merge($children, $blog_data);
			}
		}
		return $blog_data;
	}
	public function getBlogLayoutId($blog_id)
	{
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_to_layout WHERE blog_id = '" . (int) $blog_id . "' AND store_id = '" . (int) $this->config->get('config_store_id') . "'");
		if ($query->num_rows) {
			return $query->row['layout_id'];
		} else {
			return $this->config->get('config_layout_blog');
		}
	}
	public function getTotalBlogiesByBlogId($parent_id = 0)
	{
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "blog c
		LEFT JOIN " . DB_PREFIX . "blog_to_store c2s ON (c.blog_id = c2s.blog_id) WHERE c.parent_id = '" . (int) $parent_id . "' AND c2s.store_id = '" . (int) $this->config->get('config_store_id') . "' AND c.status = '1'");
		return $query->row['total'];
	}
	public function getCustomerOrder($customer_id = 0, $order_status_array, $product_id = -1)
	{
		if (!is_array($order_status_array)) {
			$order_status_array = array(
				$order_status_array
			);
		}
		$sql = "SELECT
		     	COUNT(o.customer_id) as counter
				FROM `" . DB_PREFIX . "order` o
				LEFT JOIN `" . DB_PREFIX . "order_product` op ON (o.order_id = op.order_id)
				WHERE
				o.customer_id = '" . (int) $customer_id . "'
				AND o.order_status_id IN (" . implode($order_status_array, ',') . ") ";
		if ($product_id > -1) {
			$sql_product = " AND op.product_id = '" . (int) $product_id . "'";
		} else {
			$sql_product = '';
		}
		$blog_query = $this->db->query($sql . $sql_product);
		return $blog_query->row['counter'];
	}
	public function getCategoriesByProduct($product_id)
	{
		$product_id = (int) $product_id;
		if ($product_id < 1)
			return false;
		if ($this->config->get('config_seo_url_type') == 'seo_pro') {
			$seo_pro_order = "ORDER BY main_category DESC";
		} else {
			$seo_pro_order = "";
		}
		$query = $this->db->query("SELECT category_id FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int) $product_id . "' " . $seo_pro_order . " ");
		return $query->rows;
	}
	public function getBlogiesByRecord($record_id)
	{
		$record_id = (int) $record_id;
		if ($record_id < 1)
			return false;
		$query = $this->db->query("SELECT blog_id FROM " . DB_PREFIX . "record_to_blog WHERE record_id = '" . $record_id . "' ");
		return $query->rows;
	}
	public function editSetting($group, $data, $store_id = 0)
	{
		$this->db->query("DELETE FROM " . DB_PREFIX . "setting WHERE store_id = '" . (int) $store_id . "' AND `group` = '" . $this->db->escape($group) . "'");
		foreach ($data as $key => $value) {
			if (!is_array($value)) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '" . (int) $store_id . "', `group` = '" . $this->db->escape($group) . "', `key` = '" . $this->db->escape($key) . "', `value` = '" . $this->db->escape($value) . "'");
			} else {
				$this->db->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '" . (int) $store_id . "', `group` = '" . $this->db->escape($group) . "', `key` = '" . $this->db->escape($key) . "', `value` = '" . $this->db->escape(serialize($value)) . "', serialized = '1'");
			}
		}
	}
}
