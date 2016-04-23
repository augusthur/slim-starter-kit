<?php namespace App\Util;

class TwigExtension extends \Twig_Extension {
    
    private $router;
    private $uri;
    private $debugger;
    
    public function __construct($router, $uri, $debugger)
    {
        $this->router = $router;
        $this->uri = $uri;
        $debugger->setBaseUrl($this->baseUrlFunction().'/assets/debugbar');
        $this->debugger = $debugger;
    }

    public function getFunctions()
    {
        return [
            'asset' => new \Twig_Function_Method($this, 'assetFunction'),
            'path' => new \Twig_Function_Method($this, 'pathFunction'),
            'base_url' => new \Twig_Function_Method($this, 'baseUrlFunction'),
            'debug_head' => new \Twig_Function_Method($this, 'debugHeadFunction', ['is_safe' => ['html']]),
            'debug_bar' => new \Twig_Function_Method($this, 'debugBarFunction', ['is_safe' => ['html']]),
        ];
    }
    
    public function assetFunction($name)
    {
        return $this->baseUrlFunction().'/assets/'.$name;
    }
    
    public function pathFunction($route, $params = [], $query = [])
    {
        return $this->router->pathFor($route, $params, $query);
    }

    public function baseUrlFunction()
    {
        if (is_string($this->uri)) {
            return $this->uri;
        }
        if (method_exists($this->uri, 'getBaseUrl')) {
            return $this->uri->getBaseUrl();
        }
    }
    
    public function debugHeadFunction()
    {
        return $this->debugger->renderHead();
    }

    public function debugBarFunction()
    {
        return $this->debugger->renderBar();
    }

    public function getName()
    {
        return 'app';
    }
    
}
