<?php
namespace Application\Entity;

class Customer extends Base
{
    const TABLE_NAME = 'customer';
    protected $name = '';
    protected $balance = 0.0;
    protected $email = '';
    protected $password = '';
    protected $status = '';
    protected $securityQuestion = '';
    protected $confirmCode = '';
    protected $profileId = 0;
    protected $level = '';
    
    protected $purchases = array();
    
    protected $mapping = [
        'id'              => 'id',
        'name'            => 'name',
        'balance'         => 'balance',
        'email'           => 'email',
        'password'        => 'password',
        'status'          => 'status',
        'security_question' => 'securityQuestion',
        'confirm_code'    => 'confirmCode',
        'profile_id'      => 'profileId',
        'level'           => 'level'
    ];
    
    public function setPurchases(Closure $purchaseLookup)
    {
        $this->purchases = $purchaseLookup;
    }
    
    public function addPurchase($purchase)
    {
        $this->purchases[] = $purchase;
    }
    
    // added to implement object relational mapping
    public function addPurchaseLookup($purchId, $function)
    {
            $this->purchases[$purchId] = $function;
    }
    
    public function getPurchases()
    {
        return $this->purchases;
    }
 
    public function getName() : string
    {
        return $this->name;
    }
    public function setName($name)
    {
        $this->name = $name;
    }
    public function getBalance() : float
    {
        return $this->balance;
    }
    public function setBalance($balance)
    {
        $this->balance = (float) $balance;
    }
    public function getEmail() : string
    {
        return $this->email;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function getPassword() : string
    {
        return $this->password;
    }
    public function setPassword($password)
    {
        $this->password = $password;
    }
    public function getStatus() : string
    {
        return $this->status;
    }
    public function setStatus($status)
    {
        $this->status = $status;
    }
    public function getSecurityQuestion() : string
    {
        return $this->securityQuestion;
    }
    public function setSecurityQuestion($securityQuestion)
    {
        $this->securityQuestion = $securityQuestion;
    }
    public function getConfirmCode() : string
    {
        return $this->confirmCode;
    }
    public function setConfirmCode($confirmCode)
    {
        $this->confirmCode = $confirmCode;
    }
    public function getProfileId() : string
    {
        return $this->profileId;
    }
    public function setProfileId($profileId)
    {
        $this->profileId = $profileId;
    }
     public function getLevel() : string
    {
        return $this->level;
    }
    public function setLevel($level)
    {
        $this->level = $level;
    }
    
    
}
    