<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Movie;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Expr\Value;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Interfaces\RouteCollectorInterface;
use Twig\Environment;

/**
 * Class HomeController.
 */
class HomeController
{
    /**
     * @var RouteCollectorInterface
     */
    private $routeCollector;

    /**
     * @var Environment
     */
    private $twig;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * HomeController constructor.
     *
     * @param RouteCollectorInterface $routeCollector
     * @param Environment $twig
     * @param EntityManagerInterface $em
     */
    public function __construct(RouteCollectorInterface $routeCollector, Environment $twig, EntityManagerInterface $em)
    {
        $this->routeCollector = $routeCollector;
        $this->twig = $twig;
        $this->em = $em;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     *
     * @return ResponseInterface
     *
     * @throws HttpBadRequestException
     */
    public function index(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        try {
            $data = $this->twig->render('/home/index.html.twig', [
                'trailers' => $this->fetchData(),
            ]);
        } catch (\Exception $e) {
            throw new HttpBadRequestException($request, $e->getMessage(), $e);
        }

        $response->getBody()->write($data);

        return $response;

    }

    public function trailer(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        try {
            $id = $request->getAttribute('id');
            $trailer = $this->fetch($id);
            $data = $this->twig->render('/home/trailer.html.twig', [
                'trailer' => $trailer,
            ]);
        } catch (\Exception $e) {
            throw new HttpBadRequestException($request, $e->getMessage(), $e);
        }

        $response->getBody()->write($data);

        return $response;

    }

    /**
     * @return Collection
     */
    protected function fetchData(): Collection
    {
        $data = $this->em->getRepository(Movie::class)
            ->findAll();

        return new ArrayCollection($data);
    }

    /**
     * @param $id
     * @return Value
     */
    protected function fetch($id): Value
    {
        $data = $this->em->getRepository(Movie::class)
            ->find($id);

        return new Value($data);
    }
}
