<?php

namespace core;

require_once __DIR__ . '/router/router.php';
require_once __DIR__ . '/router/ResourceNotFoundException.php';
require_once __DIR__ . '/view/view.php';

use core\router\ResourceNotFoundException;
use RuntimeException;
use Symfony\Component\HttpFoundation\Request;
use function core\router\matchRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * @param Request $request
 *
 * @return Response
 * @throws RuntimeException
 */
function handle(Request $request)
{
    initApp();

    global $app;

    if (!$request->attributes->has('_file') || !$request->attributes->has('_function')) {
        try {
            matchRequest($request);
        } catch (ResourceNotFoundException $e) {
            return new Response('Page not found', Response::HTTP_NOT_FOUND);
        }
    }

    $file = $request->attributes->get('_file');
    $function = $request->attributes->get('_function');
    $params = $request->attributes->get('_params', []);

    $path = $app['kernel.src_dir'] . DIRECTORY_SEPARATOR . $file;

    if (!is_file($path)) {
        throw new RuntimeException(sprintf("Couldn't find file %s", $path));
    }

    require_once $path;

    if (!function_exists($function)) {
        throw new RuntimeException(sprintf("Couldn't find function %s", $function));
    }

    $response = call_user_func($function, ...$params);

    if (!$response instanceof Response) {
        throw new RuntimeException('Response must be instance of Response class');
    }

    return $response;
}

/**
 * Inits all required application variables
 */
function initApp()
{
    $rootDir = dirname(dirname(__FILE__));
    $config = [
        'kernel.root_dir' => $rootDir,
        'kernel.view_dir' => $rootDir . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'views',
        'kernel.src_dir' => $rootDir . DIRECTORY_SEPARATOR . 'src',
    ];

    if (!array_key_exists('app', $GLOBALS)) {
        $GLOBALS['app'] = [];
    }

    $GLOBALS['app'] = array_merge(
        $GLOBALS['app'],
        $config
    );
}
