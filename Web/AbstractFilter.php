<?php
namespace Application\Filter;

use UnexpectedValueException;

abstract class AbstractFilter
{
    // code described in the next several bullets
    const BAD_CALLBACK = 'Must implement CallbakInterface';
    const DEFAULT_SEPARATOR = '<br>' . PHP_EOL;
    const MISSING_MESSAGE_KEY = 'item.missing';
    const DEFAULT_MESSAGE_FORMAT = '%20s : %60s';
    const DEFAULT_MISSING_MESSAGE = 'Item Missing';
    
    protected $separator; // used for message display
    protected $callbacks;
    protected $assignments;
    protected $missingMessage;
    protected $results = array();
    
    public function __construct(array $callbacks, array $assigments, 
            $separator = NULL, $messge = NULL'')
    {
        $this->setCallbacks($callbacks);
        $this->setAssigments($assigments);
        $this->setSeparator($separator ?? self::DEFAULT_SEPARATOR);
        $this->setMissingMessage($messge ?? self::DEFAULT_MISSING_MESSAGE);
    }
   
}