<?php


namespace Fds\Database\Model;

use Magento\Framework\Model\AbstractModel;
use Fds\Database\Model\ResourceModel\AffiliateMember as AffiliateMemberResource;
use Fds\Database\Api\Data\AffiliateMemberInterface;

class AffiliateMember extends AbstractModel implements AffiliateMemberInterface
{
     protected function _construct()
     {
         $this->_init(AffiliateMemberResource::class);
     }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->getData(AffiliateMemberInterface::ID);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->getData(AffiliateMemberInterface::NAME);
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->getData(AffiliateMemberInterface::ADDRESS);
    }

    /**
     * @return boolean
     */
    public function getStatus()
    {
        return $this->getData(AffiliateMemberInterface::STATUS);
    }

    /**
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->getData(AffiliateMemberInterface::PHONE_NUMBER);
    }

    /**
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->getData(AffiliateMemberInterface::CREATED_AT);
    }

    /**
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->getData(AffiliateMemberInterface::UPDATED_AT);
    }

    /**
     * @param string $name
     * @return AffiliateMemberInterface|void
     */
    public function setName($name)
    {
        $this->setData(AffiliateMemberInterface::NAME, $name);
    }

    /**
     * @param string $phoneNumber
     * @return AffiliateMemberInterface|void
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->setData(AffiliateMemberInterface::PHONE_NUMBER, $phoneNumber);
    }

    /**
     * @param string $address
     * @return AffiliateMemberInterface|void
     */
    public function setAddress($address)
    {
        $this->setData(AffiliateMemberInterface::ADDRESS, $address);
    }

    /**
     * @param bool $status
     * @return AffiliateMemberInterface|void
     */
    public function setStatus($status)
    {
        $this->setData(AffiliateMemberInterface::STATUS, $status);
    }


}
