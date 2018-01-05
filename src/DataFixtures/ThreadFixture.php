<?php

namespace App\DataFixtures;


use App\Entity\Thread;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class ThreadFixture extends Fixture implements DependentFixtureInterface
{
    private $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager)
    {
        for($i = 0; $i < 50; $i++) {
            $thread = new Thread();

            $thread->setTitle($this->faker->sentence);
            $thread->setBody($this->faker->paragraph);
            $thread->setCreatedAt($this->faker->dateTime);
            $thread->setUpdatedAt($this->faker->dateTime);
            $thread->setUser($this->getReference('user_' . rand(0, 9)));

            $manager->persist($thread);

            $this->setReference('thread_' . $i, $thread);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
          UserFixture::class
        ];
    }
}