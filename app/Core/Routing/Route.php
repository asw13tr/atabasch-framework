<?php

namespace Atabasch\Core\Routing;

class Route{

    public ?string $as = null;

    public array $methods = ['GET'];

    public ?string $prefix = null;

    public ?string $domain = null;

    public string $path = '/';

    public string $regexPath = '/';

    public mixed $handler = null;

    public array|null $middleware = [];

    public ?string $namespace = null;

    public array $variables = [];

    public bool $redirect = false;


    public function __construct(array $methods, string $path, mixed $handler=null, array $options=[]){

        $this->prefix    = !$options['prefix']? null : '/'.trim($options['prefix'], '/');
        $this->as        = $options['as'] ?? null;
        $this->domain    = $options['domain'] ?? null;
        $this->redirect    = $options['redirect'] ?? false;


        $this->methods = $methods;

        $this->path = $this->prefix.'/'.trim($path, '/');
        $this->regexPath = $this->createRegexPath();

        $this->handler = $handler;

        $this->middleware = $options['middleware'] ?? null;

        $this->namespace = $options['namespace'] ?? null;



    }

    public function createRegexPath(){
        $placeholders = $GLOBALS['_CONFIG']->placeholders->route ?? [];
        return preg_replace(array_keys($placeholders), array_values($placeholders), $this->path);
    }


    public function setMiddleware(array $middlewares=[]): void{
        $this->middleware = $middlewares;
    }

    public function getMiddleware(): array{
        return $this->middleware;
    }





}