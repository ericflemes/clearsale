<?php
namespace Clearsale\Integration\Helper;

use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Serialize\SerializerInterface;
use \Clearsale\Integration\Logger\Logger;

class Integration extends AbstractHelper
{
    const MODULE_PATH = 'clearsale_configuration/cs_config/';

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var Logger
     */
    protected $loggerClearSale;

    /**
     * Data constructor.
     * @param ScopeConfigInterface $scopeConfig
     * @param StoreManagerInterface $storeManager
     * @param SerializerInterface $serializer
     * @param Logger $loggerClearSale
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager,
        SerializerInterface $serializer,
        Logger $loggerClearSale
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
        $this->serializer = $serializer;
        $this->loggerClearSale = $loggerClearSale;
    }

    /**
     * @return mixed
     */
    public function getIsModuleEnable() {
        return $this->scopeConfig->getValue(self::MODULE_PATH.'active',ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return mixed
     */
    public function getApikeyStore() {
        return $this->scopeConfig->getValue(self::MODULE_PATH.'key',ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return mixed
     */
    public function getLog() {
        return $this->scopeConfig->getValue(self::MODULE_PATH.'enabled_log',ScopeInterface::SCOPE_STORE);
    }

    /**
     * @paarm $apikeyCall APIKEY
     * @return boolean
     */
    public function checkApikey($apikeyCall) {
        if (!empty($apikeyCall) && $apikeyCall === $this->getApikeyStore()) {
            return true;
        }
        return false;
    }

    /**
     * @param $class execution class
     * @param $method string value and line
     * @param $url url service
     * @param $type type POST|GET or Response
     * @param $data Data send
     * @param $response response
     * @return void
     */
    public function logClearSale($class, $method, $url, $type, $data, $response) {
        if($this->getLog()) {
            $data = array(
                'Class' => $class,
                'Method'=> $method,
                'Url'=> $url,
                'Type'=> $type,
                'Data'=> $data,
                'Response'=> $response
            );
            $data = $this->serializer->serialize($data);
            $this->loggerClearSale->info($data);
        }
    }
}
