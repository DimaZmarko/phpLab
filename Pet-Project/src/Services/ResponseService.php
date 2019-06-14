<?php

namespace App\Services;


class ResponseService
{

    public function generateResponse(string $action, string $templateOrRoute, array $args = [])
    {
//        return new Response('', Response::HTTP_ACCEPTED);
        if ($action == 'redirect') {
            return $this->redirectToRoute($templateOrRoute, $args);
        }elseif ($action == 'render') {
            return $this->render($templateOrRoute, $args);
        } else {
            throw new InvalidArgumentException('Invalid action must be "redirect" or "render"');
        }
    }
}