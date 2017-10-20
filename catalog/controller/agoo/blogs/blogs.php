<?php
/* All rights reserved belong to the module, the module developers http://opencartadmin.com */
// http://opencartadmin.com © 2011-2016 All Rights Reserved
// Distribution, without the author's consent is prohibited
// Commercial license
class ControllerAgooBlogsBlogs extends Controller
{
	private $error = array();
	protected $data;

	public function index($data)
	{
		$this->data = $data;
		$this->language->load('agoo/blogs/blogs');
		$this->data['type'] = 'blogs';
		$blogs_flag_work    = true;
		if (!isset($this->data['settings']['image_adaptive_status']))
			$this->data['settings']['image_adaptive_status'] = true;
		if (isset($this->data['settings']['title_list_latest'][$this->config->get('config_language_id')])) {
			$this->data['heading_title'] = $this->data['settings']['title_list_latest'][$this->config->get('config_language_id')];
		}
		$this->load->model('record/record');
		$this->load->model('tool/image');
		$this->data['blogies'] = array();
		if ($this->data['blog_path'] != 0) {
			$this->data['blog_link'] = $this->url->link('record/blog', 'blog_id=' . $this->data['blog_path']);
		} else {
			$this->data['blog_link'] = '';
		}
		$blogs = $this->model_record_blog->getBlogs();
		if (isset($this->data['settings']['blogs'])) {
			foreach ($this->data['settings']['blogs'] as $num => $blog_id) {
				$settings_blog[$blog_id] = $blog_id;
			}
			foreach ($this->data['settings']['blogs'] as $num => $blog_id) {
				if (isset($settings_blog[$blog_id]) && isset($blogs[$blog_id])) {
					$blogies[$blog_id] = $blogs[$blog_id];
				}
			}
		} else {
			$this->data['settings']['blogs'] = $settings_blog = $blogies = array();
		}
		if (isset($blogies) && count($blogies) > 0) {
			foreach ($blogies as $blog) {
				if (isset($blog['blog_id'])) {
					$blog_info = $blog;
					if ($blog_info) {
						if ($blog_info['image']) {
							if (isset($this->data['settings']['avatar']['width']) && isset($this->data['settings']['avatar']['height']) && $this->data['settings']['avatar']['width'] != "" && $this->data['settings']['avatar']['height'] != "") {
								$thumb = $this->model_tool_image->resizeme($blog_info['image'], $this->data['settings']['avatar']['width'], $this->data['settings']['avatar']['height'], $this->data['settings']['image_adaptive_status']);
							} else {
								$thumb = $this->model_tool_image->resizeme($blog_info['image'], 150, 150, $this->data['settings']['image_adaptive_status']);
							}
						} else {
							$thumb = '';
						}
					} else {
						$thumb = '';
					}
					$data         = array(
						'filter_blog_id' => $blog['blog_id'],
						'filter_sub_blog' => false
					);
					$record_total = false;
					if ((isset($this->data['settings']['counting']) && $this->data['settings']['counting']) || !isset($this->data['settings']['counting'])) {
						$record_total = $this->model_record_record->getTotalRecords($data);
					}
					if (isset($this->request->get['blog_id'])) {
						$blog_id_path_array = explode('_', (string) $this->request->get['blog_id']);
						$blog_id_path       = end($blog_id_path_array);
					} else {
						$blog_id_path_array = array();
						$blog_id_path       = false;
					}
					$this->load->model('record/path');
					$blog_href       = $this->model_record_path->pathbyblog($blog['blog_id']);
					$blog_href_array = explode('_', (string) $blog_href['path']);
					$pass            = false;
					if (in_array($blog_id_path, $blog_href_array) && ($blog['blog_id'] != $blog_id_path)) {
						$pass = true;
					}
					$active = false;
					if (isset($this->request->get['blog_id']) && !isset($this->request->get['record_id'])) {
						if ($blog['blog_id'] == $blog_id_path) {
							$active = true;
						}
					}
					$pass = 'none';
					if (!$active && $pass)
						$pass = 'pass';
					$this->data['blogs'][] = array(
						'blog_id' => $blog['blog_id'],
						'parent_id' => $blog['parent_id'],
						'sort' => $blog['sort_order'],
						'blog_design' => unserialize($blog_info['design']),
						'name' => $blog['name'],
						'count' => $record_total,
						'meta' => $blog['meta_description'],
						'thumb' => $thumb,
						'href' => $this->url->link('record/blog', 'blog_id=' . $blog_href['path']),
						'path' => $blog_href['path'],
						'display' => true,
						'active' => $pass,
						'act' => $active
					);
				}
			}
		}
		if (isset($this->data['blogs']) && count($this->data['blogs']) > 0) {
			$aparent = Array();
			$ablog   = Array();
			foreach ($this->data['blogs'] as $num => $data) {
				$aparent[$data['parent_id']] = true;
				$ablog[$data['blog_id']]     = true;
			}
			reset($this->data['blogs']);
			foreach ($this->data['blogs'] as $num => $data) {
				if (!isset($ablog[$data['parent_id']])) {
					$this->data['blogs'][$num]['parent_id'] = 0;
				}
			}
			reset($this->data['blogs']);
			for ($i = 0, $c = count($this->data['blogs']); $i < $c; $i++) {
				$new_arr[$this->data['blogs'][$i]['parent_id']][] = $this->data['blogs'][$i];
			}
			$this->data['categories_blogs'] = my_sort_div_blogs($new_arr, 0);
			$lv                             = 0;
			$alv                            = 0;
			foreach ($this->data['categories_blogs'] as $num => $mblogs) {
				$path_parts = explode('_', (string) $this->data['blog_path']);
				$blog_parts = explode('_', (string) $mblogs['path']);
				$iarr       = array_intersect($path_parts, $blog_parts);
				$active     = 'none';
				$display    = false;
				if (count($iarr) == 0) {
					$active = 'none';
					if ($mblogs['level'] == 0) {
						$display = true;
					}
				}
				if ($mblogs['level'] == $alv) {
					$display = true;
				} else {
					$alv = 0;
				}
				if (count($iarr) == count($path_parts) && count($iarr) == count($blog_parts)) {
					$display = true;
					$active  = 'active';
					$alv     = $mblogs['level'] + 1;
				}
				if ((count($iarr) > 0) && ($mblogs['level'] <= count($iarr)) && $active != 'active') {
					$display = true;
					if ($mblogs['level'] != count($iarr)) {
						$active = 'pass';
						$lv     = $mblogs['level'] + 1;
					}
				}
				if ($display) {
					$display = true;
				} else {
					if ($mblogs['level'] > $lv) {
						$lv      = 0;
						$display = false;
					}
				}
				$this->data['categories_blogs'][$num]['active']  = $active;
				$this->data['categories_blogs'][$num]['display'] = $display;
			}
		}
		if (isset($this->data['settings']['template']) && $this->data['settings']['template'] != '') {
			$this->data['template'] = '/template/agootemplates/widgets/blogs/' . $this->data['settings']['template'];
		} else {
			$this->data['template'] = '/template/agootemplates/widgets/blogs/blog.tpl';
		}
		if ($blogs_flag_work) {
			$this->data['blogs_template'] = $this->data['template'];
		} else {
			$this->data['blogs_template'] = '';
		}
		return $this->data;
	}
}
if (!function_exists('my_sort_div_blogs')) {
	function my_sort_div_blogs($data, $parent = 0, $lev = -1)
	{
		$arr = $data[$parent];
		usort($arr, 'compareblogs');
		$lev = $lev + 1;
		for ($i = 0; $i < count($arr); $i++) {
			$arr[$i]['level']               = $lev;
			$z[]                            = $arr[$i];
			$z[count($z) - 1]['flag_start'] = 1;
			$z[count($z) - 1]['flag_end']   = 0;
			if (isset($data[$arr[$i]['blog_id']])) {
				$m = my_sort_div_blogs($data, $arr[$i]['blog_id'], $lev);
				$z = array_merge($z, $m);
			}
			if (isset($z[count($z) - 1]['flag_end']))
				$z[count($z) - 1]['flag_end']++;
			else
				$z[count($z) - 1]['flag_end'] = 1;
		}
		return $z;
	}
}
