<?php


namespace Fds\Database\Api\Data;

interface AffiliateMemberInterface
{
    const ID = "id";
    const NAME = "name";
    const ADDRESS = "address";
    const PHONE_NUMBER = "phone_number";
    const STATUS = "status";
    const CREATED_AT = "created_at";
    const UPDATED_AT = "updated_at";


    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getAddress();

    /**
     * @return boolean
     */
    public function getStatus();

    /**
     * @return string
     */
    public function getPhoneNumber();

    /**
     * @return string
     */
    public function getCreatedAt();

    /**
     * @return string
     */
    public function getUpdatedAt();

    /**
     * @param int $id
     * @return \Fds\Database\Api\Data\AffiliateMemberInterface
     */
    public function setId($id);

    /**
     * @param string $name
     * @return \Fds\Database\Api\Data\AffiliateMemberInterface
     */
    public function setName($name);

    /**
     * @param string $phoneNumber
     * @return \Fds\Database\Api\Data\AffiliateMemberInterface
     */
    public function setPhoneNumber($phoneNumber);

    /**
     * @param string $address
     * @return \Fds\Database\Api\Data\AffiliateMemberInterface
     */
    public function setAddress($address);

    /**
     * @param boolean $status
     * @return \Fds\Database\Api\Data\AffiliateMemberInterface
     */
    public function setStatus($status);


}
