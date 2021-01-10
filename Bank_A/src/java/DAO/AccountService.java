
package DAO;

import Tables.Account;

import java.util.List;

public class AccountService {
    
    private static AccountDao accountDao;

	public AccountService() {
		accountDao = new AccountDao();
	}

	public void persist(Account entity) {
		accountDao.openCurrentSessionwithTransaction();
		accountDao.persist(entity);
		accountDao.closeCurrentSessionwithTransaction();
	}

	public void update(Account entity) {
		accountDao.openCurrentSessionwithTransaction();
		accountDao.update(entity);
		accountDao.closeCurrentSessionwithTransaction();
	}

	public Account findById(String id) {
		accountDao.openCurrentSession();
		Account account = accountDao.findById(id);
		accountDao.closeCurrentSession();
		return account;
	}
        
        public Account findByIdUser(String id) {
		accountDao.openCurrentSession();
		List<Account> account = accountDao.findByIdUser(id);
		accountDao.closeCurrentSession();
		return account.get(0);
	}
        
        public Account findByNumber(String number) {
		accountDao.openCurrentSession();
		List<Account> account = accountDao.findByNumber(number);
		accountDao.closeCurrentSession();
		return account.get(0);
	}

	public void delete(String id) {
		accountDao.openCurrentSessionwithTransaction();
		Account account = accountDao.findById(id);
		accountDao.delete(account);
		accountDao.closeCurrentSessionwithTransaction();
	}
        
        public void delete(Account account) {
		accountDao.openCurrentSessionwithTransaction();
		accountDao.delete(account);
		accountDao.closeCurrentSessionwithTransaction();
	}

	public List<Account> findAll() {
		accountDao.openCurrentSession();
		List<Account> accounts = accountDao.findAll();
		accountDao.closeCurrentSession();
		return accounts;
	}

	public void deleteAll() {
		accountDao.openCurrentSessionwithTransaction();
		accountDao.deleteAll();
		accountDao.closeCurrentSessionwithTransaction();
	}

	public AccountDao accountDao() {
		return accountDao;
	}
    
}
