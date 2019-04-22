<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 21/04/19
 * Time: 4:44
 */

namespace App\EventListener\Authentication;

use App\Entity\User\User;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\HttpFoundation\RequestStack;

class JWTCreatedListener
{

    /**
     * @var RequestStack
     */
    private $requestStack;

    private $em;

    /**
     * @param RequestStack $requestStack
     * @param EntityManagerInterface $em
     */
    public function __construct(RequestStack $requestStack, EntityManagerInterface $em)
    {
        $this->requestStack = $requestStack;
        $this->em = $em;
    }


    /**
     * @param JWTCreatedEvent $event
     *
     * @return void
     */
    public function onJWTCreated(JWTCreatedEvent $event)
    {

        $payload = $event->getData();

        $username = $payload['username'];
        $user = $this->em->getRepository(User::class)->findOneBy(['username' => $username]);
        if (is_null($user))
        {
            return;
        }
        $payload['userId'] = $user->getId();

        $event->setData($payload);
    }
}