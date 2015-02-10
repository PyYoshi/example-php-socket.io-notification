<?php

namespace ExamplePhalcon\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\Identical;

class LoginForm extends Form
{
    public function initialize($entity = null, $options = null)
    {
        $username = new Text("username");
        $username->addValidator(new PresenceOf(array(
            'message' => 'your username is required.'
        )));
        $username->addValidator(new StringLength(array(
            'min' => 4,
            'max' => 12,
            'messageMinimum' => 'Please lengthen your username to at least 4 characters.'
        )));
        $this->add($username);
    }

    public function messages($title)
    {
        if ($this->hasMessagesFor($title)) {
            foreach ($this->getMessagesFor($title) as $message) {
                $this->flash->error($message);
            }
        }
    }
}