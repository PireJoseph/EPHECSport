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

class SuccessDTOAssembler
{

    public function getFromSuccess(Success $success){
        $successDTO = new SuccessDTO();
        $successDTO->id = $success->getId();
        $successDTO->label = $success->getLabel();
        $successDTO->userId = $success->getUser()->getId();
        $successDTO->userName = $success->getUser()->getUsername();
        return $successDTO;
    }
}