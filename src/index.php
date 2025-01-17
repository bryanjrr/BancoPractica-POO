<?php

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/27/24
 * Time: 7:24 PM
 */

use ComBank\Bank\BankAccount;
use ComBank\Bank\InternationalBankAccount;
use ComBank\Bank\NationalBankAccount;
use ComBank\OverdraftStrategy\SilverOverdraft;
use ComBank\Transactions\DepositTransaction;
use ComBank\Transactions\WithdrawTransaction;
use ComBank\Exceptions\BankAccountException;
use ComBank\Exceptions\FailedTransactionException;
use ComBank\Exceptions\InvalidOverdraftFundsException;
use ComBank\Exceptions\ZeroAmountException;
use ComBank\Person\Person;

require_once 'bootstrap.php';


//---[Bank account 1]---/
// create a new account1 with balance 400
pl('--------- [Start testing bank account #1, No overdraft] --------');
try {

    $nuevaPersona1 = new Person("Bryan", 123214213, "bryanjoyarubio@gmail.com", 2003);
    echo "Pesona Creada -- " . " Nombre: " . $nuevaPersona1->getNombre() . " Email: " . $nuevaPersona1->getEmail() . " Año de nacimiento: " . $nuevaPersona1->getAño();

    $bankAccount1 = new BankAccount(400, "€ (EUR)", $nuevaPersona1);

    // show balance account
    pl($bankAccount1->getBalance());

    pl("Account status:" . $bankAccount1->getStatus());

    // close account

    pl("My account is now" . $bankAccount1->closeAccount());

    // reopen account
    pl("My account is now" . $bankAccount1->reOpenAccount());


    // deposit +150 
    pl('Doing transaction deposit (+150) with current balance ' . $bankAccount1->getBalance());

    $bankAccount1->transaction(new DepositTransaction(150));

    pl('My new balance after deposit (+150) : ' . $bankAccount1->getBalance());

    // withdrawal -25
    pl('Doing transaction withdrawal (-25) with current balance ' . $bankAccount1->getBalance());

    $bankAccount1->transaction(new WithdrawTransaction(25));

    pl('My new balance after withdrawal (-25) : ' . $bankAccount1->getBalance());


    // withdrawal -600
    pl('Doing transaction withdrawal (-600) with current balance ' . $bankAccount1->getBalance());

    $bankAccount1->transaction(new WithdrawTransaction(600));

    pl('My balance after failed last transaction : ' . $bankAccount1->getBalance());

    $bankAccount1->closeAccount();
} catch (ZeroAmountException $e) {
    pl($e->getMessage());
} catch (BankAccountException $e) {
    pl($e->getMessage());
} catch (FailedTransactionException $e) {
    pl('Error transaction: ' . $e->getMessage());
} catch (InvalidOverdraftFundsException $e) {
    pl($e->getMessage());
} catch (\Exception $e) {
    pl($e->getMessage());
}




//---[Bank account 2]---/
pl('--------- [Start testing bank account #2, Silver overdraft (100.0 funds)] --------');

try {
    // show balance account
    $nuevaPersona2 = new Person("Bryan", 123214213, "bryanjoyarubio@gmail.com", 2003);
    echo "Pesona Creada -- " . " Nombre: " . $nuevaPersona2->getNombre() . " Email: " . $nuevaPersona2->getEmail() . " Año de nacimiento: " . $nuevaPersona2->getAño();

    $bankAccount2 = new BankAccount(200, "€ (EUR)", $nuevaPersona2);

    $bankAccount2->applyOverdraft(new SilverOverdraft());

    pl("Actual balance: " . $bankAccount2->getBalance());
    // deposit +100
    pl('Doing transaction deposit (+100) with current balance ' . $bankAccount2->getBalance());

    $bankAccount2->transaction(new DepositTransaction(100));

    pl('My new balance after deposit (+100) : ' . $bankAccount2->getBalance());


    // withdrawal -300
    pl('Doing transaction deposit (-300) with current balance ' . $bankAccount2->getBalance());

    $bankAccount2->transaction(new WithdrawTransaction(300));

    pl('My new balance after withdrawal (-300) : ' . $bankAccount2->getBalance());

    // withdrawal -50


    pl('Doing transaction deposit (-50) with current balance ' . $bankAccount2->getBalance());

    $bankAccount2->transaction(new WithdrawTransaction(50));


    pl('My new balance after withdrawal (-50) with funds : ' . $bankAccount2->getBalance());

    // withdrawal -120
    pl('Doing transaction withdrawal (-120) with current balance ' . $bankAccount2->getBalance());

    $bankAccount2->transaction(new WithdrawTransaction(120));
} catch (FailedTransactionException $e) {
    pl('Error transaction: ' . $e->getMessage());
} catch (InvalidOverdraftFundsException $e) {
    pl($e->getMessage());
} catch (\Exception $e) {
    pl($e->getMessage());
}
pl('My balance after failed last transaction : ' . $bankAccount2->getBalance());

try {
    pl('Doing transaction withdrawal (-20) with current balance : ' . $bankAccount2->getBalance());

    $bankAccount2->transaction(new WithdrawTransaction(20));
} catch (FailedTransactionException $e) {
    pl('Error transaction: ' . $e->getMessage());
} catch (InvalidOverdraftFundsException $e) {
    pl($e->getMessage());
} catch (\Exception $e) {
    pl($e->getMessage());
}
pl('My new balance after withdrawal (-20) with funds : ' . $bankAccount2->getBalance());



$bankAccount2->closeAccount();

pl("La cuenta ahora esta cerrada");

try {
    $bankAccount2->closeAccount();
} catch (BankAccountException $e) {
    pl($e->getMessage());
}

pl('--------- [Start testing National Bank Account] --------');

$nuevaPersona3 = null;
$bankAccount3 = null;

try {
    echo "Creando Persona para la cuenta:";
    $nuevaPersona3 = new Person("John", 021421421, "John.doe@gmail.com", 2005);
    echo "Pesona Creada -- " . " Nombre: " . $nuevaPersona3->getNombre() . " Email: " . $nuevaPersona3->getEmail() . " Año de nacimiento: " . $nuevaPersona3->getAño();
    $bankAccount3 = new NationalBankAccount(500, "€ (Euro)", $nuevaPersona3);

    pl($bankAccount3->getBalance() . $bankAccount3->getCurrency());
} catch (\Exception $e) {
    pl($e->getMessage());
}
pl('--------- [Start testing International Bank Account] --------');
try {
    echo "Creando Persona para la cuenta:";
    $nuevaPersona4 = new Person("John", 124213421, "John.doe@invalid-email", 2006);
    echo "Pesona Creada -- " . " Nombre: " . $nuevaPersona4->getNombre() . " Email: " . $nuevaPersona4->getEmail() . " Año de nacimiento: " . $nuevaPersona4->getAño();
} catch (\Exception $e) {
    pl($e->getMessage());
}

$bankAccount4 = new InternationalBankAccount(300, "€ (Euro)");

try {
    pl("Balance without converting: " . $bankAccount4->getBalance() . $bankAccount4->getCurrency());

    pl("Converting balance to Dollars (Rate: 1USD = 1.10€)");

    pl("Converted Balance: " . $bankAccount4->getConvertedBalance() . "(USD)");

    pl("Making a deposit of (+7000)");

    $bankAccount4->transaction(new DepositTransaction(7000));

    pl("Balance after deposit: " . $bankAccount4->getBalance() . $bankAccount4->getCurrency());


    Pl("Making a deposit of (+25000)");

    $bankAccount4->transaction(new DepositTransaction(25000));
} catch (\Exception $e) {
    pl($e->getMessage());
} catch (FailedTransactionException $e) {
    pl('Error transaction: ' . $e->getMessage());
}


try {
    pl("Making a withdraw of (-3500)");

    $bankAccount4->transaction(new WithdrawTransaction(3500));

    pl("Balance after withdraw: " . $bankAccount4->getBalance() . $bankAccount4->getCurrency());


    Pl("Making a withdraw of (-15000)");

    $bankAccount4->transaction(new WithdrawTransaction(15000));
} catch (\Exception $e) {
    pl($e->getMessage());
} catch (FailedTransactionException $e) {
    pl('Error transaction: ' . $e->getMessage());
} catch (InvalidOverdraftFundsException $e) {
    pl($e->getMessage());
}

/* Probar api free edad */
try {
    pl("------------------ Comprobacion FREE API (comprobarEdad)  --------------------");
    echo "Creando Persona para la cuenta:";
    $personaX = new Person("Caracola", 12345678, "bryanJR@gmail.com", 2010);
    $bankAccount5 = new NationalBankAccount(500, "€(Euro)", $personaX);
} catch (Exception $e) {
    pe("Error:" . $e->getMessage());
}
