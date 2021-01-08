
package DAO;

import Tables.User;

import java.util.List;

public class UserService {
    
    private static UserDao loginDao;

	public UserService() {
		loginDao = new UserDao();
	}

	public void persist(User entity) {
		loginDao.openCurrentSessionwithTransaction();
		loginDao.persist(entity);
		loginDao.closeCurrentSessionwithTransaction();
	}

	public void update(User entity) {
		loginDao.openCurrentSessionwithTransaction();
		loginDao.update(entity);
		loginDao.closeCurrentSessionwithTransaction();
	}

	public User findById(String id) {
		loginDao.openCurrentSession();
		User login = loginDao.findById(id);
		loginDao.closeCurrentSession();
		return login;
	}

	public void delete(String id) {
		loginDao.openCurrentSessionwithTransaction();
		User login = loginDao.findById(id);
		loginDao.delete(login);
		loginDao.closeCurrentSessionwithTransaction();
	}
        
        public void delete(User login) {
		loginDao.openCurrentSessionwithTransaction();
		loginDao.delete(login);
		loginDao.closeCurrentSessionwithTransaction();
	}

	public List<User> findAll() {
		loginDao.openCurrentSession();
		List<User> users = loginDao.findAll();
		loginDao.closeCurrentSession();
		return users;
	}

	public void deleteAll() {
		loginDao.openCurrentSessionwithTransaction();
		loginDao.deleteAll();
		loginDao.closeCurrentSessionwithTransaction();
	}

	public UserDao loginDao() {
		return loginDao;
	}
    
}
