<?php

namespace FC\UserBundle\Repository;

use Doctrine\ORM\EntityRepository;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;


class UserRepository extends EntityRepository implements UserProviderInterface
{

    public function findOneByUsernameOrPassword($user){
        return $this->createQueryBuilder("u")
        ->where("u.username = :username or u.email = :email")
        ->setParameter("username", $user)
        ->setParameter("email", $user)
        ->getQuery()
        ->getOneOrNullResult();
    }

    public function loadUserByUsername(string $username) {
        $user = $this->findOneByUsernameOrPassword($username);
        if (!$user) {
            throw new UsernameNotFoundException(sprintf("User not found", $username));
        }
    }
    public function refreshUser(UserInterface $user) {
        $class = get_class($user);
        if(!$this->supportsClass($class)) {
            throw new UnsupportedUserException(sprintf("Error, not supperted class", $class));
        }
    }
    public function supportsClass(string $class) {
        return $this->getEntityName() == $class;
    }
}
