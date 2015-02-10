<?php

namespace ExamplePhalcon\Controllers;

use ExamplePhalcon\Models\SessionModel;
use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Dispatcher;

class PrivateControllerBase extends ControllerBase
{
    public function beforeExecuteRoute(Dispatcher $dispatcher)
    {
        // ユーザ名がセットされていない場合はルートへリダイレクト
        if ($this->session->has(SessionModel::KEY_USER_ID)) {
            if ($dispatcher->getControllerName() == 'index' && $dispatcher->getActionName() == 'index') {
                $this->response->redirect('dashboard');
            }
        } else {
            $this->response->redirect("/", true);
        }
    }
}
