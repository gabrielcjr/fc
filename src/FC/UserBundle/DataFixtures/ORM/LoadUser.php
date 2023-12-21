<?php

namespace FC\UserBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use FC\UserBundle\Entity\User;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;

class LoadUser extends AbstractFixture implements ContainerAwareInterface, OrderedFixtureInterface {

    private $container;

    public function load(ObjectManager $manager) {
        $user = new User();
        $user->setUsername("user")
            ->setEmail("user@user.com")
            ->setPlainPassword("user")
            ->setRoles(array("ROLE_USER"))
            ->setIsActive(true);
        
        $manager->persist($user);

        $this->addReference("user-user", $user);

        $admin = new User();
        $admin->setUsername("admin")
            ->setEmail("admin@admin.com")
            ->setPlainPassword("admin")
            ->setRoles(array("ROLE_ADMIN"))
            ->setIsActive(true);
        
        $manager->persist($admin);

        $manager->flush();
    }
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

    function getOrder() {
        return 10;
    }

}