<?php


namespace Fds\FirstModule\Model;

use \Fds\FirstModule\Api\Brightness;

class High implements Brightness
{
    /**
     * @return string
     */
    public function getBrightness()
    {
        return "High";
    }
}
