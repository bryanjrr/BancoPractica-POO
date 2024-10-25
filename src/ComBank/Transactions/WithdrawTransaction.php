<?php

namespace ComBank\Transactions;

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/28/24
 * Time: 1:22 PM
 */

use ComBank\Bank\Contracts\BankAccountInterface;
use ComBank\Exceptions\InvalidOverdraftFundsException;
use ComBank\Transactions\Contracts\BankTransactionInterface;

class WithdrawTransaction extends BaseTransaction implements BankTransactionInterface
{

    public function __construct(float $newamount = 0.0)
    {
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

        $calculoSaldo = $bankAccountt->getBalance() - $this->getAmount();
        
        if (!$bankAccountt->getOverdraft()->isGrantOverdraftFunds($calculoSaldo)) {
            throw new InvalidOverdraftFundsException("No esta permitido hacer esta operacion");
        }
        return $bankAccountt->getBalance() - $this->getAmount();
    }
}
