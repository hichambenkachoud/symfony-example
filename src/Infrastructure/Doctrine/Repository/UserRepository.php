<?php

namespace App\Infrastructure\Doctrine\Repository;

use App\Domain\User\Entity\User;
use App\Domain\User\Gateway\UserGateway;
use App\Infrastructure\Doctrine\Entity\DoctrineUser;
use App\Infrastructure\Doctrine\Factory\UserFactory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @method DoctrineUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method DoctrineUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method DoctrineUser[]    findAll()
 * @method DoctrineUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface, UserGateway
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DoctrineUser::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof DoctrineUser) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    public function register(User $user): void
    {
        $doctrineUser = UserFactory::createFromDomainUser($user);
        $this->_em->persist($doctrineUser);
        $this->_em->flush();
    }

    public function findOneByEmail(string $username): ?User
    {
        $doctrineUser = $this->findOneBy(['email' => $username]);

        if (null === $doctrineUser) {
            return null;
        }
        return new User(
            $doctrineUser->getNickname(),
            $doctrineUser->getEmail(),
            $doctrineUser->getCreatedAt(),
            $doctrineUser->getPassword(),
        );
    }
}
