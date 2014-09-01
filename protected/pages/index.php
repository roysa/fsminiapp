<?php

var_dump($_SERVER);

$r = FSMiniApp::app()->auth->auth();
var_dump($r);