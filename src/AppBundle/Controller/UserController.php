<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use AppBundle\Entity\User;
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
        return new JsonResponse($this->userService->get($userId), 200);
    }

    /**
     * @Get("users")
     * @return array
     */
    public function getUsersAction()
    {
        return new JsonResponse($this->userService->list(), 200);
    }

    /**
     * @Post("users")
     * @ParamConverter("request", converter="fos_rest.request_body")
     * @param AddUserRequest $request
     */
    public function addAction(AddUserRequest $request, ConstraintViolationListInterface $validationErrors)
    {
        if (count($validationErrors)) {
            throw new RequestValidationException($validationErrors);
        }
        $newUser = $this->userService->add($request);
        return new JsonResponse($newUser, 201);
    }
}
