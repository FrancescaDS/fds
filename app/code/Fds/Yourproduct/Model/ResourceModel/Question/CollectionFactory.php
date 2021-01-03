<?php

/**
 * Fds_Yourproduct
 * Fds - fdallserra 2018
 */

namespace Fds\Yourproduct\Model\ResourceModel\Question;


class CollectionFactory
{
    protected $_objectManager = null;
    protected $_instanceQuestion = null;

    public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager, $instanceQuestion = '\\Fds\\Yourproduct\\Model\\ResourceModel\\Question\\Collection')
    {
        $this->_objectManager = $objectManager;
        $this->_instanceQuestion = $instanceQuestion;
    }

    public function create(array $data = array())
    {
        return $this->_objectManager->create($this->_instanceQuestion, $data);
    }
}
