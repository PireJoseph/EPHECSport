<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 24/04/19
 * Time: 4:47
 */

namespace App\Assemblers\Profile\DTO;


use App\Entity\Picture;
use App\Entity\Profile\DTO\PictureDTO;
use Symfony\Component\DependencyInjection\ContainerInterface;

class PictureDTOAssembler
{

    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getFromPicture(Picture $picture)
    {
        $pictureDTO = new PictureDTO();
        $pictureDTO->id = $picture->getId();
        $pictureDTO->label = $picture->getLabel();
        $pictureDTO->picture = $this->container->getParameter('picture.uri_prefix') . '/' . $picture->getImage();
        return $pictureDTO;
    }
}