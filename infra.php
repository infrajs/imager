<?php
namespace infrajs\imager;
use infrajs\infra\Infra;

$conf=&Config::get('imager');
Imager::$conf=array_merge(Imager::$conf, $conf);
$conf=Imager::$conf;