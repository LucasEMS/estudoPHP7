<?php
namespace Application\PubSub;
use SplSubject;
use SplObserver;

class Publisher implements SplSubject
{
    protected $name;
    protected $data;
    protected $linked;
    protected $subscribers;
    
    public function __construct($name)
    {
        $this->name = $name;
        $this->data = array();
        $this->subscribers = array();
        $this->linked = array();
    }
    
    public function __toString()
    {
        return $this->name;
    }
    
    public function attach(SplObserver $subscriber) 
    {
        $this->subscribers[$subscriber->getKey()] = $subscriber;
        $this->linked[$subscriber->getKey()] = 
                $subscriber->getPriority();
        asort($this->linked);
    }
    
    public function detach(SplObserver $subscriber)
    {
        unset($this->subscribers[$subscriber->getKey()]);
        unset($this->subscribers[$subscriber->getKey()]);
    }
    
    public function notify()
    {
        foreach ($this->linked as $key => $value)
        {
            $this->subscribers[$key]->update($this);
        }
    }
    
    public function getName() {
        return $this->name;
    }

    public function getData() {
        return $this->data;
    }

    public function getLinked() {
        return $this->linked;
    }

    public function getSubscribers() {
        return $this->subscribers;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setData($data) {
        $this->data = $data;
    }

    public function setLinked($linked) {
        $this->linked = $linked;
    }

    public function setSubscribers($subscribers) {
        $this->subscribers = $subscribers;
    }

    public function setDataByKey($key, $value)
    {
        $this->data[$key] = $value;
    }

}
