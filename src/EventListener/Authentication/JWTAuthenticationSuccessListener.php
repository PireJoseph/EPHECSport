<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 21/04/19
 * Time: 14:21
 */

namespace App\EventListener\Authentication;


use App\Managers\User\UserManager;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\Security\Core\User\UserInterface;

class JWTAuthenticationSuccessListener
{

    private $refreshTokenTTL;
    private $userManager;
    private $em;

    public function __construct($refreshTokenTTL, UserManager $userManager, EntityManagerInterface $em)
    {
        $this->refreshTokenTTL = $refreshTokenTTL;
        $this->userManager = $userManager;
        $this->em = $em;
    }

    /**
     * @param AuthenticationSuccessEvent $event
     * @throws \Exception
     */
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $data = $event->getData();
        $user = $event->getUser();

        if (!$user instanceof UserInterface) {
            return;
        }


        // add refresh Token expiration
        $RefreshTokenExpirationDateTime  = new DateTime();
        $RefreshTokenExpirationDateTime->modify('+'. $this->refreshTokenTTL .' seconds');
        // set expiration 1 day before artificially
        $RefreshTokenExpirationDateTime->modify('- 1 day');
        $RefreshTokenExpirationDateTimeString = $RefreshTokenExpirationDateTime->format('Y-m-d h:i:s') ;
        $data['data'] = array(
            'refresh_token_expiration' =>  $RefreshTokenExpirationDateTimeString,
        );

        $event->setData($data);
    }

}