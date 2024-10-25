<?php

namespace ComBank\OverdraftStrategy;

use ComBank\OverdraftStrategy\Contracts\OverdraftInterface;

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/28/24
 * Time: 12:27 PM
 */

class NoOverdraft implements OverdraftInterface
{



    public function isGrantOverdraftFunds($overdraft_amount): bool
    {
        if ($overdraft_amount < 0) {
            return false;
        } else {
            return true;
        }
    }

    public function getOverdraftFundsAmount():float {
        return 0;
    }

   
}
