<?php


namespace Fds\FirstModule\Model;

use \Fds\FirstModule\Api\Brightness;

class Medium implements Brightness
{
    /**
     * @return string
     */
    public function getBrightness()
    {
        return "Medium";
    }
}
