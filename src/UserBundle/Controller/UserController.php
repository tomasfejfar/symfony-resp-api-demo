<?php

namespace UserBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use UserBundle\Entity\User;

class UserController extends FOSRestController
{
    /**
     * @var \UserBundle\Service\User
     */
    private $userService;

    /**
     * UserController constructor.
     *
     * @param \UserBundle\Service\User $userService
     */
    public function __construct(\UserBundle\Service\User $userService)
    {
        $this->userService = $userService;
    }

    public function getUserAction($userId)
    {
        return $this->userService->get($userId);
    }

    public function getUsersAction()
    {
        return $this->userService->list();
    }
}
