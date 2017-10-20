<?php
/* All rights reserved belong to the module, the module developers http://opencartadmin.com */
// http://opencartadmin.com © 2011-2016 All Rights Reserved
// Distribution, without the author's consent is prohibited
// Commercial license
class ModelRecordPath extends Model
{
	public function pathbyrecord($record_id)
	{
		$cache_file = 'blog.record.blogs.' . (int) $this->config->get('config_store_id') . '.' . (int) $this->config->get('config_language_id');
		$record_id  = (int) $record_id;
		if ($record_id < 1)
			return false;
		static $path = null;
		if (!is_array($path)) {
			$path = $this->cache->get($cache_file);
			if (!is_array($path))
				$path = array();
		}
		if (!isset($path[$record_id])) {
			$sql              = "SELECT r2b.blog_id,
			IF(r.blog_main=r2b.blog_id, 1, 0) as blog_main

			FROM " . DB_PREFIX . "record_to_blog r2b
			LEFT JOIN " . DB_PREFIX . "record r  ON (r.record_id = r2b.record_id)
			LEFT JOIN " . DB_PREFIX . "record_description pd ON (r.record_id = pd.record_id)
			WHERE
			pd.language_id = '" . (int) $this->config->get('config_language_id') . "' AND
			r2b.record_id = '" . (int) $record_id . "' ORDER BY blog_main DESC LIMIT 1";
			$query            = $this->db->query($sql);
			$path[$record_id] = $this->pathbyblog($query->num_rows ? (int) $query->row['blog_id'] : 0);
			$this->cache->set($cache_file, $path);
		}
		return $path[$record_id];
	}

	public function pathbyblog($blog_id)
	{
		$cache_file = 'blog.blogs.' . (int) $this->config->get('config_store_id') . '.' . (int) $this->config->get('config_language_id');
		if (strpos($blog_id, '_') !== false) {
			$abid    = explode('_', $blog_id);
			$blog_id = $abid[count($abid) - 1];
		}
		$blog_id = (int) $blog_id;
		if ($blog_id < 1)
			return false;
		static $path = null;
		if (!is_array($path)) {
			$path = $this->cache->get($cache_file);
			if (!is_array($path))
				$path = array();
		}
		if (!isset($path[$blog_id])) {
			$max_level = 10;
			$sql       = "SELECT td.name as name, CONCAT_WS('_'";
			for ($i = $max_level - 1; $i >= 0; --$i) {
				$sql .= ",t$i.blog_id";
			}
			$sql .= ") AS path FROM " . DB_PREFIX . "blog t0";
			for ($i = 1; $i < $max_level; ++$i) {
				$sql .= " LEFT JOIN " . DB_PREFIX . "blog t$i ON (t$i.blog_id = t" . ($i - 1) . ".parent_id)";
			}
			$sql .= "LEFT JOIN " . DB_PREFIX . "blog_description td ON ( td.blog_id = t0.blog_id )";
			$sql .= " WHERE
			td.language_id = '" . (int) $this->config->get('config_language_id') . "' AND
			t0.blog_id = '" . (int) $blog_id . "'";
			$query                  = $this->db->query($sql);
			$path[$blog_id]['path'] = $query->num_rows ? $query->row['path'] : false;
			$path[$blog_id]['name'] = $query->num_rows ? $query->row['name'] : false;
			$this->cache->set($cache_file, $path);
		}
		return $path[$blog_id];
	}
	public function pathbycategory($category_id)
	{
		$cache_file  = 'blog.category.path.' . (int) $this->config->get('config_store_id') . '.' . (int) $this->config->get('config_language_id');
		$category_id = (int) $category_id;
		if ($category_id < 1)
			return false;
		static $path = null;
		if (!is_array($path)) {
			$path = $this->cache->get($cache_file);
			if (!is_array($path))
				$path = array();
		}
		if (!isset($path[$category_id])) {
			$max_level = 10;
			$sql       = "SELECT td.name as name, CONCAT_WS('_'";
			for ($i = $max_level - 1; $i >= 0; --$i) {
				$sql .= ",t$i.category_id";
			}
			$sql .= ") AS path FROM " . DB_PREFIX . "category t0";
			for ($i = 1; $i < $max_level; ++$i) {
				$sql .= " LEFT JOIN " . DB_PREFIX . "category t$i ON (t$i.category_id = t" . ($i - 1) . ".parent_id)";
			}
			$sql .= "LEFT JOIN " . DB_PREFIX . "category_description td ON ( td.category_id = t0.category_id )";
			$sql .= " WHERE
			td.language_id = '" . (int) $this->config->get('config_language_id') . "' AND
			t0.category_id = '" . (int) $category_id . "'";
			$query                      = $this->db->query($sql);
			$path[$category_id]['path'] = $query->num_rows ? $query->row['path'] : false;
			$path[$category_id]['name'] = $query->num_rows ? $query->row['name'] : false;
			$this->cache->set($cache_file, $path);
		}
		return $path[$category_id];
	}


	public function pathbyproduct($mark_id = 0)
	{
		$mark_id = (int) $mark_id;
		if ($mark_id < 1)
			return false;

		static $path = null;
		if (!is_array($path)) {
			$path = $this->cache->get('blog.product.categories');
			if (!is_array($path))
				$path = array();
		}
		if (!isset($path[$mark_id])) {
			$sql            = "SELECT category_id FROM " . DB_PREFIX . "product_to_category
			WHERE product_id = '" . (int) $mark_id . "' ORDER BY category_id DESC LIMIT 1";
			$query          = $this->db->query($sql);
			$path[$mark_id] = $this->pathbycategory($query->num_rows ? (int) $query->row['category_id'] : 0);
			$this->cache->set('blog.product.categories', $path);
		}
		return $path[$mark_id];
	}



}
