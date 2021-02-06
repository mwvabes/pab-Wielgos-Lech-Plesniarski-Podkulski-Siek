
package DAO;

import Tables.Login;

import java.util.List;

public class LoginService {
    
    private static LoginDao loginDao;

	public LoginService() {
		loginDao = new LoginDao();
	}

	public void persist(Login entity) {
		loginDao.openCurrentSessionwithTransaction();
		loginDao.persist(entity);
		loginDao.closeCurrentSessionwithTransaction();
	}

	public void update(Login entity) {
		loginDao.openCurrentSessionwithTransaction();
		loginDao.update(entity);
		loginDao.closeCurrentSessionwithTransaction();
	}

	public Login findById(String id) {
		loginDao.openCurrentSession();
		Login login = loginDao.findById(id);
		loginDao.closeCurrentSession();
		return login;
	}

	public void delete(String id) {
		loginDao.openCurrentSessionwithTransaction();
		Login login = loginDao.findById(id);
		loginDao.delete(login);
		loginDao.closeCurrentSessionwithTransaction();
	}
        
        public void delete(Login login) {
		loginDao.openCurrentSessionwithTransaction();
		loginDao.delete(login);
		loginDao.closeCurrentSessionwithTransaction();
	}

	public List<Login> findAll() {
		loginDao.openCurrentSession();
		List<Login> loginy = loginDao.findAll();
		loginDao.closeCurrentSession();
		return loginy;
	}

	public void deleteAll() {
		loginDao.openCurrentSessionwithTransaction();
		loginDao.deleteAll();
		loginDao.closeCurrentSessionwithTransaction();
	}

	public LoginDao loginDao() {
		return loginDao;
	}
        
        public List<Login> find(String l, String p) {
		loginDao.openCurrentSession();
		List<Login> loginy = loginDao.find(l, p);
		loginDao.closeCurrentSession();
		return loginy;
	}
        
        public List<Login> findByLogin(String l) {
		loginDao.openCurrentSession();
		List<Login> loginy = loginDao.findByLogin(l);
		loginDao.closeCurrentSession();
		return loginy;
	}
    
}
