<?php

namespace Saxulum\Accessor\Accessors;

use Saxulum\Accessor\AbstractAccessor;
use Saxulum\Accessor\Hint;

class Set extends AbstractAccessor
{
    const PREFIX = 'set';

    /**
     * @return string
     */
    public function getPrefix()
    {
        return self::PREFIX;
    }

    /**
     * @param $object
     * @param $property
     * @param  array $arguments
     * @param $name
     * @param  null  $hint
     * @param  bool  $nullable
     * @return mixed
     */
    public function callback($object, &$property, array $arguments, $name, $hint = null, $nullable = false)
    {
        if (!array_key_exists(0, $arguments) || count($arguments) !== 1) {
            throw new \InvalidArgumentException("Set Accessor allows only one argument!");
        }

        if (!Hint::validate($property, $hint, $nullable)) {
            $type = gettype($arguments[0]);
            throw new \InvalidArgumentException("Invalid type '{$type}' for hint '{$hint}' on property '{$name}'!");
        }

        $property = $arguments[0];

        return $object;
    }
}
