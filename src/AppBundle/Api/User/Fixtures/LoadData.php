<?php

namespace AppBundle\Api\User\Fixtures;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;

class LoadData implements FixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('tomasfejfar');
        $user->setPassword('hardtoguesspassword');
        $manager->persist($user);
        $manager->flush();
    }
}
