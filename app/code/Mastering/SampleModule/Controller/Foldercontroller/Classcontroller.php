<?php


namespace Mastering\SampleModule\Controller\Foldercontroller;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;

class Classcontroller extends Action
{

    // pagina url http://fds.local/frontnameinroutes/foldercontroller/classcontroller)

    public function execute()
    {
        /** @var \Magento\Framework\Controller\ResultFactory $result */

        // $result = $this->resultFactory->create(ResultFactory::TYPE_RAW);
        //TYPE RAW  ignora i layout e tutti gli altri settings
        //il risultato e' solo l'echo
        //$result->setContents('Contenuto della pagina http://fds.local/frontnameinroutes/foldercontroller/classcontroller in frontend');


        //cosi torna una pagina
        $result = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        return $result;

        return $result;
    }
}
