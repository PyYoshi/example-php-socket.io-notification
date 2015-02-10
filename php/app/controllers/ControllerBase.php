<?php

namespace ExamplePhalcon\Controllers;

use ExamplePhalcon\Models\SessionModel;
use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Dispatcher;

class ControllerBase extends Controller
{
    public function initialize()
    {
        $this->tag->appendTitle(' | Real-time Notification Example');
    }
}
