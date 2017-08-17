<?php
namespace Application\I18n;

class Day
{
    public $dayOfMonth;
    public function __construct($dayOfMonth)
    {
        $this->dayOfMonth = $dayOfMonth;
    }
    public function __invoke() 
    {
        return $this->dayOfMonth ?? '';
    }
}