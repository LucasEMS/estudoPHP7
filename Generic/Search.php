<?php
namespace Application\Generic;
class Search
{
    protected $primary;
    protected $iterations;
    public function __construct($primary)
    {

      $this->primary = $primary;   
    }
    
    public function binarySearch(array $keys, $item)
    {
        $search = array();
        foreach ($this->primary as $primaryKey => $data) {
            $searchKey = function ($keys, $data) {
                $key = '';
                foreach ($keys as $k) $key .= $data[$k];
                
                return $key;
            };
            $search[$searchKey($keys, $data)] = $primaryKey;
        }
        
        ksort($search);
       
        $binary = array_keys($search);
        
        $result = $this->doBinarySearch($binary, $item);
        return $this->primary[$search[$result]] ?? FALSE;
    }
    
    public function doBinarySearch($binary, $item)
    {
        $iterations = 0;
        $found = FALSE;
        $loop = TRUE;
        $done = -1;
        $max = count($binary);
        $lower = 0;
        $upper = $max - 1;
        
        while ($loop && !$found) {
            $mid = (int) (($upper - $lower) / 2) + $lower;
            
            echo 'Upper:Mid:Lower:<=> | ' . $upper . ':' . $mid . ':' .
                    $lower . ':' . ($item <=> $binary[$mid]) .  PHP_EOL;
            switch ($item <=> $binary[$mid]) {
                // $item < $binary[$mid]
                case -1 :
                    $upper = $mid;
                    break;
                // $item == $binary[$mid]
                case 0 :
                    $found = $binary[$mid];
                    break;
                // $item > $binary[$mid]
                case 1 :
                default :
                    $lower = $mid;
            }
            
            $loop = (($iterations++ < $max) && ($done < 1));
            $done += ($upper == $lower) ? 1 : 0;
        }
        
        $this->iterations = $iterations;
        return $found;
    }
}