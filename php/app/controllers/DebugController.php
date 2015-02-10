<?php

namespace ExamplePhalcon\Controllers;

/**
 * Class DebugController
 * @package ExamplePhalcon\Controllers
 *
 * @RoutePrefix("/debug")
 */
class DebugController extends ControllerBase {
    public function indexAction()
    {
        $this->view->disable();
        phpinfo();
    }
}