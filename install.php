<?php

$dirs = infra_dirs();

$conf = infra_config();

if ($conf['infra']['cache'] == 'fs') {
	if (!is_dir($dirs['cache'].'imager_remote/')) {
		mkdir($dirs['cache'].'imager_remote/');
	}
}
if ($conf['imager']['watermark']) {
	if (!is_dir($dirs['data'].'imager/')) {
		mkdir($dirs['data'].'imager/');
	}
	if (!is_dir($dirs['data'].'imager/.notwater/')) {
		mkdir($dirs['data'].'imager/.notwater/');
	}
	
	if (!is_dir($dirs['data'].'imager/.backuporig/')) {
		mkdir($dirs['data'].'imager/.backuporig/');
	}
}
