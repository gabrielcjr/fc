<?php

namespace FC\CatalogBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use FC\CatalogBundle\Entity\Catalog;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;

class LoadCatalog extends AbstractFixture implements OrderedFixtureInterface {

    public function load(ObjectManager $manager) {
        $user = $this->getReference("user-user");
        $catalog = new Catalog();
        $catalog->setName("artistic paint")
            ->setDescription("artistic paint collection")
            ->setReleaseDate(new \DateTime("now"))
            ->setImageName("paint.jpg")
            ->setAuthor($user);
        
        $catalog2 = new Catalog();
        $catalog2->setName("relic artistic paint")
            ->setDescription("relic artistic paint collection")
            ->setReleaseDate(new \DateTime("yesterday noon"))
            ->setImageName("relic.jpg")
            ->setAuthor($user);
        
        $manager->persist($catalog);
        $manager->persist($catalog2);
        
        $manager->flush();
    }

    function getOrder() {
        return 20;
    }

}