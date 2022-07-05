<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoryFixtures extends Fixture
{
    public function __construct(private SluggerInterface $slugger)
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
       

        $count = $this->faker->numberBetween(5, 8);
        for ($a = 1; $a <= $count; $a++) {
            static $total = 0; $titles = [];

            do {
                $title = $this->faker->word();
            } while (in_array($title, $titles, true));
            $titles[] = $title;
            $category = new Category();
            $category->setTitle($title);
            $category->setSlug($this->slugger->slug($title)->lower());

            $manager->persist($category);
            $this->setReference('category-' . $total++, $category);
        }

        $manager->flush();
    }
}
