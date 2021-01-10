
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
    
    public boolean isInternal(String number){
        number = number.replaceAll("[^a-zA-Z0-9]", "");    //usuwanie niealfanumerycznych znaków
        return number.substring(2, 5).equals("102");
    }
}
