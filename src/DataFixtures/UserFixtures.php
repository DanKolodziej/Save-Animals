<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail('Dank0l@o2.pl');
        $user->setRoles(['ADMINISTRATOR']);
        $user->setName('Daniel');
        $user->setProvince('Dolnośląskie');
        $user->setCity('Wrocław');
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user, 'asd123'
        ));
        $manager->persist($user);
        $manager->flush();
    }
}
