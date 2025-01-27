<?php
namespace Webkul\BlogManager\Block\Published;

class BlogList extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Webkul\BlogManager\Model\ResourceModel\Blog\CollectionFactory
     */
    protected $blogCollection;

    /**
     * @var \Webkul\BlogManager\Model\ResourceModel\Blog\Collection
     */
    protected $blogList;

    /**
     * @var \Webkul\BlogManager\Helper\Data
     */
    protected $helper;

    /**
     * @var \Magento\Customer\Model\CustomerFactory
     */
    protected $customerFactory;

    /**
     * Dependency Initilization
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Webkul\BlogManager\Model\ResourceModel\Blog\CollectionFactory $blogCollection
     * @param \Webkul\BlogManager\Helper\Data $helper
     * @param \Magento\Customer\Model\CustomerFactory $customerFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Webkul\BlogManager\Model\ResourceModel\Blog\CollectionFactory $blogCollection,
        \Webkul\BlogManager\Helper\Data $helper,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        array $data = []
    ) {
        $this->helper = $helper;
        $this->blogCollection = $blogCollection;
        $this->customerFactory = $customerFactory;
        parent::__construct($context, $data);
    }

    /**
     * Get Blog Collection
     *
     * @return Webkul\BlogManager\Model\ResourceModel\Blog\Collection
     */
    public function getCollection()
    {
        if (!$this->blogList) {
            $collection = $this->blogCollection->create();
            $collection->addFieldToFilter('status', 1);
            $collection->setOrder('created_at', 'DESC');
            $this->blogList = $collection;
        }
        return $this->blogList;
    }

    /**
     * Prepare Layout
     *
     * @return this
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if ($this->getCollection()) {
            $pager = $this->getLayout()->createBlock(
                \Magento\Theme\Block\Html\Pager::class,
                'blogmanager.publishedblog.pager'
            )
            ->setCollection(
                $this->getCollection()
            );
            $this->setChild('pager', $pager);
            $this->getCollection()->load();
        }
        return $this;
    }

    /**
     * Get Pager Html
     *
     * @return void
     */
    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }

    /**
     * Get Author Name
     *
     * @param int $userId
     * @return string
     */
    public function getAuthor($userId)
    {
        if ($userId) {
            $customer = $this->customerFactory->create()->load($userId);
            if ($customer && $customer->getId()) {
                return $customer->getName();
            }
        }
        return __('Admin');
    }

    /**
     * Get Formatted Date
     *
     * @param string $date
     * @return date
     */
    public function getFormattedDate($date)
    {
        return $this->helper->getFormattedDate($date);
    }
}
