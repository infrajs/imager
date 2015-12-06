<?php
namespace infrajs\imager;

use infrajs\infra\Config;

$conf=Config::get('mem');
Imager::$conf=array_merge(Imager::$conf, $conf);