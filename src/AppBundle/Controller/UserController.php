<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use AppBundle\User\User;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use AppBundle\Api\Exception\RequestValidationException;
use AppBundle\Api\User\Request\AddUserRequest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class UserController extends FOSRestController
{
    /**
     * @var \AppBundle\User\UserService
     */
    private $userService;

    /**
     * UserController constructor.
     *
     * @param \AppBundle\User\UserService $userService
     */
    public function __construct(\AppBundle\User\UserService $userService)
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
