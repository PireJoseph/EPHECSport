<?php

namespace App\Controller\User;

use App\Entity\User\User;
use App\Exception\EmailAddressAlreadyExistsException;
use App\Exception\itemAlreadyExistsException;
use App\Form\RegistrationFormType;
use App\Managers\User\UserManager;
use App\Security\LoginFormAuthenticator;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     * @param Request $request
     * @param GuardAuthenticatorHandler $guardHandler
     * @param LoginFormAuthenticator $authenticator
     * @param UserManager $userManager
     * @return Response
     */
    public function register(Request $request, GuardAuthenticatorHandler $guardHandler, LoginFormAuthenticator $authenticator, UserManager $userManager): Response
    {
        $data = NULL;
        $options = ['validation_groups' => ['register_form']];
        $form = $this->createForm(RegistrationFormType::class, $data, $options);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // We get the values submitted
            $username =  $form->get('username')->getData();
            $plainTextPassword =  $form->get('plainPassword')->getData();
            $email =  $form->get('email')->getData();
            $birthDate =  $form->get('birthDate')->getData();

            try
            {
                $newUser = $userManager->createUser($username, $plainTextPassword, $email, $birthDate );
            }
            catch (Exception $exception)
            {
                $customError = '';
                switch (true)
                {
                    case (is_a($exception, itemAlreadyExistsException::class)) :
                        $form->get('username')->addError(new FormError($exception->getMessage()));
                        break;
                    case (is_a($exception, EmailAddressAlreadyExistsException::class)) :
                        $form->get('email')->addError(new FormError($exception->getMessage()));
                        break;
                    default :
                        $customError = $exception->getMessage();
                        break;
                }

                return $this->render('registration/register.html.twig', [
                    'customError' => $customError,
                    'registrationForm' => $form->createView(),
                ]);
            }

            // do anything else you need here, like send an email

            return $guardHandler->authenticateUserAndHandleSuccess(
                $newUser,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
