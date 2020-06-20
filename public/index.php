<?php

/** @var ContainerInterface $container */

use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Slim\App;
use Slim\Exception\HttpBadRequestException;
use Slim\Interfaces\CallableResolverInterface;
use Slim\Interfaces\RouteCollectorInterface;
use Slim\Interfaces\RouteResolverInterface;
use Slim\Middleware\ErrorMiddleware;
use Slim\Middleware\RoutingMiddleware;
use Slim\Psr7\Factory\ServerRequestFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Controller\HomeController;

$container = require dirname(__DIR__) . '/bootstrap.php';
$request = ServerRequestFactory::createFromGlobals();

Slim\Factory\AppFactory::create();

$app = new App(
    $container->get(ResponseFactoryInterface::class),
    $container,
    $container->get(CallableResolverInterface::class),
    $container->get(RouteCollectorInterface::class),
    $container->get(RouteResolverInterface::class)
);

$app->add($container->get(RoutingMiddleware::class));
$app->add($container->get(ErrorMiddleware::class));


$app->run($request);


