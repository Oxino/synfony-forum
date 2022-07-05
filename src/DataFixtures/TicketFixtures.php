<?php

namespace App\DataFixtures;

use App\Entity\Ticket;
use App\Entity\Category;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class TicketFixtures extends Fixture implements DependentFixtureInterface
{

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }


    public function load(ObjectManager $manager): void
    {
        $count = $this->faker->numberBetween(10, 30);
        for ($a = 0; $a < $count; $a++) {
            $randomUserId = $this->faker->numberBetween(0, 4);
            /** @var User $randomUser */
            $randomUser = $this->getReference('user-' . $randomUserId);

            $randomCategoryId = $this->faker->numberBetween(0, 4);
            /** @var Category $randomCategory */
            $randomCategory = $this->getReference('category-' . $randomCategoryId);

            $ticket = new Ticket();
            $ticket->setTitle($this->faker->sentence(6));
            $ticket->setAuthor($randomUser);
            $ticket->setCategory($randomCategory);
            $ticket->setUpdatedAt(new \DateTime());
            $ticket->setIsClose(false);

            $manager->persist($ticket);   
            $this->setReference('ticket-' . $a, $ticket);
        }

        $manager->flush();
    }

    public function getDependencies() : array
    {
        return [
            UserFixtures::class,
            CategoryFixtures::class,
        ];
    }
}