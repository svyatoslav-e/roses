<?php
/* All rights reserved belong to the module, the module developers http://opencartadmin.com */
// http://opencartadmin.com © 2011-2016 All Rights Reserved
// Distribution, without the author's consent is prohibited
// Commercial license
class ControllerAgooReviewsReviews extends Controller
{
	private $error = array();
	protected  $data;

	public function index($data)
	{
		$this->data = $data;
		$this->config->set("blog_work", true);


        $this->data['reviews_template'] = 'agoo/reviews/reviews.tpl';
       	$this->language->load('agoo/reviews/reviews');

		if (isset($this->data['id'])) {
           	$this->load->model('catalog/blog');
        	$this->load->model('catalog/category');
			$this->data['categories'] = $this->model_catalog_blog->getCategories(0);
			$this->data['cat'] = $this->model_catalog_category->getCategories(0);
		}


        if (!isset($this->data['id'])) {
         $this->data['id'] = false;
        }
		if (isset($this->data['id']) && !isset($this->data['ascp_widgets'][$this->data['id']]['anchor'])) {
			$this->data['ascp_widgets'][$this->data['id']]['anchor'] = '';
		}

		if (isset($this->data['id']) && !isset($this->data['ascp_widgets'][$this->data['id']]['admin_name'])) {
			$this->data['ascp_widgets'][$this->data['id']]['admin_name'] = 'admin';
		}
		if (isset($this->data['id']) && !isset($this->data['ascp_widgets'][$this->data['id']]['admin_color'])) {
			$this->data['ascp_widgets'][$this->data['id']]['admin_color'] = '#FCFCFC';
		}


		$this->data['block_reviews_width_templates'] = array(
		$this->language->get('entry_block_reviews_width_templates_2') => '49%',
		$this->language->get('entry_block_reviews_width_templates_3') => '32%',
		$this->language->get('entry_block_reviews_width_templates_4') => '24%',
		$this->language->get('entry_block_reviews_width_templates_5') => '19%',
		$this->language->get('entry_value_templates_clear') => ""
		);


$this->data['ascp_widgets'][$this->data['id']]['anchor_templates'] = array(

$this->language->get('entry_anchor_templates_html') => "$('#cmswidget-'+cmswidget).remove();
data = $(data).html();
$('".$this->language->get('text_anchor_templates_selector')."').html(data);",

$this->language->get('entry_anchor_templates_prepend') => "$('#cmswidget-'+cmswidget).remove();
data = $(data).html();
$('".$this->language->get('text_anchor_templates_selector')."').prepend(data);",

$this->language->get('entry_anchor_templates_append') => "$('#cmswidget-'+cmswidget).remove();
data = $(data).html();
$('".$this->language->get('text_anchor_templates_selector')."').append(data);",

$this->language->get('entry_anchor_templates_before') => "$('#cmswidget-'+cmswidget).remove();
data = $(data).html();
$('".$this->language->get('text_anchor_templates_selector')."').before(data);",

$this->language->get('entry_anchor_templates_after') => "$('#cmswidget-'+cmswidget).remove();
data = $(data).html();
$('".$this->language->get('text_anchor_templates_selector')."').after(data);",

$this->language->get('entry_anchor_templates_clear') => ""
);

if (SC_VERSION > 15) {
$this->data['ascp_widgets'][$this->data['id']]['box_begin_templates'] = array(
$this->language->get('entry_box_begin_templates_empty') => '<div>',
$this->language->get('entry_anchor_templates_clear') => ""
);
} else {
$this->data['ascp_widgets'][$this->data['id']]['box_begin_templates'] = array(
$this->language->get('entry_box_begin_templates_empty') => '<div>',
$this->language->get('entry_anchor_templates_clear') => ""
);

}

if (SC_VERSION > 15) {
$this->data['ascp_widgets'][$this->data['id']]['box_end_templates'] = array(
$this->language->get('entry_box_end_templates_empty') => '</div>',
$this->language->get('entry_anchor_templates_clear') => ""
);
} else {
$this->data['ascp_widgets'][$this->data['id']]['box_end_templates'] = array(
$this->language->get('entry_box_end_templates_empty') => '</div>',
$this->language->get('entry_anchor_templates_clear') => ""
);

}
        return $this->data;
	}


	public function settings($data)
	{
		$this->data = $data;
		$this->config->set("blog_work", true);

       	$this->language->load('agoo/reviews/reviews');

		if (!isset($this->data['ascp_settings']['reviews_widget_status'])) {
			$this->data['ascp_settings']['reviews_widget_status'] = true;
		}


		$this->data['header'] 	= '';
		$this->data['menu'] 	= '';
		$this->data['footer'] 	= '';
		$this->data['column_left'] 	= '';

		$this->template = 'agoo/reviews/settings.tpl';
        $this->data['language'] = $this->language;



        if (SC_VERSION < 20) {
			$html = $this->render();
		} else {
			$html = $this->load->view($this->template, $this->data);
		}

        $this->data['widgets']['reviews']['code'] = 'reviews';
        $this->data['widgets']['reviews']['name'] = $this->language->get('text_widget_reviews_settings');
        $this->data['widgets']['reviews']['order'] = $this->language->get('order_reviews');
        $this->data['widgets']['reviews']['html'] = $html;

	    return $this->data;

	}


	public function widget_scripts($data)
	{
		$this->data = $data;
		$this->config->set("blog_work", true);
       	$this->language->load('agoo/reviews/reviews');


		$this->template = 'agoo/reviews/widget_scripts.tpl';


		$this->data['header'] 	= '';
		$this->data['menu'] 	= '';
		$this->data['footer'] 	= '';
		$this->data['column_left'] 	= '';
        $this->data['language'] = $this->language;

        if (SC_VERSION < 20) {
			$html = $this->render();
		} else {
			$html = $this->load->view($this->template, $this->data);
		}

        $this->data['widget_scripts']['reviews'] = $html;

	    return $this->data;

	}

	public function widget_services($data)
	{
		$this->data = $data;
		$this->config->set("blog_work", true);
       	$this->language->load('agoo/reviews/reviews');


		$this->template = 'agoo/reviews/widget_services.tpl';


		$this->data['header'] 	= '';
		$this->data['menu'] 	= '';
		$this->data['footer'] 	= '';
		$this->data['column_left'] 	= '';
        $this->data['language'] = $this->language;

        if (SC_VERSION < 20) {
			$html = $this->render();
		} else {
			$html = $this->load->view($this->template, $this->data);
		}
        $this->data['widget_services']['reviews'] = $html;

	    return $this->data;
	}


	public function createTables($data)
	{

$sql[26] = "
CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "fields` (
  `field_id` int(11) NOT NULL AUTO_INCREMENT,
  `field_name` varchar(255) COLLATE utf8_general_ci NOT NULL,
  `field_image` varchar(255) COLLATE utf8_general_ci DEFAULT NULL,
  `field_type` varchar(255) COLLATE utf8_general_ci DEFAULT NULL,
  `field_must` tinyint(1) NOT NULL DEFAULT '0',
  `field_order` int(11) NOT NULL DEFAULT '0',
  `field_status` tinyint(1) NOT NULL DEFAULT '1',
  `field_public` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`field_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1 ;
";

$sql[27] = "
CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "fields_description` (
  `field_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `field_description` text COLLATE utf8_general_ci NOT NULL,
  `field_error` text COLLATE utf8_general_ci NOT NULL,
  `field_value` text COLLATE utf8_general_ci NOT NULL,
  KEY (`field_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1 ;
";

$sql[4] = "
CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "comment` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `record_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `author` varchar(64) COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `text` text COLLATE utf8_general_ci NOT NULL,
  `rating` int(1) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`comment_id`),
  KEY `record_id` (`record_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1 ;
";

$sql[20] = "
CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "rate_comment` (
  `comment_id` int(11) unsigned NOT NULL,
  `customer_id` int(11) unsigned NOT NULL,
  `delta` float(9,3) DEFAULT '0.000',
  KEY `comment_id` (`comment_id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;
";

$sql[23] = "
CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "rate_review` (
  `review_id` int(11) unsigned NOT NULL,
  `customer_id` int(11) unsigned NOT NULL,
  `delta` float(9,3) DEFAULT '0.000',
  KEY `review_id` (`review_id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;
";

$sql[25] = "
CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "review_fields` (
	 `review_id` int(11) NOT NULL,
	  KEY `review_id` (`review_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";

		foreach ($sql as $qsql) {
			$query = $this->db->query($qsql);
		}

		$r = $this->db->query("DESCRIBE " . DB_PREFIX . "fields_description `field`");
		if ($r->num_rows == 0) {
			$msql = "ALTER TABLE `" . DB_PREFIX . "fields_description` ADD `field` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `field_value`";
			$query = $this->db->query($msql);
		}

		$r = $this->db->query("DESCRIBE " . DB_PREFIX . "fields `field_public`");
		if ($r->num_rows == 0) {
			$msql = "ALTER TABLE `" . DB_PREFIX . "fields` ADD `field_public` tinyint(1) NOT NULL DEFAULT '1' AFTER `field_status`";
			$query = $this->db->query($msql);
		}

		$r = $this->db->query("DESCRIBE " . DB_PREFIX . "review `cmswidget`");
		if ($r->num_rows == 0) {
			$msql = "ALTER TABLE `" . DB_PREFIX . "review` ADD `cmswidget` INT(11) NOT NULL AFTER `status` ";
			$query = $this->db->query($msql);
		}
		$r = $this->db->query("DESCRIBE " . DB_PREFIX . "comment `cmswidget`");
		if ($r->num_rows == 0) {
			$msql = "ALTER TABLE `" . DB_PREFIX . "comment` ADD `cmswidget` INT(11) NOT NULL AFTER `status` ";
			$query = $this->db->query($msql);
		}

		$r = $this->db->query("DESCRIBE `" . DB_PREFIX . "review` `language_id`");
		if ($r->num_rows == 0) {
			$msql = "ALTER TABLE `" . DB_PREFIX . "review` ADD `language_id` INT(11) NOT NULL DEFAULT '".$this->config->get('config_language_id')."' AFTER `status` ";
			$query = $this->db->query($msql);
		}
		$r = $this->db->query("DESCRIBE `" . DB_PREFIX . "comment` `language_id`");
		if ($r->num_rows == 0) {
			$msql = "ALTER TABLE `" . DB_PREFIX . "comment` ADD `language_id` INT(11) NOT NULL DEFAULT '".$this->config->get('config_language_id')."' AFTER `status` ";
			$query = $this->db->query($msql);
		}

		$r = $this->db->query("DESCRIBE " . DB_PREFIX . "customer `avatar`");
		if ($r->num_rows == 0) {
			$msql = "ALTER TABLE `" . DB_PREFIX . "customer` ADD `avatar` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL AFTER `lastname`";
			$query = $this->db->query($msql);
		}

		$r = $this->db->query("DESCRIBE " . DB_PREFIX . "review_fields `review_id`");
		if ($r->num_rows == 0) {
			$msql = "ALTER TABLE `" . DB_PREFIX . "review_fields` ADD `review_id` INT( 11 )  NOT NULL ";
			$query = $this->db->query($msql);
		}
		$r = $this->db->query("DESCRIBE " . DB_PREFIX . "review_fields `mark`");
		if ($r->num_rows == 0) {
			$msql = "ALTER TABLE `" . DB_PREFIX . "review_fields` ADD `mark` VARCHAR( 255 ) CHARACTER SET ascii COLLATE ascii_bin NOT NULL AFTER `review_id`";
			$query = $this->db->query($msql);
		}

		$r = $this->db->query("DESCRIBE " . DB_PREFIX . "review_fields `product_id`");
		if ($r->num_rows == 0) {
			$msql = "ALTER TABLE `" . DB_PREFIX . "review_fields` ADD `product_id` INT( 11 ) NOT NULL FIRST";
			$query = $this->db->query($msql);
		}


		$r = $this->db->query("SHOW KEYS FROM `" . DB_PREFIX . "review_fields`  WHERE Key_name ='PRIMARY'");
		if ($r->num_rows != 0) {
			$msql = "ALTER TABLE `" . DB_PREFIX . "review_fields`  DROP PRIMARY KEY ";
			$query = $this->db->query($msql);
		}

		$r = $this->db->query("SHOW KEYS FROM `" . DB_PREFIX . "review_fields` WHERE Key_name ='review_id'");
		if ($r->num_rows == 0) {
			$msql = "ALTER TABLE `" . DB_PREFIX . "review_fields`  ADD INDEX (`review_id`)";
			$query = $this->db->query($msql);
		}


		$r = $this->db->query("SHOW KEYS FROM `" . DB_PREFIX . "review_fields` WHERE Key_name ='product_id'");
		if ($r->num_rows == 0) {
			$msql = "ALTER TABLE `" . DB_PREFIX . "review_fields` ADD INDEX (`product_id`)";
			$query = $this->db->query($msql);
		}

		$msql = "UPDATE `" . DB_PREFIX . "review_fields` SET `mark`='product_id' WHERE `mark`=''";
		$query = $this->db->query($msql);


		$r = $this->db->query("DESCRIBE " . DB_PREFIX . "comment `sorthex`");
		if ($r->num_rows == 0) {
			$msql = "ALTER TABLE `" . DB_PREFIX . "comment` ADD `sorthex` VARCHAR( 255 ) CHARACTER SET ascii COLLATE ascii_bin NOT NULL AFTER `rating`";
			$query = $this->db->query($msql);
		}

		$r = $this->db->query("DESCRIBE " . DB_PREFIX . "rate_comment `rate_id`");
		if ($r->num_rows == 0) {
			$msql = "ALTER TABLE `" . DB_PREFIX . "rate_comment` ADD `rate_id` int(11) AUTO_INCREMENT PRIMARY KEY";
			$query = $this->db->query($msql);
		}

		$r = $this->db->query("DESCRIBE " . DB_PREFIX . "rate_review `rate_id`");
		if ($r->num_rows == 0) {
			$msql = "ALTER TABLE `" . DB_PREFIX . "rate_review` ADD `rate_id` int(11) AUTO_INCREMENT PRIMARY KEY";
			$query = $this->db->query($msql);
		}


		$r = $this->db->query("DESCRIBE " . DB_PREFIX . "review `sorthex`");
		if ($r->num_rows == 0) {
			$msql = "ALTER TABLE `" . DB_PREFIX . "review` ADD `sorthex` INT(11) NOT NULL AFTER `product_id`";
			$query = $this->db->query($msql);
		}
		$r = $this->db->query("DESCRIBE " . DB_PREFIX . "comment `parent_id`");
		if ($r->num_rows == 0) {
			$msql = "ALTER TABLE `" . DB_PREFIX . "comment` ADD `parent_id` INT(11) NOT NULL AFTER `record_id`";
			$query = $this->db->query($msql);
		}
		$r = $this->db->query("DESCRIBE  " . DB_PREFIX . "review `parent_id`");
		if ($r->num_rows == 0) {
			$msql = "ALTER TABLE `" . DB_PREFIX . "review` ADD `parent_id` INT(11) NOT NULL AFTER `product_id`";
			$query = $this->db->query($msql);
		}
		$r = $this->db->query("DESCRIBE  " . DB_PREFIX . "review `rating_mark`");
		if ($r->num_rows == 0) {
			$msql = "ALTER TABLE `" . DB_PREFIX . "review` ADD `rating_mark` tinyint(1)  NOT NULL DEFAULT '0' AFTER `rating`";
			$query = $this->db->query($msql);
		}

		$r = $this->db->query("DESCRIBE  " . DB_PREFIX . "comment `rating_mark`");
		if ($r->num_rows == 0) {
			$msql = "ALTER TABLE `" . DB_PREFIX . "comment` ADD `rating_mark` tinyint(1)  NOT NULL DEFAULT '0' AFTER `rating`";
			$query = $this->db->query($msql);
		}


		$r = $this->db->query("DESCRIBE  " . DB_PREFIX . "comment `rating_mark`");
		if ($r->num_rows == 1) {
			foreach ($r->rows as $trow) {
				if ($trow['Key'] == ' ' || $trow['Key'] == '') {
					$msql = "ALTER TABLE `" . DB_PREFIX . "comment` ADD INDEX `rating_mark` (`rating_mark`)";
					$query = $this->db->query($msql);
				}
			}
		}

		$r = $this->db->query("DESCRIBE  " . DB_PREFIX . "comment `customer_id`");
		if ($r->num_rows == 1) {
			foreach ($r->rows as $trow) {
				if ($trow['Key'] == ' ' || $trow['Key'] == '') {
					$msql = "ALTER TABLE `" . DB_PREFIX . "comment` ADD INDEX `customer_id` (`customer_id`)";
					$query = $this->db->query($msql);
				}
			}
		}

		$r = $this->db->query("DESCRIBE  " . DB_PREFIX . "review `customer_id`");
		if ($r->num_rows == 1) {
			foreach ($r->rows as $trow) {
				if ($trow['Key'] == ' ' || $trow['Key'] == '' ) {
					$msql = "ALTER TABLE `" . DB_PREFIX . "review` ADD INDEX `customer_id` (`customer_id`)";
					$query = $this->db->query($msql);
				}
			}
		}

		$r = $this->db->query("DESCRIBE  " . DB_PREFIX . "review `rating_mark`");
		if ($r->num_rows == 1) {
			foreach ($r->rows as $trow) {
				if ($trow['Key'] == ' ' || $trow['Key'] == '') {
					$msql = "ALTER TABLE `" . DB_PREFIX . "review` ADD INDEX `rating_mark` (`rating_mark`)";
					$query = $this->db->query($msql);
				}
			}
		}
		$r = $this->db->query("DESCRIBE  " . DB_PREFIX . "comment `rating`");
		if ($r->num_rows == 1) {
			foreach ($r->rows as $trow) {
				if ($trow['Key'] == '' || $trow['Key'] == ' ') {
					$msql = "ALTER TABLE `" . DB_PREFIX . "comment` ADD INDEX `rating` (`rating`)";
					$query = $this->db->query($msql);
				}
			}
		}
		$r = $this->db->query("DESCRIBE  " . DB_PREFIX . "review `rating`");
		if ($r->num_rows == 1) {
			foreach ($r->rows as $trow) {
				if ($trow['Key'] == '' || $trow['Key'] == ' ') {
					$msql = "ALTER TABLE `" . DB_PREFIX . "review` ADD INDEX `rating` (`rating`)";
					$query = $this->db->query($msql);
				}
			}
		}

		$r = $this->db->query("DESCRIBE " . DB_PREFIX . "comment `text`");
		if ($r->num_rows > 0) {
			$msql = "ALTER TABLE `" . DB_PREFIX . "comment` CHANGE `text` `text` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL";
			$query = $this->db->query($msql);
		}
		$r = $this->db->query("DESCRIBE " . DB_PREFIX . "comment `author`");
		if ($r->num_rows > 0) {
			$msql = "ALTER TABLE `" . DB_PREFIX . "comment` CHANGE `author` `author` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL";
			$query = $this->db->query($msql);
		}


		$r = $this->db->query("DESCRIBE `" . DB_PREFIX . "comment` `type_id`");
		if ($r->num_rows == 0) {
			$msql = "ALTER TABLE `" . DB_PREFIX . "comment` ADD `type_id` INT(11) NOT NULL DEFAULT '1' AFTER `language_id`";
			$query = $this->db->query($msql);
		}
		$r = $this->db->query("SHOW KEYS FROM `" . DB_PREFIX . "comment` WHERE Key_name ='type_id'");
		if ($r->num_rows == 0) {
			$msql = "ALTER TABLE `" . DB_PREFIX . "comment`  ADD INDEX (`type_id`)";
			$query = $this->db->query($msql);
		}

		$r = $this->db->query("DESCRIBE `" . DB_PREFIX . "review` `type_id`");
		if ($r->num_rows == 0) {
			$msql = "ALTER TABLE `" . DB_PREFIX . "review` ADD `type_id` INT(11) NOT NULL DEFAULT '1' AFTER `language_id`";
			$query = $this->db->query($msql);
		}

		$r = $this->db->query("SHOW KEYS FROM `" . DB_PREFIX . "review` WHERE Key_name ='type_id'");
		if ($r->num_rows == 0) {
			$msql = "ALTER TABLE `" . DB_PREFIX . "review`  ADD INDEX (`type_id`)";
			$query = $this->db->query($msql);
		}


		$this->script_reviews();

       return $data;

	}

	public function script_reviews($layout_route = 'record/record')
	{
       $this->config->set("blog_work", true);

      if ($this->validate()) {
       $post = false;
		if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validate()) {
			if (isset($this->request->post['layout_route'])) {
				$layout_route = $this->request->post['layout_route'];
				$post = true;
			}
		}

      	$layout_id = $this->get_layout_id_by_route($layout_route);
      	$layout_name = $this->get_layout_name_by_route($layout_route);
       	$this->language->load('module/blog');
        $this->load->model('localisation/language');
        $this->load->model('setting/store');
        $this->load->model('setting/setting');

		$languages = $this->model_localisation_language->getLanguages();
		$stores = $this->model_setting_store->getStores();

		$store_info = $this->model_setting_setting->getSetting('config', 0);
        if (isset($store_info['config_email'])) {
        	$this->data['config_email'] = $store_info['config_email'];
        } else {
          	$this->data['config_email'] = '';
        }

		$ascp_widgets        = $this->model_setting_setting->getSetting('ascp_widgets');
  		if (isset( $ascp_widgets['ascp_widgets'])) {
		 $this->data['ascp_widgets'] = $ascp_widgets['ascp_widgets'];
		} else {
		 $this->data['ascp_widgets'] = Array();
		}
        if ($this->data['ascp_widgets'] == false) {
	        $this->data['ascp_widgets'] = Array();
        }


         $found= false;
         $found_double = false;
         $found_hook = array();

         if (!is_array($this->data['ascp_widgets'])) {
	         $this->data['ascp_widgets'] = array();
         }

         foreach ($this->data['ascp_widgets'] as $num => $val) {

			foreach ($languages as $language) {

				  //$title_list_latest = $this->language->get('text_reviews_for_module').$layout_name;
				  $title_list_latest = $this->language->get('text_reviews_for_module');
		          if (isset($val['title_list_latest']) && $val['title_list_latest'][$language['language_id']]==$title_list_latest) {
		           $id_new = $found_hook[$num] = $num;
		           $found_double= true;
		           $found= true;
		          }
			}

		          if (isset($val['type']) && $val['type']=='treecomments' && !$post) {
	    	       $id_new = $found_hook[$num] = $num;
	    	       $found_double= true;
	    	       $found= true;
	        	  }

         }
if (SC_VERSION > 15) {

$anchor=<<<EOF
$('#cmswidget-'+cmswidget).remove();
tabs = $('.nav-tabs').children().length;
data = $(data).html();
$('.nav-tabs').append('<li><a data-toggle=\'tab\' href=\'#tab-html-'+cmswidget+'\'>'+heading_title+'</a></li>');
$('#content .tab-content:first').append($(data).html());
if (tabs == 0 || $('.nav-tabs').children().filter('.active').length == 0) $('a[href$=\'#tab-html-'+cmswidget+'\']').click();
EOF;

} else {

$anchor=<<<EOF
tab_select[cmswidget] = '#tab-review';
$('#cmswidget-'+cmswidget).remove();
data = $(data).html();
$(tab_select[cmswidget]).html($(data).html());
EOF;

}


$box_begin=<<<EOF
<div id="tab-html-{CMSWIDGET}" class="tab-pane">
	<div class="box" style="display: block">
		<div class="box-content bordernone">
EOF;

$box_end=<<<EOF
		</div>
	</div>
</div>
EOF;


         if (!$found || $post) {
         if(!$found_double) {
		  $ar = Array(
		   'remove' => '',
           'type' => 'treecomments',
            'template' => '',
            'blog_template_comment' => '',
            'langfile' => '',
            'anchor' => $anchor,
            'cached' => '1',
            'number_comments' => '20',
            'status' => '1',
            'status_reg' => '0',
            'status_now' => '1',
            'karma' => '1',
            'karma_reg' => '0',
            'rating_num' => '',
            'avatar_status' => '1',
            'avatar_width' => '50',
            'avatar_height' => '50',
            'buyer_status' => '1',
            'comments_email' => $this->data['config_email'],
            'admin_name' => 'admin',
            'admin_color' => '#fafafa',
            'order' => 'sort',
            'order_ad' => 'desc',
            'comment_must' => '1',
            'rating' => '1',
            'rating_must' => '0',
            'visual_rating' => '1',
            'fields_view' => '1',
            'view_captcha' => '1',
            'signer' => '1',
            'visual_editor' => '1',
            'bbwidth' => '160',
            'record' => '',
            'recordid' => '',
            'handler' => '',
            'box_begin' => $box_begin,
            'box_end' => $box_end,
            'doc_ready' => '1',
            'ajax' => '0',
            'reserved' => '',
           'store' => Array ('0' => '0'),
           'customer_groups' => Array
                (
                    '0' =>  $this->config->get('config_customer_group_id'),
                    '1' => '-1',
                    '2' => '-2',
                    '3' => '-3'
                )
        	);


		foreach ($stores as $num => $store) {
		 $ar['store'][] = $store['store_id'];
		}

		foreach ($languages as $language) {
			//$title_list_latest = $this->language->get('text_reviews_for_module').$layout_name;
			$title_list_latest = $this->language->get('text_reviews_for_module');
			$ar['title_list_latest'][$language['language_id']] = $title_list_latest;
		}

       	 $ascp_widgets['ascp_widgets'] = $this->data['ascp_widgets'];

      	 $id_new = 1;

	      	 foreach($ascp_widgets['ascp_widgets'] as $id => $massa) {
	           if ($id_new!=$id) {
	             if (!isset($ascp_widgets['ascp_widgets'][$id_new])) {
	                break;
	             }
	           }
	           $id_new++;
	      	 }

          $ascp_widgets['ascp_widgets'][$id_new] = $ar;

       	  $this->model_setting_setting->editSetting('ascp_widgets', $ascp_widgets);
        }
       }


		$blog_module        = $this->model_setting_setting->getSetting('blog_module');
        if (isset($blog_module['blog_module'])) {
		 $this->data['blog_module'] = $blog_module['blog_module'];
		} else {
		 $this->data['blog_module']  = Array();
		}
        if ($this->data['blog_module'] == false) {
	        $this->data['blog_module'] = Array();
        }


		$ascp_widgets        = $this->model_setting_setting->getSetting('ascp_widgets');
        if (isset($ascp_widgets['ascp_widgets'])) {
		 $this->data['ascp_widgets'] = $ascp_widgets['ascp_widgets'];
		} else {
		 $this->data['ascp_widgets']  = Array();
		}
        if ($this->data['ascp_widgets'] == false) {
	        $this->data['ascp_widgets'] = Array();
        }

         $found_hook= Array();
         foreach ($this->data['ascp_widgets'] as $num => $val) {
          if (isset($val['type']) && $val['type']=='treecomments') {
           $found_hook[$num] = $num;
          }
         }

         if ($post) $found_hook[$id_new] = $id_new;

         $found= false;
         $found_scheme = '';
         foreach ($this->data['blog_module'] as $num => $val) {
          if (isset($val['what']) && isset($found_hook[$val['what']])) {

          foreach ($val['layout_id'] as $number => $lay_id ) {
           	if ($lay_id == $layout_id) {
           		$found= true;
           		$found_scheme = $num;
           	}
           }
          }
         }



        $ar = Array();
        if (!$found && !empty($found_hook)) {
           $ar = Array(
		   'url_template' => '0',
           'url' => '',
           'position' => 'content_bottom',
           'status' => '1',
           'sort_order' => '0',
           'what' => $found_hook[$id_new],
           'layout_id' => Array('0'=> $layout_id)
        	);

       	 $blog_module['blog_module'] = $this->data['blog_module'];

      	 $id_new = 1;
      	 foreach($blog_module['blog_module'] as $id => $massa) {
	             if (!isset($blog_module['blog_module'][$id_new])) {
	                break;
	             }
           $id_new++;
      	 }

         $blog_module['blog_module'][$id_new] = $ar;

       	 $this->model_setting_setting->editSetting('blog_module', $blog_module);
        }



      if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validate()) {
   			$html = $this->language->get('ok_create_tables');
			$this->response->setOutput($html);
		}
	 }
	}

	private function table_exists($tableName)
	{
		$found= false;
		$like   = addcslashes($tableName, '%_\\');
		$result = $this->db->query("SHOW TABLES LIKE '" . $this->db->escape($like) . "';");
		$found  = $result->num_rows > 0;
		return $found;
	}

	private function validate()
	{
		$this->language->load('module/blog');
		if (!$this->user->hasPermission('modify', 'module/blog')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if (isset($this->request->post['ascp_widgets'])) {
			foreach ($this->request->post['ascp_widgets'] as $num => $value) {
				if (isset($value['addfields']) && !empty($value['addfields'])) {
					foreach ($value['addfields'] as $num_add => $value_add) {
						if ($value_add['field_name'] == '') {
							$this->error['warning'] = $this->language->get('error_addfields_name');
						} else {
							if (!preg_match('/^[a-z][a-z0-9-_]{3,30}$/i', $value_add['field_name'])) {
								$this->error['warning'] = $this->language->get('error_addfields_name');
							}
						}
					}
				}
			}
		}
		if (!$this->error) {
			return true;
		} else {
			$this->request->post = array();
			return false;
		}
	}

	private function get_layout_id_by_route($route) {
		if (!isset($found_layout_id)) {

				$msql = "SELECT * FROM `" . DB_PREFIX . "layout_route` WHERE `route`='".$route."';";
				$query = $this->db->query($msql);

				if (count($query->rows) <= 0) {
                   return false;
				} else {
					$found_layout_id = $query->row['layout_id'];
				}

		}
        return $found_layout_id;
	}

	private function get_layout_name_by_route($route) {
		if (!isset($found_layout_name)) {

				$msql = "SELECT * FROM `" . DB_PREFIX . "layout_route` lr
				LEFT JOIN `" . DB_PREFIX . "layout` l ON (lr.layout_id = l.layout_id)
				WHERE lr.route='".$route."';";
				$query = $this->db->query($msql);

				if (count($query->rows) <= 0) {
                   return false;
				} else {
					$found_layout_name = $query->row['name'];
				}

		}
        return $found_layout_name;
	}

}

