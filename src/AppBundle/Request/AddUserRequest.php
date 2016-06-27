<?php
namespace AppBundle\Request;

use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

class AddUserRequest
{
    /**
     * @Assert\Type("string")
     * @Assert\NotBlank()
     * @JMS\Type("string")
     * @var string
     */
    public $name;

    /**
     * @Assert\NotBlank()
     * @JMS\Type("string")
     * @var string
     */
    public $password;
}
