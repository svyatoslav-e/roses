<?php
/* All rights reserved belong to the module, the module developers http://opencartadmin.com */
// http://opencartadmin.com © 2011-2016 All Rights Reserved
// Distribution, without the author's consent is prohibited
// Commercial license
if (!class_exists('ModelCatalogRecord')) {
class ModelCatalogRecord extends Model
{
	public function addRecord($data)
	{
		if (isset($data['sort_order']) && $data['sort_order'] != '') {
			$sort_order = (int) $data['sort_order'];
		} else {
			if (isset($data['record_blog'])) {
				foreach ($data['record_blog'] as $blog_id) {
					$sql        = "SELECT MAX(sort_order) as maxis
			     FROM " . DB_PREFIX . "record re
			     INNER  JOIN " . DB_PREFIX . "record_to_blog r_t_b ON r_t_b.record_id=re.record_id WHERE r_t_b.blog_id='" . (int) $blog_id . "'
			     ";
					$query      = $this->db->query($sql);
					$sort_order = (int) $query->row['maxis'] + 1;
				}
			} else {
				$sort_order = 1;
			}
		}
		if (isset($data['date_end']) && $data['date_end'] != '') {
			$date_end = "date_end = '" . $this->db->escape($data['date_end']) . "',";
		} else {
			$date_end = "date_end = '2033-11-11 00:00:00',";
		}

		if (!isset($data['viewed'])) {
			$data['viewed'] = 0;
		}

		if (!isset($data['blog_main'])) {
			$data['blog_main'] = '';
		}

		if (!isset($data['comment'])) {
			$data['comment'] = array();
		}


		if (!isset($data['customer_id'])) {
			$data['customer_id'] = 0;
		}

		if (!isset($data['author'])) {
			$data['author'] = '';
		}
		if (!isset($data['author'])) {
			$data['author'] = '';
		}

		if (!isset($sort_order)) {
			$sort_order = '100000';
		}

		if (isset($data['index_page']) && is_array($data['index_page'])) {
   			$index_page = implode($data['index_page'],',');
		} else {
			$index_page = '';
		}


		$sql = "INSERT INTO " . DB_PREFIX . "record SET
		date_available = '" . $this->db->escape($data['date_available']) . "'," . $date_end . "
        blog_main ='" . $data['blog_main'] . "',
		comment = '" . serialize($data['comment']) . "',
		status = '" . (int) $data['status'] . "',
		index_page = '" . $this->db->escape($index_page) . "',
		customer_id = '" . (int)$data['customer_id'] . "',
		author = '" . $this->db->escape($data['author']) . "',
		viewed = '" . (int)$data['viewed'] . "',
		sort_order = '" . $sort_order . "', date_added = NOW()";
		$this->db->query($sql);
		$record_id = $this->db->getLastId();

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "record SET image = '" . $this->db->escape($data['image']) . "' WHERE record_id = '" . (int) $record_id . "'");
		}
		foreach ($data['record_description'] as $language_id => $value) {

         if (isset($data['record_tags_product'][$language_id])  && $data['record_tags_product'][$language_id]!='' ) {
         	$sql_r_t_p = "tag_product = '".$data['record_tags_product'][$language_id]."',
         	tag_search = '".$data['record_tags_search'][$language_id]."',  ";
         } else {
         	$sql_r_t_p = "";
         }

		if (!isset($value['name'])) {
			$value['name'] = '';
		}

		if (!isset($value['meta_title'])) {
			$value['meta_title'] = '';
		}

		if (!isset($value['meta_h1'])) {
			$value['meta_h1'] = '';
		}

		if (!isset($value['meta_keyword'])) {
			$value['meta_keyword'] = '';
		}

		if (!isset($value['meta_description'])) {
			$value['meta_description'] = '';
		}

		if (!isset($value['sdescription'])) {
			$value['sdescription'] = '';
		}

		if (!isset($value['description'])) {
			$value['description'] = '';
		}

		 $sql_rd = "INSERT INTO " . DB_PREFIX . "record_description SET record_id = '" . (int) $record_id . "', language_id = '" . (int) $language_id . "',
			name = '" . $this->db->escape($value['name']) . "',
			meta_title = '" . $this->db->escape($value['meta_title']) . "',
			meta_h1 = '" . $this->db->escape($value['meta_h1']) . "',
			meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "',
			meta_description = '" . $this->db->escape($value['meta_description']) . "',
			sdescription = '" . $this->db->escape($value['sdescription']) . "'" . ",
			 ".$sql_r_t_p."
			description = '" . $this->db->escape($value['description']) . "'" ;

			$this->db->query($sql_rd);
		}
		if (isset($data['record_store'])) {
			foreach ($data['record_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "record_to_store SET record_id = '" . (int) $record_id . "', store_id = '" . (int) $store_id . "'");
			}
		}
		if (isset($data['record_attribute'])) {
			foreach ($data['record_attribute'] as $record_attribute) {
				if ($record_attribute['attribute_id']) {
					$this->db->query("DELETE FROM " . DB_PREFIX . "record_attribute WHERE record_id = '" . (int) $record_id . "' AND attribute_id = '" . (int) $record_attribute['attribute_id'] . "'");
					foreach ($record_attribute['record_attribute_description'] as $language_id => $record_attribute_description) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "record_attribute SET record_id = '" . (int) $record_id . "', attribute_id = '" . (int) $record_attribute['attribute_id'] . "', language_id = '" . (int) $language_id . "', text = '" . $this->db->escape($record_attribute_description['text']) . "'");
					}
				}
			}
		}
		if (isset($data['record_image'])) {
			foreach ($data['record_image'] as $record_image) {
				if (!isset($record_image) || !is_array($record_image)) {
					$record_image = array();
				}
				if (!isset($record_image['options'])) {
					$record_image['options'] = array();
				}
				if (!isset($record_image['sort_order'])) {
					$record_image['sort_order'] = 0;
				}
				if (!isset($record_image['image'])) {
					$record_image['image'] = '';
				}
				$this->db->query("INSERT INTO " . DB_PREFIX . "record_image SET record_id = '" . (int) $record_id . "',
				options ='" . base64_encode(serialize($record_image['options'])) . "',
				image = '" . $this->db->escape($record_image['image']) . "', sort_order = '" . (int) $record_image['sort_order'] . "'");
			}
		}
		if (isset($data['record_download'])) {
			foreach ($data['record_download'] as $download_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "record_to_download SET record_id = '" . (int) $record_id . "', download_id = '" . (int) $download_id . "'");
			}
		}
		if (isset($data['record_blog'])) {
			foreach ($data['record_blog'] as $blog_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "record_to_blog SET record_id = '" . (int) $record_id . "', blog_id = '" . (int) $blog_id . "'");
			}
		}
		if (isset($data['record_related'])) {
			foreach ($data['record_related'] as $related_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "record_related WHERE pointer_id = '" . (int) $related_id . "'  AND related_id = '" . (int) $record_id . "' AND pointer='record_id'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "record_related WHERE pointer_id = '" . (int) $record_id . "'  AND related_id = '" . (int) $related_id . "' AND pointer='record_id'");
			}
		}
		if (isset($data['record_related'])) {
			foreach ($data['record_related'] as $related_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "record_related SET pointer_id = '" . (int) $record_id . "', related_id = '" . (int) $related_id . "' , pointer='record_id'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "record_related SET pointer_id = '" . (int) $related_id . "', related_id = '" . (int) $record_id . "' , pointer='record_id'");
			}
		}
		if (isset($data['product_related'])) {
			foreach ($data['product_related'] as $product_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "record_related WHERE pointer_id = '" . (int) $product_id . "' AND related_id = '" . (int) $record_id . "' AND pointer='product_id'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "record_related WHERE pointer_id = '" . (int) $record_id . "' AND related_id = '" . (int) $product_id . "' AND pointer='product_id'");
			}
		}
		if (isset($data['product_related'])) {
			foreach ($data['product_related'] as $product_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "record_related SET pointer_id = '" . (int) $record_id . "', related_id = '" . (int) $product_id . "' , pointer='product_id'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "record_related SET pointer_id = '" . (int) $product_id . "', related_id = '" . (int) $record_id . "' , pointer='product_id'");
			}
		}
		if (isset($data['blog_related'])) {
			foreach ($data['blog_related'] as $blog_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "record_related WHERE pointer_id = '" . (int) $record_id . "' AND related_id = '" . (int) $blog_id . "' AND pointer='blog_id'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "record_related WHERE pointer_id = '" . (int) $blog_id . "' AND related_id = '" . (int) $record_id . "' AND pointer='blog_id'");
			}
		}
		if (isset($data['blog_related'])) {
			foreach ($data['blog_related'] as $blog_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "record_related SET pointer_id = '" . (int) $record_id . "', related_id = '" . (int) $blog_id . "' , pointer='blog_id'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "record_related SET pointer_id = '" . (int) $blog_id . "', related_id = '" . (int) $record_id . "' , pointer='blog_id'");
			}
		}
		if (isset($data['category_related'])) {
			foreach ($data['category_related'] as $category_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "record_related WHERE pointer_id = '" . (int) $record_id . "' AND related_id = '" . (int) $category_id . "'  AND pointer='category_id'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "record_related WHERE pointer_id = '" . (int) $category_id . "' AND related_id = '" . (int) $record_id . "'  AND pointer='category_id'");
			}
		}
		if (isset($data['category_related'])) {
			foreach ($data['category_related'] as $category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "record_related SET pointer_id = '" . (int) $record_id . "', related_id = '" . (int) $category_id . "' , pointer='category_id'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "record_related SET pointer_id = '" . (int) $category_id . "', related_id = '" . (int) $record_id . "' , pointer='category_id'");
			}
		}


		if (isset($data['manufacturer_related'])) {
			foreach ($data['manufacturer_related'] as $manufacturer_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "record_related WHERE pointer_id = '" . (int) $record_id . "' AND related_id = '" . (int) $manufacturer_id . "'  AND pointer='manufacturer_id'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "record_related WHERE pointer_id = '" . (int) $manufacturer_id . "' AND related_id = '" . (int) $record_id . "'  AND pointer='manufacturer_id'");
			}
		}
		if (isset($data['manufacturer_related'])) {
			foreach ($data['manufacturer_related'] as $manufacturer_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "record_related SET pointer_id = '" . (int) $record_id . "', related_id = '" . (int) $manufacturer_id . "' , pointer='manufacturer_id'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "record_related SET pointer_id = '" . (int) $manufacturer_id . "', related_id = '" . (int) $record_id . "' , pointer='manufacturer_id'");
			}
		}




		if (isset($data['record_layout'])) {
			foreach ($data['record_layout'] as $store_id => $layout) {
				if (isset($layout['layout_id']) && $layout['layout_id']) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "record_to_layout SET record_id = '" . (int) $record_id . "', store_id = '" . (int) $store_id . "', layout_id = '" . (int) $layout['layout_id'] . "'");
				}
			}
		}
		foreach ($data['record_tag'] as $language_id => $value) {
			if ($value) {
				$tags = explode(',', $value);
				foreach ($tags as $tag) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "record_tag SET record_id = '" . (int) $record_id . "', language_id = '" . (int) $language_id . "', tag = '" . $this->db->escape(trim($tag)) . "'");
				}
			}
		}
		if ($data['keyword']) {
			foreach ($data['keyword'] as $lang_id => $keyword) {
				if ($keyword != '') {
					$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias_blog SET query = 'record_id=" . (int) $record_id . "', keyword = '" . $this->db->escape($keyword) . "' , language_id = '" . (int) $lang_id . "'");
				}
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "record_access WHERE record_id = '" . (int) $record_id . "'");
		if (isset($data['customer_groups_record'])) {
			foreach ($data['customer_groups_record'] as $customer_grops_record_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "record_access SET record_id = '" . (int) $record_id . "', customer_group_id = '" . (int) $customer_grops_record_id . "'");
			}
		}

		$this->cache->delete('blog');

		return  $record_id;
	}

	public function editRecord($record_id, $data)
	{
		if (isset($data['date_end']) && $data['date_end'] != '') {
			$date_end = "date_end = '" . $this->db->escape($data['date_end']) . "',";
		} else {
			$date_end = '';
		}
		if (!isset($data['blog_main'])) {
			$data['blog_main'] = '';
		}

		if (isset($data['index_page']) && is_array($data['index_page'])) {
   			$index_page = implode($data['index_page'],',');
		} else {
			$index_page = '';
		}

		$sql = "UPDATE " . DB_PREFIX . "record SET
		date_available = '" . $this->db->escape($data['date_available']) . "'," . $date_end . "
        blog_main ='" . $data['blog_main'] . "',
		comment  = '" . serialize($data['comment']) . "',
		status = '" . (int) $data['status'] . "',
		index_page = '" . $this->db->escape($index_page) . "',
		sort_order = '" . (int) $data['sort_order'] . "',
		customer_id = '" . (int)$data['customer_id'] . "',
		author = '" . $this->db->escape($data['author']) . "',
		date_modified = NOW() WHERE record_id = '" . (int) $record_id . "'";
		$this->db->query($sql);
		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "record SET image = '" . $this->db->escape($data['image']) . "' WHERE record_id = '" . (int) $record_id . "'");
		}
		$this->db->query("DELETE FROM " . DB_PREFIX . "record_description WHERE record_id = '" . (int) $record_id . "'");

		foreach ($data['record_description'] as $language_id => $value) {

			 if (isset($data['record_tags_product'][$language_id])  && $data['record_tags_product'][$language_id]!='' ) {
	         	$sql_r_t_p = "tag_product = '".$data['record_tags_product'][$language_id]."',
	         	tag_search = '".$data['record_tags_search'][$language_id]."',  ";
	         } else {
	         	$sql_r_t_p = "";
	         }

			$this->db->query("INSERT INTO " . DB_PREFIX . "record_description SET record_id = '" . (int) $record_id . "', language_id = '" . (int) $language_id . "',
			name = '" . $this->db->escape($value['name']) . "',
			meta_title = '" . $this->db->escape($value['meta_title']) . "',
			meta_h1 = '" . $this->db->escape($value['meta_h1']) . "',
			meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "',
			meta_description = '" . $this->db->escape($value['meta_description']) . "',
			description = '" . $this->db->escape($value['description']) . "'" . ",
			 ".$sql_r_t_p."
			sdescription = '" . $this->db->escape($value['sdescription']) . "'");
		}
		$this->db->query("DELETE FROM " . DB_PREFIX . "record_to_store WHERE record_id = '" . (int) $record_id . "'");
		if (isset($data['record_store'])) {
			foreach ($data['record_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "record_to_store SET record_id = '" . (int) $record_id . "', store_id = '" . (int) $store_id . "'");
			}
		}
		$this->db->query("DELETE FROM " . DB_PREFIX . "record_attribute WHERE record_id = '" . (int) $record_id . "'");
		if (!empty($data['record_attribute'])) {
			foreach ($data['record_attribute'] as $record_attribute) {
				if ($record_attribute['attribute_id']) {
					$this->db->query("DELETE FROM " . DB_PREFIX . "record_attribute WHERE record_id = '" . (int) $record_id . "' AND attribute_id = '" . (int) $record_attribute['attribute_id'] . "'");
					foreach ($record_attribute['record_attribute_description'] as $language_id => $record_attribute_description) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "record_attribute SET record_id = '" . (int) $record_id . "', attribute_id = '" . (int) $record_attribute['attribute_id'] . "', language_id = '" . (int) $language_id . "', text = '" . $this->db->escape($record_attribute_description['text']) . "'");
					}
				}
			}
		}
		$this->db->query("DELETE FROM " . DB_PREFIX . "record_image WHERE record_id = '" . (int) $record_id . "'");
		if (isset($data['record_image'])) {
			foreach ($data['record_image'] as $record_image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "record_image SET record_id = '" . (int) $record_id . "',
				options ='" . base64_encode(serialize($record_image['options'])) . "',
				image = '" . $this->db->escape($record_image['image']) . "',
				sort_order = '" . (int) $record_image['sort_order'] . "'");
			}
		}
		$this->db->query("DELETE FROM " . DB_PREFIX . "record_to_download WHERE record_id = '" . (int) $record_id . "'");
		if (isset($data['record_download'])) {
			foreach ($data['record_download'] as $download_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "record_to_download SET record_id = '" . (int) $record_id . "', download_id = '" . (int) $download_id . "'");
			}
		}
		$this->db->query("DELETE FROM " . DB_PREFIX . "record_to_blog WHERE record_id = '" . (int) $record_id . "'");
		if (isset($data['record_blog'])) {
			foreach ($data['record_blog'] as $blog_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "record_to_blog SET record_id = '" . (int) $record_id . "', blog_id = '" . (int) $blog_id . "'");
			}
		}
		$this->db->query("DELETE FROM " . DB_PREFIX . "record_related WHERE pointer_id = '" . (int) $record_id . "'  AND pointer='record_id'");
		if (isset($data['record_related'])) {
			foreach ($data['record_related'] as $related_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "record_related SET pointer_id = '" . (int) $record_id . "', related_id = '" . (int) $related_id . "' , pointer='record_id'");
			}
		}
		$this->db->query("DELETE FROM " . DB_PREFIX . "record_related WHERE pointer_id = '" . (int) $record_id . "'  AND pointer='product_id'");
		if (isset($data['product_related'])) {
			foreach ($data['product_related'] as $product_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "record_related SET pointer_id = '" . (int) $record_id . "', related_id = '" . (int) $product_id . "' , pointer='product_id'");
			}
		}
		$this->db->query("DELETE FROM " . DB_PREFIX . "record_related WHERE pointer_id = '" . (int) $record_id . "'  AND pointer='blog_id'");
		if (isset($data['blog_related'])) {
			foreach ($data['blog_related'] as $blog_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "record_related SET pointer_id = '" . (int) $record_id . "', related_id = '" . (int) $blog_id . "' , pointer='blog_id'");
			}
		}
		$this->db->query("DELETE FROM " . DB_PREFIX . "record_related WHERE pointer_id = '" . (int) $record_id . "'  AND pointer='category_id'");
		if (isset($data['category_related'])) {
			foreach ($data['category_related'] as $category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "record_related SET pointer_id = '" . (int) $record_id . "', related_id = '" . (int) $category_id . "' , pointer='category_id'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "record_related WHERE pointer_id = '" . (int) $record_id . "'  AND pointer='manufacturer_id'");
		if (isset($data['manufacturer_related'])) {
			foreach ($data['manufacturer_related'] as $manufacturer_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "record_related SET pointer_id = '" . (int) $record_id . "', related_id = '" . (int) $manufacturer_id . "' , pointer='manufacturer_id'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "record_to_layout WHERE record_id = '" . (int) $record_id . "'");

		if (isset($data['record_layout'])) {
			foreach ($data['record_layout'] as $store_id => $layout) {
				if ($layout['layout_id']) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "record_to_layout SET record_id = '" . (int) $record_id . "', store_id = '" . (int) $store_id . "', layout_id = '" . (int) $layout['layout_id'] . "'");
				}
			}
		}
		$this->db->query("DELETE FROM " . DB_PREFIX . "record_tag WHERE record_id = '" . (int) $record_id . "'");
		foreach ($data['record_tag'] as $language_id => $value) {
			if ($value) {
				$tags = explode(',', $value);
				foreach ($tags as $tag) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "record_tag SET record_id = '" . (int) $record_id . "', language_id = '" . (int) $language_id . "', tag = '" . $this->db->escape(trim($tag)) . "'");
				}
			}
		}
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias_blog WHERE query = 'record_id=" . (int) $record_id . "'");
		if ($data['keyword']) {
			foreach ($data['keyword'] as $lang_id => $keyword) {
				if ($keyword != '') {
					$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias_blog SET query = 'record_id=" . (int) $record_id . "', keyword = '" . $this->db->escape($keyword) . "' , language_id = '" . (int) $lang_id . "'");
				}
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "record_access WHERE record_id = '" . (int) $record_id . "'");
		if (isset($data['customer_groups_record'])) {
			foreach ($data['customer_groups_record'] as $customer_grops_record_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "record_access SET record_id = '" . (int) $record_id . "', customer_group_id = '" . (int) $customer_grops_record_id . "'");
			}
		}

		$this->cache->delete('blog');

		return $record_id;

	}
	public function copyRecord($record_id)
	{
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "record p LEFT JOIN " . DB_PREFIX . "record_description pd ON (p.record_id = pd.record_id) WHERE p.record_id = '" . (int) $record_id . "' AND pd.language_id = '" . (int) $this->config->get('config_language_id') . "'");
		if ($query->num_rows) {
			$data = $query->row;
			if (!isset($data) || !is_array($data)) {
				$data = array();
			}
			if (!isset($data['comment']) || !is_array($data['comment'])) {
				$data['comment'] = unserialize($data['comment']);
			}
			$data['keyword']               = '';
			$data['status']                = '0';
			$data['customer_id']           = '0';
			$data['author']                = '';
			$data['comment']['status']     = '0';
			$data['comment']['status_reg'] = '0';
			$data['comment']['status_now'] = '0';

			$data  = array_merge($data, array(
				'record_attribute' => $this->getRecordAttributes($record_id)
			));
			$data  = array_merge($data, array(
				'record_description' => $this->getRecordDescriptions($record_id)
			));
			$data = array_merge($data, array(
				'record_image' => $this->getRecordImages($record_id)
			));

			$data['record_image']          = array();
			$results                       = $this->getRecordImages($record_id);
			foreach ($results as $result) {
				$data['record_image'][] = $result['image'];
			}

			$data = array_merge($data, array(
				'record_related' => $this->getRecordRelated($record_id, 'record_id')
			));
			$data = array_merge($data, array(
				'product_related' => $this->getRecordRelated($record_id, 'product_id')
			));
			$data = array_merge($data, array(
				'blog_related' => $this->getRecordRelated($record_id, 'blog_id')
			));
			$data = array_merge($data, array(
				'category_related' => $this->getRecordRelated($record_id, 'category_id')
			));
			$data = array_merge($data, array(
				'manufacturer_related' => $this->getManufacturerRelated($record_id, 'manufacturer_id')
			));
			$data = array_merge($data, array(
				'record_tag' => $this->getRecordTags($record_id)
			));
			$data = array_merge($data, array(
				'record_blog' => $this->getRecordCategories($record_id)
			));
			$data = array_merge($data, array(
				'record_download' => $this->getRecordDownloads($record_id)
			));
			$data = array_merge($data, array(
				'record_layout' => $this->getRecordLayouts($record_id)
			));
			$data = array_merge($data, array(
				'record_store' => $this->getRecordStores($record_id)
			));
			$data = array_merge($data, array(
				'customer_groups_record' => $this->getRecordAccess($record_id)
			));

			$record_id = $this->addRecord($data);
			return  $record_id;
		} else {
			return false;
		}
	}

	public function deleteRecord($record_id)
	{
		$this->db->query("DELETE FROM " . DB_PREFIX . "record WHERE record_id = '" . (int) $record_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "record_attribute WHERE record_id = '" . (int) $record_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "record_description WHERE record_id = '" . (int) $record_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "record_image WHERE record_id = '" . (int) $record_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "record_related WHERE pointer_id = '" . (int) $record_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "record_related WHERE related_id = '" . (int) $record_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "record_tag WHERE record_id='" . (int) $record_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "record_to_blog WHERE record_id = '" . (int) $record_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "record_to_download WHERE record_id = '" . (int) $record_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "record_to_layout WHERE record_id = '" . (int) $record_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "record_to_store WHERE record_id = '" . (int) $record_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "comment WHERE record_id = '" . (int) $record_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias_blog WHERE query = 'record_id=" . (int) $record_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "record_access` WHERE record_id = '" . (int) $record_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "agoo_signer` WHERE id = '" . (int) $record_id . "' AND pointer='record_id'");
		$this->cache->delete('blog');
		return true;
	}

	public function getRecord($record_id, $mark = "record_id")
	{
         if ($mark == 'product_id') {
          $mark_record = 'product';
         } else {
          $mark_record = 'record';
         }

		$sql = "SELECT DISTINCT *
		FROM " . DB_PREFIX . $mark_record." p
		LEFT JOIN " . DB_PREFIX . $mark_record."_description pd ON (p.".$mark_record."_id = pd.".$mark_record."_id)
		WHERE p.".$mark_record."_id = '" . (int) $record_id . "'
		AND
		pd.language_id = '" . (int) $this->config->get('config_language_id') . "'";

		$query = $this->db->query($sql);
		return $query->row;
	}

	public function getRecordKeywords($record_id)
	{
		$keys  = array();
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias_blog WHERE query = 'record_id=" . (int) $record_id . "'");
		foreach ($query->rows as $num => $row) {
			$keys[$row['language_id']] = $row['keyword'];
		}
		return $keys;
	}

	public function getRecords($data = array())
	{
		if (!empty($data['mark'])) {

         if ($data['mark'] == 'product_id') {
          $mark = 'review';
          $mark_record = 'product';
          $mark_category = 'category';
         } else {
          $mark = 'comment';
          $mark_record = 'record';
          $mark_category = 'blog';
         }

		} else {
			 $mark = 'comment';
	         $mark_record = 'record';
	         $mark_category = 'blog';
		}

		$grouping = "GROUP BY p.".$mark_record."_id";

		if (isset($data['ajax']) && $data['ajax']) {
			$grouping = "GROUP BY bd.".$mark_category."_id";
		}

		if ($data) {
			$sql = "SELECT  p2c.".$mark_category."_id, p.*,pd.*,
			bd.name as blog_name FROM " . DB_PREFIX . $mark_record." p
			LEFT JOIN " . DB_PREFIX . $mark_record."_description pd ON (p.".$mark_record."_id = pd.".$mark_record."_id)
			LEFT JOIN " . DB_PREFIX . $mark_record."_to_".$mark_category." p2c ON (p.".$mark_record."_id = p2c.".$mark_record."_id)
			LEFT JOIN " . DB_PREFIX . $mark_category."_description bd ON (p2c.".$mark_category."_id = bd.".$mark_category."_id AND bd.language_id ='" . (int) $this->config->get('config_language_id') . "')
			";
			$sql .= " WHERE pd.language_id = '" . (int) $this->config->get('config_language_id') . "' ";
			if (!empty($data['filter_name'])) {
				$sql .= " AND LCASE(pd.name) LIKE '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";
			}
			if (!empty($data['filter_blog'])) {
				$sql .= " AND LCASE(bd.name) LIKE '" . $this->db->escape(utf8_strtolower($data['filter_blog'])) . "%'";
			}
			if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
				$sql .= " AND p.status = '" . (int) $data['filter_status'] . "'";
			}
			if (!empty($data['filter_blog_id'])) {
				if (!empty($data['filter_sub_blog'])) {
					$implode_data   = array();
					$implode_data[] = $mark_category."_id = '" . (int) $data['filter_blog_id'] . "'";

					$this->load->model('catalog/blog');
					$categories = $this->model_catalog_blog->getCategories($data['filter_blog_id'], $mark_category);

					foreach ($categories as $blog) {
						$implode_data[] = "p2c.".$mark_category."_id = '" . (int) $blog[$mark_category.'_id'] . "'";
					}
					$sql .= " AND (" . implode(' OR ', $implode_data) . ")";
				} else {
					$sql .= " AND p2c.".$mark_category."_id = '" . (int) $data['filter_blog_id'] . "'";
				}
			}
			$sql .= $grouping;
			$sort_data = array(
				'pd.name',
				'p.status',
				'p.date_added',
				'blog_name',
				'p.sort_order'
			);
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];
			} else {
				$sql .= " ORDER BY p.".$mark_record."_id";
			}
			if (isset($data['order']) && ($data['order'] == 'DESC')) {
				$sql .= " DESC";
			} else {
				$sql .= " ASC";
			}
			if (isset($data['start']) || isset($data['limit'])) {
				if ($data['start'] < 0) {
					$data['start'] = 0;
				}
				if ($data['limit'] < 1) {
					$data['limit'] = 20;
				}
				$sql .= " LIMIT " . (int) $data['start'] . "," . (int) $data['limit'];
			}

			$query = $this->db->query($sql);
			return $query->rows;
		} else {

			if (!$record_data) {
				$query       = $this->db->query("SELECT * FROM " . DB_PREFIX . $mark_record." p LEFT JOIN " . DB_PREFIX . $mark_record."_description pd ON (p.".$mark_record."_id = pd.".$mark_record."_id) WHERE pd.language_id = '" . (int) $this->config->get('config_language_id') . "' ORDER BY p.".$mark_record."_id DESC");
				$record_data = $query->rows;

			}
			return $record_data;
		}
	}


	public function getMainBlog($record_id)
	{
		$sql = "SELECT *
		FROM " . DB_PREFIX . "record p
		LEFT JOIN " . DB_PREFIX . "blog b ON (b.blog_id = p.blog_main)
		LEFT JOIN " . DB_PREFIX . "blog_description bd ON (b.blog_id = bd.blog_id)
		WHERE
		bd.language_id = '" . (int) $this->config->get('config_language_id') . "'
		AND
		p.record_id = '" . (int) $record_id . "'
		ORDER BY p.record_id DESC";
		$query = $this->db->query($sql);
		return $query->row;
	}


	public function getRecordsByBlogId($blog_id)
	{
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "record p LEFT JOIN " . DB_PREFIX . "record_description pd ON (p.record_id = pd.record_id) LEFT JOIN " . DB_PREFIX . "record_to_blog p2c ON (p.record_id = p2c.record_id) WHERE pd.language_id = '" . (int) $this->config->get('config_language_id') . "' AND p2c.blog_id = '" . (int) $blog_id . "' ORDER BY p.record_id DESC");
		return $query->rows;
	}

	public function setRecordAccessGroup($record_id, $group, $check)
	{
			$this->db->query("DELETE FROM `" . DB_PREFIX . "record_access` WHERE record_id = '" . (int) $record_id . "' AND customer_group_id = '".(int)$group."' ");

			if ($check) {
				$msql = "INSERT INTO `" . DB_PREFIX . "record_access` (`record_id`, `customer_group_id`) VALUES  ('" . (int)$record_id . "', '" . (int)$group . "')";
				$query = $this->db->query($msql);
				return true;
			} else {
				return false;
			}

	}

	public function getRecordAccess($record_id)
	{
		$query           = $this->db->query("SELECT * FROM " . DB_PREFIX . "record_access WHERE record_id = '" . (int) $record_id . "'");
		$blog_access = array();
		foreach ($query->rows as $result) {
			$blog_access[$result['customer_group_id']] = $result['customer_group_id'];
		}
		return $blog_access;
	}

	public function getRecordDescriptions($record_id)
	{
		$record_description_data = array();
		$query                   = $this->db->query("SELECT * FROM " . DB_PREFIX . "record_description WHERE record_id = '" . (int) $record_id . "'");
		foreach ($query->rows as $result) {
			$record_description_data[$result['language_id']] = array(
				'name' => $result['name'],
				'description' => $result['description'],
				'sdescription' => $result['sdescription'],
				'meta_title' => $result['meta_title'],
				'meta_h1' => $result['meta_h1'],
				'meta_keyword' => $result['meta_keyword'],
				'meta_description' => $result['meta_description']
			);
		}
		return $record_description_data;
	}

	public function getRecordAttributes($record_id)
	{
		$record_attribute_data  = array();
		$record_attribute_query = $this->db->query("SELECT pa.attribute_id, ad.name FROM " . DB_PREFIX . "record_attribute pa LEFT JOIN " . DB_PREFIX . "attribute a ON (pa.attribute_id = a.attribute_id) LEFT JOIN " . DB_PREFIX . "attribute_description ad ON (a.attribute_id = ad.attribute_id) WHERE pa.record_id = '" . (int) $record_id . "' AND ad.language_id = '" . (int) $this->config->get('config_language_id') . "' GROUP BY pa.attribute_id");
		foreach ($record_attribute_query->rows as $record_attribute) {
			$record_attribute_description_data  = array();
			$record_attribute_description_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "record_attribute WHERE record_id = '" . (int) $record_id . "' AND attribute_id = '" . (int) $record_attribute['attribute_id'] . "'");
			foreach ($record_attribute_description_query->rows as $record_attribute_description) {
				$record_attribute_description_data[$record_attribute_description['language_id']] = array(
					'text' => $record_attribute_description['text']
				);
			}
			$record_attribute_data[] = array(
				'attribute_id' => $record_attribute['attribute_id'],
				'name' => $record_attribute['name'],
				'record_attribute_description' => $record_attribute_description_data
			);
		}
		return $record_attribute_data;
	}

	public function getRecordImages($record_id)
	{
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "record_image WHERE record_id = '" . (int) $record_id . "'");
		return $query->rows;
	}

	public function getRecordDownloads($record_id)
	{
		$record_download_data = array();
		$query                = $this->db->query("SELECT * FROM " . DB_PREFIX . "record_to_download WHERE record_id = '" . (int) $record_id . "'");
		foreach ($query->rows as $result) {
			$record_download_data[] = $result['download_id'];
		}
		return $record_download_data;
	}

	public function getRecordStores($record_id)
	{
		$record_store_data = array();
		$query             = $this->db->query("SELECT * FROM " . DB_PREFIX . "record_to_store WHERE record_id = '" . (int) $record_id . "'");
		foreach ($query->rows as $result) {
			$record_store_data[] = $result['store_id'];
		}
		return $record_store_data;
	}

	public function getRecordLayouts($record_id)
	{
		$record_layout_data = array();
		$query              = $this->db->query("SELECT * FROM " . DB_PREFIX . "record_to_layout WHERE record_id = '" . (int) $record_id . "'");
		foreach ($query->rows as $result) {
			$record_layout_data[$result['store_id']] = $result['layout_id'];
		}
		return $record_layout_data;
	}

	public function getRecordCategories($record_id)
	{
		$record_blog_data = array();
		$query            = $this->db->query("SELECT * FROM " . DB_PREFIX . "record_to_blog WHERE record_id = '" . (int) $record_id . "'");
		foreach ($query->rows as $result) {
			$record_blog_data[] = $result['blog_id'];
		}
		return $record_blog_data;
	}

	public function getRecordRelated($record_id, $pointer = 'record_id')
	{
		$record_related_data = array();
		$query               = $this->db->query("SELECT *
		FROM " . DB_PREFIX . "record_related WHERE pointer_id = '" . (int) $record_id . "' AND pointer='" . $pointer . "'");
		foreach ($query->rows as $result) {
			$record_related_data[] = $result['related_id'];
		}
		return $record_related_data;
	}

	public function getProductRelated($record_id)
	{
		$product_related_data = array();
		$query                = $this->db->query("SELECT * FROM " . DB_PREFIX . "record_related WHERE pointer_id = '" . (int) $record_id . "' AND pointer='product_id'");
		foreach ($query->rows as $result) {
			$product_related_data[] = $result['related_id'];
		}
		return $product_related_data;
	}

	public function getBlogRelated($record_id)
	{
		$record_related_data = array();
		$query               = $this->db->query("SELECT * FROM " . DB_PREFIX . "record_related WHERE pointer_id = '" . (int) $record_id . "' AND pointer='blog_id'");
		foreach ($query->rows as $result) {
			$record_related_data[] = $result['related_id'];
		}
		return $record_related_data;
	}

	public function getCategoryRelated($record_id)
	{
		$record_related_data = array();
		$query               = $this->db->query("SELECT * FROM " . DB_PREFIX . "record_related WHERE pointer_id = '" . (int) $record_id . "' AND pointer='category_id'");
		foreach ($query->rows as $result) {
			$record_related_data[] = $result['related_id'];
		}
		return $record_related_data;
	}


	public function getManufacturerRelated($record_id)
	{
		$record_related_data = array();
		$query               = $this->db->query("SELECT * FROM " . DB_PREFIX . "record_related WHERE pointer_id = '" . (int) $record_id . "' AND pointer='manufacturer_id'");
		foreach ($query->rows as $result) {
			$record_related_data[] = $result['related_id'];
		}

		return $record_related_data;
	}


	public function getRecordTags($record_id)
	{
		$record_tag_data = array();
		$query           = $this->db->query("SELECT * FROM " . DB_PREFIX . "record_tag WHERE record_id = '" . (int) $record_id . "'");
		$tag_data        = array();
		foreach ($query->rows as $result) {
			$tag_data[$result['language_id']][] = $result['tag'];
		}
		foreach ($tag_data as $language => $tags) {
			$record_tag_data[$language] = implode(',', $tags);
		}
		return $record_tag_data;
	}

	public function getTotalRecords($data = array())
	{
		$sql = "SELECT COUNT(DISTINCT p.record_id) AS total FROM " . DB_PREFIX . "record p LEFT JOIN " . DB_PREFIX . "record_description pd ON (p.record_id = pd.record_id)";
		if (!empty($data['filter_blog_id'])) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "record_to_blog p2c ON (p.record_id = p2c.record_id)";
		}
		$sql .= " WHERE pd.language_id = '" . (int) $this->config->get('config_language_id') . "'";
		if (!empty($data['filter_name'])) {
			$sql .= " AND LCASE(pd.name) LIKE '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";
		}
		if (!empty($data['filter_price'])) {
			$sql .= " AND p.price LIKE '" . $this->db->escape($data['filter_price']) . "%'";
		}
		if (isset($data['filter_quantity']) && !is_null($data['filter_quantity'])) {
			$sql .= " AND p.quantity = '" . $this->db->escape($data['filter_quantity']) . "'";
		}
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND p.status = '" . (int) $data['filter_status'] . "'";
		}
		if (!empty($data['filter_blog_id'])) {
			if (!empty($data['filter_sub_blog'])) {
				$implode_data   = array();
				$implode_data[] = "p2c.blog_id = '" . (int) $data['filter_blog_id'] . "'";
				$this->load->model('catalog/blog');
				$categories = $this->model_catalog_blog->getCategories($data['filter_blog_id']);
				foreach ($categories as $blog) {
					$implode_data[] = "p2c.blog_id = '" . (int) $blog['blog_id'] . "'";
				}
				$sql .= " AND (" . implode(' OR ', $implode_data) . ")";
			} else {
				$sql .= " AND p2c.blog_id = '" . (int) $data['filter_blog_id'] . "'";
			}
		}
		$query = $this->db->query($sql);
		return $query->row['total'];
	}

	public function getTotalRecordsByTaxClassId($tax_class_id)
	{
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "record WHERE tax_class_id = '" . (int) $tax_class_id . "'");
		return $query->row['total'];
	}

	public function getTotalRecordsByStockStatusId($stock_status_id)
	{
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "record WHERE stock_status_id = '" . (int) $stock_status_id . "'");
		return $query->row['total'];
	}

	public function getTotalRecordsByWeightClassId($weight_class_id)
	{
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "record WHERE weight_class_id = '" . (int) $weight_class_id . "'");
		return $query->row['total'];
	}

	public function getTotalRecordsByLengthClassId($length_class_id)
	{
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "record WHERE length_class_id = '" . (int) $length_class_id . "'");
		return $query->row['total'];
	}

	public function getTotalRecordsByDownloadId($download_id)
	{
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "record_to_download WHERE download_id = '" . (int) $download_id . "'");
		return $query->row['total'];
	}

	public function getTotalRecordsByManufacturerId($manufacturer_id)
	{
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "record WHERE manufacturer_id = '" . (int) $manufacturer_id . "'");
		return $query->row['total'];
	}

	public function getTotalRecordsByAttributeId($attribute_id)
	{
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "record_attribute WHERE attribute_id = '" . (int) $attribute_id . "'");
		return $query->row['total'];
	}

	public function getTotalRecordsByLayoutId($layout_id)
	{
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "record_to_layout WHERE layout_id = '" . (int) $layout_id . "'");
		return $query->row['total'];
	}
}
}
