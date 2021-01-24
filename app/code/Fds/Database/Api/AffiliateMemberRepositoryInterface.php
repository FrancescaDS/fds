<?php


namespace Fds\Database\Api;


interface AffiliateMemberRepositoryInterface
{
    /**
     * @return \Fds\Database\Api\Data\AffiliateMemberInterface[]
     */
    public function getList();

    /**
     * @param int $id
     * @return \Fds\Database\Api\Data\AffiliateMemberInterface
     */
    public function getAffiliateMemberById($id);

    /**
     * @param \Fds\Database\Api\Data\AffiliateMemberInterface $member
     * @return \Fds\Database\Api\Data\AffiliateMemberInterface
     */
    public function saveAffiliateMember(\Fds\Database\Api\Data\AffiliateMemberInterface $member);

    /**
     * @param int $id
     * @return void
     */
    public function deleteAffiliateMemberById($id);

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return \Fds\Database\Api\Data\AffiliateMemberSearchResultInterface
     */
    public function getSearchResultList(SearchCriteriaInterface $searchCriteria);


}
