<?php

namespace UserBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use UserBundle\Entity\User;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use UserBundle\Exception\RequestValidationException;
use UserBundle\Request\AddUserRequest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

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

    /**
     * @Get("users/{userId}")
     * @param $userId
     * @return User
     */
    public function getUserAction($userId)
    {
        return $this->userService->get($userId);
    }

    /**
     * @Get("users")
     * @return array
     */
    public function getUsersAction()
    {
        return $this->userService->list();
    }

    /**
     * @Post("users")
     * @ParamConverter("request", converter="fos_rest.request_body")
     * @param AddUserRequest $request
     */
    public function addAction(AddUserRequest $request, ConstraintViolationListInterface $validationErrors)
    {
        if (count($validationErrors)) {
            return new RequestValidationException($validationErrors);
        }
        return $request;
    }
}
