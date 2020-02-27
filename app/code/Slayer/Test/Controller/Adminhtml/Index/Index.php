<?php

namespace Slayer\Test\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\Page;

class Index extends Action
{
    /**
     * @return ResponseInterface|ResultInterface|Page
     */
    public function execute()
    {
        echo 'Hello!';
    }
}
