<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use stdClass;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class UserFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordEncoder, private SluggerInterface $slugger)
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        $count = $this->faker->numberBetween(5, 20);
        for ($a = 0; $a < $count; $a++) {
            $user = (new User())
                ->setEmail($this->faker->email())
                ->setFirstname($this->faker->firstName())
                ->setLastname($this->faker->lastName())
                ->setRoles(['ROLE_AUTHOR'])
                ->setAddress($this->faker->address())
                ->setPhoneNumber($this->faker->phoneNumber())
                ->setZipCode($this->faker->postCode())
                ->setUsername($this->faker->userName())
                ->setIsBanned(false);
            $user->setPassword(
                $this->passwordEncoder->hashPassword(
                    $user,
                    $this->faker->password()
                ));
            $user->setSlug($this->slugger->slug($user->getUsername())->lower());
            

            $manager->persist($user);
            $this->setReference('user-' . $a, $user);
        }

        $manager->flush();
    }
}
