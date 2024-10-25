<?php

namespace ComBank\Transactions;

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/28/24
 * Time: 1:22 PM
 */

use ComBank\Bank\Contracts\BankAccountInterface;
use ComBank\Exceptions\FailedTransactionException;
use ComBank\Exceptions\InvalidOverdraftFundsException;
use ComBank\Transactions\Contracts\BankTransactionInterface;

class WithdrawTransaction extends BaseTransaction implements BankTransactionInterface
{


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
        return "WITHDRAW_TRANSACTION";
    }

    public function applyTransaction(BankAccountInterface $bankAccountt): float
    {


        $calculoSaldo = $bankAccountt->getBalance() - $this->getAmount();

        if (!$bankAccountt->getOverdraft()->isGrantOverdraftFunds($calculoSaldo)) {
            if ($bankAccountt->getOverdraft()->getOverdraftFundsAmount() == 0) {
                throw new InvalidOverdraftFundsException("balance insuficiente para hacer el retiro ");
            }
        
            throw new FailedTransactionException("balance insuficiente para hacer el retiro");
        }
        return $bankAccountt->getBalance() - $this->getAmount();
    }
}
