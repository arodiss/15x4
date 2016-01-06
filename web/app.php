<?php

use Symfony\Component\HttpFoundation\Request;

/** @var Composer\Autoload\ClassLoader */
$loader = require __DIR__.'/../app/autoload.php';
include_once __DIR__.'/../var/bootstrap.php.cache';

$kernel = new AppKernel(getenv("SF_ENVIRONMENT"), getenv("SF_ENVIRONMENT") !== "prod");
$kernel->loadClassCache();

$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
