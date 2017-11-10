<?php
session_start();
include_once 'Tools/Autoload.php';

Autoload::register();
Autoload::addPath('system/Tools');
Autoload::addPath('app/models');

$request = Request::fromUserRequest();
App::$cur = new App('app');

App::$cur->processRequest($request);