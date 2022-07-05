<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use stdClass;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordEncoder)
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        $count = $this->faker->numberBetween(5, 20);
        for ($a = 0; $a < $count; $a++) {
            $user = new User();
            $user->setEmail($this->faker->email());
            $user->setFirstname($this->faker->firstName());
            $user->setLastname($this->faker->lastName());
            $user->setRoles(['ROLE_AUTHOR']);
            $user->setPassword(
                $this->passwordEncoder->hashPassword(
                    $user,
                    $this->faker->password()
            ));
            $user->setAddress($this->faker->address());
            $user->setPhoneNumber($this->faker->phoneNumber());
            $user->setZipCode($this->faker->postCode());
            $user->setUsername($this->faker->userName());
            $user->setIsBanned(false);
            

            $manager->persist($user);
            $this->setReference('user-' . $a, $user);
        }

        $manager->flush();
    }
}
