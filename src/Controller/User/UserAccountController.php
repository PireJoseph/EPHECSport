<?php

namespace App\Controller\User;

use App\Managers\User\UserManager;
use Exception;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Security\iHasRole;
use Knp\Snappy\Pdf;

/**
 * Class UserAccountController
 * @package App\Controller\User
 *
 *  @IsGranted(iHasRole::ROLE_USER)
 */
class UserAccountController extends AbstractController
{

    private $userManager;
    private $knpSnappyPDF;

    public function __construct(UserManager $userManager, Pdf $knpSnappyPDF)
    {
        $this->userManager = $userManager;
        $this->knpSnappyPDF = $knpSnappyPDF;
    }

    /**
     * @Route("account", name="app_account")
     */
    public function index()
    {
        return $this->render('user/account/index.html.twig', [
            'controller_name' => 'UserAccountController',
        ]);
    }


    /**
     * @Route("unregister", name="app_unregister")
     */
    public function unRegister()
    {

        $connectedUser = $this->get('security.token_storage')->getToken()->getUser();

        try {
            $this->userManager->deleteUserData($connectedUser);

            $this->get('security.token_storage')->setToken(null);
            $this->get('session')->invalidate();

            $this->userManager->removeUser($connectedUser);
        }
        catch (Exception $e)
        {

        }

        // redirects to the "homepage" route
        return $this->redirectToRoute('default');
    }


    /**
     * @Route("my_data", name="app_get_personnal_data")
     */
    public function getPersonalData()
    {

        $connectedUser = $this->get('security.token_storage')->getToken()->getUser();

        $personalData = $this->userManager->getAllPersonalData($connectedUser);

        $test= '';
        return $this->render(
            'user/account/my_data.html.twig',
            [
                'data' => $personalData,
            ]
        );




        // redirects to the "homepage" route
//        return $this->redirectToRoute('default');
    }

    /**
     * @Route("my_data_pdf", name="app_get_personnal_data_as_pdf")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getPersonalDataAsPDF(Request $request)
    {
        $connectedUser = $this->get('security.token_storage')->getToken()->getUser();

        $personalData = $this->userManager->getAllPersonalData($connectedUser);
        $rootDir = $this->get('parameter_bag')->get('root_dir');
        $publicFolder = $rootDir . '/public/';
        $html = $this->renderView(
            'user/account/my_data.pdf.html.twig',
            [
                'data' => $personalData,
            ]
        );

        return new PdfResponse(
            $this->knpSnappyPDF->getOutputFromHtml($html),
            'file.pdf'
        );


    }


}
