<?php

namespace FC\UserBundle\Listener;

class UserListener 
{
    public function prePersist()
    {
        die("Testing method");
    }
}