<?php

namespace Vanguard\Events\Types;

use Vanguard\Types;

abstract class TypesEvent
{
    /**
     * @var Role
     */
    protected $types;

    public function __construct(Types $types)
    {
        $this->types = $types;
    }

    /**
     * @return Types
     */
    public function getTypes()
    {
        return $this->types;
    }
}
