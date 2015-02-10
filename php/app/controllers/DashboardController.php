<?php

namespace ExamplePhalcon\Controllers;
use ExamplePhalcon\Models\SessionModel;
use Phalcon\Http\Response;

/**
 * Class DashboardController
 * @package ExamplePhalcon\Controllers
 *
 * @RoutePrefix("/dashboard")
 */
class DashboardController extends PrivateControllerBase
{

    public function initialize()
    {
        parent::initialize();
    }

    /**
     * @Get("/")
     */
    public function indexAction()
    {
        $this->view->pick('dashboard/index');
        $this->tag->prependTitle("Dashboard");

        $sessionModel = new SessionModel();
        $userId = $sessionModel->getUserId();
        $userName = $sessionModel->getUsername();

        $this->view->socketIoPath = 'http://127.0.0.1:3000';
        $this->view->username = $userName;
        $this->view->userId = $userId;
    }

    /**
     * @Get("/1")
     */
    public function dashboard3001Action($port)
    {
        $this->view->pick('dashboard/index');
        $this->tag->prependTitle("Dashboard");

        $sessionModel = new SessionModel();
        $userId = $sessionModel->getUserId();
        $userName = $sessionModel->getUsername();

        $this->view->socketIoPath = 'http://127.0.0.1:3001';
        $this->view->username = $userName;
        $this->view->userId = $userId;
    }

    /**
     * @Get("/2")
     */
    public function dashboard3002Action($port)
    {
        $this->view->pick('dashboard/index');
        $this->tag->prependTitle("Dashboard");

        $sessionModel = new SessionModel();
        $userId = $sessionModel->getUserId();
        $userName = $sessionModel->getUsername();

        $this->view->socketIoPath = 'http://127.0.0.1:3001';
        $this->view->username = $userName;
        $this->view->userId = $userId;
    }

    /**
     * @Post("/chat")
     */
    public function chatAction()
    {
        $statusCode = 400;
        $statusMsg = 'Bad Request';
        $content = '';

        $sessionModel = new SessionModel();
        $userId = $sessionModel->getUserId();
        $username = $sessionModel->getUsername();

        $json = $this->request->getJsonRawBody();
        if (!is_null($json->message) && mb_strlen($json->message) > 0) {
            $statusCode = 200;
            $statusMsg = 'OK';

            // socket.io emit
            $msgObj = [
                'message' => $json->message,
                'userId' => $userId,
                'username' => $username
            ];
            $this->socketIoEmitter->emit('chat', $msgObj);
            $content = json_encode($msgObj);
        }

        $this->view->disable();
        $response = new Response();
        $response->setStatusCode($statusCode, $statusMsg);
        $response->setContent($content);
        return $response;

    }
}
