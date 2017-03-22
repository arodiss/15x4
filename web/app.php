<?php

use Symfony\Component\HttpFoundation\Request;

$env = getenv('SF_ENVIRONMENT') ?: 'dev';
$debug = $env !== 'prod';

/** @var Composer\Autoload\ClassLoader */
$loader = require __DIR__.'/../app/autoload.php';
if ($debug) {
    \Symfony\Component\Debug\Debug::enable();
} else {
    include_once __DIR__.'/../var/bootstrap.php.cache';
}

$kernel = new AppKernel($env, $debug);
if (!$debug) {
    $kernel->loadClassCache();
    $kernel = new AppCache($kernel);
}

$request = Request::createFromGlobals();
// Some browsers have built-in reverse proxies
// which send conflicting "FORWARDED" and "X-FORWARDED-FOR" headers
// Thus have to distrust one of them
Request::setTrustedHeaderName(Request::HEADER_FORWARDED, null);
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
