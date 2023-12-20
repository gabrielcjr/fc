<?php

namespace FC\UserBundle\Listener;


use Doctrine\ORM\Event\LifecycleEventArgs;
use FC\UserBundle\Entity\User;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class UserListener 
{
    private $encoderFactory;

    public function __construct(EncoderFactoryInterface $encoderFactory){
        $this->encoderFactory = $encoderFactory;
    }
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if( $entity instanceof User ) {
            $this->handleEvent($entity);
        }
    }

    private function handleEvent(User $user) {
        $encoder = $this->encoderFactory->getEncoder($user);

        $password = $encoder->encodePassword($user->getPlainPassword(), $user->getSalt());
        $user->setPassword($password);
    }
}