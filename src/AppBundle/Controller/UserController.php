<?php

namespace AppBundle\Controller;

use AppBundle\Api\User\Response\UserResponseFactory;
use AppBundle\User\UserService;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use AppBundle\Entity\User;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\Delete;
use AppBundle\Api\Exception\RequestValidationException;
use AppBundle\Api\User\Request\UserRequest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

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
     * @ApiDoc(
     *   resource = true,
     *   description = "Gets a user",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *   }
     * )
     * @Get("users/{id}", requirements={"id" = "\d+"})
     * @param $id
     * @return User
     */
    public function getUserAction($id)
    {
        return new JsonResponse($this->userService->get($id), 200);
    }

    /**
     * @ApiDoc(
     *   resource = true,
     *   description = "Lists users",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *   }
     * )
     * @Get("users")
     * @return array
     */
    public function getUsersAction()
    {
        return new JsonResponse(array_map(function (User $user) {
            return $this->userResponseFactory->getResponseFor($user);
        }, $this->userService->list()), 200);
    }

    /**
     * @ApiDoc(
     *   resource = true,
     *   description = "Creates a new user",
     *   input = "\AppBundle\Api\User\Request\UserRequest",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when validation fails"
     *   }
     * )
     * @Post("users")
     * @ParamConverter("request", converter="fos_rest.request_body")
     * @param UserRequest $request
     */
    public function addAction(UserRequest $request, ConstraintViolationListInterface $validationErrors)
    {
        if (count($validationErrors)) {
            throw new RequestValidationException($validationErrors);
        }
        $this->userService->add($request);
        return new JsonResponse(null, 204);
    }

    /**
     * @ApiDoc(
     *   resource = true,
     *   description = "Removes user",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *   },
     *     requirements={
     *      {
     *       "name"="id",
     *      "requirement"="\d+",
     *      "dataType"="integer",
     *      "required"=true,
     *      "description"="ID of user to be updated"
     *     }
     *   }
     * )
     * @Delete("users/{id}", requirements={"id" = "\d+"})
     */
    public function removeAction($id)
    {
        $this->userService->remove($id);
        return new JsonResponse(null, 204);
    }

    /**
     * @ApiDoc(
     *   resource = true,
     *   description = "Updates user",
     *   input = "\AppBundle\Api\User\Request\UserRequest",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *   },
     *   requirements={
     *      {
     *       "name"="id",
     *      "requirement"="\d+",
     *      "dataType"="integer",
     *      "required"=true,
     *      "description"="ID of user to be updated"
     *     }
     *   }
     * )
     * @Put("users/{id}", requirements={"id" = "\d+"})
     */
    public function updateAction($id, UserRequest $request, ConstraintViolationListInterface $validationErrors)
    {
        if (count($validationErrors)) {
            throw new RequestValidationException($validationErrors);
        }
        $this->userService->set($id, $request);
        return new JsonResponse(null, 204);
    }
}
