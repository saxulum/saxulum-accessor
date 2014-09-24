<?php

namespace Saxulum\Accessor\Accessors;

use Doctrine\Common\Collections\Collection;
use Saxulum\Accessor\Prop;

class Remove extends AbstractCollection
{
    const PREFIX = 'remove';

    /**
     * @return string
     */
    public function getPrefix()
    {
        return self::PREFIX;
    }

    /**
     * @param array $property
     * @param mixed $value
     */
    protected function removeArray(array &$property, $value)
    {
        $key = array_search($value, $property, true);

        if (false !== $key) {
            unset($property[$key]);
        }
    }

    /**
     * @param  array      $property
     * @param  object     $value
     * @param  Prop       $prop
     * @param  bool       $stopPropagation
     * @throws \Exception
     */
    protected function removeArrayOne(array &$property, $value, Prop $prop, $stopPropagation = false)
    {
        $key = array_search($value, $property, true);

        if (false !== $key) {
            $this->handleRemote($value, null, $prop, Set::PREFIX, $stopPropagation);
            unset($property[$key]);
        }
    }

    /**
     * @param  array      $property
     * @param  object     $value
     * @param  Prop       $prop
     * @param  bool       $stopPropagation
     * @param  object     $object
     * @throws \Exception
     */
    protected function removeArrayMany(array &$property, $value, Prop $prop, $stopPropagation = false, $object = null)
    {
        $key = array_search($value, $property, true);

        if (false !== $key) {
            $this->handleRemote($value, $object, $prop, Remove::PREFIX, $stopPropagation);
            unset($property[$key]);
        }
    }

    /**
     * @param Collection $property
     * @param mixed      $value
     */
    protected function removeCollection(Collection &$property, $value)
    {
        if ($property->contains($value)) {
            $property->removeElement($value);
        }
    }

    /**
     * @param  Collection $property
     * @param  object     $value
     * @param  Prop       $prop
     * @param  bool       $stopPropagation
     * @throws \Exception
     */
    protected function removeCollectionOne(Collection &$property, $value, Prop $prop, $stopPropagation = false)
    {
        if ($property->contains($value)) {
            $this->handleRemote($value, null, $prop, Set::PREFIX, $stopPropagation);
            $property->removeElement($value);
        }
    }

    /**
     * @param  Collection $property
     * @param  object     $value
     * @param  Prop       $prop
     * @param  bool       $stopPropagation
     * @param  object     $object
     * @throws \Exception
     */
    protected function removeCollectionMany(Collection &$property, $value, Prop $prop, $stopPropagation = false, $object = null)
    {
        if ($property->contains($value)) {
            $this->handleRemote($value, $object, $prop, Remove::PREFIX, $stopPropagation);
            $property->removeElement($value);
        }
    }
}
