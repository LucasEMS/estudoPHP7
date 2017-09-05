<?php
namespace Application\Captcha;

use DirectoryIterator;

class Image implements CaptchaInterface 
{
    const DEFAULT_WIDTH = 200;
    const DEFAULT_HEIGHT = 50;
    const DEFAULT_LABEL = 'Enter this phrase';
    const DEFAULT_BG_COLOR = [255, 255, 255];
    const DEFAULT_URL = '/captcha';
    const IMAGE_PREFIX = 'CAPTCHA_';
    const IMAGE_SUFFIX = '.jpg';
    const IMAGE_EXP_TIME = 300;
    const ERROR_REQUIRES_GD = 'Requires the GD extension + '
            . ' the JPEG library';
    const ERROR_IMAGE = 'Unable to generate image';
    
    protected $phrase;
    protected $imageFont;
    protected $label;
    protected $imageWidth;
    protected $imageHeight;
    protected $imageRGB;
    protected $imageDir;
    protected $imageUrl;
    
    public function __construct(
            $imageDir,
            $imageUrl,
            $imageFont = NULL,
            $label = NULL,
            $length = NULL,
            $includeNumbers = TRUE,
            $includeUpper = TRUE,
            $includeLower= TRUE,
            $includeSpecial = FALSE,
            $otherChars = NULL,
            array $suppressChars = NULL,
            $imageWidth = NULL,
            $imageHeight = NULL,
            array $iamgeRGB = NULL)
    {
        if (!function_exists('imagecreatetruecolor')) {
            throw  new \Exception(self::ERROR_REQUIRES_GD);
        }
        
        $this->imageDir     = $imageDir;
        $this->imageUrl     = $imageUrl;
        $this->imageFont    = $imageFont;
        $this->label        = $label ?? self::DEFAULT_LABEL;
        $this->imageRGB     = $imageRGB ?? self::DEFAULT_BG_COLOR;
        $this->imageWidth   = $imageWidth ?? self::DEFAULT_WIDTH;
        $this->imageHeight  = $imageHeight ?? self::DEFAULT_HEIGHT;
        
        
        
        
    }
            
}