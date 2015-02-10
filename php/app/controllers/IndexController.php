<?php

namespace ExamplePhalcon\Controllers;

use ExamplePhalcon\Forms\LoginForm;
use ExamplePhalcon\Models\SessionModel;

/**
 * Class IndexController
 * @package ExamplePhalcon\Controllers
 *
 * @RoutePrefix("/")
 */
class IndexController extends ControllerBase
{

    public function initialize()
    {
        parent::initialize();
    }

    public function indexAction()
    {
        $this->view->pick('index/index');
        $this->tag->prependTitle("Top");
        $form = new LoginForm();

        if ($this->session->has(SessionModel::KEY_USER_ID)) {
            $this->response->redirect("dashboard");
        } else {
            if ($this->request->isPost()) {
                if ($form->isValid($this->request->getPost()) == false) {

                } else {
                    $sessionModel = new SessionModel();
                    $userId = SessionModel::generateUserId();
                    $sessionModel->setUserId($userId);
                    $sessionModel->setUsername($this->request->getPost('username'));
                    $this->response->redirect("dashboard");
                }
            }
        }
        $this->view->form = $form;
    }
}
