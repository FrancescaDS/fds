<?php


namespace Mastering\SampleModule\Controller\adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;

class Index extends Action
{

    public function execute()
    {
        // pagina url http://fds.local/admin_fds/mastering (oppure http://fds.local/admin_fds/mastering/index/index seguendo i folder)
        // 'mastering' e' preso dal file etc/adminhtml/routes.xml
        // /** @var \Magento\Framework\Controller\ResultFactory $result */
       // $result = $this->resultFactory->create(ResultFactory::TYPE_RAW);
       // $result->setContents('Contenuto della pagina in backend');
        //return $result;

        //questo invece ritorna una pagina dentro il backend
        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
