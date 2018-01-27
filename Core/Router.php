<?php

namespace App\Core;

class Router{
    protected $uri;             // Uri
    protected $route;           // Request route
    protected $routePrefix;     // Request routePrefix
    protected $controller;      // Request controller
    protected $action;          // Request controller action
    protected $params;          // Request Parameters
                                ///* in Custom routes $params are passed in method parameters and $params[] array();.
                                ///* in Default routes $params are passed in controller's $params[] array();.

    protected $isCustomRoute = false;   /// Indicate if Route is Custom or Default.
    /**
     * Router constructor.
     * @param $uri
     */
    public function __construct(&$uri)
    {
        $this->uri = urldecode(trim($uri,'/'));

        //Parse
        $uri_parts = explode('?', $this->uri);

        //Get URL without GET? params
        $uri_path = $uri_parts[0];

        //Get Path Separated Parts
        $path_parts = explode('/', $uri_path);

        //get routes.
        $routes = Config::get('routes');

        /* CUSTOM ROUTING (If enabled)
        *  Check if parts matches a custom Route parts.
        *  Return false if no custom routes matched, else return attributes array 'route','controller','action', 'params'. */
        if(Config::get('use_custom_routes') &&
            $customRouteAttributes = Route::CustomRouteMatch($path_parts) !== false)
        {
            $this -> route = $customRouteAttributes['route'];
            $this -> routePrefix = $routes[$this->route];
            $this -> controller = $customRouteAttributes['controller'];
            $this -> action = $customRouteAttributes['action'];
            $this -> params = $customRouteAttributes['params'];
            $this -> isCustomRoute = true;
            return;
        }

        /* if reached here -> DEFAULT ROUTING */

        //Load Defaults
        $this -> route = Config::get('default_route');
        $this -> routePrefix = $routes[$this->route];
        $this -> controller = Config::get('default_controller');
        $this -> action = Config::get('default_action');

        if(count($path_parts))
        {
            //Get Route from first part if exits
            $currentPart = current($path_parts);
            foreach ($routes as $routeName => &$routePrefix)
            {
                if(strcasecmp($routeName, $currentPart) === 0)
                {
                    $this->route = $routeName;
                    $this->routePrefix = $routePrefix;
                    array_shift($path_parts);
                    break;
                }
            }

            //Get Controller
            if(current($path_parts)){
                $this->controller = strtolower(current($path_parts));
                array_shift($path_parts);
            }

            //Get Action
            if( current($path_parts) ){
                $this->action = strtolower(current($path_parts));
                array_shift($path_parts);
            }

            //Get Params
            $this -> params = $path_parts;
        }
    }

    /**
     * @param bool $isCustomRoute
     */
    public function setIsCustomRoute($isCustomRoute)
    {
        $this->isCustomRoute = $isCustomRoute;
    }

    /**
     * @return mixed
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @param mixed $uri
     */
    public function setUri($uri)
    {
        $this->uri = $uri;
    }

    /**
     * @return mixed
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @param mixed $controller
     */
    public function setController($controller)
    {
        $this->controller = $controller;
    }

    /**
     * @return bool
     */
    public function isCustomRoute()
    {
        return $this->isCustomRoute;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param mixed $action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }

    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param mixed $params
     */
    public function setParams($params)
    {
        $this->params = $params;
    }

    /**
     * @return string
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @param string $route
     */
    public function setRoute($route)
    {
        $this->route = $route;
    }

    /**
     * @return string
     */
    public function getRoutePrefix()
    {
        return $this->routePrefix;
    }

    /**
     * @param string $routePrefix
     */
    public function setRoutePrefix($routePrefix)
    {
        $this->routePrefix = $routePrefix;
    }

}