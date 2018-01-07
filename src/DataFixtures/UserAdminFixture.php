<?php

namespace App\DataFixtures;


use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserAdminFixture extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('superadmin');
        $user->setEmail('AdminControllers@example.com');
        $user->setRoles(['ROLE_USER', 'ROLE_ADMIN']);
        $user->setIsActive(true);

        $password = $this->encoder->encodePassword($user, 'superpassword');
        $user->setPassword($password);

        $manager->persist($user);
        $manager->flush();
    }
}