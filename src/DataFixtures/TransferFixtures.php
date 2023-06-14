<?php


namespace App\DataFixtures;

use App\Entity\Transfer;
use App\Entity\Player;
use App\Entity\Team;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class TransferFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        $players = $manager->getRepository(Player::class)->findAll();
        $teams = $manager->getRepository(Team::class)->findAll();

        foreach ($players as $player) {
            // Choose random teams for selling and buying
            $sellingTeam = $teams[array_rand($teams)];
            $buyingTeam = $teams[array_rand($teams)];

            // Make sure selling and buying teams are not the same
            while ($sellingTeam === $buyingTeam) {
                $buyingTeam = $teams[array_rand($teams)];
            }

            $transfer = new Transfer();
            $transfer->setAmount($faker->randomFloat(2, 100000, 10000000));
            $transfer->setPlayer($player);
            $transfer->setSellingTeam($sellingTeam);
            $transfer->setBuyingTeam($buyingTeam);

            $manager->persist($transfer);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            TeamFixtures::class,
            PlayerFixtures::class,
        ];
    }
}
