<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 5/04/19
 * Time: 15:46
 */

namespace App\Controller\Admin;


use App\Entity\User\User;
use App\Managers\User\UserManager;
use DateTime;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use EasyCorp\Bundle\EasyAdminBundle\Event\EasyAdminEvents;
use EasyCorp\Bundle\EasyAdminBundle\Exception\EntityRemoveException;
use Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Firewall\ContextListener;

class UserAdminController  extends EasyAdminController
{

    private $passwordEncoder;
    private $userManager;
    private $security;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder, UserManager $userManager, Security $security)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->userManager = $userManager;
        $this->security = $security;
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
            $userRequestArray = $this->request->get('user');

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

    /**
     * Allows applications to modify the entity associated with the item being
     * deleted before removing it.
     *
     * @param User $entity
     * @throws \App\Exception\InvalidArgumentException
     */
    protected function removeEntity($entity)
    {
        //$connectedUser = $this->get('security.context')->getToken()->getUser();
        $user = $this->security->getUser();
        /*if($connectedUser->getId()=== $entity->getId() ){
            return;
        }*/
        $editedUser = $this->userManager->deleteUserData($entity);

        //parent::removeEntity($editedUser);
    }
}