<?php


namespace Fds\FirstModule\Model;

use Fds\FirstModule\Api\Size;

class Big implements Size
{
    /**
     * @return string
     */
    public function getSize()
    {
        return "Big";
    }
}
