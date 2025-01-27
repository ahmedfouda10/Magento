<?php
namespace Maxime\Helloworld\Controller\Say;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;

class Hello extends Action
{
    public function __construct(Context $context)
    {
        parent::__construct($context);
    }

    public function execute()
    {
        $this->_view->loadLayout();
        $this->_view->getLayout()->initMessages();
        $this->_view->renderLayout();
    }
}
