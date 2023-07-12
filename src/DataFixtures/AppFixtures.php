<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    public function __construct(
        private UserPasswordHasherInterface $passwordHash
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $userAdmin = new User();

        $userAdmin
            ->setEmail("admin@admin.com")
            ->setPseudo("SuperAdmin21")
            ->setRoles(["ROLE_ADMIN"]);

        $userAdmin->setPassword(
            $this->passwordHash->hashPassword(
                $userAdmin,
                "adminadmin"
            )
        );

        $manager->persist($userAdmin);
        $user = new User;

        $user
            ->setEmail("test@test.com")
            ->setPseudo("Test974");

        $user->setPassword(
            $this->passwordHash->hashPassword(
                $user,
                "testtest"
            )
        );

        $manager->persist($user);

        $categories = [
            "Animaux",
            "Professionnels",
            "École",
            "Devinettes",
            "Contrepèteries",
            "Enfants",
            "Blondes",
            "Chuck Norris"
        ];

        foreach ($categories as $category) {
            $c = new Category;

            $c->setName($category)
                ->setDescription("Lorem ipsum");

            $manager->persist($c);
        }

        $manager->flush();
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
