<?php
namespace AppBundle\Api\Exception;

use Symfony\Component\Validator\ConstraintViolationListInterface;

class RequestValidationException extends \Exception
{
    /**
     * @var ConstraintViolationListInterface
     */
    private $validations;

    /**
     * RequestValidationException constructor.
     *
     * @param ConstraintViolationListInterface $validations
     */
    public function __construct(ConstraintViolationListInterface $validations)
    {
        $this->validations = $validations;
    }
}
