<?php
namespace Application\Generic\Hydrator;

class GetSet 
{
    // code
    public static function hydrate(array $array, $object)
    {
        $class = get_class($object);
        $methodList = get_class_methods($class);
        
        foreach ($methodList as $method) {
            preg_match ('/^(set)(.*?)$/i', $method, $matches);
            $prefix = $matches[1] ?? '';
            $key    = $matches[2] ?? '';
            $key    = strtolower(substr($key, 0, 1)) . substr($key, 1);
            if ($prefix == 'set' && !empty($array[$key])) {
                $object->$method($array[$key]);
            }
        }
        return $object;
    }
}