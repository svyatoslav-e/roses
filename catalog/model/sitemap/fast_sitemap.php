<?php

/*
 * Fast Sitemap [xml]
 * by dub(nix)
 */

class ModelSitemapFastSitemap extends Model {

	public function getInformations($option) {

		if ($option['cache_st'] == 1) {
			$info_xml = $this->cache->get('fast_sitemap.info.' . $option['lid'] . '.' . $option['sid']);

			if (!$info_xml) {
				$info_xml = array();

				$query = $this->db->query("

					SELECT
						i.information_id
					FROM " . DB_PREFIX . "information i
					INNER JOIN " . DB_PREFIX . "information_description id ON i.information_id = id.information_id
					INNER JOIN " . DB_PREFIX . "information_to_store i2s ON id.information_id = i2s.information_id
					WHERE i.status = 1
						AND id.language_id = '" . $option['lid'] . "'
						AND i2s.store_id = '" . $option['sid'] . "'

				");

				$info_xml = $query->rows;

				$this->cache->set('fast_sitemap.info.' . $option['lid'] . '.' . $option['sid'], $info_xml);
			}

			return $info_xml;
		} else {
			$query = $this->db->query("

					SELECT
						i.information_id
					FROM " . DB_PREFIX . "information i
					INNER JOIN " . DB_PREFIX . "information_description id ON i.information_id = id.information_id
					INNER JOIN " . DB_PREFIX . "information_to_store i2s ON id.information_id = i2s.information_id
					WHERE i.status = 1
						AND id.language_id = '" . $option['lid'] . "'
						AND i2s.store_id = '" . $option['sid'] . "'

				");

			return $query->rows;
		}
	}

public function getManufacturers($option) {

		if ($option['cache_st'] == 1) {
			$munuf_xml = $this->cache->get('fast_sitemap.munuf.' . $option['lid'] . '.' . $option['sid']);

			if (!$munuf_xml) {
				$munuf_xml = array();

				$query = $this->db->query("

					SELECT
						m.manufacturer_id
					FROM " . DB_PREFIX . "manufacturer m
					INNER JOIN " . DB_PREFIX . "manufacturer_to_store m2s ON m.manufacturer_id = m2s.manufacturer_id
					WHERE m2s.store_id = '" . $option['sid'] . "'

				");

				$munuf_xml = $query->rows;

				$this->cache->set('fast_sitemap.munuf.' . $option['lid'] . '.' . $option['sid'], $munuf_xml);
			}

			return $munuf_xml;
		} else {
			$query = $this->db->query("

				SELECT
					m.manufacturer_id
				FROM " . DB_PREFIX . "manufacturer m
				INNER JOIN " . DB_PREFIX . "manufacturer_to_store m2s ON m.manufacturer_id = m2s.manufacturer_id
				WHERE m2s.store_id = '" . $option['sid'] . "'

			");

			return $query->rows;
		}
	}

	public function getCategories($option) {

		if ($option['cache_st'] == 1) {
			$cat_xml = $this->cache->get('fast_sitemap.cat.' . $option['lid'] . '.' . $option['sid']);

			if (!$cat_xml) {
				$cat_xml = array();

				$query = $this->db->query("

					SELECT
						c.category_id,
						c.date_added,
						c.date_modified
					FROM " . DB_PREFIX . "category c
					INNER JOIN " . DB_PREFIX . "category_description cd ON c.category_id = cd.category_id
					INNER JOIN " . DB_PREFIX . "category_to_store c2s ON c.category_id = c2s.category_id
					WHERE status = 1
						AND cd.language_id = '" . $option['lid'] . "'
						AND c2s.store_id = '" . $option['sid'] . "'

				");

				$cat_xml = $query->rows;

				$this->cache->set('fast_sitemap.cat.' . $option['lid'] . '.' . $option['sid'], $cat_xml);
			}

			return $cat_xml;
		} else {
			$query = $this->db->query("

				SELECT
					c.category_id,
					c.date_added,
					c.date_modified
				FROM " . DB_PREFIX . "category c
				INNER JOIN " . DB_PREFIX . "category_description cd ON c.category_id = cd.category_id
				INNER JOIN " . DB_PREFIX . "category_to_store c2s ON c.category_id = c2s.category_id
				WHERE status = 1
					AND cd.language_id = '" . $option['lid'] . "'
					AND c2s.store_id = '" . $option['sid'] . "'

			");

			return $query->rows;
		}
	}	

	public function getProducts($option) {

	if ($option['cache_st'] == 1) {
		$prod_xml = $this->cache->get('fast_sitemap.prod.' . $option['lid'] . '.' . $option['sid']);

		if (!$prod_xml) {
			$prod_xml = array();

			$query = $this->db->query("

				SELECT
					p.product_id,
					p.date_added,
					p.date_modified
				FROM " . DB_PREFIX . "product p
				INNER JOIN " . DB_PREFIX . "product_description pd ON p.product_id = pd.product_id
				INNER JOIN " . DB_PREFIX . "product_to_store p2s ON p.product_id = p2s.product_id
				WHERE status = 1
					AND pd.language_id = '" . $option['lid'] . "'
					AND p2s.store_id = '" . $option['sid'] . "'

			");

			$prod_xml = $query->rows;

			$this->cache->set('fast_sitemap.prod.' . $option['lid'] . '.' . $option['sid'], $prod_xml);
		}

		return $prod_xml;
		} else {
			$query = $this->db->query("

				SELECT
					p.product_id,
					p.date_added,
					p.date_modified
				FROM " . DB_PREFIX . "product p
				INNER JOIN " . DB_PREFIX . "product_description pd ON p.product_id = pd.product_id
				INNER JOIN " . DB_PREFIX . "product_to_store p2s ON p.product_id = p2s.product_id
				WHERE status = 1
					AND pd.language_id = '" . $option['lid'] . "'
					AND p2s.store_id = '" . $option['sid'] . "'

			");

			return $query->rows;
		}

	}

}

?>