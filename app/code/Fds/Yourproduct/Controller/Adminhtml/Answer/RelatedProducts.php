<?php

/**
 * Fds_Yourproduct
 * Fds - fdallserra 2018
 */

namespace Fds\Yourproduct\Controller\Adminhtml\Answer;

use Fds\Yourproduct\Controller\Adminhtml\Answer;

class RelatedProducts extends Answer
{
    public function execute()
    {
        if (empty($this->_model)) {

           $this->_model = \Magento\Framework\App\ObjectManager::getInstance()
                ->get(\Magento\Eav\Model\Attribute::class);



            $id = (int)$this->getRequest()->getParam('attribute_id');
            if ($id) {
                $this->_model->load($id);
            }
        }
        $this->_coreRegistry->register('related_pro_model', $this->_model);
        $this->_view->loadLayout()
            ->getLayout()
            ->getBlock('fds_yourproduct_relatedproducts')
            ->setProductsRelated(
                $this->getRequest()->getPost('products_related', null)
            );

        $this->_view->renderLayout();
    }
}
