<?php

require '../vendor/autoload.php';

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\Loader\PhpFileLoader;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\HttpKernel;
use App\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\EventListener\RouterListener;
use Symfony\Component\EventDispatcher\ContainerAwareEventDispatcher;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Templating\TemplateNameParser;
use Symfony\Component\Templating\Loader\FilesystemLoader;

Symfony\Component\Debug\Debug::enable();

$request = Request::createFromGlobals();

$container = new ContainerBuilder();
$container
    ->register('templating', 'Symfony\Component\Templating\PhpEngine')
    ->addArgument(new TemplateNameParser)
    ->addArgument(new FilesystemLoader('../app/Resources/views/%name%'));

$requestStack = new RequestStack();
$requestStack->push($request);

$requestContext = new RequestContext();
$requestContext->fromRequest($request);

$loader = new PhpFileLoader(new FileLocator('../app/Resources/config'));
$routes = $loader->load('routes.php');

$generator  = new UrlGenerator($routes, $requestContext);
$matcher    = new UrlMatcher($routes, $requestContext);

$dispatcher = new ContainerAwareEventDispatcher($container);
$dispatcher->addSubscriber(new RouterListener($matcher, $requestStack));

$resolver = new ControllerResolver($container);
$kernel = new HttpKernel($dispatcher, $resolver);

$response = $kernel->handle($request);
$response->send();

$kernel->terminate($request, $response);
