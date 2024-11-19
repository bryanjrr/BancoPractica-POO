<?php

namespace ComBank\apiTrait;

use ComBank\Transactions\Contracts\BankTransactionInterface;
use ComBank\Transactions\DepositTransaction;
use ComBank\Transactions\WithdrawTransaction;

/* use ComBank\Bank\BankAccount;
 */

trait apiTrait
{

    public function convertBalance($balance): float
    {

        $ch = curl_init();

        $api = "https://api.fxratesapi.com/latest?base=EUR&amount=" . $balance;

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

    public function validateEmail(String $email): bool
    {


        $ch = curl_init();
        $validado = false;

        pl("Validating email: " . $email);

        $api = "https://www.disify.com/api/email/" . $email;

        curl_setopt($ch, CURLOPT_URL, $api);
        curl_setopt_array($ch, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => true

        ));

        $resultado = curl_exec($ch);

        curl_close($ch);
        $data = json_decode($resultado, true);

        if ($data["format"]) {
            if ($data["dns"] && !$data["disposable"]) {
                $validado = true;
            }
        }

        return $validado;
    }

    public function detectFraud(BankTransactionInterface $b): bool
    {
        $tipoTransaccion = $b->getTransactionInfo();
        $amountUsuario = $b->getAmount();

        $ch = curl_init();

        $api = "https://673608e25995834c8a9521a8.mockapi.io/fraudev1/fraude";

        curl_setopt($ch, CURLOPT_URL, $api);
        curl_setopt_array($ch, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => true

        ));

        $resultado = curl_exec($ch);

        curl_close($ch);
        $data = json_decode($resultado, true);

        for ($i = 0; $i < 8; $i++) {
            if ($data[$i]["TipoDeMovimiento"] == $tipoTransaccion) {
                if ($data[$i]["amount"] <= $amountUsuario && $data[$i]["permitido"] == true) {
                    $fraude = false;
                } elseif ($data[$i]["amount"] <= $amountUsuario && $data[$i]["permitido"] == false) {
                    $fraude = true;
                }
            }
        }

        return $fraude;
    }
}
