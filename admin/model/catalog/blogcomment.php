<?php
/* All rights reserved belong to the module, the module developers http://opencartadmin.com */
// http://opencartadmin.com © 2011-2016 All Rights Reserved
// Distribution, without the author's consent is prohibited
// Commercial license
class ModelCatalogBlogComment extends Model
{
	public function addComment($data)
	{

		if (isset($data['mark']) && $data['mark']=='product_id') {
			$data['mark'] = 'product_id';
			$data['mark_record'] = 'product';
			$data['mark_name'] = 'review';
		} else {
			$data['mark'] = 'record_id';
			$data['mark_record'] = 'record';
			$data['mark_name'] = 'comment';
		}


		$parent_id = 0;

		$record_id = $data['record_id'];

		$sql       = "
		SELECT r.*, p.*, pp.sorthex as sorthex_parent
		FROM " . DB_PREFIX . $data['mark_name']." r
		LEFT JOIN " . DB_PREFIX . $data['mark_record']." p ON (r.".$data['mark_record']."_id = p.".$data['mark_record']."_id)
		LEFT JOIN " . DB_PREFIX . $data['mark_record']."_description pd ON (p.".$data['mark_record']."_id = pd.".$data['mark_record']."_id)
		LEFT JOIN " . DB_PREFIX . $data['mark_name']." pp ON (r.parent_id = pp.".$data['mark_name']."_id)
		WHERE p.".$data['mark_record']."_id = '" . (int) $record_id . "'
		AND r.parent_id = '" . (int) $parent_id . "'
		AND pd.language_id = '" . (int) $this->config->get('config_language_id') . "'
		ORDER BY r.sorthex DESC
		LIMIT 1";

		$query     = $this->db->query($sql);
		if (count($query->rows) > 0) {
			foreach ($query->rows as $comment) {
				$sorthex        = $comment['sorthex'];
				$sorthex_parent = $comment['sorthex_parent'];
				$sorthex        = substr($sorthex, strlen($sorthex_parent), 4);
			} //$query->rows as $comment
			$sorthex = $sorthex_parent . (str_pad(dechex($sortdec = hexdec($sorthex) + 1), 4, "0", STR_PAD_LEFT));
		} //count($query->rows) > 0
		else {
			if ($parent_id == 0) {
				$sorthex = '0000';
			} //$parent_id == 0
			else {
				$queryparent = $this->db->query("
				SELECT c.sorthex
				FROM " . DB_PREFIX . $data['mark_name']." c
				WHERE c.".$data['mark_name']."_id = '" . (int) $parent_id . "'
				ORDER BY c.sorthex DESC
				LIMIT 1");
				if (count($queryparent->rows) > 0) {
					foreach ($queryparent->rows as $parent) {
						$sorthex = $parent['sorthex'];
					} //$queryparent->rows as $parent
					$sorthex = $sorthex . "0000";
				} //count($queryparent->rows) > 0
			}
		}

		if (!isset($data['customer_id'])) $data['customer_id'] = '0';
		if (!isset($data['parent_id'])) $data['parent_id'] = '0';

		if (isset($data['date_available']) && $data['date_available'] != '') {
			$sql_date_available = "date_added = '".$data['date_available']."', ";
		} else {
			$sql_date_available = ' date_added = NOW(), ';
		}


		$this->db->query("INSERT INTO " . DB_PREFIX . $data['mark_name']."
		SET author = '" . $this->db->escape($data['author']) . "',
		".$data['mark_record']."_id = '" . $this->db->escape($data['record_id']) . "',
		customer_id = '" . (int)$data['customer_id'] . "',
		parent_id = '" . (int)$data['parent_id'] . "',
		language_id = '" . (int)$data['language_id'] . "',
		type_id = '" . (int)$data['type_id'] . "',
		cmswidget = '" . (int)$data['cmswidget'] . "',
		sorthex   = '" . $sorthex . "',
		text = '" . $data['text'] . "',
		".$sql_date_available."
		rating = '" . (int) $data['rating'] . "',
		rating_mark = '" . (int) $data['rating_mark'] . "',
		status = '" . (int) $data['status'] . "' ");

		$review_id = $this->db->getLastId();
		$sql_add   = "";

		if (isset($data['af'])) {
			$af_bool = $this->table_exists(DB_PREFIX . "review_fields");
			if ($af_bool) {
				foreach ($data['af'] as $num => $value) {
					if ($value != '') {
						$sql_add .= " " . $this->db->escape(strip_tags($num)) . " = '" . $this->db->escape(strip_tags($value)) . "',";
					} //$value != ''
				} //$data['af'] as $num => $value
				if ($sql_add != "") {
					$sql = "INSERT INTO " . DB_PREFIX . "review_fields SET " . $sql_add . " review_id='" . (int) $review_id . "', mark='".$data['mark']."' ";
					$this->db->query($sql);
				}
			}
		}



		$this->cache->delete('product');
		$this->cache->delete('blog');
		return $review_id;
	}
	public function getField($data = array())
	{
		$sql   = "SELECT * FROM  " . DB_PREFIX . "review_fields rf
		WHERE
		review_id = '" . (int)$data['review_id'] . "'
		AND
		mark = '" . $data['mark'] . "'
		LIMIT 1";
		$query = $this->db->query($sql);
		return $query->rows;
	}

	public function getFieldsDesc()
	{

		 $sql = "SELECT  f.*, fd.* FROM " . DB_PREFIX . "fields f
			LEFT JOIN " . DB_PREFIX . "fields_description fd ON (f.field_id = fd.field_id)
			WHERE fd.language_id = '" . (int) $this->config->get('config_language_id') . "'
			GROUP BY f.field_id
			ORDER BY f.field_order DESC ";


			$query = $this->db->query($sql);

			return $query->rows;

	}

 	public function getFieldsAll()
	{
		$sql   = "SELECT * FROM  " . DB_PREFIX . "review_fields rf	LIMIT 1";
		$query = $this->db->query($sql);
		return $query->rows;
	}


	public function table_exists($tableName)
	{
		$found= false;
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

	public function editComment($comment_id, $data)
	{

		if (!isset($data['customer_id'])) $data['customer_id'] = '0';
		if (!isset($data['parent_id'])) $data['parent_id'] = '0';


		if (isset($data['mark']) && $data['mark']=='product_id') {
			$data['mark'] = 'product_id';
			$data['mark_name'] = 'review';
		} else {
			$data['mark'] = 'record_id';
			$data['mark_name'] = 'comment';
		}



		$this->db->query("UPDATE " . DB_PREFIX . $data['mark_name']." SET
		author = '" . $this->db->escape($data['author']) . "',
		".$data['mark']." = '" . $this->db->escape($data['record_id']) . "',
		customer_id = '" . (int)$data['customer_id'] . "',
		parent_id = '" . (int)$data['parent_id'] . "',
		language_id = '" . (int)$data['language_id'] . "',
		type_id = '" . (int)$data['type_id'] . "',
		cmswidget = '" . (int)$data['cmswidget'] . "',
		text = '" . $data['text'] . "',
		rating = '" . (int) $data['rating'] . "',
		rating_mark = '" . (int) $data['rating_mark'] . "',
		status = '" . (int) $data['status'] . "',
		date_added = '" . $this->db->escape($data['date_available']) . "'
		WHERE ".$data['mark_name']."_id = '" . (int) $comment_id . "'");


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
						review_id = '" . (int) $comment_id . "'
						AND
						mark = '" . $data['mark'] . "'
						LIMIT 1";
						$query = $this->db->query($sql);

                      if (count($query->rows) > 0) {
						$sql = "UPDATE " . DB_PREFIX . "review_fields SET " . $sql_add . " WHERE review_id='" . (int) $comment_id . "' AND mark='".$data['mark']."' ";

                      } else {
			  		$sql = "INSERT INTO " . DB_PREFIX . "review_fields SET " . $sql_add . ", review_id='" . (int) $comment_id . "', mark='".$data['mark']."' ";

					}
					$this->db->query($sql);
				}
			}
		}




		$this->cache->delete('product');
		$this->cache->delete('blog');

	}


	public function deleteComment($comment_id, $mark_name = 'comment')
	{
        $comments_data_old[] =  $comment_id;

		$comments_data_new = $this->getCommentsWithChild($comment_id, $mark_name);

		$comments_data   = array_merge($comments_data_old, $comments_data_new);

        foreach ($comments_data as $num => $comment_id) {
		 $this->db->query("DELETE FROM `" . DB_PREFIX . $mark_name. "` WHERE ".$mark_name."_id = '" . (int) $comment_id . "'");
		 $this->db->query("DELETE FROM `" . DB_PREFIX . "rate_".$mark_name."` WHERE ".$mark_name."_id = '" . (int) $comment_id . "'");
		 $this->db->query("DELETE FROM `" . DB_PREFIX . "agoo_signer` WHERE id = '" . (int) $comment_id . "' AND pointer='".$mark_name."_id'");
        }

		$this->cache->delete('product');
		$this->cache->delete('blog');
	}


	public function getCommentsWithChild($comment_id, $mark_name = 'comment')
	{


			$comments_data = array();

			$sql  = "SELECT r.".$mark_name."_id as id, r.parent_id as parent_id
			FROM " . DB_PREFIX . $mark_name." r
			WHERE
			r.parent_id = '".(int)$comment_id."'
			";
			$query       = $this->db->query($sql);

			foreach ($query->rows as $result) {
				$comments_data[] = $result['id'];

				$comments_data   = array_merge($comments_data, $this->getCommentsWithChild($result['id'], $mark_name));
			}


		return $comments_data;

	}



	public function getComment($comment_id, $mark_name = 'comment')
	{
         if ($mark_name == 'review') {
          $mark_join = 'product';
         } else {
          $mark_join = 'record';
         }

		$sql = "SELECT DISTINCT * , ".$mark_join."_id as record_id,
		(SELECT pd.name FROM " . DB_PREFIX . $mark_join."_description pd
		WHERE
		pd.".$mark_join."_id = r.".$mark_join."_id
		AND
		pd.language_id = '" . (int) $this->config->get('config_language_id') . "') AS record

		FROM " . DB_PREFIX . $mark_name." r
		WHERE
		r.".$mark_name."_id = '" . (int) $comment_id . "'";

		$query = $this->db->query($sql);
		return $query->row;
	}
	public function getComments($data = array())
	{

		if (!empty($data['mark'])) {
         if ($data['mark'] == 'product_id') {
          $mark = 'review';
          $mark_join = 'product';
         } else {
          $mark = 'comment';
          $mark_join = 'record';
         }

		}


		$sql  = "SELECT SQL_CALC_FOUND_ROWS r.".$mark."_id, r.".$data['mark'].", r.cmswidget, r.text, pd.name, r.type_id, r.author, r.rating, r.status, r.date_added, r.language_id
		FROM " . DB_PREFIX . $mark." r
		LEFT JOIN " . DB_PREFIX . $mark_join."_description pd ON (r.".$mark_join."_id = pd.".$mark_join."_id)
		WHERE pd.language_id = '" . (int) $this->config->get('config_language_id') . "'";
		$sort_data = array(
			'pd.name',
			'r.author',
			'r.rating',
			'r.status',
			'r.date_added'
		);
		if (!empty($data['filter_name'])) {
			$sql .= " AND LCASE(pd.name) LIKE '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";
		} //!empty($data['filter_name'])
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} //isset($data['sort']) && in_array($data['sort'], $sort_data)
		else {
			$sql .= " ORDER BY r.date_added";
		}
		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} //isset($data['order']) && ($data['order'] == 'DESC')
		else {
			$sql .= " ASC";
		}
		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			} //$data['start'] < 0
			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			} //$data['limit'] < 1
			$sql .= " LIMIT " . (int) $data['start'] . "," . (int) $data['limit'];
		} //isset($data['start']) || isset($data['limit'])
		$query       = $this->db->query($sql);
		$sql         = "SELECT FOUND_ROWS()";
		$query_found = $this->db->query($sql);
		foreach ($query->rows as $num => $value) {
			$query->rows[$num]['total'] = $query_found->row['FOUND_ROWS()'];
		} //$query->rows as $num => $value
		return $query->rows;
	}

	public function getTotalComments($data)
	{
		$sql   = "SELECT COUNT(*) AS total
		FROM " . DB_PREFIX . "comment r
		";
		$query = $this->db->query($sql);
		return $query->row['total'];
	}
	public function getTotalCommentsAwaitingApproval()
	{
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "comment WHERE status = '0'");
		return $query->row['total'];
	}
	public function getRecordIdbyCommentId($comment_id, $mark = 'comment')
	{
		if ($mark == 'comment') {
			$mark_record = 'record';
		} else {
           $mark_record = 'product';
		}

		$sql   = "SELECT DISTINCT * FROM " . DB_PREFIX . $mark." r WHERE r.".$mark."_id = '" . (int) $comment_id . "'";
		$query = $this->db->query($sql);
		return $query->row[$mark_record.'_id'];
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

	public function deleteKarma($id, $mark_name = 'comment')
	{
		$sql = "DELETE FROM `" . DB_PREFIX . "rate_".$mark_name."` WHERE rate_id = '" . (int) $id . "'";
		$this->db->query($sql);

		$this->cache->delete('product');
		$this->cache->delete('blog');

		return $sql;

	}

}
?>