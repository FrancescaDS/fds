<?php


namespace Fds\Database\Model;

use Fds\Database\Api\AffiliateMemberRepositoryInterface;
use Fds\Database\Api\SearchCriteriaInterface;
use Fds\Database\Model\ResourceModel\AffiliateMember\CollectionFactory;
use Fds\Database\Model\AffiliateMemberFactory;
use Fds\Database\Model\ResourceModel\AffiliateMember;
use Fds\Database\Api\Data\AffiliateMemberSearchResultInterfaceFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessor;

class AffiliateMemberRepository implements AffiliateMemberRepositoryInterface
{

    protected $collectionFactory;
    protected $affiliateMemberFactory;
    protected $affiliateMember;
    protected $resultInterfaceFactory;
    protected $collectionProcessor;

    public function __construct(CollectionFactory $collectionFactory,
                                AffiliateMemberFactory $affiliateMemberFactory,
                                AffiliateMember $affiliateMember,
                                AffiliateMemberSearchResultInterfaceFactory $resultInterfaceFactory,
                                CollectionProcessor $collectionProcessor)
    {
        $this->collectionFactory = $collectionFactory;
        $this->affiliateMemberFactory = $affiliateMemberFactory;
        $this->affiliateMember = $affiliateMember;
        $this->resultInterfaceFactory = $resultInterfaceFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @return \Fds\Database\Api\Data\AffiliateMemberInterface[]
     */
    public function getList()
    {
        return $this->collectionFactory->create()->getItems();
    }

    /**
     * @param int $id
     * @return \Fds\Database\Api\Data\AffiliateMemberInterface|void
     */
    public function getAffiliateMemberById($id)
    {
        $member = $this->affiliateMemberFactory->create();
        return $member->load($id);
    }

    /**
     * @param \Fds\Database\Api\Data\AffiliateMemberInterface $member
     * @return \Fds\Database\Api\Data\AffiliateMemberInterface|void
     */
    public function saveAffiliateMember(\Fds\Database\Api\Data\AffiliateMemberInterface $member)
    {
       //check if the object has id =>update
        //altrimenti lo si crea
        if ($member->getId() == null)
        {
            //crea
            $this->affiliateMember->save($member);
            return ($member);
        } else {
            //update
            $updateMember = $this->affiliateMemberFactory->create()->load($member->getId());
            foreach ($member->getData() as $key => $value)
            {
                $updateMember->setData($key, $value);
            }
            $this->affiliateMember->save($updateMember);
            return ($updateMember);
        }

    }

    /**
     * @param int $id
     * @return void
     */
    public function deleteAffiliateMemberById($id)
    {
        $member = $this->affiliateMemberFactory->create()->load($id);
        $member->delete();
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return \Fds\Database\Api\Data\AffiliateMemberSearchResultInterface|void
     */
    public function getSearchResultList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->affiliateMemberFactory->create()->getCollection();
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResults = $this->resultInterfaceFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getData());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }
}
