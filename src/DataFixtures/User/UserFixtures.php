<?php

namespace App\DataFixtures\User;

use App\Entity\User\User;
use App\Security\iHasRole;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Exception;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{

    private $passwordEncoder;

     public function __construct(UserPasswordEncoderInterface $passwordEncoder)
     {
         $this->passwordEncoder = $passwordEncoder;
     }

    /**
     * @param ObjectManager $manager
     * @throws Exception
     */
    public function load(ObjectManager $manager)
    {
        $userTest = new User();
        $userTest->setUsername('test');
        $userTest->setEmail('test@gmail.com');
        $birthDate = new DateTime();
        $userTest->setBirthDate($birthDate);
        $userTestRoles = array(iHasRole::ROLE_USER);
        $cratedAt = new DateTime();
        $userTest->setCreatedAt($cratedAt);
        $userTest->setRoles($userTestRoles);
        $userTest->setPassword($this->passwordEncoder->encodePassword(
            $userTest,
            'test'
        ));

        $manager->persist($userTest);
        $manager->flush();
    }
}
