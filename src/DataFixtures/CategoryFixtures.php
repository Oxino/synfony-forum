<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CategoryFixtures extends Fixture
{
    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        $total = 0;
        $count = $this->faker->numberBetween(5, 20);
        for ($a = 1; $a <= $count; $a++) {
            $category = new Category();
            $category->setTitle($this->faker->word());

            $manager->persist($category);
            $this->setReference('category-' . $total++, $category);
        }

        $manager->flush();
    }
}
