<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $user = new User();
        $user->setEmail('toto@toto.fr');
        # password is 'test' encrypted
        $test = '$2y$13$3F91eDlSaukXouX1YJIVs.Mzc44XFGfLvw35odVZA0N0wG5fzyNMW';
        $user->setPassword($test);
        $user->setRoles(['ROLE_USER']);
        $user->setAdress('1 rue de la paix');
        $user->setTotalCredits(0);
        $manager->persist($user);
        
        $manager->flush();
    }
}
