<?php
/**
 * Fds_Yourproduct
 * Fds - fdallserra 2018
 * Question Interface
 */

namespace Fds\Yourproduct\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

interface QuestionInterface extends ExtensibleDataInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @param int $id
     * @return void
     */
    public function setId($id);

    /**
     * @return string
     */
    public function getQuestion();

    /**
     * @param string $name
     * @return void
     */
    public function setQuestion($question);

    /**
     * @return string
     */
    public function getQuestionOrder();

    /**
     * @param int $questionOrder
     * @return void
     */
    public function setQuestionOrder($questionOrder);


}
