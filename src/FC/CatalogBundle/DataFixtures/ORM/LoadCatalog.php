<?php

namespace FC\CatalogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FC\CatalogBundle\Entity\Catalog;

class LoadCatalog implements FixtureInterface {

    public function load(ObjectManager $manager) {
        $catalog = new Catalog();
        $catalog->setName("artistic paint")
            ->setDescription("artistic paint collection")
            ->setReleaseDate(new \DateTime("now"))
            ->setImageName("paint.jpg");
        
        $catalog2 = new Catalog();
        $catalog2->setName("relic artistic paint")
            ->setDescription("relic artistic paint collection")
            ->setReleaseDate(new \DateTime("yesterday noon"))
            ->setImageName("relic.jpg");
        
        $manager->persist($catalog);
        $manager->persist($catalog2);
        
        $manager->flush();
    }
}