<?php
/* All rights reserved belong to the module, the module developers http://opencartadmin.com */
// http://opencartadmin.com © 2011-2016 All Rights Reserved
// Distribution, without the author's consent is prohibited
// Commercial license
class ModelCatalogAdapter extends Model
{
	public function getThemes($data = array())
	{
		$sql   = "SELECT *
		FROM  " . DB_PREFIX . "review_adapter rf

		WHERE
		review_id = '" . (int)$data['review_id'] . "'
		AND
		mark = '" . $this->db->escape($data['mark']) . "'
		LIMIT 1";
		$query = $this->db->query($sql);
		return $query->rows;
	}


	public function getFieldsDB()
	{
        /*
		 $sql = "SELECT  f.*,fd.* FROM " . DB_PREFIX . "adapter f
			LEFT JOIN " . DB_PREFIX . "adapter_description fd ON (f.adapter_id = fd.adapter_id)
			WHERE fd.language_id = '" . (int) $this->config->get('config_language_id') . "'
			GROUP BY f.adapter_id
			ORDER BY f.adapter_order DESC ";
        */

		 $sql = "SELECT  f.* FROM " . DB_PREFIX . "adapter f
			GROUP BY f.adapter_id
			ORDER BY f.adapter_order DESC ";


			$query = $this->db->query($sql);

			return $query->rows;

	}


	public function getFieldsDesc()
	{

		 $sql = "SELECT  f.*, fd.* FROM " . DB_PREFIX . "adapter f
			LEFT JOIN " . DB_PREFIX . "adapter_description fd ON (f.adapter_id = fd.adapter_id)
			WHERE fd.language_id = '" . (int) $this->config->get('config_language_id') . "'
			GROUP BY f.adapter_id
			ORDER BY f.adapter_order DESC ";


			$query = $this->db->query($sql);

			return $query->rows;

	}





	public function getDesc()
	{
		 $sql = "SELECT  * FROM " . DB_PREFIX . "adapter_description";
		 $query = $this->db->query($sql);

		 return $query->rows;
	}


	public function getFieldsDBlang()
	{
         $adapter = $this->getFieldsDB();
         $desc   = $this->getDesc();

         $adapter_new = $adapter;
		 foreach ($adapter as $num => $adapter) {
            foreach ($desc as $num_desc => $adapter_desc) {
          	if ($adapter['adapter_id'] == $adapter_desc['adapter_id']) {
                 $adapter_new[$num]['adapter_description'][$adapter_desc['language_id']] = $adapter_desc['adapter_description'];
                 $adapter_new[$num]['adapter'][$adapter_desc['language_id']] = unserialize(base64_decode($adapter_desc['adapter'])) ;
                 $adapter_new[$num]['adapter_error'][$adapter_desc['language_id']] 		= $adapter_desc['adapter_error'];
                 $adapter_new[$num]['adapter_value'][$adapter_desc['language_id']] 		= $adapter_desc['adapter_value'];
                }
		 	}

		 }
		return $adapter_new;
	}



 	public function getFieldsAll()
	{
		$sql   = "SELECT * FROM  " . DB_PREFIX . "review_adapter rf	LIMIT 1";
		$query = $this->db->query($sql);
        $data['adapter'] = array();
    	foreach ($query->rows as $val) {
	           	foreach ($val as $adapter => $key) {
	            		if ($adapter!="mark" && $adapter!="review_id") {
	            		$data['adapter'][]['adapter_name'] = $adapter;
	            	}

	           	}
	    }

		return $data['adapter'];
	}

	public function getField($adapter_id)
	{
		$query = $this->db->query("SELECT DISTINCT *
		FROM " . DB_PREFIX . "adapter f
		LEFT JOIN " . DB_PREFIX . "adapter_description fd ON (f.adapter_id = fd.adapter_id)
		WHERE f.adapter_id = '" . (int) $adapter_id . "' AND fd.language_id = '" . (int) $this->config->get('config_language_id') . "'");
		return $query->row;
	}

	public function getFieldByName($adapter_name)
	{
		$query = $this->db->query("SELECT DISTINCT *
		FROM " . DB_PREFIX . "adapter f
		LEFT JOIN " . DB_PREFIX . "adapter_description fd ON (f.adapter_id = fd.adapter_id)
		WHERE f.adapter_name = '" .  $this->db->escape(strip_tags($adapter_name))  . "' AND fd.language_id = '" . (int) $this->config->get('config_language_id') . "'");
		return $query->row;
	}

	public function getFieldOnly($adapter_id)
	{
		$query = $this->db->query("SELECT DISTINCT *
		FROM " . DB_PREFIX . "adapter f
		WHERE f.adapter_id = '" . (int) $adapter_id . "'");
		return $query->row;
	}


	public function getFieldDescriptions($adapter_id)
	{
		$adapter_description_data = array();
		$query                   = $this->db->query("SELECT * FROM " . DB_PREFIX . "adapter_description WHERE adapter_id = '" . (int) $adapter_id . "'");

		foreach ($query->rows as $result) {
			$adapter_description_data[$result['language_id']] = array(
				'adapter_error' => $result['adapter_error'],
				'adapter_value' => $result['adapter_value'],
				'adapter_description' => $result['adapter_description'],
				'adapter' => $result['adapter']
			);
		}
		return $adapter_description_data;
	}



	public function table_exists($tableName)
	{
		$found= false;
		$like   = addcslashes($tableName, '%_\\');
		$result = $this->db->query("SHOW TABLES LIKE '" . $this->db->escape($like) . "';");
		$found  = $result->num_rows > 0;
		return $found;
	}
	public function adapter_exists($tableName, $adapter)
	{
		$r = $this->db->query("SELECT `" . $this->db->escape($adapter) . "` FROM `" . DB_PREFIX . $this->db->escape($tableName) . "` WHERE 0");
		return $r;
	}


	public function editField($adapter_id, $data)
	{

    	if (!isset($data['adapter_must'])) {
	     $data['adapter_must'] = 0;
		}


		if ($this->db->escape($data['adapter_type']) == 'text') {
			$type_adapter = "VARCHAR";
			$type_filed_end = "(255) COLLATE utf8_general_ci NOT NULL";
		}

		if ($this->db->escape($data['adapter_type']) == 'textarea') {
          	$type_adapter = "TEXT";
          	$type_filed_end = " COLLATE utf8_general_ci NOT NULL";
		}

		if ($this->db->escape($data['adapter_type']) == 'select') {
          	$type_adapter = "TEXT";
          	$type_filed_end = " COLLATE utf8_general_ci NOT NULL";
		}

		if ($this->db->escape($data['adapter_type']) == 'rating') {
			$type_adapter = "INT";
			$type_filed_end = "(1) NOT NULL";
		}

		$r = $this->db->query("DESCRIBE " . DB_PREFIX . "review_adapter `".$this->db->escape($data['adapter_name'])."`");
		if ($r->num_rows > 0 && strtoupper($r->row['Type']) != strtoupper ($type_adapter) ) {
			$msql  = "ALTER TABLE `" . DB_PREFIX . "review_adapter`
			CHANGE `".$this->db->escape($data['adapter_name'])."` `".$this->db->escape($data['adapter_name'])."`
			" .$type_adapter.$type_filed_end;
			$query = $this->db->query($msql);
		}


       $data_info = $this->getFieldOnly($adapter_id);

		if ($data['adapter_name']!=$data_info['adapter_name']) {
         $msql  = "ALTER TABLE `" . DB_PREFIX . "review_adapter`
			CHANGE `".$this->db->escape($data_info['adapter_name'])."` `".$this->db->escape($data['adapter_name'])."`
			" .$type_adapter.$type_filed_end;
			$query = $this->db->query($msql);

		}

		$sql = "UPDATE " . DB_PREFIX . "adapter SET
		adapter_name = '" . $this->db->escape($data['adapter_name']) . "',
		adapter_image = '" . $this->db->escape($data['adapter_image']) . "',
		adapter_type = '" . $this->db->escape($data['adapter_type']) . "',
		adapter_must = '" . (int) $data['adapter_must'] . "',
		adapter_status = '" . (int) $data['adapter_status'] . "',
		adapter_public = '" . (int) $data['adapter_public'] . "',
		adapter_order = '" . (int) $data['adapter_order'] . "'

		WHERE adapter_id = '" . (int) $adapter_id . "'";
		$this->db->query($sql);

		$this->db->query("DELETE FROM " . DB_PREFIX . "adapter_description WHERE adapter_id = '" . (int) $adapter_id . "'");

		foreach ($data['adapter_description'] as $language_id => $value) {
			$this->db->query("
			INSERT INTO " . DB_PREFIX . "adapter_description SET
			adapter_id = '" . (int) $adapter_id . "',
			language_id = '" . (int) $language_id . "',
			adapter_description = '" . $this->db->escape($value['adapter_description']) . "',
            adapter_error = '" . $this->db->escape($value['adapter_error']) . "',
            adapter_value = '" . $this->db->escape($value['adapter_value']) . "',
            adapter		= '" . base64_encode(serialize($value['adapter'])) . "'"

			);
		}


		$this->cache->delete('blog');
	}


	public function addField($data)
	{
        $error = false;

		if ($this->db->escape($data['adapter_type']) == 'text') {
			$type_adapter = "VARCHAR";
			$type_filed_end = "(255) COLLATE utf8_general_ci NOT NULL";
		}

		if ($this->db->escape($data['adapter_type']) == 'textarea') {
          	$type_adapter = "TEXT";
          	$type_filed_end = " COLLATE utf8_general_ci NOT NULL";
		}

		if ($this->db->escape($data['adapter_type']) == 'select') {
          	$type_adapter = "TEXT";
          	$type_filed_end = " COLLATE utf8_general_ci NOT NULL";
		}

		if ($this->db->escape($data['adapter_type']) == 'rating') {
			$type_adapter = "INT";
			$type_filed_end = "(1) NOT NULL";
		}


		$r = $this->db->query("DESCRIBE " . DB_PREFIX . "review_adapter `".$this->db->escape($data['adapter_name'])."`");
		if ($r->num_rows == 0) {
			$msql  = "ALTER TABLE `" . DB_PREFIX . "review_adapter`
			ADD `".$this->db->escape($data['adapter_name'])."`
			" .$type_adapter.$type_filed_end;
			$query = $this->db->query($msql);

			$sql = "INSERT INTO " . DB_PREFIX . "adapter SET
			adapter_name = '" . $this->db->escape($data['adapter_name']) . "'";
			$this->db->query($sql);
	 		$data['adapter_id'] = $this->db->getLastId();
	        $this->request->get['adapter_id'] = $data['adapter_id'];
	        $this->editField($data['adapter_id'], $data);
	        $field_id = $this->db->getLastId();

        } else {
          $error = true;
        }

		$this->cache->delete('blog');
		return $error;
	}

 	public function deleteField($adapter_id) {

		$data = $this->getFieldOnly($adapter_id);


		if (isset($data['adapter_name'])) {
			$r = $this->db->query("DESCRIBE " . DB_PREFIX . "review_adapter `".$this->db->escape($data['adapter_name'])."`");
			if ($r->num_rows > 0) {
				$msql  = "ALTER TABLE `" . DB_PREFIX . "review_adapter` DROP `".$this->db->escape($data['adapter_name'])."`";
				$query = $this->db->query($msql);
			}
		}

		//$r = $this->db->query("DESCRIBE " . DB_PREFIX . "adapter `".$this->db->escape($data['adapter_name'])."`");
		//if ($r->num_rows > 0)
		{
			$msql  = "DELETE FROM " . DB_PREFIX . "adapter WHERE `adapter_id` = ".(int)$adapter_id."";
			$query = $this->db->query($msql);
			$msql  = "DELETE FROM " . DB_PREFIX . "adapter_description WHERE `adapter_id` = ".(int)$adapter_id."";
			$query = $this->db->query($msql);
		}



 	}

 	public function copyField($adapter_id) {

		$data = $this->getFieldOnly($adapter_id);
        $data['adapter_description'] = $this->getFieldDescriptions($adapter_id);

                $prefix = '';

                $prefix_str = str_replace("_","",md5($data['adapter_name']));
                $prefix_str = preg_replace ("/[^a-z\s]/","",$prefix_str);
                $prefix_array = preg_split('//', $prefix_str, -1, PREG_SPLIT_NO_EMPTY);
                shuffle($prefix_array);
                $prefix =  substr(implode($prefix_array), 0, 3);

		$data['adapter_name'] = $data['adapter_name']."_".$prefix;
		$this->addField($data);



 	}



}
?>