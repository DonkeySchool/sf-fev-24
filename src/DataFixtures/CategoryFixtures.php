<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=0; $i < 100; $i++) {
            $category = new Category();
            $category->setName('Cuisine ' . $i);
            $category->setDescription('Description ' . $i);
            $this->addReference('CATEGORY_'.$i, $category);
            $manager->persist($category);
        }

        $manager->flush();
    }
}
