
package Klasy;

import DAO.AccountService;
import DAO.OperationService;
import Tables.Account;
import Tables.Operation;
import java.math.BigDecimal;
import java.sql.Date;
import java.util.List;

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
    
    public void makeInternalTransaction(Account account, String number, BigDecimal amount, String title){
        //OBCIĄŻENIE KONTA
        AccountService as = new AccountService();
        account.setBalance(account.getBalance().subtract(amount));
        as.update(account);
        //ZAPIS OPERACJI
        OperationService os = new OperationService();
        Operation o = new Operation("obciążenie", new Date(new java.util.Date().getTime()), amount, "Zrealizowany", account.getNumber(), number, title);
        os.persist(o);
        //UZNANIE KONTA
        Account account2 = as.findByNumber(number);
        account2.setBalance(account2.getBalance().add(amount));
        as.update(account2);
    }
    
    public List<Operation> getHistory(Account account){
        OperationService os = new OperationService();
        List<Operation> list = os.findByNumber(account.getNumber());
        return list;
    }
}
