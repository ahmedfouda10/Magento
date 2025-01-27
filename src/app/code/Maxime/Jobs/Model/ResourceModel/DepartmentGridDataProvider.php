<?php
namespace Maxime\Jobs\Model\ResourceModel;

use Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider;

class DepartmentGridDataProvider extends DataProvider
{
    protected $loadedData;

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->getCollection()->getItems();
        foreach ($items as $item) {
            $this->loadedData[$item->getId()] = $item->getData();
        }

        return $this->loadedData;
    }
}
