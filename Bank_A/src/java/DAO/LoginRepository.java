
package DAO;

import Tables.Login;

public interface LoginRepository {
    Login getLogin(String login, String password);
}
