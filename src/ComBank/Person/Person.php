<?php

namespace ComBank\Person;

use ComBank\apiTrait\apiTrait;
use ComBank\Exceptions\BankAccountException;

class Person
{


    private $name;

    private $idCard;

    private $email;

    use apiTrait;


    public function __construct(String $nName, int $nidCard, String $nEmail)
    {
        $this->name = $nName;
        $this->idCard = $nidCard;
        if ($this->validateEmail($nEmail)) {
            pl("The email is valid");
            $this->email = $nEmail;
        } else {
            throw new \Exception("Error: invalid email address: " . $nEmail);
        }
    }

    public function getEmail()
    {
        return $this->email;
    }
}
