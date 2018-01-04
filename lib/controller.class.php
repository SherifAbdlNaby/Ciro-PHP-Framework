<?php

abstract class  Controller{
    protected $data;
    protected $model;
    protected $params;

    /**
     * Controller constructor.
     * @param $data
     * @param $model
     * @param $params
     */
    public function __construct($data = array(), $model = array(), $params = array())
    {
        $this->data = $data;
        $this->model = $model;
        $this->params = App::getRouter() -> getParams();
    }

    /** Redirect User to the given path.
     * @param $path
     */
    function redirect($path)
    {
        return header("Location: ".$path);
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->params;
    }
}