
package Tables;

import java.util.List;
import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.Id;
import javax.persistence.JoinColumn;
import javax.persistence.OneToMany;
import javax.persistence.Table;

@Entity(name = "login")
@Table(name = "login")
public class Login {
    
    @Column(name = "id_login", unique = true)
    @Id
    @GeneratedValue
    private int id_login;

    @Column(name = "login")
    private String login;
    
    @Column(name = "password")
    private String password;
    
    
    @Column(name = "moderator", columnDefinition = "tinyint")
    private boolean moderator;

    public Login(int id_login, String login, String password, boolean moderator) {
        this.id_login = id_login;
        this.login = login;
        this.password = password;
        this.moderator = moderator;
    }
    
    public Login() {
    }

    public int getId_login() {
        return id_login;
    }

    public void setId_login(int id_login) {
        this.id_login = id_login;
    }

    public String getLogin() {
        return login;
    }

    public void setLogin(String login) {
        this.login = login;
    }

    public String getPassword() {
        return password;
    }

    public void setPassword(String password) {
        this.password = password;
    }

    public boolean isModerator() {
        return moderator;
    }

    public void setModerator(boolean moderator) {
        this.moderator = moderator;
    }

    @Override
    public String toString() {
        return "Login{" + "id_login=" + id_login + ", login=" + login + ", password=" + password + ", moderator=" + moderator + '}';
    }

}
