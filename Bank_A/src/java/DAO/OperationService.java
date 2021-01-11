
package DAO;

import Tables.Operation;

import java.util.List;

public class OperationService {
    
    private static OperationDao operationDao;

	public OperationService() {
		operationDao = new OperationDao();
	}

	public void persist(Operation entity) {
		operationDao.openCurrentSessionwithTransaction();
		operationDao.persist(entity);
		operationDao.closeCurrentSessionwithTransaction();
	}

	public void update(Operation entity) {
		operationDao.openCurrentSessionwithTransaction();
		operationDao.update(entity);
		operationDao.closeCurrentSessionwithTransaction();
	}

	public Operation findById(String id) {
		operationDao.openCurrentSession();
		Operation operation = operationDao.findById(id);
		operationDao.closeCurrentSession();
		return operation;
	}
        
        public List<Operation> findByIdAccount(String id) {
		operationDao.openCurrentSession();
		List<Operation> operations = operationDao.findByIdAccount(id);
		operationDao.closeCurrentSession();
		return operations;
	}

	public void delete(String id) {
		operationDao.openCurrentSessionwithTransaction();
		Operation operation = operationDao.findById(id);
		operationDao.delete(operation);
		operationDao.closeCurrentSessionwithTransaction();
	}
        
        public void delete(Operation operation) {
		operationDao.openCurrentSessionwithTransaction();
		operationDao.delete(operation);
		operationDao.closeCurrentSessionwithTransaction();
	}

	public List<Operation> findAll() {
		operationDao.openCurrentSession();
		List<Operation> operations = operationDao.findAll();
		operationDao.closeCurrentSession();
		return operations;
	}

	public void deleteAll() {
		operationDao.openCurrentSessionwithTransaction();
		operationDao.deleteAll();
		operationDao.closeCurrentSessionwithTransaction();
	}

	public OperationDao operationDao() {
		return operationDao;
	}
    
}
