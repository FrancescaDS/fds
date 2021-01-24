<?php


namespace Fds\Database\Controller\Page;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Fds\Database\Model\AffiliateMemberFactory;

class Index extends Action
{
    protected $affiliateMemberFactory;

    public function __construct(Context $context, AffiliateMemberFactory $affiliateMemberFactory)
    {
        $this->affiliateMemberFactory = $affiliateMemberFactory;

        parent::__construct($context);
    }

    public function execute()
    {

        //cambia indirizzo di un affiliato esistente
        $affiliateMember = $this->affiliateMemberFactory->create();
        $member = $affiliateMember->load(1);
        $member->setAddress('new address');
        $member->save();
        var_dump( $member->getData());

        //aggiunge un affiliato
        /*$affiliateMemberNew = $this->affiliateMemberFactory->create();
        $affiliateMemberNew->addData(['name'=>'Pippo','address'=>'Topolinia','phone_number'=>'007']);
        $affiliateMemberNew->save();
        var_dump( $affiliateMemberNew->getData());*/

        //cancella un affiliato
        /*$affiliateMemberDel = $this->affiliateMemberFactory->create();
        $memberDel = $affiliateMemberDel->load(4);
        $memberDel->delete();*/

        //collezione dei modelli
        echo '<br><br>Collezione dei modelli<br>';
        $collection = $affiliateMember->getCollection()
       // ->addFieldToSelect('name');
        ->addFieldToSelect(['name','address','status'])
        //->addFieldToFilter('name', array('eq'=>'Pippo'))
        ->addFieldToFilter('status', array('neq'=>true));

        foreach ($collection as $item){
            print_r($item->getData());
            echo '<br>';
        }

    }
}
