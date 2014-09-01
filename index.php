<?php

ini_set('session.auto_start', 0);
$config = include (dirname(__FILE__) . DIRECTORY_SEPARATOR . 'protected' . DIRECTORY_SEPARATOR . 'config.php');
require dirname(__FILE__) . DIRECTORY_SEPARATOR . 'protected' . DIRECTORY_SEPARATOR . 'FSMiniApp.php';
$app = FSMiniApp::app($config);
$app->run();
