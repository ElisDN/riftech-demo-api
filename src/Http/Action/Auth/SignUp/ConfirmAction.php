<?php

declare(strict_types=1);

namespace App\Http\Action\Auth\SignUp;

use App\Model\User\UseCase\SignUp\Confirm\Command;
use App\Model\User\UseCase\SignUp\Confirm\Handler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Zend\Diactoros\Response\JsonResponse;

class ConfirmAction implements RequestHandlerInterface
{
    private $handler;
    private $validator;

    public function __construct(Handler $handler, ValidatorInterface $validator)
    {
        $this->handler = $handler;
        $this->validator = $validator;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $body = json_decode($request->getBody()->getContents(), true);

        $command = new Command();

        $command->email = $body['email'] ?? '';
        $command->token = $body['token'] ?? '';

        $violations = $this->validator->validate($command);
        if ($violations->count() > 0) {
            $errors = [];
            foreach ($violations as $violation) {
                $errors[$violation->getPropertyPath()] = $violation->getMessage();
            }
            return new JsonResponse(['errors' => $errors], 400);
        }

        $this->handler->handle($command);

        return new JsonResponse([
            'links' => [
                [
                    'rel' => 'profile',
                    'url' => '/profile',
                    'type' => 'GET',
                ],
            ],
        ]);
    }
}
