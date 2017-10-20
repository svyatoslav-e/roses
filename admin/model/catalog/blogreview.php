<?php
/* All rights reserved belong to the module, the module developers http://opencartadmin.com */
// http://opencartadmin.com © 2011-2016 All Rights Reserved
// Distribution, without the author's consent is prohibited
// Commercial license
class ModelCatalogBlogreview extends Model
{
	public function editReview($review_id, $data)
	{
		if ($review_id != "" && $data['date_added'] != "") {
			$this->db->query("UPDATE " . DB_PREFIX . "review SET   date_added = '" . $data['date_added'] . "' WHERE review_id = '" . (int) $review_id . "'");
			$this->cache->delete('product');
			$this->cache->delete('blog.module.view');
		} //$review_id != "" && $data['date_added'] != ""


		if (isset($data['af'])) {
		$sql_add='';
			$af_bool = $this->table_exists(DB_PREFIX . "review_fields");
			if ($af_bool) {
			   $i=1;
				foreach ($data['af'] as $num => $value) {

						$sql_add .= " " . $this->db->escape(strip_tags($num)) . " = '" . $this->db->escape(strip_tags($value))."' ";

                     	if ($i!=count($data['af'])) $sql_add .=",";


                    $i++;
				}
				if (substr($sql_add, -1)==',') {
				 $sql_add = substr($sql_add, 0, strlen($sql_add)-1);
				}

				if ($sql_add != "") {

					 $sql   = "SELECT * FROM  " . DB_PREFIX . "review_fields rf
						WHERE
						review_id = '" . (int) $review_id . "'
						AND
						mark = '" . $data['mark'] . "'
						LIMIT 1";
						$query = $this->db->query($sql);

                      if (count($query->rows) > 0) {
						$sql = "UPDATE " . DB_PREFIX . "review_fields SET " . $sql_add . " WHERE review_id='" . (int) $review_id . "' AND mark='".$data['mark']."' ";

                      } else {
			  		$sql = "INSERT INTO " . DB_PREFIX . "review_fields SET " . $sql_add . ", review_id='" . (int) $review_id . "', mark='".$data['mark']."' ";

					}
					$this->db->query($sql);
				} //$sql_add != ""
			} //$af_bool
		} //isset($data['af'])
		$this->cache->delete('product');
		$this->cache->delete('blog');

	}
	public function table_exists($tableName)
	{
		$like   = addcslashes($tableName, '%_\\');
		$result = $this->db->query("SHOW TABLES LIKE '" . $this->db->escape($like) . "';");
		$found  = $result->num_rows > 0;
		return $found;
	}
	public function field_exists($tableName, $field)
	{
		$r = $this->db->query("SELECT `" . $field . "` FROM `" . DB_PREFIX . $tableName . "` WHERE 0");
		return $r;
	}
	public function getProductbyReviewId($comment_id)
	{
		$sql   = "SELECT DISTINCT * FROM " . DB_PREFIX . "review r
		LEFT JOIN " . DB_PREFIX . "product p ON (r.product_id = p.product_id)
		LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id)
		LEFT JOIN " . DB_PREFIX . "product_to_store ps ON (p.product_id = ps.product_id)

		WHERE r.review_id = '" . (int) $comment_id . "'
		AND pd.language_id = '" . (int) $this->config->get('config_language_id') . "'
        AND ps.store_id = '" . (int) $this->config->get('config_store_id') . "'";

		$query = $this->db->query($sql);
		return $query->row;
	}

	public function getProductIdbyReviewId($comment_id)
	{
		$sql   = "SELECT DISTINCT * FROM " . DB_PREFIX . "review r WHERE r.review_id = '" . (int) $comment_id . "'";
		$query = $this->db->query($sql);
		return $query->row['product_id'];
	}




}
?>