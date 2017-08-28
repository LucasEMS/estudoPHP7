<?php
namespace Application\Entity;
class Person 
{
    protected $firstName    = '';
    protected $lastName     = '';
    protected $address      = '';
    protected $city         = '';
    protected $stateProv    = '';
    protected $postalCode   = '';
    protected $country      = '';
    
    function getFirstName() {
        return $this->firstName;
    }

    function getLastName() {
        return $this->lastName;
    }

    function getAddress() {
        return $this->address;
    }

    function getCity() {
        return $this->city;
    }

    function getStateProv() {
        return $this->stateProv;
    }

    function getPostalCode() {
        return $this->postalCode;
    }

    function getCountry() {
        return $this->country;
    }

    function setFirstName($firstName) {
        $this->firstName = $firstName;
    }

    function setLastName($lastName) {
        $this->lastName = $lastName;
    }

    function setAddress($address) {
        $this->address = $address;
    }

    function setCity($city) {
        $this->city = $city;
    }

    function setStateProv($stateProv) {
        $this->stateProv = $stateProv;
    }

    function setPostalCode($postalCode) {
        $this->postalCode = $postalCode;
    }

    function setCountry($country) {
        $this->country = $country;
    }


}