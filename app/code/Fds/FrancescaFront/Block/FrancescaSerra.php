<?php


namespace Fds\FrancescaFront\Block;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\View\Element\Template;

class FrancescaSerra extends Template
{
    protected $product;

    public function __construct(
                        ProductRepositoryInterface $productRepository,
                        Template\Context $context,
                        array $data = [])
    {
        $this->product = $productRepository;
        parent::__construct($context, $data);
    }

    public function getProductName()
    {
        $product = $this->product->get('Chianti_3');
        return $product->getName();
    }
}
