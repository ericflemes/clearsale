<?php
namespace Clearsale\Integration\Controller\Index;

use \Magento\Framework\App\Action\Action;
use \Magento\Framework\App\Action\Context;
use \Magento\Framework\View\Result\PageFactory;
use Clearsale\Integration\Model\Utils\ClearSaleSchedule;

class Index extends Action
{
    /**
     * @var PageFactory
     */
    protected $pageFactory;
    /**
     * @var ClearSaleSchedule
     */
    protected $clearSaleSchedule;
    /**
     * @param Context $context
     * @param JsonFactory $resultJsonFactory
     * @param ClearSaleSchedule $clearSaleSchedule
     */
    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        ClearSaleSchedule $clearSaleSchedule
    ) {
        parent::__construct($context);
        $this->pageFactory = $pageFactory;
        $this->clearSaleSchedule = $clearSaleSchedule;
    }

    /**
     * View  page action
     * @return ResultInterface
     */
    public function execute() {
        $this->clearSaleSchedule->integration($this->getRequest()->getParam('api'));
    }
}
