<?php
namespace Application\Web\Rest;

use Application\Web\ { Request, Response, Received };
use Application\Entity\Customer;
use Application\Database\ { Connection, CustomerService };

class CustomerApi extends AbstractApi 
{
    const ERROR = 'ERROR';
    const ERROR_NOT_FOUND = 'ERROR: Not Found';
    const SUCCESS_UPDATE = 'SUCCESS: update succeeded';
    const SUCCESS_DELETE = 'SUCCESS: delete succeeded';
    const ID_FIELD = 'id'; // field name of primary key
    const TOKEN_FIELD = 'token'; // field use for authentication
    const LIMIT_FIELD = 'limit';
    const OFFSET_FIELD = 'offset';
    const DEFAULT_LIMIT = 20;
    const DEFAULT_OFFSET = 0;
    
    protected $service;
    
    public function __construct($registeredKeys, $dbparams, 
            $tokenField = NULL)
    {
        parent::__construct($registeredKeys, $tokenField);
        $this->service = new CustomerService(
                new Connection($dbparams));
    }
    
    public function get(Request $request, Response $response)
    {
        $result = array();
        $id = $request->getDataByKey(self::ID_FIELD) ?? 0;
        if ($id > 0) {
            $result = $this->service->fetchById($id)->entityToArray();
        } else {
            $limit = $request->getDataByKey(self::LIMIT_FIELD) 
                    ?? self::DEFAULT_LIMIT;
            $offset = $request->getDataByKey(self::OFFSET_FIELD)
                    ?? self::DEFAULT_OFFSET;
            $result = [];
            $fetch = $this->service->fetchAll($limit, $offset);
            foreach ($fetch as $row) {
                $result[] = $row;
            }
        }
        
        if ($result) {
            $response->setData($result);
            $response->setStatus(Request::STATUS_200);
        } else {
            $response->setData([self::ERROR_NOT_FOUND]);
            $response->setStatus(Request::STATUS_500);
        }
    }
    
    public function put(Request $request, Response $response)
    {
        $cust = Customer::arrayToEntity($request->getData(),
                new Customer());
        
        if($newCust = $this->service->save($cust)) {
            $response->setData(['success' => self::SUCCESS_UPDATE,
                'id' => $newCust->getId()]);
            $response->setStatus(Request::STATUS_200);
        } else {
            $response->setData([self::ERROR]);
            $response->setStatus(Request::STATUS__500);
        }
    }
    
    public function post(Request $request, Response $response)
    {
     
    }
}