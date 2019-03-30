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

        $now = new DateTime();

        $userTest = new User();
        $userTest->setUsername('user_test');
        $userTest->setEmail('test-user-ephec-sport@mailinator.com');
        $userTest->setBirthDate($now);
        $userTestRoles = array(iHasRole::ROLE_USER);
        $userTest->setCreatedAt($now);
        $userTest->setRoles($userTestRoles);
        $userTest->setPassword($this->passwordEncoder->encodePassword(
            $userTest,
            'test'
        ));
        $manager->persist($userTest);
        $manager->flush();

        ///////////////////////////////////////////////

        $userAdmin = new User();
        $userAdmin->setUsername('admin_test');
        $userAdmin->setEmail('test-admin-ephec-sport@mailinator.com');
        $userAdmin->setBirthDate($now);
        $userAdminRoles = array(iHasRole::ROLE_ADMIN);
        $userAdmin->setCreatedAt($now);
        $userAdmin->setRoles($userAdminRoles);
        $userAdmin->setPassword($this->passwordEncoder->encodePassword(
            $userAdmin,
            'test'
        ));
        $manager->persist($userAdmin);
        $manager->flush();

        ///////////////////////////////////////////////

        $preferedPartner = new User();
        $preferedPartner->setUsername('partner');
        $preferedPartner->setEmail('partner@gmail.com');
        $birthDate = new DateTime();
        $preferedPartner->setBirthDate($birthDate);
        $userTestRoles = array(iHasRole::ROLE_USER);
        $cratedAt = new DateTime();
        $preferedPartner->setCreatedAt($cratedAt);
        $preferedPartner->setRoles($userTestRoles);
        $preferedPartner->setPassword($this->passwordEncoder->encodePassword(
            $preferedPartner,
            'partner'
        ));

        $manager->persist($preferedPartner);
        $manager->flush();

        $userTest->addPreferedPartner($preferedPartner);
        $manager->persist($userTest);
        $manager->flush();

    }
}
