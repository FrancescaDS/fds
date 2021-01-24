<?php


namespace Fds\FrancescaFront\Block;

use Magento\Framework\View\Element\Template;

class FrancescaDalla extends Template
{

    public function getContenuto()
    {
        return "Contenuto del block FrancescaDalla";
    }

    public function helloArray(){
        $array= [
            "good",
            "very good",
            "excellent"
        ];
        return $array;
    }
}
