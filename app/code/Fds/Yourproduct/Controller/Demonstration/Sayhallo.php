<?php
/**
 * Created by PhpStorm.
 * User: francescadallaserra
 * Date: 26/06/2018
 * Time: 15:01
 */

namespace Fds\Yourproduct\Controller\Demonstration;


class Sayhallo extends \Magento\Framework\App\Action\Action
{
    /**
     * say hello text
     */
    public function execute()
    {
        //http://goldcollagen.local/uk/yourproduct/demonstration/sayhallo/
        die("Hello 😉 - Inchoo\\CustomControllers\\Controller\\Demonstration\\Sayhello - execute() method");
    }
}
