<?php
/**
 * Fds_Yourproduct
 * Fds - fdallserra 2018
 * Question Repository Interface
 */

namespace Fds\Yourproduct\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Fds\Yourproduct\Api\Data\AnswerInterface;


interface AnswerRepositoryInterface
{
    /**
     * @param int $id
     * @return \Fds\Yourproduct\Api\Data\AnswerInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($id);

    /**
     * @param \Fds\Yourproduct\Api\Data\AnswerInterface $answer
     * @return \Fds\Yourproduct\Api\Data\AnswerInterface
     */
    public function save(AnswerInterface $answer);

    /**
     * @param \Fds\Yourproduct\Api\Data\AnswerInterface $answer
     * @return void
     */
    public function delete(AnswerInterface $answer);

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Fds\Yourproduct\Data\AnswerSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);
}
