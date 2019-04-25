<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 28/03/19
 * Time: 1:02
 */

namespace App\Controller\Admin;

use App\Entity\User\User;
use App\Security\iHasRole;
use DateTime;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use Exception;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminController extends EasyAdminController
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

        //
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
        parent::persistEntity($entity);
    }

}