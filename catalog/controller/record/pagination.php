<?php
/* All rights reserved belong to the module, the module developers http://opencartadmin.com */
// http://opencartadmin.com © 2011-2016 All Rights Reserved
// Distribution, without the author's consent is prohibited
// Commercial license
class ControllerRecordPagination extends Controller
{
	protected $data;
	public $kzsv = false;

 	public function __construct($registry) 	{
			parent::__construct($registry);


	}

	public function index($params = array()) {
			$output = '';

           	if (SC_VERSION > 15) {
	            //$pagination_object = (object) array('ControllerRecordPagination' => 'setPagination');
	           // $this->load->setreplacedata(array('' => array('pagination'=> $pagination_object )));
           } else {
             	$output = $this->setPagination($params);
           }
            return $output;
	}

	public function setPagination($params) {
        /*

        if (!$this->kzsv) {
        $time_start = microtime(true);
		print_my($this->getHref($params));
        $time_end = microtime(true);
		$time = $time_end - $time_start;
        print_my (sprintf ("%05.5f sec.", $time));
        $this->kzsv = false;
        }
          */
/*
$time_start = microtime(true);
$dom = new DOMDocument;
$dom->loadHTML($params);
foreach ($dom->getElementsByTagName('a') as $node) {
    print_my ($dom->saveHtml($node));
}

      $time_end = microtime(true);
		$time = $time_end - $time_start;
        print_my (sprintf ("%05.5f sec.", $time));
*/
		$settings  = $this->config->get('asc_langmark');
		if (isset($settings['pagination_prefix'])) {
			$pagination_prefix = $settings['pagination_prefix'];
		} else {
			$pagination_prefix = 'page';
		}

		if (isset($this->data['settings_general']['get_pagination']) && $this->data['settings_general']['get_pagination'] ) {
		  	$get_pagination = $this->data['settings_general']['get_pagination'];
		} else {
		   	$get_pagination = 'tracking';
		}

		if (strpos($params , "/".$pagination_prefix."-{page}")!==false) {
			if ($this->config->get('config_seo_url_type')=='seo_url'  || isset($this->request->get['manufacturer_id']) || isset($this->request->get['information_id'])) {
		      	$params = str_replace("/".$pagination_prefix."-{page}", "", $params);
		    } else {
		        $params = str_replace("/".$pagination_prefix."-{page}", "/", $params);
		    }
		}

		if (strpos($params , $get_pagination."=cmswidget")!==false) {
				  $tok = "/(((\&|(\&amp\;))|(\?))".$get_pagination."=cmswidget-\d+.*?(_wpage-1|_wpage-\{page\}))(?=((\')|(\#)|(\")|(\?)|(\&)))/";
		          $params = preg_replace($tok , "", $params );
		}


		if ($this->config->get('config_seo_url_type')!='seo_url') {
			$devider = "/";
		} else {
			$devider = "";
		}

		if (strpos($params , "/".$pagination_prefix."-1")!==false) {
			if ($this->registry->get('blog_design')) {

	        	$blog_design = $this->registry->get('blog_design');

				if (isset($blog_design['blog_devider']) && $blog_design['blog_devider']) {
					if (isset($blog_design['end_url_category']) && $blog_design['end_url_category']!='') {

						if (strpos('.', $blog_design['end_url_category'])!==false) {
							$devider = "";
						} else {
							$devider = "/";
						}

					} else {
						$devider = "/";
					}

				} else {
					$devider = "";
				}

				if (isset($blog_design['end_url_category']) && strpos($blog_design['end_url_category'], '.') !== false) {
					$devider = "";
				}

	       }
	            $params = str_replace("/".$pagination_prefix."-1'", $devider."'", $params);
	            $params = str_replace("/".$pagination_prefix.'-1"', $devider.'"', $params);
	            $params = str_replace("/".$pagination_prefix."-1/", $devider, $params);
	            $params = str_replace("/".$pagination_prefix."-1?", $devider."?", $params);
	            $params = str_replace("/".$pagination_prefix."-1/?", $devider."?", $params);

		}

		$params = str_replace("//?", "/?", $params);



        return $params;
	}


public function getHref($params) {

		// preg_match_all("/<[Aa][\s]{1}[^>]*[Hh][Rr][Ee][Ff][^=]*=[ '\"\s]*([^ \"'>\s#]+)[^>]*>/", $params, $matches);
         $this->kzsv = true;

  		preg_match_all('/href="([^"]+)"/', $params, $matches);
        foreach ($matches[1] as $href) {
        	$urls[$href]=$href;
        }

        foreach ($urls as $href) {
        	//$href_new = $this->setPagination($params);
        	$href_new = '/';
          	$params = str_replace($href, $href_new);
        }

        return $params;

		/*

		$this->load->library('parser/simple_html_dom');

		$html_dom = new simple_html_dom();
		$html_dom->load($params, true, false, DEFAULT_TARGET_CHARSET, true);

		$html_dom_found = $html_dom->find('a[href]');

			if ($html_dom_found) {
				foreach ($html_dom_found as $nm => $a) {
				//print_my($a->href);
				$ssilka[]=$a->href;

				}

			}

        */




}





  /*
    public function removecategorydescription($params) {

         if (SC_VERSION > 15) {
         return $str = '';
         }

		$this->load->library('parser/simple_html_dom');

		$html_dom = new simple_html_dom();
		$html_dom->load($params, true, false, DEFAULT_TARGET_CHARSET, true);

         $clear_tags = Array('0' => array('title' => '.category-info', 'number' => ''));

         foreach ($clear_tags as $id => $type) {
			if (isset($type['number']) && trim($type['number'])!='') {
				$number = (int)$type['number'];
			}

			$html_dom_p  = $html_dom->find($type['title']);

			if ($html_dom_p) {
				foreach ($html_dom_p as $nm => $a) {
					if (isset($type['number']) && trim($type['number'])!='') {
						if ($nm == $number) {
							$a->outertext = '';
						}
					} else {
						$a->outertext = '';
					}

				}
	        }
         }

		$html_dom_found = $html_dom->find('body', 0);
		$output = $html_dom->innertext;

	    unset($html_dom);
	    unset($html_dom_found);

        return $params;
	    return $output;

   }
   */

}
