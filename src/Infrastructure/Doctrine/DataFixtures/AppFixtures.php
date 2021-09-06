<?php

namespace App\Infrastructure\Doctrine\DataFixtures;

use App\Domain\User\Encoder\PasswordEncoderInterface;
use App\Domain\User\Entity\User;
use App\Infrastructure\Doctrine\Factory\UserFactory;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{

    private PasswordEncoderInterface $passwordEncoder;

    public function __construct(PasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User("admin", "admin@email.com", new DateTimeImmutable());
        $user->encodePassword($this->passwordEncoder, "password");
        $manager->persist(UserFactory::createFromDomainUser($user, true));
        $manager->flush();
    }
}
