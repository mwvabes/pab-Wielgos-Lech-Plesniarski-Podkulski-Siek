
package Klasy;

import DAO.AccountService;
import DAO.OperationService;
import Tables.Account;
import Tables.Operation;
import java.math.BigDecimal;
import java.sql.Date;

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
        return number.substring(2, 5).equals("102");
    }
    
    public void makeInternalTransaction(Account account, String number, BigDecimal amount){
        //ZAPIS OPERACJI
        OperationService os = new OperationService();
        Operation o = new Operation("obciążenie", new Date(new java.util.Date().getTime()), amount, "Zrealizowany", account.getId_account());
        os.persist(o);
        //OBCIĄŻENIE KONTA
        AccountService as = new AccountService();
        account.setBalance(account.getBalance().subtract(amount));
        as.update(account);
        //UZNANIE KONTA
        Account account2 = as.findByNumber(number);
        account2.setBalance(account2.getBalance().add(amount));
        as.update(account2);
    }
}
