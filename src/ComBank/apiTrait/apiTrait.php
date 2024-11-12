<?php

namespace ComBank\apiTrait;

/* use ComBank\Bank\BankAccount;
 */

trait apiTrait
{

    public function convertBalance($balance): float
    {

        $ch = curl_init();

        $api = "https://api.fxratesapi.com/latest?base=EUR&amount=". $balance;

        curl_setopt($ch, CURLOPT_URL, $api);
        curl_setopt_array($ch, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => true
            
        ));

        $resultado = curl_exec($ch);

        curl_close($ch);
        $data = json_decode($resultado, true);
        

        return $data["rates"]["USD"];
    }

    public function validateEmail(String $email): float
    {

        $ch = curl_init();

        $api = "https://www.disify.com/api/email/". $email;

        curl_setopt($ch, CURLOPT_URL, $api);
        curl_setopt_array($ch, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => true
            
        ));

        $resultado = curl_exec($ch);

        curl_close($ch);
        $data = json_decode($resultado, true);
        
        

        return $data["format"];
    }
}
