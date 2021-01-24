<?php


namespace Fds\FirstModule\Model;


class PencilFactoryOld
{
    private $objectManager;

    public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    public function create(array $data)
    {
        return $this->objectManager->create('Fds\FirstModule\Api\PencilInterface', $data);
    }

}
