<?php

namespace App\Tests;

use App\Assemblers\Profile\DTO\ProfileDTOAssembler;
use App\Assemblers\Profile\DTO\SportProfileDTOAssembler;
use App\Assemblers\User\DTO\UserDTOAssembler;
use App\Assemblers\User\UserAssembler;
use App\Entity\User\User;
use App\Managers\User\UserManager;
use App\Security\LoginFormAuthenticator;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserManagerTest extends WebTestCase
{

    private $client = null;
    /** @var EntityManager $em */
    private $em = null;
    private $userManager = null;

    public function setUp() : void
    {
        $this->client = static::createClient([], [
            'PHP_AUTH_USER' => 'joseph pire',
            'PHP_AUTH_PW'   => 'zryt2465',
        ]);
        $this->em = $this->client->getContainer()->get('doctrine.orm.default_entity_manager');
        $this->userManager = $this->client->getContainer()->get(UserManager::class);

    }



    public function testGetAllPersonalData()
    {

        $container= $this->client->getContainer();



        // page  d'accueil


//        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
//        $this->assertContains('Hello World', $crawler->filter('h1')->text());
        $user= $this->em->getRepository(User::class)->findOneBy([]);
        $data = $this->userManager->getAllPersonalData($user);
        $test = 'hehe';

    }


}
