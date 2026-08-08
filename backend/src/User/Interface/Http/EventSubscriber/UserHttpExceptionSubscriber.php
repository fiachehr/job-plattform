<?php

namespace App\User\Interface\Http\EventSubscriber;

use App\User\Domain\Exception\EmailAlreadyExistsException;
use App\User\Interface\Http\Response\ErrorResponse;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Throwable;

final class UserHttpExceptionSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($this->handleEmailConflict($event, $exception)) {
            return;
        }

        if ($this->handleValidationError($event, $exception)) {
            return;
        }

        $this->handleInvalidJson($event, $exception);
    }


    private function handleEmailConflict(ExceptionEvent $event, Throwable $exception): bool
    {
        if (!($exception instanceof EmailAlreadyExistsException)) {
            return false;
        }

        $event->setResponse($this->errorJson($exception->getMessage(), 409));

        return true;
    }

    private function handleValidationError(ExceptionEvent $event, Throwable $exception): bool
    {
        if (
            !($exception instanceof UnprocessableEntityHttpException)
            || !($exception->getPrevious() instanceof ValidationFailedException)
        ) {
            return false;
        }

        $errors = [];
        foreach ($exception->getPrevious()->getViolations() as $violation) {
            $errors[$violation->getPropertyPath()][] = $violation->getMessage();
        }

        $event->setResponse($this->errorJson('Validation failed.', 422, $errors));

        return true;
    }


    private function handleInvalidJson(ExceptionEvent $event, Throwable $exception): void
    {
        if (!($exception instanceof BadRequestHttpException)) {
            return;
        }

        $event->setResponse($this->errorJson('Invalid JSON payload.', 400));
    }


    private function errorJson(string $message, int $statusCode, array $errors = []): JsonResponse
    {
        return new JsonResponse(
            (new ErrorResponse($message, $errors))->toArray(),
            $statusCode
        );
    }
}
