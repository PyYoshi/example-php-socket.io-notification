<?php

namespace ExamplePhalcon\Controllers;

use ExamplePhalcon\Models\SessionModel;

/**
 * Class SessionController
 * @package ExamplePhalcon\Controllers
 *
 * @RoutePrefix("/session")
 */
class SessionController extends ControllerBase
{

    /**
     * @Get("/logout")
     */
    public function logoutAction()
    {
        $sessionModel = new SessionModel();
        $sessionModel->destroy();

        $this->response->redirect('/', true);
    }

}