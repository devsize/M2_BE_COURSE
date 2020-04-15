<?php
namespace Slayer\Test\Controller\Adminhtml\Customers;

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
    const ADMIN_RESOURCE = 'Slayer_Test::slayer_manage_customers';

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
     * Customers list
     *
     * @return Page
     */
    public function execute()
    {
        /** @var Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu(self::ADMIN_RESOURCE);
        $resultPage->getConfig()->getTitle()->prepend(__('My customers'));
        $resultPage->addBreadcrumb(__('My Customers'), __('My Customers'));
        $resultPage->addBreadcrumb(__('Customers'), __('Customers'));
        return $resultPage;
    }
}
