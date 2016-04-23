<?php namespace App\Controller;

abstract class AbstractController
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function __get($name)
    {
        return $this->container->get($name);
    }
}
