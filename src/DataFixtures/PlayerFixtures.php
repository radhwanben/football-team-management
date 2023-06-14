<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Team;
use App\Entity\Player;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class PlayerFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        $teams = $manager->getRepository(Team::class)->findAll();

        foreach ($teams as $team) {
            for ($i = 0; $i < 12; $i++) {
                $player = new Player();
                $player->setName($faker->firstName);
                $player->setSurname($faker->lastName);
                $team->addPlayer($player);
                $manager->persist($player);
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            TeamFixtures::class,
        ];
    }
}
