<?php

namespace App\DataFixtures;


use App\Entity\Reply;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class ReplyFixture extends Fixture implements DependentFixtureInterface
{
    private $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager)
    {
        for($i = 0; $i < 100; $i++) {
            $reply = new Reply();

            $reply->setBody($this->faker->paragraph);
            $reply->setCreatedAt($this->faker->dateTime);
            $reply->setUpdatedAt($this->faker->dateTime);
            $reply->setUser(
                $this->getReference('user_' . rand(0, 9))
            );
            $reply->setThread(
                $this->getReference('thread_' . rand(0, 49))
            );

            $manager->persist($reply);
        }

        $manager->flush();
    }

    function getDependencies()
    {
        return [
            UserFixture::class,
            ThreadFixture::class,
        ];
    }
}