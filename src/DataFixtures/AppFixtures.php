<?php

namespace App\DataFixtures;

use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user1 = new User();
        $user1->setEmail('user+1@email.com')
            ->setPassword($this->passwordHasher->hashPassword($user1, 'password1'))
            ->setRoles([])
            ->setNickname('user+1');
         $manager->persist($user1);

        $user2 = new User();
        $user2->setEmail('admin@email.com')
            ->setPassword($this->passwordHasher->hashPassword($user2, 'password1'))
            ->setRoles(['ROLE_ADMIN'])
            ->setNickname('admin');
         $manager->persist($user2);

        $userSuspended = new User();
        $userSuspended->setEmail('user+suspended@email.com')
            ->setPassword($this->passwordHasher->hashPassword($userSuspended, 'password1'))
            ->setRoles([])
            ->setSuspendAt(new DateTimeImmutable())
            ->setNickname('user+suspended');
         $manager->persist($userSuspended);

        $manager->flush();
    }
}
