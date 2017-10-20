<?php
class ModelModuleStickers extends Model {

  public function getStickers() {
    $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "stickers`;");
    return $query->rows;
  }

    public function getBestSeller($limit) {
      $product_id_data_seller = array();

      $query = $this->db->query("SELECT op.product_id, SUM(op.quantity) AS total FROM " . DB_PREFIX . "order_product op LEFT JOIN `" . DB_PREFIX . "order` o ON (op.order_id = o.order_id) LEFT JOIN `" . DB_PREFIX . "product` p ON (op.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE o.order_status_id > '0' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' GROUP BY op.product_id ORDER BY total DESC LIMIT " . (int)$limit);

      foreach ($query->rows as $result) {
        $product_id_data_seller[] = $result['product_id'];
      }
    return $product_id_data_seller;
  }

}
?>