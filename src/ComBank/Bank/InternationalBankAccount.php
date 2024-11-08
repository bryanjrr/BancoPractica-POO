<?php

namespace ComBank\Bank;

use ComBank\Bank\BankAccount;

class InternationalBankAccount extends BankAccount
{
    public function getConvertedBalance(): float
    {
       return $this->convertBalance($this->balance);
    }

    public function getConvertedCurrency(): String
    {
        $this->currency = "(USD)";
        return  $this->currency;
    }
}
