<?php
namespace Slayer\Test\Controller\Adminhtml\Orders;

use \Magento\Backend\App\Action as BackendAction;
use \Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface as HttpGetActionInterface;
use \Magento\Backend\Model\View\Result\Page;
use \Magento\Framework\View\Result\PageFactory;

/**
 * Class Index
 */
abstract class Index extends BackendAction implements HttpGetActionInterface
{
    /**
     * Authorization level of a basic admin session
     *
     * @see \Magento\Backend\App\Action\_isAllowed()
     */
    const ADMIN_RESOURCE = 'Slayer_Test::slayer_manage_orders';

    /**
     * @var PageFactory
     */
    private $resultPageFactory;

    /**
     * Initialize Group Controller
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Orders list
     *
     * @return Page
     */
    public function execute()
    {
        /** @var Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu(self::ADMIN_RESOURCE);
        $resultPage->getConfig()->getTitle()->prepend(__('My customer orders'));
        $resultPage->addBreadcrumb(__('My Customer Orders'), __('My Customer Orders'));
        $resultPage->addBreadcrumb(__('Customer Orders'), __('Customer Orders'));
        return $resultPage;
    }
}
