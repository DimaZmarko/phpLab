<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../vendor/autoload.php';
require_once '../app/app.php';

use Symfony\Component\HttpFoundation\Request;
use function core\handle;

$request = Request::createFromGlobals();
$response = handle($request);
$response->send();
