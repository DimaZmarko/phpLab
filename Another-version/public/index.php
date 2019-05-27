<?php

require_once __DIR__ . '/../vendor/autoload.php';
include __DIR__ . '/../src/routes.php';

$request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();

$context = new \Symfony\Component\Routing\RequestContext();
$matcher = new \Symfony\Component\Routing\Matcher\UrlMatcher($routes, $context);
$controllerResolver = new \Symfony\Component\HttpKernel\Controller\ControllerResolver();
$argsResolver = new \Symfony\Component\HttpKernel\Controller\ArgumentResolver();

$framework = new \Core\Framework($matcher, $controllerResolver, $argsResolver);
$response = $framework->handle($request);

$response->send();
