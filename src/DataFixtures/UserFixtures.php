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
            $this->createUser($manager);
        }
        $this->createUser($manager, [
            'email' => 'testuser@gmail.com',
            'username' => 'TestUser',
            'firstname' => 'Tim',
            'lastname' => 'Laurençon',
            'address' => '7 Cours Dupré Saint Maur',
            'zip_code' => '33300',
            'phone_number' => '0665543432',
            'roles' => ['ROLE_AUTHOR'],
            'password' => '123456'
        ]);
        $this->createUser($manager, [
            'email' => 'testadministrator@gmail.com',
            'username' => 'TestAdministrator',
            'firstname' => 'Max',
            'lastname' => 'Dessange',
            'address' => '7 Cours Dupré Saint Maur',
            'zip_code' => '33300',
            'phone_number' => '0665543432',
            'roles' => ['ROLE_ADMINISTRATOR', 'ROLE_AUTHOR',],
            'password' => '123456'
        ]);

        $manager->flush();
    }

    public function createUser(ObjectManager $manager, array $data = []) {
        static $index = 0;
        $data = array_replace(
            [
                'email' => $this->faker->email(),
                'username' => $this->faker->userName(),
                'firstname' => $this->faker->firstName(),
                'lastname' => $this->faker->lastName(),
                'address' => $this->faker->address(),
                "zip_code" => $this->faker->postCode(),
                'phone_number' => $this->faker->phoneNumber(),
                "roles" => ['ROLE_AUTHOR'],
                "password" => $this->faker->password(),
            ],
            $data,
        );

        $user = (new User())
            ->setEmail($data['email'])
            ->setUsername($data['username'])
            ->setFirstname($data['firstname'])
            ->setLastname($data['lastname'])
            ->setAddress($data['address'])
            ->setZipCode($data['zip_code'])
            ->setPhoneNumber($data['phone_number'])
            ->setBanned(false)
            ->setSlug($this->slugger->slug($data['username'])->lower())
            ->setRoles($data['roles']);
        
        $user->setPassword($this->passwordEncoder->hashPassword($user, $data['password']));   
        $manager->persist($user);
        $this->setReference('user-' . $index++, $user);
    }
}
