<?php


namespace Fds\FirstModule\Model;
use Fds\FirstModule\Api\Color;
use Fds\FirstModule\Api\Size;

class Book
{
    protected $color;
    protected $size;

    public function __construct(Color $color, Size $size)
    {
        $this->color = $color;
        $this->size = $size;
    }
}
