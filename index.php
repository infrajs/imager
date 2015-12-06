<?php
namespace infrajs\imager;
use infrajs\ans\Ans;
use infrajs\path\Path;
use infrajs\cache\Cache;

if(!is_file('vendor/autoload.php')) {
	chdir('../../../');
}
require_once('vendor/autoload.php');

$ans = array();

$isrc = Ans::get('src');
if (!$isrc) return Ans::err($ans,'?src= to the image required. Relative to the siteroot. For example vendor/infrajs/imager/?src=vendor/infrajs/imager/test.jpg');

$src = Imager::prepareSrc($isrc);
$or = Ans::get('or'); //Путь на случай если src не найден

if (!$src && $or) $src = Imager::prepareSrc($or); //Путь не найден смотрим or

Imager::modified($src);


$mark = Ans::get('mark','bool');
$w = Ans::get('w', 'int');
$h = Ans::get('h', 'int');
$top = Ans::get('top','bool');
$crop = Ans::get('crop','bool');
$ignoremark = Ans::get('ignoremark','bool', null); //1 - Навсегда убирает водяной знак с картинки и больше водяной знак добавляться на неё не будет. 0 отменяет этот запрет.

$getorig = Ans::get('getorig','bool'); //Показывает оригинальную картинку без изменения размеров, как есть... без водяного знака

$conf=Imager::$conf;

$default = false;
$orig = false;






if (isset($_GET['info'])) {
	infra_admin(true);
	$info = imager_readInfo($src);
	if (!$info) {
		echo 'В файле нет сохранённых данных, файл оригинальный';
	}
	echo '<pre>';
	print_r($info);

	return;
}

if ($src && (preg_match("/\/\./", $src) || (mb_substr($src, 0, 1) == '.' && mb_substr($src, 1, 1) != '/'))) {

	header('HTTP/1.1 403 Forbidden');

	return Ans::err($ans,'Путь содержит запрещённые символы');
}

if (!$src) {
	$default = true;
	$src = Imager::noImage();
	if (!$src) {
		header('HTTP/1.0 404 Not Found');
		return Ans::err('Noimage Not found');
	}
}

if ($getorig) {
	infra_admin(true);
}

if (!is_null($ignoremark)) {
	infra_admin(true);
}
if ($getorig) {
	infra_admin(true);
}

$gray = isset($_GET['gray']);
$args = array($src, $ignoremark, $mark, $default, $getorig, $w, $h, $crop, $top, $gray);

$data = Cache::exec(array($isrc), 'imager.php', function ($src, $ignoremark, $mark, $default, $getorig, $w, $h, $crop, $top, $gray, $re) use ($isrc) {
	
	$ext = Path::getExt($src);
	if (in_array($ext, array('docx','mht'))) {
		die("docx, mht TODO");
		/*
			TODO: Смотрим подключён ли плагин files для того чтобы достать картинку и файла
		*/
		
		$default = true;
		$src = Imager::noImage('*imager/noimage.png');
	}
	$src = Imager::tofs($src);
	$type = Imager::getType($src);
	/*
	if (!is_null($ignoremark)) {
		//Метку ignore может выставить только администратор
		//На файлы с такой меткой водяной знак никогда не ставится
		$info = imager_makeInfo($src);

		if ($ignoremark && $info['water']) {
			//Если файл был с водяным знаком
			$orig = $info['orig'];
			if ($orig) {
				$orig = infra_theme($orig);
				if ($orig) {
					//Если оригинальный файл найден
					$r = copy($orig, $src);//Востановили оригинал без удаления оригинала
					$info['water'] = false;
					if (!$r) {
						imager_writeInfo($src, $info);
						die('Не удалось востановить оригинал чтобы поставить метку ignore');
					}
					$info['ignore'] = $ignoremark;
				} else {
					imager_writeInfo($src, $info);
					die('На файле установлен водяной знак. Оригинальный файл не найден. Метку установить неудалось');
				}
			} else {
				imager_writeInfo($src, $info);
				die('Водяной знак есть а оригинал не указан. исключение.');
			}
		} else {
			//Водяного знака небыло
			$info['ignore'] = $ignoremark;
		}
		imager_writeInfo($src, $info);
	}
	if ($type && $mark && !$default) {
		//Это не значит что нужно делать бэкап
		imager_mark($src, $type);//Накладываем водяной знак
	}*/

	/*$info=imager_readInfo($src);
	if($info['ignore']){
		$orig=$info['orig'];
	}*/

	/*$limark = false;//Не делать водяной знак если площать меньше 150x150
	if ($w && $h) {
		$limark = ($conf['imager']['waterlim'] > ($w * $h));
	} elseif ($w || $h) {
		$wl = $w;
		$hl = $h;
		if (!$w) {
			$wl = $h;
		}
		if (!$h) {
			$hl = $w;
		}
		$limark = ($conf['imager']['waterlim'] > $wl * $hl);
	}
	if ($getorig) {
		$w = 0;
		$h = 0;
		$crop = false;
		$info = imager_readInfo($src);
		$orig = $info['orig'];

		if ($orig) {
			$orig = infra_theme($orig);
			if (!$orig) {
				die('Оригинал не найден');
			} else {
				$src = $orig;//Что далее будет означать что возьмётся для вывода оригинальная картинка
			}
		} else {
			die('Already original');
		}
	} elseif ($limark) {
		$info = imager_readInfo($src);
		if (@$info['water']) {
			$orig = infra_theme($info['orig']);
			if ($orig) {
				$src = $orig;
			} else {
				//die('Не найден оригинал');
			}
		}
	}*/
	//$src с водяной меткой если нужно
	if ($gray) {
		$src = Imager::makeGray($src, $temp);//новый src уже на серую картинку
	}

	$data = Imager::scale($src, $w, $h, $crop, $top);

	if (!$data) {
		die('Resize Error');
	}

	$br = infra_imager_browser();
	$name = preg_replace("/(.*\/)*/", '', $isrc);
	
	$name = Imager::toutf($name);
	
	if (!preg_match('/ff/', $br)) {
		$name = rawurlencode($name);
	}
	if (preg_match('/ie6/', $br)) {
		$name = preg_replace("/\s/", '%20', $name);
	}

	if (!$type) {
		$type = 'image/jpeg';
	}

	$data = array('data' => $data, 'name' => $name, 'type' => $type);

	return $data;
}, $args, isset($_GET['re']));

header('Content-Disposition: filename="'.$data['name'].'";');
header('content-type: image/'.$data['type']);
echo $data['data'];
