<?php
namespace AppBundle\Api\User\Request;

use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

class UserRequest
{
    /**
     * Email address
     *
     * @Assert\Type("string")
     * @Assert\NotBlank()
     * @Assert\Email()
     * @JMS\Type("string")
     * @var string
     */
    public $name;

    /**
     * Unhashed password
     *
     * @Assert\NotBlank()
     * @Assert\Length(min=8)
     * @JMS\Type("string")
     * @var string
     */
    public $password;
}
