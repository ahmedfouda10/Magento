<?php
// app/code/Vendor/Blog/Api/Data/BlogSearchResultsInterface.php
namespace Webkul\BlogManager\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface BlogSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get Blog list.
     *
     * @return \Webkul\BlogManager\Api\Data\BlogInterface[]
     */
    public function getItems();

    /**
     * Set blog list.
     *
     * @param \Webkul\BlogManager\Api\Data\BlogInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
