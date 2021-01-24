<?php


namespace Fds\FirstModule\Plugin;


class PluginSolution
{
    public function beforeSetName(\Magento\Catalog\Model\Product $subject, $name)
    {
        $name = "<b> --Plugin Before SetName-- </b>" . $name;
        return $name;

    }

    public function afterGetName(\Magento\Catalog\Model\Product $subject, $result)
    {
        $name = $result . "<b> --Plugin After GetName-- </b>";
        return $name;
    }

    //se ci sono piu' argomenti (non solo $name) nel method observed bisogna metterli tutti
    /*public function aroundSetName(\Magento\Catalog\Model\Product $subject, callable $proceed, $name)
    {
        $name = $name . " Before Proceed Around";

        //qui bisogna ripassare tutti gli argomenti del method observed originale nello stesso ordine
        $name = $proceed($name);

        $name = $name . " After Proceed Around";
        return $name;
    }*/

    //la funzione getName non ha arguments
    public function aroundGetName(
        \Magento\Catalog\Model\Product $subject,
        callable $proceed)
    {
        echo "Before Proceed Plugin Around GetName" . "</br>";
        $name = $proceed();
        echo $name;
        echo "</br>" . "After Proceed Plugin Around GetName";
        return $name;
    }

    public function aroundGetIdBySku(
        \Magento\Catalog\Model\Product $subject,
        callable $proceed,
        $sku)
    {
        echo " Before Proceed Plugin Around getIdBySku" . "</br>";
        $id = $proceed($sku);
        echo $id;
        echo "</br>" . "After Proceed Plugin Around getIdBySku";
        return $id;
    }

}
