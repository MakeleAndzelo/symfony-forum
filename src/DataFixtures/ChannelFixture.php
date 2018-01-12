<?php

namespace App\DataFixtures;


use App\Entity\Channel;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class ChannelFixture extends Fixture
{
    private $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 15; $i++) {
            $channel = new Channel();
            $channel->setName($this->faker->word);

            $manager->persist($channel);
            $this->setReference('channel_' . $i, $channel);
        }

        $manager->flush();
    }
}