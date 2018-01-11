<?php

/*
 * Class Name should match this pattern {Route Prefix}{Controller Name}Controller
 * route prefix for default controllers = "", so just use {Controller Name}Controller.
 * (unless you changed default route prefix in config)
 */

class HomeController extends WebController {
    public function Index(){
        $db = DB::connection();
        return $this->render();
    }

    public function About(){
        return $this->render();
    }

    public function CustomRouteOne($id, $name, $desc = 'optional'){
        echo $id.' - Name: -'.$name.' - Description: '.$desc;
    }

}