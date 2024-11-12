<?php

namespace ComBank\Person;
use ComBank\apiTrait\apiTrait;

class Person
{

    private $name;

    private $idCard;

    private $email;

    public function __construct(String $nName, int $nidCard, String $nEmail)
    {
        $this->name = $nName;
        $this->idCard = $nidCard;
        $this->email = $nEmail;
    }

    public function getEmail(){
        return $this->email;
    }
}
