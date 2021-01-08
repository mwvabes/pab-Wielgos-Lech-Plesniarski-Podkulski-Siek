
package DAO;

import Tables.Login;

public class LoginRepositoryImpl implements LoginRepository {

    private LoginService ls;

    public LoginRepositoryImpl(LoginService ls) {
        this.ls = ls;
    }
    
    @Override
    public Login getLogin(String login, String password) {
        Login l = ls.findByLoginAndPassword(login, password);
        return l;
    }
    
}
