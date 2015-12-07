<?php
namespace infrajs\imager;
use infrajs\path\Path;

class Iadmin {
	public static function runfolder($dir, $f = 1, $d = 0, $sub = false, $exts = false, &$filelist = array(), $pre = '')
	{
		$dir=Path::theme($dir);
		if ($dir && is_dir($dir) && $dh = opendir($dir)) {
			while (($file = readdir($dh)) !== false) {
				if ($file[0] == '.') {
					continue;
				}
				if ($file == 'vendor') {
					continue;
				}
				if ($file[0] == '~') {
					continue;
				}

				$path = $dir.$file;
				if (is_file($path) && $exts) {
					preg_match('/\.(\w{0,4})$/', $file, $math);//Расширение при поиске не учитываем
						$ext = strtolower($math[1]);
					if (!in_array($ext, $exts)) {
						continue;
					}
				}

//$count++;
				//if($count<$lims)continue;
				//if($count>=($lims+$limc))break;


				if (!$f && is_file($path) && (!$d || !is_dir($path))) {
					continue;
				}//Файлы не надо


//if(!$f && is_file($path))continue;//Файлы не надо
				if (is_dir($path)) {
					if ($sub) {
						static::runfolder($path.'/', $f, $d, $sub, $exts, $filelist, $pre.$file.'/');
					}
					if (!$d) {
						continue;
					}//Папки не надо
				}
				if ($d && preg_match("/\.files$/", $file)) {
					continue;
				}
					array_push($filelist, $pre.$file);
			}
			closedir($dh);
		}

		return $filelist;
	}
}