
package Tables;

import java.math.BigDecimal;
import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.Id;
import javax.persistence.Table;

@Entity(name = "account")
@Table(name = "account")
public class Account {
    @Column(name = "id_account", unique = true)
    @Id
    @GeneratedValue
    private int id_account;
    
    @Column(name = "number")
    private String number;
    
    @Column(name = "balance")
    private BigDecimal balance;
    
    @Column(name = "id_user")
    private int id_user;

    public Account(String number, BigDecimal balance, int id_user) {
        this.number = number;
        this.balance = balance;
        this.id_user = id_user;
    }
    
    public Account(){
        
    }

    public int getId_account() {
        return id_account;
    }

    public void setId_account(int id_account) {
        this.id_account = id_account;
    }

    public String getNumber() {
        return number;
    }

    public void setNumber(String number) {
        this.number = number;
    }

    public BigDecimal getBalance() {
        return balance;
    }

    public void setBalance(BigDecimal balance) {
        this.balance = balance;
    }

    public int getId_user() {
        return id_user;
    }

    public void setId_user(int id_user) {
        this.id_user = id_user;
    }
    
    
}
