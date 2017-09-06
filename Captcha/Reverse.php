<?php
namespace Application\Captcha;

class Reverse implements CaptchaInterface
{
    const DEFAULT_LABEL = 'Type this in reverse';
    const DEFAULT_LENGTH = 6;
    
    protected $phrase;
    protected $label = self::DEFAULT_LABEL;
    
    public function __construct(
            $label = self::DEFAULT_LABEL,
            $length = self::DEFAULT_LENGTH,
            $includeNumbers = TRUE,
            $includeUpper = TRUE,
            $includeLower = TRUE, 
            $includeSpecial = TRUE,
            $otherChars = NULL,
            array $suppressChars = NULL)
    {
        $this->label = $label;
        $this->phrase = new Phrase(
                $length,
                $includeNumbers,
                $includeUpper,
                $includeLower,
                $includeSpecial,
                $otherChars,
                $suppressChars);
    }
    
    public function getLabel() {
        return $this->label;
    }
    
    public function getImage() {
        return strrev($this->phrase->getPhrase());
    }
    
    public function getPhrase()
    {
        return $this->phrase->getPhrase();
    }
}