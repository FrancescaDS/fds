<?php
/**
 * Fds_Yourproduct
 * Fds - fdallserra 2018
 * Answer Repository
 */

namespace Fds\Yourproduct\Model;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\NoSuchEntityException;
use Fds\Yourproduct\Api\Data\AnswerInterface;
use Fds\Yourproduct\Api\Data\AnswerSearchResultInterface;
use Fds\Yourproduct\Api\AnswerRepositoryInterface;


class AnswerRepository implements AnswerRepositoryInterface
{
    private $_answerFactory;

    private $_answerCollectionFactory;

    private $_searchResultFactory;

    public function __construct(
        \Fds\Yourproduct\Model\AnswerFactory $answerFactory,
        \Fds\Yourproduct\Model\ResourceModel\Answer\Collection $answerCollectionFactory,
        \Fds\Yourproduct\Api\Data\AnswerSearchResultInterfaceFactory $answerSearchResultInterfaceFactory
    ) {
        $this->_answerFactory = $answerFactory;
        $this->_answerCollectionFactory = $answerCollectionFactory;
        $this->_searchResultFactory = $answerSearchResultInterfaceFactory;
    }


    public function getById($id)
    {
        $answer = $this->_answerFactory->create();
        $answer->getResource()->load($answer, $id);
        if (! $answer->getId()) {
            throw new NoSuchEntityException(__('Unable to find answer with ID "%1"', $id));
        }
        return $answer;
    }

    public function save(AnswerInterface $answer)
    {
        $answer->getResource()->save($answer);
        return $answer;
    }

    public function delete(AnswerInterface $answer)
    {
        $answer->getResource()->delete($answer);
    }

    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->_collectionFactory->create();

        $this->addFiltersToCollection($searchCriteria, $collection);
        $this->addSortOrdersToCollection($searchCriteria, $collection);
        $this->addPagingToCollection($searchCriteria, $collection);

        $collection->load();

        return $this->buildSearchResult($searchCriteria, $collection);
    }

    private function addFiltersToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            $fields = $conditions = [];
            foreach ($filterGroup->getFilters() as $filter) {
                $fields[] = $filter->getField();
                $conditions[] = [$filter->getConditionType() => $filter->getValue()];
            }
            $collection->addFieldToFilter($fields, $conditions);
        }
    }

    private function addSortOrdersToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        foreach ((array) $searchCriteria->getSortOrders() as $sortOrder) {
            $direction = $sortOrder->getDirection() == SortOrder::SORT_ASC ? 'asc' : 'desc';
            $collection->addOrder($sortOrder->getField(), $direction);
        }
    }

    private function addPagingToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        $collection->setPageSize($searchCriteria->getPageSize());
        $collection->setCurPage($searchCriteria->getCurrentPage());
    }

    private function buildSearchResult(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        $searchResults = $this->_searchResultFactory->create();

        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }
}
