<?php

$ans = array();
$ans['title'] = 'Check GD extension';
if (!function_exists('imagecreatetruecolor')) {
	return Ans::err($ans, 'GD required');
}

return Ans::ret($ans, 'ok');
