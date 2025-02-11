<?php

namespace Maxime\Jobs\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    const LIST_JOBS_ENABLED = 'jobs/department/view_list';

    /**
     * Return if display list is enabled on department view
     * @return bool
     */
    public function getListJobEnabled() {
        return $this->scopeConfig->getValue(
            self::LIST_JOBS_ENABLED,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
}
