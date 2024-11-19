<?php

namespace ComBank\Transactions\Contracts;

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/27/24
 * Time: 7:29 PM
 */

use ComBank\Bank\Contracts\BankAccountInterface;
use ComBank\Exceptions\InvalidOverdraftFundsException;
use ComBank\Bank\Contracts\BankAccount;


interface BankTransactionInterface
{

    public function applyTransaction(BankAccountInterface $account);

    public function getTransactionInfo(): string;

    public function getAmount(): float;
}
