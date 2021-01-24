<?php


namespace Fds\FirstModule\Model;

use Fds\FirstModule\Api\Brightness;
use Fds\FirstModule\Api\Color;

class Red implements Color
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
        return "Red";
    }
}
