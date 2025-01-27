<?php

namespace Maxime\Helloworld\Helper;

class CustomerHelper extends \Magento\Framework\App\Helper\AbstractHelper
{
    protected $customerSession;
    public function __construct(
        \Magento\Customer\Model\Session $customerSession
    ) {
        $this->customerSession = $customerSession;
    }
    /**
     * @var Magento\Customer\Model\Session
     */
    public function getCustomerId()
    {
        return $this->customerSession->getCustomerId();
    }

    public function getCustomerName()
    {
        if ($this->customerSession->isLoggedIn()) {
            $customer = $this->customerSession->getCustomer();
            return $customer->getFirstname() . ' ' . $customer->getLastname();
        }
        return '';
    }
}
