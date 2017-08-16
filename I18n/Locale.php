<?php
namespace Application\I18n;

use Locale as PhpLocale;
use NumberFormatter;

class Locale extends PhpLocale
{
    const FALLBACK_LOCALE = 'en';
    
    protected $numberFormatter;
    protected $localeCode;
    
    public function getNumberFormatter()
    {
        if (!$this->numberFormatter){
            $this->numberFormatter = 
                    new NumberFormatter($this->getLocaleCode(),
                            NumberFormatter::DECIMAL);
        }
        return $this->numberFormatter;
    }
    
    public function formatNumber($number)
    {
        return $this->getNumberFormatter()->format($number);
    }
    
    public function parseNumber($string)
    {
        $result = $this->getNumberFormatter()->parse($string);
        return ($result) ? $result : self::ERROR_UNABLE_TO_PARSE;
    }
                
    public function setLocaleCode($acceptLangHeader)
    {
        $this->localeCode = 
            $this->acceptFromHttp($acceptLangHeader);
    }
    
    public function getAcceptLanguage()
    {
        return $_SERVER['HTTP_ACEEPT_LANGUAGE'] ??
                self::FALLBACK_LOCALE;
    }
    
    public function getLocaleCode()
    {
        return $this->localeCode;
    }
    
    public function __construct($localeString = NULL)
    {
        if ($localeString) {
            $this->setLocaleCode($localeString);
        } else {
            $this->setLocaleCode($this->getAcceptLanguage());
        }
    }
}