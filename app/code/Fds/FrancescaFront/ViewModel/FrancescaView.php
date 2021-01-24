<?php

namespace Fds\FrancescaFront\ViewModel;


use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class FrancescaView implements ArgumentInterface
{

    protected $product;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->product = $productRepository;
    }


    public function getProductName()
    {
        $product = $this->product->get('Chianti_1');
        return $product->getName();
    }


    public function getContenutoMod()
    {
        return "Contenuto dal model FrancescaView";
    }

    public function helloArrayMod(){
        $array= [
            "goodModel",
            "very goodModel",
            "excellentModel"
        ];
        return $array;
    }


}
