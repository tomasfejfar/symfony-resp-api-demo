<?php

namespace AppBundle\Service;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use AppBundle\Repository\UserRepository;

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
}
