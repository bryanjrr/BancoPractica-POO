<?php namespace ComBank\Transactions;

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/28/24
 * Time: 11:30 AM
 */

use ComBank\Bank\Contracts\BankAccountInterface;
use ComBank\Transactions\Contracts\BankTransactionInterface;

/* Con implements sobrescribo si la funcion es la misma */
/* Con el extends pillo amount de baseTransaction */
class DepositTransaction extends BaseTransaction implements BankTransactionInterface
{   

    public function __construct(float $newamount = 0.0){
        $this->amount = $newamount;
    }

    public function getAmount():float{
        return $this->amount;
    }

    public function getTransactionInfo():string{
        return "DEPOSIT_TRANSACTION";
    }

    public function applyTransaction(BankAccountInterface $bankAccountt):float{
        return $bankAccountt->getBalance() + $this->getAmount();
    }
   
}
