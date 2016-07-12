<?php

namespace AppBundle\Controller;

use AppBundle\Api\Response\UserResponseFactory;
use AppBundle\User\UserService;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use AppBundle\Entity\User;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use AppBundle\Api\Exception\RequestValidationException;
use AppBundle\Api\User\Request\AddUserRequest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class UserController extends FOSRestController
{
    /**
     * @var UserService
     */
    private $userService;

    /**
     * @var UserResponseFactory
     */
    private $userResponseFactory;

    /**
     * UserController constructor.
     *
     * @param UserService $userService
     * @param UserResponseFactory $userResponseFactory
     */
    public function __construct(UserService $userService, UserResponseFactory $userResponseFactory)
    {
        $this->userService = $userService;
        $this->userResponseFactory = $userResponseFactory;
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
        return new JsonResponse(array_map(function (User $user) {
            $this->userResponseFactory->getResponseFor($user);
        }, $this->userService->list()), 200);
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
        $this->userService->add($request);
        return new JsonResponse(null, 204);
    }

    /**
     * @Delete("users/{id}")
     */
    public function removeAction($id)
    {
        $this->userService->remove($id);
        return new JsonResponse(null, 204);
    }
}
