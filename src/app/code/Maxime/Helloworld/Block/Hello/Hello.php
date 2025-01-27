<?php
namespace Maxime\Helloworld\Block\Hello;

use Maxime\Helloworld\Helper\CustomerHelper;

class Hello extends \Magento\Framework\View\Element\Template
{

    /**
     * @var \Maxime\Helloworld\Helper\CustomerHelper
     */
    protected $helper;


    /**
     * @var \Magento\Framework\Stdlib\DateTime\TimezoneInterface
     */
    protected $date;

    /**
     * Dependency Initilization
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Maxime\Helloworld\Helper\CustomerHelper $helper
     * @param \Magento\Framework\Stdlib\DateTime\TimezoneInterface $date
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        CustomerHelper $helper,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $date,
        array $data = []
    ) {
        $this->helper = $helper;
        $this->date = $date;
        parent::__construct($context, $data);
    }

    public function getCustomerName()
    {
        return $customerName = $this->helper->getCustomerName();
    }

    public function getCustomerId()
    {
        return $customerId = $this->helper->getCustomerId();
    }



    /**
     * Get Formatted Date
     *
     * @param date $date
     * @return date
     */
    // public function getFormattedDate($date)
    // {
    //     return $this->date->date($date)->format('d/m/y H:i');
    // }
}
