<?php


namespace Fds\Attribute\Model\Config;

use Magento\Eav\Model\Entity\Attribute\Backend\AbstractBackend;
use Magento\Framework\Exception\LocalizedException;

class Validation extends AbstractBackend
{
    public function validate($object)
    {
        //questo messaggio di errore appare sopra la pagina, non accanto al campo
        if($object->getData($this->getAttribute()->getAttributeCode()) < 10)
            throw new LocalizedException(__('Value of attribute "custom_eav" must not be less than 10'));

        return parent::validate($object);

    }
}
