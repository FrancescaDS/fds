<?php
/**
 * Fds_Yourproduct
 * Fds - fdallserra 2018
 * Question Repository Interface
 */

namespace Fds\Yourproduct\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Fds\Yourproduct\Api\Data\QuestionInterface;


interface QuestionRepositoryInterface
{
    /**
     * @param int $id
     * @return \Fds\Yourproduct\Api\Data\QuestionInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($id);

    /**
     * @param \Fds\Yourproduct\Api\Data\QuestionInterface $question
     * @return \Fds\Yourproduct\Api\Data\QuestionInterface
     */
    public function save(QuestionInterface $question);

    /**
     * @param \Fds\Yourproduct\Api\Data\QuestionInterface $question
     * @return void
     */
    public function delete(QuestionInterface $question);

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Fds\Yourproduct\Data\QuestionSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);
}
