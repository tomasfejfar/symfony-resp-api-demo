<?php

namespace AppBundle\Service;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use AppBundle\User\UserRepository;

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
     * @return \AppBundle\User\User
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
