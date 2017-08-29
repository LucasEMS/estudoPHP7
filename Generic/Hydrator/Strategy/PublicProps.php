<?php
namespace Application\Generic\Hydrator\Strategy;

class PublicProps implements HydratorInterface
{
    public static function hydrate(array $array, $object)
    {
        $propertyList = array_keys(
                get_class_vars(get_class($object)));
        foreach ($propertyList as $property) {
            $object->$property = $array[$property] ?? NULL;
        }
        return $object;
    }
    
    public static function extract($object)
    {
        $array = array();
        $propertyList = array_keys(
                get_class_vars(get_class($object)));
        foreach ($propertyList as $property) {
            $array[$property] = $object->$property;
        }
        return $array;
    }
}