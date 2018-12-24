<?php

namespace App\Controller\REST;

use App\Entity\User;
use App\Security\iHasRole;
use DateTime;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserRESTController extends FOSRestController
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * Creates a New User resource
     * @Rest\Post("/users")
     * @param Request $request
     * @return View
     * @throws \Exception
     */
    public function postUser(Request $request): View
    {

        $user = new User();

        $userName = $request->get('userName');
        $email = $request->get('email');
        $passWord = $request->get('password');
        $passwordEncoded = $this->passwordEncoder->encodePassword(
            $user,
            $passWord
        );
        $birthDate = $request->get('birthDate');
        $birthDateTime = new DateTime($birthDate);

        $user->setUsername($userName);
        $user->setEmail($email);
        $user->setPassword($passwordEncoded);
        $user->setBirthDate($birthDateTime);
        $user->setRoles(array(iHasRole::ROLE_USER));

        $em = $this->getDoctrine()->getManager();

        $em->persist($user);
        $em->flush();


        // In case our POST was a success we need to return a 201 HTTP CREATED response
        return View::create($user, Response::HTTP_CREATED);
    }
}
