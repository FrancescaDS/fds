<?php
/**
 * Created by PhpStorm.
 * User: francescadallaserra
 * Date: 18/06/2018
 * Time: 16:50
 */

namespace Fds\Yourproduct\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface AnswerSearchResultInterface extends SearchResultsInterface
{
    /**
     * @return \Fds\Yourproduct\Api\Data\AnswerInterface[]
     */
    public function getItems();

    /**
     * @param \Fds\Yourproduct\Api\Data\AnswerInterface[] $items
     * @return void
     */
    public function setItems(array $items);
}
