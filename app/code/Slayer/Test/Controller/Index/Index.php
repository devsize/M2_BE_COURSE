<?php

namespace Slayer\Test\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use \Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use \Magento\Framework\Controller\ResultInterface;
use \Magento\Framework\View\Result\Page;
use \Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    /**
     * @var PageFactory
     */
    private $resultPageFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    /*public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }*/

    /**
     * @return ResponseInterface|ResultInterface|Page
     */
    public function execute()
    {
//        $array = ['GET_PARAMS' => $this->getRequest()->getParams()];
//        return $this->resultPageFactory->create();
            return $this->resultFactory->create(ResultFactory::TYPE_PAGE);

    }
}
