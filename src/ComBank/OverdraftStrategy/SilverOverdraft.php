<?php

namespace ComBank\OverdraftStrategy;

use ComBank\OverdraftStrategy\Contracts\OverdraftInterface;

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/28/24
 * Time: 1:39 PM
 */

/**
 * @description: Grant 100.00 overdraft funds.
 * */
class SilverOverdraft implements OverdraftInterface
{
    public function isGrantOverdraftFunds($overdraft_amount): bool
    {

        if ($overdraft_amount + 100 < 0) {
            return false;
        } else {
            return true;
        }
    }

    public function getOverdraftFundsAmount(): float
    {
        return 100;
    }
}
