<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserInserter extends AbstractDBInserter {

    private $passwordEncoder;

    public function __construct(ObjectManager $objectManager, UserPasswordEncoderInterface $passwordEncoder) {
        parent::__construct($objectManager);
        $this->passwordEncoder = $passwordEncoder;
    }

    public function setProperties(User $user, array $properties) {
        $user->setEmail($properties['email']);
        $user->setRoles([$properties['role']]);
        if($properties['password'] !== '') {
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user, $properties['password']
            ));
        }
        $user->setName($properties['name']);
        $user->setProvince($properties['province']);
        $user->setCity($properties['city']);
        $user->setTermsAccepted($properties['termsAccepted']);
    }
}