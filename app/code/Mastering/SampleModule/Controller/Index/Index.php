<?php


namespace Mastering\SampleModule\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\Controller\ResultFactory;

class Index extends Action
{

// pagina url http://fds.local/mastering (oppure http://fds.local/mastering/index/index seguendo i folder)
//'mastering' e' preso dal file etc/frontend/routes.xml
    public function execute()
    {
        /** @var \Magento\Framework\Controller\ResultFactory $result */
        //$result = $this->resultFactory->create(ResultFactory::TYPE_RAW);
        //TYPE RAW  ignora i layout e tutti gli altri settings
        //il risultato e' solo l'echo
        // $result->setContents('Contenuto della pagina in frontend');

        //cosi torna una pagina
        $result = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        return $result;
    }
}
