<?php

namespace App\Domain\User\UseCase\Registration;

use App\Domain\Shared\Provider\DateProviderInterface;
use App\Domain\User\Encoder\PasswordEncoderInterface;
use App\Domain\User\Entity\User;
use App\Domain\User\Gateway\UserGateway;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class Registration implements RegistrationInterface
{

    private UserGateway $userGateway;
    private DateProviderInterface $dateProvider;
    private ValidatorInterface $validator;
    private PasswordEncoderInterface $passwordEncoder;

    public function __construct(
        UserGateway $userGateway,
        DateProviderInterface $dateProvider,
        ValidatorInterface $validator,
        PasswordEncoderInterface $passwordEncoder
    ) {
        $this->userGateway = $userGateway;
        $this->dateProvider = $dateProvider;
        $this->validator = $validator;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function execute(RegistrationRequest $request, RegistrationPresenterInterface $presenter): void
    {
        $request->validate($this->validator);

        $user = new User(
            $request->nickname,
            $request->email,
            $this->dateProvider->now()
        );

        $user->encodePassword($this->passwordEncoder, $request->password);

        $this->userGateway->register($user);

        $presenter->present(RegistrationResponse::create($user));
    }
}
