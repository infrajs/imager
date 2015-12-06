<?php
namespace infrajs\imager;
use infrajs\infra\Infra;

$conf=Infra::config('mem');
Imager::$conf=array_merge(Imager::$conf, $conf);