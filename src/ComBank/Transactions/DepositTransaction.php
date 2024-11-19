<?php

namespace ComBank\Transactions;

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/28/24
 * Time: 11:30 AM
 */

use ComBank\apiTrait\apiTrait;
use ComBank\Bank\Contracts\BankAccountInterface;
use ComBank\Support\Traits\AmountValidationTrait;
use ComBank\Transactions\Contracts\BankTransactionInterface;
use ComBank\Exceptions\FailedTransactionException;
use ComBank\Exceptions\ZeroAmountException;

/* Con implements sobrescribo si la funcion es la misma */
/* Con el extends pillo amount de baseTransaction */

class DepositTransaction extends BaseTransaction implements BankTransactionInterface
{
    use AmountValidationTrait;

    public function __construct(float $newamount = 0.0)
    {
        parent::validateAmount($newamount);
        $this->amount = $newamount;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getTransactionInfo(): string
    {
        return "DEPOSIT_TRANSACTION";
    }

    public function applyTransaction(BankAccountInterface $bankAccountt): float
    {
        if (!($this->detectFraud($this))) {
            return $bankAccountt->getBalance() + $this->getAmount();
        } else {
            throw new FailedTransactionException("Fraud DETECTED!");
        }
    }
}
