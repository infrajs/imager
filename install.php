<?php
namespace infrajs\imager;
use infrajs\path\Path;

require_once(__DIR__.'/../../../vendor/autoload.php');
require_once(__DIR__.'/../path/install.php');

Path::mkdir(Imager::$conf['cache']);
Path::mkdir(Imager::$conf['cache'].'remote/');