<?php

namespace core\view;

use \RuntimeException;
use Symfony\Component\HttpFoundation\Response;

/**
 * @param array $layouts
 * @param array $data
 *
 * @return Response
 */
function view(array $layouts, array $data = [])
{
    global $app;

    static $viewData = [];

    if (empty($app['kernel.view_dir'])) {
        throw new RuntimeException('The $app[`kernel.view_dir`] variable is not defined');
    }

    $content = null;
    $layouts = array_reverse($layouts);
    $viewData = array_replace_recursive($viewData, $data);
    extract($viewData);

    foreach ($layouts as $layout) {
        ob_start();
        include $app['kernel.view_dir'] . DIRECTORY_SEPARATOR . $layout;
        $content = ob_get_contents();
        ob_end_clean();
    }

    return new Response($content);
}
