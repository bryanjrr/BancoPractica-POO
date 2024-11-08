<?php

namespace ComBank\Bank;

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/27/24
 * Time: 7:25 PM
 */

use ComBank\Exceptions\BankAccountException;
use ComBank\Exceptions\InvalidArgsException;
use ComBank\Exceptions\ZeroAmountException;
use ComBank\OverdraftStrategy\NoOverdraft;
use ComBank\Bank\Contracts\BankAccountInterface;
use ComBank\Exceptions\FailedTransactionException;
use ComBank\Exceptions\InvalidOverdraftFundsException;
use ComBank\OverdraftStrategy\Contracts\OverdraftInterface;
use ComBank\apiTrait\apiTrait;
use ComBank\Support\Traits\AmountValidationTrait;
use ComBank\Transactions\Contracts\BankTransactionInterface;

class BankAccount implements BankAccountInterface
{
    protected $balance;
    protected $status;
    protected $overdraft;
    protected $person_holder;
    protected $currency;

    use AmountValidationTrait, apiTrait;

    

    /*     public function __constructt($balance, $status, $overdraft)
    {
        $this->balance = $balance;
        $this->status = $status;
        $this->overdraft = $overdraft;
    } */

    public function __construct(float $newbalance = 0.0, string $newcurrency = "€ (EUR)")
    {
        $this->validateAmount($newbalance);
        $this->balance = $newbalance;
        $this->status = BankAccountInterface::STATUS_OPEN;
        $this->overdraft = new NoOverdraft();
        $this->currency = $newcurrency;
    }


    /* GETTERS */


    public function getStatus()
    {
        return $this->status;
    }

    public function getCurrency()
    {
        return $this->currency;
    }

    public function applyOverdraft(OverdraftInterface $o)
    {
        $this->overdraft = $o;
    }


    /* Setters */

    public function setBalance($balance)
    {
        return $this->balance = $balance;
    }

    public function setStatus($status)
    {
        return $this->status = $status;
    }



    /* Funciones */
    public function getOverdraft()
    {
        return $this->overdraft;
    }

    public function transaction(BankTransactionInterface $bank)
    {

        if ($this->status == BankAccountInterface::STATUS_CLOSED) {
            throw new BankAccountException(("La cuenta esta cerrada!"));
        } else {
            $saldoSettear = $bank->applyTransaction($this);


            $this->setBalance($saldoSettear);
        }
    }

    public function isOpen()
    {
        if ($this->status == BankAccountInterface::STATUS_CLOSED) {
            return false;
        } else {
            return true;
        }

    }

    public function closeAccount()
    {
        if ($this->getStatus() == BankAccountInterface::STATUS_CLOSED) {
            throw new BankAccountException("La cuenta ya esta cerrada!");
        } else {
            return $this->status = BankAccountInterface::STATUS_CLOSED;
        }


    }

    public function reOpenAccount()
    {

        if ($this->status == BankAccountInterface::STATUS_CLOSED) {
            return $this->status = BankAccountInterface::STATUS_OPEN;
        } else {
            throw new BankAccountException("La cuenta ya estaba abierta");
        }
    }


    public function getBalance()
    {
        return $this->balance;
    }
}
