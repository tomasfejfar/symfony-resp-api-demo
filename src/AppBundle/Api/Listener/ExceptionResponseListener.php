<?php
namespace AppBundle\Api\Listener;

use AppBundle\Api\Exception\RequestValidationException;
use Doctrine\DBAL\Driver\PDOException;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

class ExceptionResponseListener
{
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();
        if ($exception instanceof RequestValidationException) {
            $validationErrors = [];

            /** @var  $violation */
            foreach ($exception->getValidationErrors() as $violation) {
                $validationErrors[] = [
                    'message' => $violation->getMessage(),
                    'path' => $violation->getPropertyPath(),
                    'invalidValue' => $violation->getInvalidValue(),
                ];
            }
            $event->setResponse(new JsonResponse([
                'errors' => $validationErrors,
                'code' => 400,
            ], 400));
        } elseif ($exception instanceof UniqueConstraintViolationException) {
            /** @var $previous PDOException */
            $previous = $exception->getPrevious();
            $event->setResponse(new JsonResponse([
                'errors' => [
                    [
                        "message" => $previous->errorInfo[2]
                    ]
                ],
                'code' => 400,
            ], 400));
        } else {
            $response = [
                'error' => sprintf('Error %s', get_class($exception)),
                'message' => $exception->getMessage(),
                'trace' => $exception->getTrace(),
                'code' => 500,
            ];
            $event->setResponse(new JsonResponse($response, 500));
        }
    }
}
