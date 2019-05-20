<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 19/05/19
 * Time: 4:15
 */

namespace App\Api\Persisters\Promotion;


use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\Promotion\ShoutOut;
use App\Managers\Promotion\PromotionManager;
use Exception;

class ShoutOutDataPersister implements DataPersisterInterface
{

    private $promotionManager;

    public function __construct(PromotionManager $promotionManager)
    {
        $this->promotionManager = $promotionManager;
    }

    /**
     * Is the data supported by the persister?
     */
    public function supports($data): bool
    {
        return $data instanceof ShoutOut;
    }

    /**
     * Persists the data.
     *
     * @param $data
     * @return object
     * @throws Exception
     */
    public function persist($data)
    {
        return $this->promotionManager->persistShoutOut($data);
    }

    /**
     * Removes the data.
     */
    public function remove($data)
    {
        // TODO: Implement remove() method.
    }

}