<?php


namespace Fds\Database\Api\Data;

use Magento\Framework\Api\Search\SearchResultsInterface;

interface AffiliateMemberSearchResultInterface extends SearchResultsInterface
{
    /**
     * @return \Magento\Framework\Api\ExtensibleDataInterface
     */
    public function getItems();

    /**
     * @param array $items
     * @return SearchResultsInterface
     */
    public function setItems(array $items);
}
