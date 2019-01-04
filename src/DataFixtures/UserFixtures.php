<?php

namespace App\DataFixtures;

use App\Security\iHasRole;
use DateTime;
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
        $userTest = new User();
        $userTest->setUsername('test');
        $userTest->setEmail('test@gmail.com');
        $birthDate = new DateTime();
        $userTest->setBirthDate($birthDate);
        $userTestRoles = array(iHasRole::ROLE_USER);
        $userTest->setRoles($userTestRoles);
        $userTest->setPassword($this->passwordEncoder->encodePassword(
            $userTest,
            'test'
        ));

        $manager->persist($userTest);
        $manager->flush();
    }
}
