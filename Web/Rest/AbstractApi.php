<?php
namespace Application\Web\Rest;
use Applicatoin\Web\ { Request\ Response };

abstract class AbstractApi implements ApiInterface
{
    const TOKEN_BYTE_SIZE = 16;
    protected $resgisteredKeys;
    
    abstract  public function get(Request $request,
            Response $response);
    abstract public function put(Request $request,
            Response $response);
    abstract public function post(Request $request,
            Response $response);
    abstract public function delete(Request $request, 
            Response $response);
    
    abstract public function authenticate(Request $request);
    
    public function __construct($resgisteredKeys, $tokenField)
    {
        $this->registeredKeys = $resgisteredKeys;
    }
    
    public static function generateToken()
    {
        return bin2hex(random_bytes(self::TOKEN_BYTE_SIZE));
    }
}