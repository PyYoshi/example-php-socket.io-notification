<?php

namespace ExamplePhalcon\Models;

use Phalcon\Mvc\User\Component;
use Rhumsaa\Uuid\Uuid;

class SessionModel extends Component
{

    const KEY_USERNAME = 'ses-username';
    const KEY_USER_ID = 'ses-user-id';

    public function getUsername()
    {
        return $this->session->get(self::KEY_USERNAME);
    }

    public function setUsername($val)
    {
        $this->session->set(self::KEY_USERNAME, $val);
    }

    public function getUserId()
    {
        return $this->session->get(self::KEY_USER_ID);
    }

    public function setUserId($val)
    {
        $this->session->set(self::KEY_USER_ID, $val);
    }

    public static function generateUserId()
    {
        return Uuid::uuid4()->toString();
    }

    public function destroy()
    {
        $this->session->destroy();
    }
}