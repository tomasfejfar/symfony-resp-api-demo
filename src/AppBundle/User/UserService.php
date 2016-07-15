<?php

namespace AppBundle\User;

use AppBundle\Api\User\Request\UserRequest;
use AppBundle\Entity\User;
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

    public function add(UserRequest $request)
    {
        $user = new User();
        $user->setUsername($request->name);
        $user->setPassword($request->password);
        $this->repository->create($user);
    }

    public function remove($id)
    {
        $user = $this->repository->find($id);
        $this->repository->remove($user);
    }
}
