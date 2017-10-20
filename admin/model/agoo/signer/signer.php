<?php
/* All rights reserved belong to the module, the module developers http://opencartadmin.com */
// http://opencartadmin.com © 2011-2016 All Rights Reserved
// Distribution, without the author's consent is prohibited
// Commercial license
class ModelagooSignerSigner extends Model
{
	public function getStatus($id, $customer_id, $pointer = 'record_id', $email)
	{
		if ($customer_id!=0) {
		 $sql_customer = " AND  customer_id =" . (int) $customer_id . " ";
		} else {
		 if ($email) {
		 $sql_customer = " AND  email = '" . $this->db->escape($email) . "' ";
		 } else {
		 	return false;
		 	}
		}

		$sql   = "SELECT * FROM `" . DB_PREFIX . "agoo_signer` WHERE id =" . (int) $id . $sql_customer. " AND pointer='" . $this->db->escape($pointer) . "' LIMIT 1";
		$query = $this->db->query($sql);

		if ($query && !empty($query->row)) {

			return $query->row;
			}
		else {
			return false;
			}
	}
	public function getStatusId($id, $pointer = 'record_id')
	{
		$sql   = "SELECT * FROM `" . DB_PREFIX . "agoo_signer` WHERE id =" . (int) $id . " AND pointer='" . $this->db->escape($pointer) . "'";
		$query = $this->db->query($sql);
		return $query->rows;
	}
	public function getCustomer($customer_id)
	{
		$sql   = "SELECT * FROM `" . DB_PREFIX . "customer` WHERE customer_id =" . (int) $customer_id . " LIMIT 1";
		$query = $this->db->query($sql);
		return $query->row;
	}
	public function setStatus($id, $customer_id, $pointer = 'record_id', $email)
	{

		if ($customer_id!=0) {
			$customer = $this->getCustomer($customer_id);
			$email = $customer['email'];
		}

		 if ($email && $email!='') {
		 	$sql_email = " , email = '" . $this->db->escape($email) . "' ";
		 } else {
		    $sql_email = '';
		 }


		$datetime = date('Y-m-d H:i:s');
		$sql      = "INSERT INTO `" . DB_PREFIX . "agoo_signer` SET  pointer='" . $this->db->escape($pointer) . "', id =" . (int) $id . ", customer_id =" . (int) $customer_id . $sql_email.", date='" . $datetime . "' ";
		$query    = $this->db->query($sql);
		if ($query) {
			return true;
		} //$query
		else {
			return false;
		}
	}
	public function removeStatus($id, $customer_id, $pointer = 'record_id', $email)
	{
		if ($customer_id!=0) {
		 $sql_customer = " AND  customer_id =" . (int) $customer_id . " ";
		} else {
		 if ($email) {
		 $sql_customer = " AND  email = '" . $this->db->escape($email) . "' ";
		 } else {
		 	return false;
		 	}
		}

		$sql   = "DELETE FROM `" . DB_PREFIX . "agoo_signer` WHERE id =" . (int) $id . $sql_customer. " AND pointer='" . $this->db->escape($pointer) . "'";
		$query = $this->db->query($sql);
		if ($query) {
			return true;
		} //$query
		else {
			return false;
		}
	}

	public function getComment($comment_id, $mark)
	{

		if ($mark=="product_id") {
		$table ="review";
		$comm = 'review_id';
		} else {
		$table ="comment" ;
		$comm = 'comment_id';
		}

		$sql   = "
		SELECT r.*
		FROM " . DB_PREFIX . $table." r

		WHERE r.".$comm." = '" . (int) $comment_id . "'
		";
		$query = $this->db->query($sql);
		return $query->row;
	}


}
?>