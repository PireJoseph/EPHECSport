<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 26/05/19
 * Time: 11:12
 */

namespace App\Controller\Actions\Promotion;


use App\Managers\Promotion\PromotionManager;

class GetShoutOutsForAnEmeritusSportManAction
{
    private $promotionManager;

    public function __construct(PromotionManager $promotionManager)
    {
        $this->promotionManager = $promotionManager;
    }

    /**
     * @param $data
     * @param $id
     * @return array
     * @throws Exception
     */
    public function __invoke($data, $id)
    {
        $shoutOuts = $this->promotionManager->getShoutOutsForAnEmeritusSportMan($id);

        return $shoutOuts;
    }
}