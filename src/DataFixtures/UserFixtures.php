<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Baker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    public const USERS = [
        [
            'email' => 'customer@gmail.com',
            "roles" => ["ROLE_CUSTOMER"],
            "password" => 'customerpassword'
        ],
        [
            'email' => 'baker@gmail.com',
            'roles' => ['ROLE_BAKER'],
            'password' => 'bakerpassword'
        ],
        [
            'email' => 'admin@monsite.com',
            'roles' => ['ROLE_ADMIN'],
            'password' => 'adminpassword'
        ],
    ];

    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $number = 1;
        // Création d'un utilisateur de type "contributeur" (= auteur)
        foreach (self::USERS as $userName) {
            $faker = Factory::create();
            $user = new User();
            $user->setEmail($userName['email']);
            $user->setRoles($userName['roles']);
            $hashedPassword = $this->passwordHasher->hashPassword(
                $user,
                $userName['password']
            );
            $user->setPassword($hashedPassword);
            // adds a reference to User to bind it with an Address
            $this->addReference('billingAddress_' . $number, $user);          

            $roles = $user->getRoles();
            if($roles == 'ROLE_BAKER') {
                $this->getReference('baker_' . $faker->numberBetween(0, 49));
            }

            $manager->persist($user);
            
            $number++;
        }
        // Sauvegarde des 3 nouveaux utilisateurs :
        $manager->flush();
    }

    public function getDependencies()
    {
        // Tu retournes ici toutes les classes de fixtures dont addressFixtures dépend
        return [
            BakerFixtures::class
        ];
    }
}
