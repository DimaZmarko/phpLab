<?php

namespace Core;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;

class Framework
{
    protected $matcher;
    protected $controllerResolver;
    protected $argsResolver;

    public function __construct(
        UrlMatcher $matcher,
        ControllerResolver $controllerResolver,
        ArgumentResolver $argumentResolver
    ) {
        $this->matcher = $matcher;
        $this->controllerResolver = $controllerResolver;
        $this->argsResolver = $argumentResolver;

    }

    public function handle(Request $request)
    {
        $this->matcher->getContext()->fromRequest($request);

        try {
            $request->attributes->add($this->matcher->match($request->getPathInfo()));

            $controller = $this->controllerResolver->getController($request);
            $args = $this->argsResolver->getArguments($request, $controller);

            return call_user_func_array($controller, $args);
        } catch (ResourceNotFoundException $e) {
            return new Response('Not Found', 404);
        } catch (\Exception $e) {
            return new Response('An Error', 500);
        }
    }
}