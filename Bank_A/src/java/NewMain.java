
import Klasy.AccountNumber;
import Klasy.Transaction;

public class NewMain {

    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) {
     /*   LoginService ls = new LoginService();
       // List<Login> list = ls.findAll();
        List<Login> login = ls.find("admin", "nimda");
        Login l = login.get(0);
        UserService us = new UserService();
        List<User> lu = us.findAll();
        System.out.println(l); */
        
        //LoginRepositoryImpl lr = new LoginRepositoryImpl(getEnitityManager());
       // Login l2 = lr.getLogin("admin", "nimda");
       // System.out.println(l2);
     //  LoginRepositoryImpl lri = new LoginRepositoryImpl(new LoginService());
      // Login login = lri.getLogin("admin", "nimda");
       // System.out.println(login);
        
       
        AccountNumber iban = new AccountNumber();
        String test = iban.ControlSum("PL00 0000 0000 0000 0000 0000 0000");
        System.out.println(test);
        System.out.println(iban.isValid("PL04 0000 0000 0000 0000 0000 0000"));
        System.out.println(iban.isValid("PL51102029640000000000000013"));
        
        Transaction t = new Transaction();
        System.out.println("51102029640000000000000013".substring(2, 5));
        System.out.println(t.isInternal("51102029640000000000000013"));
        System.out.println(t.isInternal("04 0000 0000 0000 0000 0000 0000"));
        
        /*
        AccountService as = new AccountService();
        Account a = new Account("123", new BigDecimal(0), 0);
        as.persist(a);
        String N = String.valueOf(a.getId_account());
        while(N.length() < 16){
            N = "0" + N;
        }
        System.out.println(a.getId_account());
        System.out.println(N);
        String n = iban.GenerateAccountNumber("02964", N);
        a.setNumber(n);
        as.update(a);
        */
    }
    
}
