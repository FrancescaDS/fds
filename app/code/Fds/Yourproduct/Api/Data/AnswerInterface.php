<?php
/**
 * Fds_Yourproduct
 * Fds - fdallserra 2018
 * Question Interface
 */

namespace Fds\Yourproduct\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

interface AnswerInterface extends ExtensibleDataInterface
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
     * @return int
     */
    public function getQuestion_id();

    /**
     * @param string $name
     * @return void
     */
    public function setQuestion_id($question_id);

    /**
     * @return int
     */
    public function getAttribute_id();

    /**
     * @param int $attrib_id
     * @return void
     */
    public function setAttribute_id($Attribute_id);


}
