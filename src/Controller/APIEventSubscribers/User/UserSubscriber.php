<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 27/12/18
 * Time: 14:51
 */

namespace App\Controller\APIEventSubscribers\User;


use App\Controller\APIManagers\User\UserManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class UserSubscriber implements EventSubscriberInterface
{
    const USER_CREATE_CUSTOM_SUBSCRIBED_ROUTE = '/user';

    private $userManager;

    // Injection de dépendances
    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2')))
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return [
//            KernelEvents::VIEW => ['testUserSubscriber', EventPriorities::POST_VALIDATE],
//            KernelEvents::REQUEST => ['getUserSubscriber', EventPriorities::PRE_READ]
        ];
    }

//    public function getUserSubscriber(GetResponseEvent $event)
//    {
//         $request = $event->getRequest();
//
//         // get USerDTO from an User
//        if ( 'api_user_d_t_os_get_item' !== $request->attributes->get('_route')) {
//            return;
//        }
//
//        $newUserToReturn = $this->userManager->getUser($request->attributes->get('id'));
//
//    }
//
//    public function testUserSubscriber(GetResponseForControllerResultEvent $event)
//    {
//        $request = $event->getRequest();
//
////        if (self::USER_CREATE_CUSTOM_SUBSCRIBED_ROUTE !== $request->attributes->get('_route')) {
////            return;
////        }
//
//
//
//        $controllerResult = $event->getControllerResult();
//
////        $user = $this->userManager->findOneByEmail($forgotPasswordRequest->email);
////
////        // We do nothing if the user does not exist in the database
////        if ($user) {
////            $this->userManager->requestPasswordReset($user);
////        }
//
//        $event->setResponse(new JsonResponse($event->getControllerResult(), 204));
//
//    }

}