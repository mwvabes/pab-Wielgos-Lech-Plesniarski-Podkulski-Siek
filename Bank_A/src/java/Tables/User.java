
package Tables;

import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.Id;
import javax.persistence.Table;

@Entity(name = "user")
@Table(name = "user")
public class User {
    
    @Column(name = "id_user", unique = true)
    @Id
    @GeneratedValue
    private int id_user;
    
    @Column(name = "name")
    private String name;
    
    @Column(name = "lastName")
    private String lastName;
    
    @Column(name = "address")
    private String address;
    
    @Column(name = "contact")
    private String contact;

    @Column(name = "id_login")
    private String id_login;

    public User(String name, String lastName, String address, String contact, String id_login) {
        this.name = name;
        this.lastName = lastName;
        this.address = address;
        this.contact = contact;
        this.id_login = id_login;
    }

    public User(){
        
    }
}
