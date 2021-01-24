<?php


namespace Fds\FirstModule\Model;

use Fds\FirstModule\Api\Size;

class Normal implements Size
{
    /**
     * @return string
     */
    public function getSize()
    {
        return "Normal";
    }
}
