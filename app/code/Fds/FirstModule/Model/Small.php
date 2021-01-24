<?php


namespace Fds\FirstModule\Model;

use Fds\FirstModule\Api\Size;

class Small implements Size
{
    /**
     * @return string
     */
    public function getSize()
    {
        return "big";
    }
}
