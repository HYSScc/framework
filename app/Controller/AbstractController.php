<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

class AbstractController implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    protected function render($view, array $parameters = array(), Response $response = null)
    {
        $templating = $this->container->get('templating');

        if (null === $response) {
            $response = new Response();
        }

        $response->setContent($templating->render($view, $parameters));

        return $response;
    }
}
