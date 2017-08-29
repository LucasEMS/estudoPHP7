<?php
namespace Application\Generic\Hydrator;
use InvalidArgumentException;
use Application\Generic\Hydrator\Strategy\ {
    GetSet, PublicProps, Extending };
 
class Any 
{
    const STRATEGY_PUBLIC   = 'PublicProps';
    const STRATEGY_GET_SET  = 'GetSet';
    const STRATEGY_EXTEND   = 'Extending';
    protected $strategies;
    public $chosen;
    
    public function __construct() 
    {
        $this->strategies[self::STRATEGY_GET_SET] = new GetSet();
        $this->strategies[self::STRATEGY_PUBLIC] = new PublicProps();
        $this->strategies[self::STRATEGY_EXTEND] = new Extending();
    }
    
    public function addStrategy($key, HydratorInterface $strategy)
    {
        $this->strategies[$key] = $strategy;
    }
    
    public function hydrate(array $array, $object)
    {
        $strategy = $this->chooseStrategy($object);
        $this->chosen = get_class($strategy);
        return $strategy::hydrate($array, $object);
    }
    
    public function extract($object)
    {
        $strategy = $this->chooseStrategy($object);
        $this->chosen = get_class($strategy);
        return $strategy::extract($object);
    }
    
    public function chooseStrategy($object)
    {
        $strategy = NULL;
        $methodList = get_class_methods(get_class($object));
        if (!empty($methodList) && is_array($methodList)) {
            $getSet = FALSE;
            foreach ($methodList as $method) {
                if (preg_match('/^get|set.*$/i', $method)) 
                    $strategy = $this->strategies[self::STRATEGY_GET_SET];
                break;
            }
        }
        
        if (!$strategy) {
            $vars = get_class_vars(get_class($object));
            if(!empty($vars) && count($vars)) {
                $strategy = $this->strategies[self::STRATEGY_PUBLIC];
            }
        }
        
        if (!$strategy) {
            $strategy = $this->strategies[self::STRATEGY_EXTEND];
        }
        return $strategy;
    }
}
