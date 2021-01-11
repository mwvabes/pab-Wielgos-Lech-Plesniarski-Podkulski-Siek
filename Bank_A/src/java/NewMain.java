
import java.io.BufferedReader;
import java.io.DataOutputStream;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;

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
        
       
//        AccountNumber iban = new AccountNumber();
//        String test = iban.ControlSum("PL00 0000 0000 0000 0000 0000 0000");
//        System.out.println(test);
//        System.out.println(iban.isValid("PL04 0000 0000 0000 0000 0000 0000"));
//        System.out.println(iban.isValid("PL51102029640000000000000013"));
//        
//        Transaction t = new Transaction();
//        System.out.println("51102029640000000000000013".substring(2, 5));
//        System.out.println(t.isInternal("51102029640000000000000013"));
//        System.out.println(t.isInternal("04 0000 0000 0000 0000 0000 0000"));
//        
//        AccountService as = new AccountService();
//        Account account2 = as.findByNumber("67102029640000000000000016");
//        System.out.println(account2);
//        
//        System.out.println(t.getHistory(account2));
        
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
        
//        String json = "{\n" +
//                        "    \"numer_faktury\" : \"105/28112020\",\n" +
//                        "    \"id_nabywca\" : 1,\n" +
//                        "    \"id_status\" : 1,\n" +
//                        "    \"data_wystawienia\" : \"2020-11-28\",\n" +
//                        "    \"data_sprzedazy\" : \"2020-11-28\",\n" +
//                        "    \"towary\" : [\n" +
//                        "        {\n" +
//                        "            \"ilosc\" : 5,\n" +
//                        "            \"id_towar\" : 1\n" +
//                        "        },\n" +
//                        "        {\n" +
//                        "            \"ilosc\" : 10,\n" +
//                        "            \"id_towar\" : 1\n" +
//                        "        }\n" +
//                        "    ]\n" +
//                        "}";
//            
//                HttpURLConnection connection = null;
//
//          try {
//            //Create connection
//            URL url = new URL("http://localhost/Project/api/invoice/addInvoice.php");
//            connection = (HttpURLConnection) url.openConnection();
//            connection.setRequestMethod("POST");
//            connection.setRequestProperty("Content-Type", 
//                "application/json; charset=UTF-8");
//
//            connection.setUseCaches(false);
//            connection.setDoOutput(true);
//
//            //Send request
//            DataOutputStream wr = new DataOutputStream (
//                connection.getOutputStream());
//            wr.writeBytes(json);
//            wr.close();
//            connection.getInputStream();
////            //Get Response  
//       //     InputStream is = 
////            BufferedReader rd = new BufferedReader(new InputStreamReader(is));
//////            StringBuilder response = new StringBuilder(); // or StringBuffer if Java version 5+
//////            String line;
//////            while ((line = rd.readLine()) != null) {
////////              response.append(line);
////////              response.append('\r');
//////            }
////            rd.close();
//          } catch (Exception e) {
//            e.printStackTrace();
//          } finally {
//            if (connection != null) {
//              connection.disconnect();
//            }
//          }
          
          
    }
    
}
