<?php
namespace Maxime\Jobs\Controller\Adminhtml\Job;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\App\Action;

class Index extends Action
{
    /** 
     * ADMIN_RESOURCE: يحدد مفتاح الصلاحيات (ACL) الذي يُستخدم للتحقق مما إذا كان للمستخدم إذن للوصول إلى هذا القسم.
     * المفتاح Maxime_Jobs::job يجب أن يكون معرّفًا في ملف acl.xml.
    */

    const ADMIN_RESOURCE = 'Maxime_Jobs::job'; 
    /**
     * @var PageFactory
     */

    /**
     * $resultPageFactory: يستخدم لإنشاء صفحات إدارة جديدة باستخدام PageFactory، وهو المسؤول عن إنشاء وتنسيق الصفحات في لوحة التحكم الإدارية.
     */
    protected $resultPageFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    /**
     * Context: يوفر السياق الأساسي للتعامل مع الطلبات، الردود، وبيئة لوحة الإدارة.
     * PageFactory: يُستخدم لإنشاء صفحة جديدة لعرضها في لوحة التحكم.
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Index action
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Maxime_Jobs::job');
        $resultPage->addBreadcrumb(__('Jobs'), __('Jobs'));
        $resultPage->addBreadcrumb(__('Manage Jobs'), __('Manage Jobs'));
        $resultPage->getConfig()->getTitle()->prepend(__('Job')); // ضبط عنوان الصفحة ليكون Job

        return $resultPage;
    }
}
