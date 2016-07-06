<?php


namespace Eva\Crud;

use Interop\TemplateRenderer\TemplateRendererInterface;
use Interop\Container\ContainerInterface;
use Interop\ObjectManager\ObjectManagerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

abstract class AbstractAction
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    abstract public function __invoke(ServerRequestInterface $request, ResponseInterface $response);

    /**
     * @return ObjectManagerInterface
     */
    protected function getObjectManager()
    {
        return $this->container->get(ObjectManagerInterface::class);
    }

    /**
     * @return TemplateRendererInterface
     */
    protected function getTemplateRenderer()
    {
        return $this->container->get(TemplateRendererInterface::class);
    }
}