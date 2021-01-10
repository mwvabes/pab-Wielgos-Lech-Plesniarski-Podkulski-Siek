
package Tables;

import java.math.BigDecimal;
import java.util.Date;
import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.Id;
import javax.persistence.Table;

@Entity(name = "operation")
@Table(name = "operation")
public class Operation {
    
    @Column(name = "id_operation", unique = true)
    @Id
    @GeneratedValue
    private int id_operation;
    
    @Column(name = "type")
    private String type;
    
    @Column(name = "date")
    private Date date;
    
    @Column(name = "amount")
    private BigDecimal amount;
    
    @Column(name = "status")
    private String status;
    
    @Column(name = "id_account")
    private int id_account;

    public Operation(String type, Date date, BigDecimal amount, String status, int id_account) {
        this.type = type;
        this.date = date;
        this.amount = amount;
        this.status = status;
        this.id_account = id_account;
    }

    public int getId_operation() {
        return id_operation;
    }

    public void setId_operation(int id_operation) {
        this.id_operation = id_operation;
    }

    public String getType() {
        return type;
    }

    public void setType(String type) {
        this.type = type;
    }

    public Date getDate() {
        return date;
    }

    public void setDate(Date date) {
        this.date = date;
    }

    public BigDecimal getAmount() {
        return amount;
    }

    public void setAmount(BigDecimal amount) {
        this.amount = amount;
    }

    public String getStatus() {
        return status;
    }

    public void setStatus(String status) {
        this.status = status;
    }
    
    
}
