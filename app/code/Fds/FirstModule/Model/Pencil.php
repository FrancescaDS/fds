<?php


namespace Fds\FirstModule\Model;

use Fds\FirstModule\Api\PencilInterface;
use Fds\FirstModule\Api\Color;
use Fds\FirstModule\Api\Size;

class Pencil implements PencilInterface
{
    protected $color;
    protected $size;
    protected $name;
    protected $school;

    public function __construct(Color $color, Size $size, $name = null, $school = null)
    {
        $this->color = $color;
        $this->size = $size;
        $this->name = $name;
        $this->school = $school;
    }

    public function getPencilType()
    {
        return "pencil has " . $this->color->getColor() . " Color and " . $this->size->getSize() ." Size.";
    }
}
