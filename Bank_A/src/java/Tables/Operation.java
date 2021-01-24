
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
    
    @Column(name = "sender_number")
    private String sender_number;
    
    @Column(name = "recipent_number")
    private String recipent_number;
    
    @Column(name = "title")
    private String title;

    public Operation(String type, Date date, BigDecimal amount, String status, String sender_number, String recipent_number, String title) {
        this.type = type;
        this.date = date;
        this.amount = amount;
        this.status = status;
        this.sender_number = sender_number;
        this.recipent_number = recipent_number;
        this.title = title;
    }
    
    public Operation(){
        
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

    public String getSender_number() {
        return sender_number;
    }

    public void setSender_number(String sender_number) {
        this.sender_number = sender_number;
    }

    public String getRecipent_number() {
        return recipent_number;
    }

    public void setRecipent_number(String recipent_number) {
        this.recipent_number = recipent_number;
    }

    public String getTitle() {
        return title;
    }

    public void setTitle(String title) {
        this.title = title;
    }
    
    
}