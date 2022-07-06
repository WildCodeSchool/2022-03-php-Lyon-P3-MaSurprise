<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Address;
use App\Entity\Baker;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create('fr_FR');
        // creating ONE known admin account
        $user = new User();
        $user->setLastname($faker->lastName());
        $user->setFirstname($faker->firstName());
        $user->setEmail("admin@admin.com");
        $user->setPhone($faker->phoneNumber());
        $user->setRoles(['ROLE_ADMIN']);
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            "password"
        );
        $user->setPassword($hashedPassword);
        $manager->persist($user);

        // creating ONE known baker account (user_0)
        $user = new User();
        $user->setLastname($faker->lastName());
        $user->setFirstname($faker->firstName());
        $user->setEmail("baker@baker.com");
        $user->setPhone($faker->phoneNumber());
        if ($this->getReference('billingAddress_0') instanceof Address) {
            $user->addBillingAddress($this->getReference('billingAddress_0'));
        }
        $user->setRoles(['ROLE_BAKER']);
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            "password"
        );
        $user->setPassword($hashedPassword);
        $this->addReference('seller_0', $user);
        $this->addReference('user_0', $user);
        $manager->persist($user);

        // creating 49 random bakers (user_0 to user_49)
        for ($i = 1; $i < 50; $i++) {
            $user = new User();
            $user->setLastname($faker->lastName());
            $user->setFirstname($faker->firstName());
            $user->setEmail($faker->email());
            $user->setPhone($faker->phoneNumber());
            if ($this->getReference('billingAddress_' . $i) instanceof Address) {
                $user->addBillingAddress($this->getReference('billingAddress_' . $i));
            }
            $user->setRoles(['ROLE_BAKER']);
            $hashedPassword = $this->passwordHasher->hashPassword(
                $user,
                "password"
            );
            $user->setPassword($hashedPassword);

            $this->addReference('seller_' . $i, $user);
            $this->addReference('user_' . $i, $user);
            $manager->persist($user);
        }

        // creating ONE known customer account (user_50)
        $user = new User();
        $user->setLastname($faker->lastName());
        $user->setFirstname($faker->firstName());
        $user->setEmail("customer@customer.com");
        $user->setPhone($faker->phoneNumber());
        if ($this->getReference('billingAddress_50') instanceof Address) {
            $user->addBillingAddress($this->getReference('billingAddress_50'));
        }
        $user->setRoles(['ROLE_CUSTOMER']);
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            'password'
        );
        $user->setPassword($hashedPassword);
        $this->addReference('buyer_50', $user);
        $this->addReference('user_50', $user);
        $manager->persist($user);

        // creating ~99 random customers (user_51 to user_150)
        for ($j = 51; $j <= 150; $j++) {
            $user = new User();
            $user->setLastname($faker->lastName());
            $user->setFirstname($faker->firstName());
            $user->setEmail($faker->email());
            $user->setPhone($faker->phoneNumber());
            // billingAddress_0 is already taken by the first customer
            if ($this->getReference('billingAddress_' . $j) instanceof Address) {
                $user->addBillingAddress($this->getReference('billingAddress_' . $j));
            }
            $user->setRoles(['ROLE_CUSTOMER']);
            $hashedPassword = $this->passwordHasher->hashPassword(
                $user,
                'password'
            );
            $user->setPassword($hashedPassword);
            $this->addReference('buyer_' . $j, $user);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return
            [
                AddressFixtures::class,
                BakerFixtures::class,
            ];
    }
}
