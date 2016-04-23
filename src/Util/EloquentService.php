<?php namespace App\Util;

use PDO;
use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Fluent;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Connectors\ConnectionFactory;
use Illuminate\Database\Eloquent\Model as Eloquent;

class EloquentService {

    private $container;
    
    private $manager;
    
    public function __construct(array $config)
    {
        $this->container = new Container;
        $this->container->instance('config', new Fluent);
        $this->container['config']['database.fetch'] = PDO::FETCH_OBJ;
        $this->container['config']['database.default'] = 'default';
        $this->manager = new DatabaseManager($this->container, new ConnectionFactory($this->container));
        
        $this->addConnection($config);
        
        $this->setEventDispatcher(new Dispatcher($this->container));
        Eloquent::setConnectionResolver($this->manager);
        Eloquent::setEventDispatcher($this->getEventDispatcher());
    }
    
    public function addConnection(array $config, $name = 'default')
    {
        $connections = $this->container['config']['database.connections'];
        $connections[$name] = $config;
        $this->container['config']['database.connections'] = $connections;
    }
    
    public function getConnection($name = null)
    {
        return $this->manager->connection($name);
    }
    
    public function table($table, $connection = null)
    {
        return $this->getConnection($connection)->table($table);
    }
    
    public function schema($connection = null)
    {
        return $this->getConnection($connection)->getSchemaBuilder();
    }
    
    public function query($model)
    {
        $entity = str_replace(':', '\\Model\\', '\\'.$model);
        return (new $entity)->newQuery();
    }
    
    public function getContainer()
    {
        return $this->container;
    }
    
    public function setContainer(Container $container)
    {
        $this->container = $container;
    }
    
    public function getEventDispatcher()
    {
        if ($this->container->bound('events')) {
            return $this->container['events'];
        }
    }
    
    public function setEventDispatcher(Dispatcher $dispatcher)
    {
        $this->container->instance('events', $dispatcher);
    }
    
    public function setFetchMode($fetchMode)
    {
        $this->container['config']['database.fetch'] = $fetchMode;
        return $this;
    }
    
    public function getDatabaseManager()
    {
        return $this->manager;
    }
    
}
