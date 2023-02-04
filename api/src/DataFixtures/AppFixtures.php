<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('user@gmail.com');
        $userPwd = '$2y$13$A8IlTKw3YOh775KEjFFPV.vOXEa96m6EtQqImUGnusZefh.zweVTu';
        $user->setPassword($userPwd);
        $user->setRoles(['ROLE_USER']);
        $user->setAdress('1 rue de la paix');
        $user->setTotalCredits(0);
        
        $adminUser = new User();
        $adminUser->setEmail('admin@gmail.com');
        $pwd = '$2y$13$aUII8rEYy8RtaQtgiwWsAur3w1NW02BRvyRCgeG4b2wOkgUcI6NKW';
        $adminUser->setPassword($pwd);
        $adminUser->setRoles(['ROLE_ADMIN']);
        $adminUser->setAdress('123 rue de vaugirard');
        $adminUser->setTotalCredits(10000);
        
        $cinemaUser = new User();
        $cinemaUser->setEmail('cinema@gmail.com');
        $pwd = '$2y$13$p4XTPTtCDPHDB3CxjnWKy.56gcSaBD3VorHb0p45DTR0gA73N6GpC';
        $cinemaUser->setPassword($pwd);
        $cinemaUser->setRoles(['ROLE_CINEMA']);
        $cinemaUser->setAdress('Quai d\'ivry, 75013 Paris');
        $cinemaUser->setTotalCredits(0);


        $manager->persist($user);
        $manager->persist($adminUser);
        $manager->persist($cinemaUser);
        
        $manager->flush();
    }
}
