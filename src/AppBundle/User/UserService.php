<?php

namespace AppBundle\User;

use AppBundle\Api\User\Request\AddUserRequest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use AppBundle\User\UserRepository;

class UserService
{
    /**
     * @var UserRepository
     */
    private $repository;

    /**
     * User constructor.
     *
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param $id
     * @return \AppBundle\Entity\User
     */
    public function get($id)
    {
        if (!$entity = $this->repository->find($id)) {
            throw new NotFoundHttpException();
        }
        return $entity;
    }

    public function list()
    {
        $all = $this->repository->findAll();
        return $all;
    }

    public function add(AddUserRequest $request)
    {
        $user = new User();
        $user->setUsername($request->name);
        $user->setPassword($request->password);
        $newUserId = $this->repository->create($user);
        return $this->get($newUserId);
    }
}
