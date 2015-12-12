<?php
use infrajs\ans\Ans;
if (!is_file('vendor/autoload.php')) {
	chdir('../../../');
	require_once('vendor/autoload.php');
}
$ans = array();
$ans['title'] = 'Check GD extension';
if (!function_exists('imagecreatetruecolor')) {
	return Ans::err($ans, 'GD required');
}

return Ans::ret($ans, 'ok');
