<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use AppBundle\Entity\User;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use AppBundle\Exception\RequestValidationException;
use AppBundle\Request\AddUserRequest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class UserController extends FOSRestController
{
    /**
     * @var \AppBundle\Service\User
     */
    private $userService;

    /**
     * UserController constructor.
     *
     * @param \AppBundle\Service\User $userService
     */
    public function __construct(\AppBundle\Service\User $userService)
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
