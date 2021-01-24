<?php


namespace Fds\FirstModule\Model;


class HeavyService
{
    /*Quando si chiama un oggetto si esegue il construct method*/
    public function __construct()
    {
        echo "HeavyService has been instantiated" . "</br>";
    }

    public function printHeavyServiceMessage()
    {
        echo "message from HeavyService class";
    }
}
