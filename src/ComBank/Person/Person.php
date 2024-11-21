<?php

namespace ComBank\Person;

use ComBank\apiTrait\apiTrait;
use ComBank\Exceptions\BankAccountException;

class Person
{


    private $name;

    private $añoDeNacimiento;

    private $idCard;

    private $email;

    use apiTrait;


    public function __construct(String $nName, int $nidCard, String $nEmail, int $añoNacimiento)
    {
        $this->name = $nName;
        $this->idCard = $nidCard;
        if ($this->validateEmail($nEmail)) {
            pl("The email is valid");
            $this->email = $nEmail;
        } else {
            throw new \Exception("Error: invalid email address: " . $nEmail);
        }

        if ($this->detectarMayorEdad($añoNacimiento)) {
            $this->añoDeNacimiento = $añoNacimiento;
        } else {
            throw new \Exception("Eres menor de edad no puedes abrir una cuenta " . $nEmail);
        }
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getNombre()
    {
        return $this->name;
    }

    public function getAño(){
        return $this->añoDeNacimiento;
    }
}
