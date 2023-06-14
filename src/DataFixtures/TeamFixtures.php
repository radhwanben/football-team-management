<?php

namespace App\DataFixtures;

use App\Entity\Team;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class TeamFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 0; $i < 15; $i++) {
            $team = new Team();
            $team->setName($faker->company);
            $team->setCountry($faker->country);
            $team->setBalance($faker->randomFloat(2, 100000, 10000000));
            $manager->persist($team);
        }

        $manager->flush();
    }
}
