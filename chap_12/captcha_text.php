<?php
require __DIR__ . '/../../Application/Autoload/Loader.php';
Application\Autoload\Loader::init(__DIR__ . '/../..');
use Application\Captcha\Reverse;

session_start();
session_regenerate_id();


