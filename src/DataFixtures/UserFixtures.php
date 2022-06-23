<?php

namespace App\DataFixtures;

use App\Entity\Baker;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    public const USERS = [
        [
            'email' => 'customer@gmail.com',
            "roles" => ["ROLE_CUSTOMER"],
            "password" => 'customerpassword',
        ],
        [
            'email' => 'baker@gmail.com',
            'roles' => ['ROLE_BAKER'],
            'password' => 'bakerpassword',
        ],
        [
            'email' => 'admin@monsite.com',
            'roles' => ['ROLE_ADMIN'],
            'password' => 'adminpassword',
        ],
    ];

    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Création d’un utilisateur de type “contributeur” (= auteur)

        $faker = Factory::create('fr_FR');
        $user = new User();
        $user->setLastname($faker->lastName());
        $user->setFirstname($faker->firstName());
        $user->setEmail('customer@gmail.com');
        //$user->setAddress($faker->address());
        $user->setPhone($faker->phoneNumber());
        $user->setRoles(['ROLE_USER']);
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            'customerpassword'
        );

        $user->setPassword($hashedPassword);
        $this->addReference('user_1', $user);
        $manager->persist($user);


        // Création d’un utilisateur de type “administrateur”
        $faker = Factory::create('fr_FR');
        $admin = new User();
        $admin->setLastname($faker->lastName());
        $admin->setFirstname($faker->firstName());
        $admin->setEmail('admin@monsite.com');
        //$admin->setAddress($faker->address());
        $admin->setPhone($faker->phoneNumber());
        $admin->setRoles(['ROLE_ADMIN']);
        $hashedPassword = $this->passwordHasher->hashPassword(
            $admin,
            'adminpassword'
        );
        $admin->setPassword($hashedPassword);
        $this->addReference('user_2', $admin);
        $manager->persist($admin);


        // Création d’un utilisateur de type “contributeur” (= auteur)
        $faker = Factory::create('fr_FR');
        for ($i = 3; $i < 101; $i++) {
            $user = new User();
            $user->setLastname($faker->lastName());
            $user->setFirstname($faker->firstName());
            $user->setEmail($faker->email());
            //$user->setAddress($faker->address());
            $user->setBillingAddress($this->getReference('billingAddress_' . $i));
            $user->setPhone($faker->phoneNumber());
            $user->setRoles(['ROLE_USER']);
            $hashedPassword = $this->passwordHasher->hashPassword(
                $user,
                $faker->password(8, 15)
            );
            $user->setPassword($hashedPassword);
            $this->addReference('user_' . $i, $user);
            // adds a reference to User to bind it with an Address
            //$this->addReference('billingAddress_' . $i, $user);
            $manager->persist($user);
        }
        // Sauvegarde des 3 nouveaux utilisateurs :
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return
            [
                AddressFixtures::class
            ];
    }
}
