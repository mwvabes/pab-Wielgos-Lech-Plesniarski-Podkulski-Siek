
import Klasy.IBAN;

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
        
        IBAN iban = new IBAN();
        String test = iban.ControlSum("PL00 0000 0000 0000 0000 0000 0000");
        System.out.println(test);
        System.out.println(iban.isValid("PL04 0000 0000 0000 0000 0000 0000"));
    }
    
}
