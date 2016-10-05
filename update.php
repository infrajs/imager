<?php
namespace infrajs\imager;
use infrajs\path\Path;

require_once(__DIR__.'/../../../vendor/autoload.php');

Path::mkdir(Imager::$conf['cache']);
Path::mkdir(Imager::$conf['cache'].'resize/');
Path::mkdir(Imager::$conf['cache'].'remote/');