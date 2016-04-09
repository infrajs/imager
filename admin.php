<?php
namespace infrajs\imager;
use infrajs\access\Access;
use infrajs\path\Path;

if (!is_file('vendor/autoload.php')) {
    chdir('../../../');
    require_once('vendor/autoload.php');
}
Access::admin(true);

$dirorig = Path::theme('~imager/.notwater/');
$iswater = Path::theme('~imager/mark.png');
$ishwater = Path::theme('~imager/.mark.png');

$water = $iswater || $ishwater;
if (isset($_GET['action'])) {
	$act = $_GET['action'];
	if ($act == 'togglemark') {
		if ($iswater) {
			$new = preg_replace('/mark\.png$/', '.mark.png', $iswater);
			rename($iswater, $new);
		} elseif ($ishwater && !$iswater) {
			$new = preg_replace('/\.mark\.png$/', 'mark.png', $ishwater);
			rename($ishwater, $new);
		}
	} elseif ($act == 'removemarks') {
		//$dir='infra/data/';
		$dir = './';
		session_start();
		if (isset($_REQUEST['restart'])) {
			unset($_SESSION['imager']);
		}
		if (!isset($_SESSION['imager'])) {
			//Шаг один
			$conf = Imager::$conf;
			$files = Iadmin::runfolder($dir, 1, 0, true, $conf['images']);
			//Если на пробежке обламаемся сессия создана не будет и при обновлении продолжим...
			$_SESSION['imager'] = array();
			$_SESSION['imager']['origs'] = array();
			$_SESSION['imager']['files'] = $files;
		}

		foreach ($_SESSION['imager']['files'] as $k => $file) {
			$src = $dir.$file;
			$info = imager_readInfo($src);//Долгая операция

			$orig = $info['orig'];
			if ($orig) {
				if (!isset($_SESSION['imager']['origs'][$orig])) {
					$_SESSION['imager']['origs'][$orig] = array();
				}
				$_SESSION['imager']['origs'][$orig][] = $dir.$file;
			}
			unset($_SESSION['imager']['files'][$k]);//Чтобы при обнолении страницы, не бегать снова
		}

		//Теперь у нас есть только массив origs
		foreach ($_SESSION['imager']['origs'] as $orig => $srcs) {
			$origf = Path::theme($orig);
			if (!$origf) {
				//if(preg_match("/^core\/data\//",$orig))continue;//старая версия сайта ничего с этим не поделать
				//die('Не найден оригинал '.Path::toutf($orig)." для картинки ".Path::toutf(print_r($srcs,true)).'<br>\n');
				echo 'Не найден оригинал '.Path::toutf($orig).' для картинки '.Path::toutf(print_r($srcs, true)).'<br>\n';
				continue;
			}

			foreach ($srcs as $src) {
				$r = copy($origf, $src);
				if (!$r) {
					die('Не удалось скопировать на место оригинал '.Path::toutf($src));
				}
			}
			$r = unlink($origf);
			if (!$r) {
				die('Не удалось удалить востановленный оригинал');
			}
			unset($_SESSION['imager']['origs'][$orig]);//Пометили что этот оригинал уже востановили
		}

		$files = Iadmin::runfolder($dirorig, 1, 0);

		unset($_SESSION['imager']);
	} elseif ($act == 'delcache') {
		infra_mem_flush();
	}
	header('location: /-imager/admin.php');
	exit;
}
$files = Iadmin::runfolder($dirorig);
$countorig = sizeof($files);
?>
<html>
<head>
	
</head>
<body>
	<div style="margin:50px 100px; font-family: Tahoma; font-size:14px">
		Config.imager.watermark: <b>
<?php
$conf = Imager::$conf;
echo($conf['watermark'] ? 'true' : 'false');
?></b> - глобальный запрет и создавать или нет папку data/imager/<br>
		Количество оригиналов иллюстраций с водяным знаком: <b><?php echo $countorig?></b>. 
		<br><a href="?action=removemarks">Удалить на иллюстрациях водяной знак</a>. <small>Если будет ошибка на ограничение времени выполенния скрипта, нужно обновлять страницу пока скрипт не закончит работу.</small><br>
	<!--	<a title="Нажимать нельзя" style="font-size:10px; color:gray;" href="?action=delorig">Удалить оригиналы</a><br>-->
	<a title="Можно нажимать" href="?action=delcache">Удалить кэш</a><br>
	<hr>
	Есть файл водяного знака: <b><?php echo ($water) ? 'Да' : 'Нет';?></b><br>
	Водяной знак на иллюстрациях: <a title="Изменить" style="font-weight:bold; color:<?php echo ($iswater) ? 'green' : 'red'; ?>" href="?action=togglemark"><?php echo ($iswater) ? 'добавляется' : 'не добавляется';?></a><br>
	</div>
	<p>
		Востановить все водяные знаки не всегда можно... водяные занки накладываются на файлы любого разрешения, а значит отмена водяного знака может не найти такой файл
	</p>
</body>
</html>