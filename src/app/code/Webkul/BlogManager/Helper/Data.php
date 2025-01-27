<?php
namespace Webkul\BlogManager\Helper;

use Magento\Customer\Model\Session;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var Magento\Customer\Model\Session
     */
    protected $customerSession;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\TimezoneInterface
     */
    protected $date;

    /**
     * Dependency Initilization
     *
     * @param Session $customerSession
     * @param \Magento\Framework\Stdlib\DateTime\TimezoneInterface $date
     * @param \Magento\Framework\App\Helper\Context $context
     */
    public function __construct(
        Session $customerSession,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $date,
        \Magento\Framework\App\Helper\Context $context
    ) {
        $this->customerSession = $customerSession;
        $this->date = $date;
        parent::__construct($context);
    }

    /**
     * Get Customer Id
     *
     * @return int
     */
    public function getCustomerId()
    {
        $customerId = $this->customerSession->getCustomerId();
        return $customerId;
    }

    /**
     * Get Formatted Date
     *
     * @param string $date
     * @return date
     */
    public function getFormattedDate($date='')
    {
        return $this->date->date($date)->format('d/m/y h:i A');
    }
}
