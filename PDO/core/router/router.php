<?php

namespace core\router;

use InvalidArgumentException;
use RuntimeException;
use Symfony\Component\HttpFoundation\Request;

const ROUTE_REGEX = '/{([^}]+)}/';

/**
 * @param Request $request
 *
 * @throws RuntimeException
 * @throws ResourceNotFoundException
 */
function matchRequest(Request $request)
{
    global $app;

    if (!isset($app['routes'])) {
        throw new RuntimeException('The $app[`routes`] variable is not defined');
    }

    $pathinfo = $request->getPathInfo();
    $method = $request->getMethod() ?? Request::METHOD_GET;

    foreach ($app['routes'] as $name => $route) {
        if (!isRouteValid($route)) {
            continue;
        }

        $routePattern = buildRoutePattern($route);
        $routeMethods = $route['methods'] ?? [Request::METHOD_GET];

        if (preg_match($routePattern, $pathinfo, $matches) && in_array($method, $routeMethods)) {
            $request->attributes->add([
                '_route' => $name,
                '_file' => $route['file'],
                '_function' => $route['function'],
                '_params' => !empty($matches) ? array_slice($matches, 1) : []
            ]);

            break;
        }
    }

    if ($request->attributes->count() == 0) {
        throw new ResourceNotFoundException(sprintf('Could not find route for %s', $pathinfo));
    }
}

/**
 * @param $routeName
 * @param array $params
 *
 * @return string
 * @throws InvalidArgumentException
 */
function generate($routeName, array $params = [])
{
    global $app;

    if (!isset($app['routes'][$routeName])) {
        throw new RuntimeException(sprintf('Route %s is not defined', $routeName));
    }

    $route = $app['routes'][$routeName];

    if (!isRouteValid($route)) {
        throw new InvalidArgumentException(
            sprintf("Can't find route %s or it does not have all required parameters", $routeName)
        );
    }

    $path = preg_replace_callback(
        ROUTE_REGEX,
        function ($matches) use ($params) {
            if (!isset($params[$matches[1]])) {
                throw new InvalidArgumentException(sprintf("Parameter %s is required", $matches[1]));
            }
            return $params[$matches[1]];
        },
        $route['path']
    );

    $routePattern = buildRoutePattern($route);

    if (!preg_match($routePattern, $path)) {
        throw new InvalidArgumentException("Invalid parameters. Please, check the requirements section");
    }

    return $path;
}

/**
 * @param array $route
 *
 * @return string
 */
function buildRoutePattern(array $route)
{
    $routeRequirements = isset($route['requirements']) ? (array)$route['requirements'] : [];

    return preg_replace_callback(
        ROUTE_REGEX,
        function ($matches) use ($routeRequirements) {
            return isset($routeRequirements[$matches[1]]) ? '(' . $routeRequirements[$matches[1]] . ')' : '([^/]*)';
        },
        '#^' . $route['path'] . '$#'
    );
}

/**
 * @param array $route
 *
 * @return bool
 */
function isRouteValid(array $route)
{
    return isset($route['path'])
        && isset($route['file'])
        && isset($route['function']);
}
