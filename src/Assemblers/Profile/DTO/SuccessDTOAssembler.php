<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 24/04/19
 * Time: 4:35
 */

namespace App\Assemblers\Profile\DTO;


use App\Entity\Profile\DTO\SuccessDTO;
use App\Entity\Profile\Success;
use Symfony\Contracts\Translation\TranslatorInterface;

class SuccessDTOAssembler
{
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function getFromSuccess(Success $success){
        $successDTO = new SuccessDTO();
        $successDTO->id = $success->getId();
        $successToken = Success::getSuccessToken($success->getLabel());
        $successDTO->labelValue = $success->getLabel();
        $successDTO->label = $this->translator->trans($successToken, [], 'messages');
        $successDTO->userId = $success->getUser()->getId();
        $successDTO->userName = $success->getUser()->getUsername();
        $successDTO->themeColor = Success::getSuccessColorTheme($success->getLabel());
        return $successDTO;
    }
}