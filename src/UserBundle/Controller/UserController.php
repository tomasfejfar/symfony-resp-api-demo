<?php

namespace UserBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use UserBundle\Entity\User;

class UserController extends FOSRestController
{
    public function getUserAction(User $user)
    {
        return array('user' => $user);
    }
}
