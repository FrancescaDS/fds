<?php
/**
 * Fds_Yourproduct
 * Fds - fdallserra 2018
 * Question Repository
 */

namespace Fds\Yourproduct\Model;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\NoSuchEntityException;
use Fds\Yourproduct\Api\Data\QuestionInterface;
use Fds\Yourproduct\Api\Data\QuestionSearchResultInterface;
use Fds\Yourproduct\Api\QuestionRepositoryInterface;


class QuestionRepository implements QuestionRepositoryInterface
{
    private $_questionFactory;

    private $_questionCollectionFactory;

    private $_searchResultFactory;

    public function __construct(
        \Fds\Yourproduct\Model\QuestionFactory $questionFactory,
        \Fds\Yourproduct\Model\ResourceModel\Question\Collection $questionCollectionFactory,
        \Fds\Yourproduct\Api\Data\QuestionSearchResultInterfaceFactory $questionSearchResultInterfaceFactory
    ) {
        $this->_questionFactory = $questionFactory;
        $this->_questionCollectionFactory = $questionCollectionFactory;
        $this->_searchResultFactory = $questionSearchResultInterfaceFactory;
    }


    public function getById($id)
    {
        $question = $this->_questionFactory->create();
        $question->getResource()->load($question, $id);
        if (! $question->getId()) {
            throw new NoSuchEntityException(__('Unable to find question with ID "%1"', $id));
        }
        return $question;
    }

    public function save(QuestionInterface $question)
    {
        $question->getResource()->save($question);
        return $question;
    }

    public function delete(QuestionInterface $question)
    {
        $question->getResource()->delete($question);
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
