
package DAO;

import Tables.Login;

import java.util.List;
import org.hibernate.Query;
import org.hibernate.Session;
import org.hibernate.SessionFactory;
import org.hibernate.Transaction;
import org.hibernate.boot.registry.StandardServiceRegistryBuilder;
import org.hibernate.cfg.Configuration;

public class LoginDao {
    
    private Session currentSession;
	
	private Transaction currentTransaction;

	public LoginDao() {
	}

	public Session openCurrentSession() {
		currentSession = getSessionFactory().openSession();
		return currentSession;
	}

	public Session openCurrentSessionwithTransaction() {
		currentSession = getSessionFactory().openSession();
		currentTransaction = currentSession.beginTransaction();
		return currentSession;
	}
	
	public void closeCurrentSession() {
		currentSession.close();
	}
	
	public void closeCurrentSessionwithTransaction() {
		currentTransaction.commit();
		currentSession.close();
	}
	
	private static SessionFactory getSessionFactory() {
		Configuration configuration = new Configuration().configure();
		StandardServiceRegistryBuilder builder = new StandardServiceRegistryBuilder()
				.applySettings(configuration.getProperties());
		SessionFactory sessionFactory = configuration.buildSessionFactory(builder.build());
		return sessionFactory;
	}

	public Session getCurrentSession() {
		return currentSession;
	}

	public void setCurrentSession(Session currentSession) {
		this.currentSession = currentSession;
	}

	public Transaction getCurrentTransaction() {
		return currentTransaction;
	}

	public void setCurrentTransaction(Transaction currentTransaction) {
		this.currentTransaction = currentTransaction;
	}

	public void persist(Login entity) {
		getCurrentSession().save(entity);
	}

	public void update(Login entity) {
		getCurrentSession().update(entity);
	}

	public Login findById(String id) {
		Login login = (Login) getCurrentSession().get(Login.class, id);
		return login; 
	}

	public void delete(Login entity) {
		getCurrentSession().delete(entity);
	}

	@SuppressWarnings("unchecked")
	public List<Login> findAll() {
		List<Login> loginy = (List<Login>) getCurrentSession().createQuery("from login").list();
		return loginy;
	}

	public void deleteAll() {
		List<Login> entityList = findAll();
		for (Login entity : entityList) {
			delete(entity);
		}
	}
        
        public List<Login> find(String l, String pass) {
                String hql = "select l from login l where l.login = :log and l.password = :pass";
                Query query = getCurrentSession().createQuery(hql);
                query.setParameter("log", l);
                query.setParameter("pass", pass);
		List<Login> login = (List<Login>) query.list();
		return login; 
	}
        
        public Login findByLoginAndPassword(String l, String pass) {
                String hql = "select l from login l where l.login = :log and l.password = :pass";
                Query query = getCurrentSession().createQuery(hql);
                query.setParameter("log", l);
                query.setParameter("pass", pass);
		Login login = (Login) query.uniqueResult();
		return login; 
	}
    
}
