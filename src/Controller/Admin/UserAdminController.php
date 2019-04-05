<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 5/04/19
 * Time: 15:46
 */

namespace App\Controller\Admin;


use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserAdminController  extends EasyAdminController
{

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    // It persists and flushes the given Doctrine entity. It allows to modify the entity
    // before/after being saved in the database (e.g. to transform a DTO into a Doctrine entity)
    /**
     * @param object $entity
     * @throws Exception
     */
    public function persistEntity($entity)
    {


        if (method_exists($entity, 'setCreatedAt'))
        {
            $now = new DateTime();
            $entity->setCreatedAt($now);
        }
        if (method_exists($entity, 'setCreatedBy'))
        {
            $user = $this->get('security.token_storage')->getToken()->getUser();
            $entity->setCreatedBy($user);
        }


        parent::persistEntity($entity);
    }

    /**
     * Allows applications to modify the entity associated with the item being
     * edited before updating it.
     *
     * @param object $entity

     */
    protected function updateEntity($entity)
    {


        // User update
        if (is_a($entity, User::class))
        {
            /** @var User $entity */
            $userRequestArray= $this->request->get('user');

            // ROLE
            if (array_key_exists('isAdmin', $userRequestArray) && ("1" === $userRequestArray['isAdmin']))
            {
                $entity->setRoles([iHasRole::ROLE_ADMIN]);
            }
            else
            {
                $entity->setRoles([iHasRole::ROLE_USER]);
            }


            // Password
            if (array_key_exists('plainTextPassword', $userRequestArray)  && ('' !== $userRequestArray['plainTextPassword']))
            {
                $plainTextPassword = $userRequestArray['plainTextPassword'];

                $entity->setPassword(
                    $this->passwordEncoder->encodePassword(
                        $entity,
                        $plainTextPassword
                    )
                );
            }


        }

        parent::persistEntity($entity);
    }

}