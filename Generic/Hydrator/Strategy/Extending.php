<?php
namespace Application\Generic\Hydrator\Strategy;

class Extending implements HydratorInterface 
{
    const UNDEFIED_PREFIX = 'undefined';
    const TEMP_PREFIX = '_TEMP';
    const ERROR_EVAL = 'ERROR: unable to evaluate object';
    
    public static function hydrate(array $array, $object) {
        $className = get_class($object);
        $components = explode('\\', $className);
        $realClass = array_pop($components);
        $nameSpace = implode('\\', $components);
        $tempClass = $realClass . self::TEMP_PREFIX;
        $template = 'namespace ' . $nameSpace . '{'
                    . 'class ' . $tempClass . ' extends ' . $realClass . ' '
                    . '{ '
                    . '  protected $values; '
                    . '  public function __construct($array) '
                    . '  { $this->values = $array; '
                    . '    foreach ($array as $key => $value) '
                    . '       $this->$key = $value; '
                    . '  } '
                    . '  public function getArrayCopy() '
                    . '  { return $this->values; } '
                    . '  public function __get($key) '
                    . '  { return $this->values[$key] ?? NULL; } '
                    . '  public function __call($method, $params) '
                    . '  { '
                    . '    preg_match("/^(get|set)(.*?)$/i", $method, $matches); '
                    . '    $prefix = $matches[1] ?? ""; '
                    . '    $key    = $matches[2] ?? ""; '
                    . '    $key    = strtolower(substr($key, 0, 1)) . substr($key, 1); '
                    . '    if ($prefix == "get") { return $this->values[$key] ?? NULL; } '
                    . '    else { $this->values[$key] = $params[0]; } '
                    . '  } '
                    . '} '
                    . '} // ends namespace ' . PHP_EOL
                    . 'namespace { '
                    . 'function build($array) '
                    . '{ return new ' . $nameSpace . '\\' . $tempClass . '($array); } '
                    . '} // ends global namespace '
                    . PHP_EOL;
        try {
            eval($template);
        } catch (ParseError $e) {
            error_log(__METHOD__ . ':' . $e->getMessage());
            throw new Exception(self::ERROR_EVAL);
        }
        
        return \build($array);
    }
    
    public static function extract($object)
    {
        $array = array();
        $class = get_class($object);
        $methodList = get_class_methods($class);
        foreach ($methodList as $method) {
            preg_match('/^(get)(.*?)$/i', $method, $matches);
            $prefix = $matches[1] ?? '';
            $key    = $matches[2] ?? '';
            $key    = strtolower(substr($key, 0, 1))
                    . substr($key , 1);
            if ($prefix == 'get') {
                $array[$key] = $object->$method();
            }
        }
        $propertyList = array_keys(get_class_vars($class));
        foreach ($propertyList as $property) {
            $array[$property] = $object-$method();
        }
        return $array;
    }
}