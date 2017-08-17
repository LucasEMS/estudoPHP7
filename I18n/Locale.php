<?php
namespace Application\I18n;

use Locale as PhpLocale;
use NumberFormatter;

class Locale extends PhpLocale
{
    const FALLBACK_LOCALE = 'en';
    const ERROR_UNABLE_TO_PARSE = 'ERROR: Unable to parse';
    const FALLBACK_CURRENCY = 'GBP';
    
    protected $currencyFormatter;
    protected $currentyLookup;
    protected $currencyCode;
    protected $numberFormatter;
    protected $localeCode;
    
    public function __construct($localeString = NULL,
            IsoCodesInterface $currencyLookup = NULL)
    {
        if ($localeString) {
            $this->setLocaleCode($localeString);
        } else {
            $this->setLocaleCode($this->getAcceptLanguage());
        }
        
        $this->currencyLookup = $currencyLookup;
        if ($this->currencyLookup) {
            $this->currencyCode = $this->currencyLookup
                            ->getCurrencyCodeFromIso2CountryCode($this
                            ->getCountryCode())
                            ->currency_code;
        } else {
            $this->currencyCode = self::FALLBACK_CURRENCY;
        }
    }
    
    public function formatCurrency($currency)
    {
        return $this->getCurrencyFormatter()
                ->formatCurrency($currency, $this->currencyCode);
    }
    
    public function parseCurrency($string)
    {
        $result = $this->getCurrencyFormatter()
                ->parseCurrency($string, $this->currencyCode);
        return ($result) ? $result : self::ERROR_UNABLE_TO_PARSE;
    }
            
    public function getCountryCode()
    {
        return $this->getRegion($this->getLocalecode());
    }
    
    public function getCurrencyCode()
    {
        return $this->currencyCode;
    }
    
    public function getCurrencyFormatter()
    {
        if (!$this->currencyFormatter) {
            $this->currencyFormatter =
                    new NumberFormatter($this->getLocaleCode(),
                            NumberFormatter::CURRENCY);
        }
        return $this->currencyFormatter;
    }
    
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
    
}