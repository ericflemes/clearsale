<?php
namespace Clearsale\Integration\Model\Utils;

use Clearsale\Integration\Helper\Integration;
use \Clearsale\Integration\Observer\ClearsaleObserver;
use Magento\Framework\Serialize\Serializer\Json;

class ClearSaleSchedule {

    /**
     * @var \Clearsale\Integration\Observer\ClearsaleObserver
     */
    protected $observer;
    /**
     * @var \Magento\Framework\Serialize\Serializer\Json
     */
    protected $json;
    /**
     * @var Clearsale\Integration\Helper\Integration
     */
    protected $helper;

    /**
     * @param Integration $helper
     * @param Json $json
     * @param ClearsaleObserver $observer
     */
    public function __construct(
        Integration $helper,
        Json $json,
        ClearsaleObserver $observer
    ) {
        $this->helper = $helper;
        $this->json = $json;
        $this->observer = $observer;
    }

    /**
     * @param  $api string
     * @return mixed
     */
    public function integration($api) {
        if ($this->helper->checkApikey($api)) {
            $this->observer->sendPendingOrders();
            sleep(2);
            $this->observer->getClearsaleOrderStatus();
        }
    }
}
