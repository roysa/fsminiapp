<?php
FSMiniApp::app()->auth->requireAuth();
FSMiniApp::app()->auth->logout();
FSMiniApp::app()->redirect();
