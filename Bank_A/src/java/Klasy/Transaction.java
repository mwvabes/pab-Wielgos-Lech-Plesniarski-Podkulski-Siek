
package Klasy;

import Tables.Account;
import java.math.BigDecimal;

public class Transaction {


    public boolean isSolvent(Account account, BigDecimal amount){
        if(account.getBalance().compareTo(amount) == -1){
            return false;
        }
        else {
            return true;
        }
    }
}
