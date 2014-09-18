<?php

namespace Saxulum\Accessor;

trait AccessorTrait
{
    /**
     * @var AbstractAccessor[]
     */
    private static $accessors = array();

    /**
     * @var Prop[]
     */
    private $properties = array();

    final public function __call($name, array $arguments = array())
    {
        foreach (self::$accessors as $prefix => $accessor) {
            if (strpos($name, $prefix) === 0) {
                $property = lcfirst(substr($name, strlen($prefix)));
                if (property_exists($this, $property)) {
                    if (isset($this->properties[$property])) {
                        $config = $this->properties[$property];
                        if ($config->hasMethod($prefix)) {
                            return $accessor->callback(
                                $this,
                                $this->$property,
                                $arguments,
                                $property,
                                $config->getHint()
                            );
                        }
                    }
                }
            }
        }

        throw new \Exception('Call to undefined method ' . __CLASS__ . '::' . $name . '()');
    }

    /**
     * @param  Prop       $property
     * @return static
     * @throws \Exception
     */
    final public function prop(Prop $property)
    {
        $name = $property->getName();

        if (isset($this->properties[$name])) {
            throw new \Exception("Override Property is not allowed, to enhance stability!");
        }

        $this->properties[$name] = $property;

        return $this;
    }

    /**
     * @param  AbstractAccessor $accessor
     * @throws \Exception
     */
    final public static function registerAccessor(AbstractAccessor $accessor)
    {
        $prefix = $accessor->getPrefix();

        if (isset(self::$accessors[$prefix])) {
            throw new \Exception("Override Accessor is not allowed, to enhance stability!");
        }

        self::$accessors[$prefix] = $accessor;
    }
}
