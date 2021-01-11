
package DAO;

import Tables.Account;
import Tables.Operation;

import java.util.List;
import org.hibernate.Query;
import org.hibernate.Session;
import org.hibernate.SessionFactory;
import org.hibernate.Transaction;
import org.hibernate.boot.registry.StandardServiceRegistryBuilder;
import org.hibernate.cfg.Configuration;

public class OperationDao {
    
    private Session currentSession;
	
	private Transaction currentTransaction;

	public OperationDao() {
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

	public void persist(Operation entity) {
		getCurrentSession().save(entity);
	}

	public void update(Operation entity) {
		getCurrentSession().update(entity);
	}

	public Operation findById(String id) {
		Operation operation = (Operation) getCurrentSession().get(Operation.class, id);
		return operation; 
	}
        
        public List<Operation> findByIdAccount(String id) {
		List<Operation> operations = (List<Operation>) getCurrentSession().createQuery("select o from operation o where o.id_account = " + id).list();
		return operations;
	}

	public void delete(Operation entity) {
		getCurrentSession().delete(entity);
	}

	@SuppressWarnings("unchecked")
	public List<Operation> findAll() {
		List<Operation> users = (List<Operation>) getCurrentSession().createQuery("from user").list();
		return users;
	}

	public void deleteAll() {
		List<Operation> entityList = findAll();
		for (Operation entity : entityList) {
			delete(entity);
		}
	}
        
    
}
