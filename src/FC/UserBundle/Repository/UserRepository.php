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

     /**
     * @param string $username The username
     *
     * @return UserInterface
     *
     * @throws UsernameNotFoundException if the user is not found
     */
    public function loadUserByUsername($username) {
        $user = $this->findOneByUsernameOrPassword($username);
        if (!$user) {
            throw new UsernameNotFoundException("User not found: {$username}");
        }
        return $user;
    }

    /**
     * Refreshes the user.
     * @return UserInterface
     *
     * @throws UnsupportedUserException if the user is not supported
     */
    public function refreshUser(UserInterface $user) {
        $class = get_class($user);
        if(!$this->supportsClass($class)) {
            throw new UnsupportedUserException("Error, not supperted class: {$class}");
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    /**
     * @param string $class
     *
     * @return bool
     */
    public function supportsClass($class) {
        return $this->getEntityName() == $class;
    }
}
