<?php
namespace Slayer\Mobile\Controller\Adminhtml\Manufacturers;

use Magento\Backend\App\Action as BackendAction;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface as HttpGetActionInterface;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Index
 */
abstract class Index extends BackendAction implements HttpGetActionInterface
{
    /**
     * Authorization level of a basic admin session
     *
     * @see BackendAction\_isAllowed()
     */
    const ADMIN_RESOURCE = 'Slayer_Mobile::manage_manufacturers';

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
        $resultPage->getConfig()->getTitle()->prepend(__('Manufacturers'));
        $resultPage->addBreadcrumb(__('Manufacturers'), __('Manufacturers'));
        return $resultPage;
    }
}