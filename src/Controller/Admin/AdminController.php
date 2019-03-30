<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 28/03/19
 * Time: 1:02
 */

namespace App\Controller\Admin;

use DateTime;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use Exception;

class AdminController extends EasyAdminController
{

    // It persists and flushes the given Doctrine entity. It allows to modify the entity
    // before/after being saved in the database (e.g. to transform a DTO into a Doctrine entity)
    /**
     * @param object $entity
     * @throws Exception
     */
    public function persistEntity($entity)
    {

        if (method_exists($entity, 'setCreatedAt')) {
            $now = new DateTime();
            $entity->setCreatedAt($now);
        }

        if (method_exists($entity, 'setCreatedBy')) {
            $user = $this->get('security.token_storage')->getToken()->getUser();
            $entity->setCreatedBy($user);
        }

        parent::persistEntity($entity);
    }

}