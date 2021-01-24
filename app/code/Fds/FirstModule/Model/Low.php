<?php


namespace Fds\FirstModule\Model;

use \Fds\FirstModule\Api\Brightness;

class Low implements Brightness
{
    /**
     * @return string
     */
    public function getBrightness()
    {
        return "Low";
    }
}
