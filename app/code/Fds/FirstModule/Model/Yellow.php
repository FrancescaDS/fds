<?php


namespace Fds\FirstModule\Model;

use Fds\FirstModule\Api\Color;
use Fds\FirstModule\Api\Brightness;

class Yellow implements Color
{

    protected $brightness;

    public function __construct(Brightness $brightness)
    {
        $this->brightness = $brightness;
    }

    /**
     * @return string
     */
    public function getColor()
    {
        return "Yellow";
    }
}
