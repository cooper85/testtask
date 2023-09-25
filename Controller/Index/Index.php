<?php
namespace Test\Task\Controller\Index;

use Magento\Customer\Controller\AbstractAccount;

class Index extends AbstractAccount
{
    /**
     * Managing customer hobby
     *
     * @return void
     */
    public function execute()
    {
        $this->_view->loadLayout();

        if ($block = $this->_view->getLayout()->getBlock('customer_hobby')) {
            $block->setRefererUrl($this->_redirect->getRefererUrl());
        }
        $this->_view->getPage()->getConfig()->getTitle()->set(__('Hobby Management'));
        $this->_view->renderLayout();
    }
}
