<?php

namespace Vanguard\Events\Types;

use Vanguard\Type;

abstract class TypesEvent
{
    /**
     * @var Role
     */
    protected $type;

    public function __construct(Type $type)
    {
        $this->type = $type;
    }

    /**
     * @return Types
     */
    public function getTypes()
    {
        return $this->type;
    }
}
