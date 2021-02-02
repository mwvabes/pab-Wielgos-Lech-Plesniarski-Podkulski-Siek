
import DAO.AccountService;
import DAO.OperationService;
import DAO.UserService;
import Klasy.AccountNumber;
import Klasy.Transaction;
import Tables.Account;
import Tables.Operation;
import Tables.User;
import java.io.DataOutputStream;
import java.io.InputStream;
import java.math.BigDecimal;
import java.net.HttpURLConnection;
import java.net.URL;
import java.sql.Date;
import javax.json.Json;
import javax.json.JsonObject;
import javax.json.JsonObjectBuilder;
import javax.json.JsonReader;

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
//        System.out.println(iban.isValid("PL 85 1050 4475 6311 7698 7831 7488 1785"));
//        System.out.println(iban.isValid("PL87105044754135270066902937"));
//        
//        Transaction t = new Transaction();
//        System.out.println("51102029640000000000000013".substring(2, 5));
//        System.out.println(t.isInternal("51102029640000000000000013"));
//        System.out.println(t.isInternal("04 0000 0000 0000 0000 0000 0000"));
//        
//        AccountService as = new AccountService();
//        Account account2 = as.findByNumber("67102029640000000000000016");
//        System.out.println(account2);
//        Account account3 = as.findByNumber("17102029640000000000000016");
//        System.out.println(account3);
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
//    int delay = 2000; //msecs
//    Timer timer = new Timer();
//    timer.schedule(new TimerTask()
//    {
//        public void run()
//        {
//            System.out.println("Dizała");
//        }
//    }, delay); 
//    Calendar today = Calendar.getInstance();
//    today.set(Calendar.HOUR_OF_DAY, 0);
//    today.set(Calendar.MINUTE, 0);
//    today.set(Calendar.SECOND, 2);
//
//    // every night at 2am you run your task
//    Timer timer = new Timer();
//    timer.schedule(new TimerTask(){
//        public void run()
//        {
//            System.out.println("Dizała");
//        }
//    }, today.getTime(), TimeUnit.MILLISECONDS.convert(1, TimeUnit.SECONDS)); // period: 1 day
//        try {
//
//            URL url = new URL("https://jr-api-express.herokuapp.com/api/payment/getIncoming/?bankCode=102&session=20210123_04");
//
//            HttpURLConnection conn = (HttpURLConnection) url.openConnection();
//            conn.setRequestMethod("GET");
//            conn.connect();
//
//            //Getting the response code
//            int responsecode = conn.getResponseCode();
//
//            if (responsecode != 200) {
//                throw new RuntimeException("HttpResponseCode: " + responsecode);
//            } else {
//
//                String inline = "";
//                Scanner scanner = new Scanner(url.openStream());
//                String response = scanner.useDelimiter("\\Z").next();
//
//                //Write all the JSON data into a string using a scanner
//                while (scanner.hasNext()) {
//                    inline += scanner.nextLine();
//                }
//
//                //Close the scanner
//                scanner.close();
//
//                System.out.println(inline);
//            }
//
//        } catch (Exception e) {
//            e.printStackTrace();
//        }
//        try {
//            URL url = new URL("https://jr-api-express.herokuapp.com/api/payment/getIncoming/?bankCode=102&session=20210123_04");
//            InputStream is = url.openStream();
//            JsonReader rdr = Json.createReader(is);
//
//            JsonObject obj = rdr.readObject();
//            JsonArray results = obj.getJsonArray("r");
//            for (JsonObject result : results.getValuesAs(JsonObject.class)) {
//                if(result.getString("paymentStatus").compareTo("settled") == 0){    //czy udany przelew
//                    System.out.println("Przelano");
//                }
//                else {
//                    System.out.println("Nie przelano");
//                }
//            }
//        } catch (Exception e) {
//            e.printStackTrace();
//        }
//        String code = "";
//        Calendar cal = Calendar.getInstance();
//        SimpleDateFormat sdf = new SimpleDateFormat("YYYYMMdd");
//        if(cal.getTime().getDay() != 0 && cal.getTime().getDay() != 6){
//            
//        }
//        System.out.println(sdf.format(cal.getTime()));
//        System.out.println(cal.getTime().getHours());
//        
//        Transaction t = new Transaction();
//        System.out.println(t.getSession());
        //  AccountNumber an = new AccountNumber();
        // System.out.println(an.ControlSum("PL 00 1050 4475 9393 0635 9401 7658"));
        //     Transaction t = new Transaction();
        //  t.receiveExternalTransaction("20210125_04");
//        String password = "2";
//        String hashed = BCrypt.hashpw(password, BCrypt.gensalt());
//        System.out.println(hashed);
//        if (BCrypt.checkpw("hasło", hashed)) {
//            System.out.println("It matches");
//        } else {
//            System.out.println("It does not match");
//        }
//        AccountNumber an = new AccountNumber();
//        System.out.println(an.GenerateAccountNumber("02964", "0000000000000002"));
//        System.out.println(an.isValid("PL" + "57102029640000000000000002"));


//        JsonObjectBuilder objectBuilder = Json.createObjectBuilder();
//        objectBuilder.add("senderAccountnumber", "PL 34 1020 1417 3109 9087 2047 4799");
//        objectBuilder.add("recipientAccountnumber", "PL 87 1050 4475 4135 2700 6690 2937");
//        objectBuilder.add("paymentTitle", "Tytułem test 1");
//        objectBuilder.add("paymentAmount", 20);
//        objectBuilder.add("currency", "PLN");
//        JsonObject json = objectBuilder.build();
//
//        System.out.println(json.toString());
//
//        HttpURLConnection connection = null;
//
//        try {
//            Transaction t = new Transaction();
//            //Create connection
//            URL url = new URL("https://jr-api-express.herokuapp.com/api/payment/");
//            connection = (HttpURLConnection) url.openConnection();
//            connection.setRequestMethod("POST");
//            connection.setRequestProperty("Content-Type",
//                    "application/json; charset=UTF-8");
//            connection.setRequestProperty("Authorization", t.getToken());
//
//            connection.setUseCaches(false);
//            connection.setDoOutput(true);
//
//            //Send request
//            DataOutputStream wr = new DataOutputStream(
//                    connection.getOutputStream());
//            wr.writeBytes(json.toString());
//            wr.close();
//            //Recieve request
//            InputStream is = connection.getInputStream();
//            if (connection.getResponseCode() == 200) {
//                JsonReader rdr = Json.createReader(is);
//                JsonObject obj = rdr.readObject();
//                Boolean accepted = obj.getBoolean("isPaymentAccepted");
//                if (accepted) {
//
//                }
//                String message = obj.getString("message");
//                System.out.println(message);
//            } else {
//
//            }
//
//        } catch (Exception e) {
//            e.printStackTrace();
//        } finally {
//            if (connection != null) {
//                connection.disconnect();
//            }
//        }

//        AccountService as = new AccountService();
//        Account account = as.findByIdUser("16");
//
//        System.out.println(makeExternalTransaction(account, "27105044759393063594017658", new BigDecimal("12"), "Test"));
        
        //Transaction t = new Transaction();
      //  t.receiveExternalTransaction("20210125_04");
      
      UserService us = new UserService();
            User user = us.findById(18);
            System.out.println(user.getName());
    }

    public static boolean makeExternalTransaction(Account account, String number, BigDecimal amount, String title) {
        boolean success = false;
        //WYSŁANIE ZAPYTANIA DO JEDNOSTKI ROZLICZENIOWEJ
        JsonObjectBuilder objectBuilder = Json.createObjectBuilder();
        objectBuilder.add("senderAccountnumber", "PL" + account.getNumber());
        objectBuilder.add("recipientAccountnumber", "PL" + number);
        objectBuilder.add("paymentTitle", title);
        objectBuilder.add("paymentAmount", amount);
        objectBuilder.add("currency", "PLN");
        JsonObject json = objectBuilder.build();
        
        System.out.println(json.toString());

        HttpURLConnection connection = null;

        try {
            Transaction t = new Transaction();
            //Create connection
            URL url = new URL("https://jr-api-express.herokuapp.com/api/payment/");
            connection = (HttpURLConnection) url.openConnection();
            connection.setRequestMethod("POST");
            connection.setRequestProperty("Content-Type",
                    "application/json; charset=UTF-8");
            connection.setRequestProperty("Authorization", t.getToken());

            connection.setUseCaches(false);
            connection.setDoOutput(true);

            //Send request
            DataOutputStream wr = new DataOutputStream(
                    connection.getOutputStream());
            wr.writeBytes(json.toString());
            wr.close();
            //Recieve request
            InputStream is = connection.getInputStream();
            if (connection.getResponseCode() == 200) {
                JsonReader rdr = Json.createReader(is);
                JsonObject obj = rdr.readObject();
                Boolean accepted = obj.getBoolean("isPaymentAccepted");
                if (accepted) {
                    success = true;
                }
            }
        } catch (Exception e) {
            e.printStackTrace();
        } finally {
            if (connection != null) {
                connection.disconnect();
            }
        }
        if (success) {
            //OBCIĄŻENIE KONTA
            AccountService as = new AccountService();
            account.setBalance(account.getBalance().subtract(amount));
            as.update(account);
            //ZAPIS OPERACJI
            OperationService os = new OperationService();
            Operation o = new Operation("obciążenie", new Date(new java.util.Date().getTime()), amount, "Zlecony", account.getNumber(), number, title);
            os.persist(o);
        }

        return success;
    }

}
