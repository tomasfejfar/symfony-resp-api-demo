<?php
namespace AppBundle\Api\Exception;

use Symfony\Component\Validator\ConstraintViolationListInterface;

class RequestValidationException extends \Exception
{
    /**
     * @var ConstraintViolationListInterface
     */
    private $validationErrors;

    /**
     * RequestValidationException constructor.
     *
     * @param ConstraintViolationListInterface $validationErrors
     */
    public function __construct(ConstraintViolationListInterface $validationErrors)
    {
        $this->validationErrors = $validationErrors;
    }

    /**
     * @return ConstraintViolationListInterface
     */
    public function getValidationErrors()
    {
        return $this->validationErrors;
    }
}
