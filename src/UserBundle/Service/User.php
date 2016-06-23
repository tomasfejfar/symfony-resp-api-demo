<?php

namespace UserBundle\Service;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use UserBundle\Repository\UserRepository;

class User
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
     * @return \UserBundle\Entity\User
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
}
