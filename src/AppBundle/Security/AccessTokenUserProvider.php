<?php

namespace AppBundle\Security;

use AppBundle\Entity\User;
use AppBundle\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class AccessTokenUserProvider implements UserProviderInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * Constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param string $token
     *
     * @return User|null
     */
    public function getUserByAccessToken($token)
    {
        /** @var UserRepository $repository */
        $repository = $this->entityManager->getRepository(User::class);

        return $repository->findByAccessToken($token);
    }

    /**
     * {@inheritdoc}
     */
    public function loadUserByUsername($username)
    {
        throw new UsernameNotFoundException();
    }

    /**
     * {@inheritdoc}
     */
    public function refreshUser(UserInterface $user)
    {
        // Not needed for stateless auth
        throw new UnsupportedUserException();
    }

    /**
     * {@inheritdoc}
     */
    public function supportsClass($class)
    {
        return $class === User::class;
    }
}
