<?php
/* All rights reserved belong to the module, the module developers http://opencartadmin.com */
// http://opencartadmin.com © 2011-2016 All Rights Reserved
// Distribution, without the author's consent is prohibited
// Commercial license
class agooModelToolImage extends Controller
{
protected  $Layout_;
protected  $data;

   public function __call($name, array $params)
   {
       	$object = 'ModelToolImage';
       	$data = false;

	    if (!class_exists('ModelToolImage')) {
			$file  = DIR_APPLICATION . 'model/tool/image.php';
			if (file_exists($file)) {
				include_once($file);
			}
	    }

		$this->Layout_ =  new $object($this->registry);

		if ($this->config->get('ascp_settings') != '') {
			$this->data['settings_general'] = $this->config->get('ascp_settings');
		} else {
			$this->data['settings_general'] = Array();
		}

       	if (isset($this->data['settings_general']['blog_resize']) && $this->data['settings_general']['blog_resize'] && $name == 'resize' && $this->config->get("blog_work")) {

        	if (isset($params[3])) {
        		$data = $this->resizeme($params[0], $params[1], $params[2], $params[3]);
        	} else {
        	 	$data = $this->resizeme($params[0], $params[1], $params[2]);
        	}

        } else {
        	$data = call_user_func_array(array($this->Layout_ , $name), $params);
        }
        return $data;
   }


	public function resizeme($filename, $width, $height, $type = true, $copy = true)
	{
 		if (!class_exists('PhpThumbFactory')) {
			require_once(DIR_SYSTEM . 'library/image/ThumbLib.php');
		}

		if ($type) {
			$asaptive_path = "adaptive/";
		} else {
			$asaptive_path = "";
		}


        $dir_image = DIR_IMAGE;

        $ok = false;
		if (!file_exists($dir_image . $filename) || !is_file($dir_image . $filename)) {
			return $ok;
		}

		$info      = pathinfo($filename);
		$extension = $info['extension'];
		$old_image = $filename;
		$new_image = 'cache/'.$asaptive_path . utf8_substr($filename, 0, utf8_strrpos($filename, '.')) . '-' . $width . 'x' . $height . '.' . $extension;
		if (!file_exists($dir_image . $new_image) || (filemtime($dir_image . $old_image) > filemtime($dir_image . $new_image))) {
			$path        = '';
			$directories = explode('/', dirname(str_replace('../', '', $new_image)));
			foreach ($directories as $directory) {
				$path = $path . '/' . $directory;
				if (!file_exists($dir_image . $path)) {
					@mkdir($dir_image . $path, 0777);
				}
			}
				list($width_orig, $height_orig) = getimagesize($dir_image . $old_image);
				if (($width_orig != $width || $height_orig != $height) || !$copy) {
		  			//********* code *************
		  			$thumb = PhpThumbFactory::create($dir_image . $old_image, Array('resizeUp'=> true));
					if ($type) {
						$ok = $thumb->adaptiveResize($width, $height)->save($dir_image . $new_image);
					} else {
						//$ok = $thumb->resize($width, $height)->save($dir_image . $new_image);
                        // opencart standart
						$image = new Image($dir_image . $old_image);
						$image->resize($width, $height);
						$image->save($dir_image . $new_image);
						$ok = true;
					}
		            //********* code *************
				} else {
					$ok =  copy($dir_image . $old_image, $dir_image . $new_image);
				}

			 if ($ok)
			 return $this->getHttpImage().$new_image;
			 else
			 return '';
		} else {
			 return $this->getHttpImage().$new_image;
		}

    }
	private function mkdirs($pathname, $index = FALSE, $mode = 0777)
	{
		$flag_save = false;
		$path_file = dirname($pathname);
		$name_file = basename($pathname);
		if (is_dir(dirname($path_file))) {
		} else {
			$this->mkdirs(dirname($pathname), $mode, $index);
		}
		if (is_dir($path_file)) {
			if (file_exists($path_file)) {
				$flag_save = true;
			}
		} else {
			umask(0);
			@mkdir($path_file, $mode);
			if (file_exists($path_file)) {
				$flag_save = true;
			}
			if ($index) {
				$accessFile = $path_file . "/" . $name_file;
				touch($accessFile);
				$accessWrite = fopen($accessFile, "wb");
				fwrite($accessWrite, 'Access denied');
				fclose($accessWrite);
				if (file_exists($accessFile)) {
					$flag_save = true;
				} else {
					$flag_save = false;
				}
			}
		}
		return $flag_save;
	}



	public function resizeavatar($filename, $filename_original, $width, $height, $type = true, $copy = true)
	{
 		if (!class_exists('PhpThumbFactory')) {
			require_once(DIR_SYSTEM . 'library/image/ThumbLib.php');
		}

        $ok = false;
		if (!file_exists(DIR_IMAGE . $filename) || !is_file(DIR_IMAGE . $filename)) {
			return $ok;
		}

		$info      = pathinfo($filename_original);
		$extension = $info['extension'];
		$old_image = $filename;
        $new_image = $filename_original;

			if (!file_exists(DIR_IMAGE . $new_image) || (filemtime(DIR_IMAGE . $old_image) > filemtime(DIR_IMAGE . $new_image))) {
				$path        = '';
				$directories = explode('/', dirname(str_replace('../', '', $new_image)));
				foreach ($directories as $directory) {
					$path = $path . '/' . $directory;
					if (!file_exists(DIR_IMAGE . $path)) {
						@mkdir(DIR_IMAGE . $path, 0777);
					}
				}

				list($width_orig, $height_orig) = getimagesize(DIR_IMAGE . $old_image);
				if (($width_orig != $width || $height_orig != $height) || !$copy) {
		  			//********* code *************
		  			$thumb = PhpThumbFactory::create(DIR_IMAGE . $old_image, Array('resizeUp'=> true));
					if ($type)
						$ok = $thumb->adaptiveResize($width, $height)->save(DIR_IMAGE . $new_image);
					else
						$ok = $thumb->resize($width, $height)->save(DIR_IMAGE . $new_image);
		            //********* code *************
				} else {
					copy(DIR_IMAGE . $old_image, DIR_IMAGE . $new_image);
					$ok = true;
				}

			 if ($ok)
			 return $this->getHttpImage().$new_image;
			 else
			 return '';
		}

    }

	public function getHttpImage()
	{
		$array_dir_image = str_split(DIR_IMAGE);
		$array_dir_app   = str_split(DIR_APPLICATION);
		$i               = 0;
		$dir_root        = '';
		while ($array_dir_image[$i] == $array_dir_app[$i]) {
			$dir_root .= $array_dir_image[$i];
			$i++;
		}
		$dir_image_ = str_replace($dir_root, '', DIR_IMAGE);
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$http_image = HTTPS_SERVER . $dir_image_;
		} else {
			$http_image = HTTP_SERVER . $dir_image_;
		}
		return $http_image;
	}

}
?>