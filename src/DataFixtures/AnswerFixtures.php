<?php

namespace App\DataFixtures;

use App\Entity\Ticket;
use App\Entity\Answer;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AnswerFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }


    public function load(ObjectManager $manager): void
    {
        $count = $this->faker->numberBetween(10, 30);
        for ($a = 1; $a <= $count; $a++) {
            $randomUserId = $this->faker->numberBetween(0, 4);
            /** @var User $randomUser */
            $randomUser = $this->getReference('user-' . $randomUserId);

            $randomTicketId = $this->faker->numberBetween(0, 4);
            /** @var Ticket $randomTicket */
            $randomTicket = $this->getReference('ticket-' . $randomTicketId);

            $minDate = $randomTicket->getPublishedDate();
            $date = $this->faker->dateTimeBetween(
                $minDate,
                'now',
            );

            $ticket = (new Answer())
                ->setContent($this->faker->sentence(20))
                ->setPublishedDate($date)
                ->setAuthor($randomUser)
                ->setTicket($randomTicket)
                ->setUpdatedAt(new \DateTime());

            $manager->persist($ticket);   
        }

        $manager->flush();
    }

    public function getDependencies() : array
    {
        return [
            UserFixtures::class,
            TicketFixtures::class,
        ];
    }
}
