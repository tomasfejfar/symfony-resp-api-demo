<?php
namespace AppBundle\Api\Response;

use AppBundle\Entity\User;

class UserResponseFactory
{
    public function getResponseFor(User $user)
    {
        return [
            'id' => $user->getId(),
            'name' => $user->getUsername(),
        ];
    }
}
