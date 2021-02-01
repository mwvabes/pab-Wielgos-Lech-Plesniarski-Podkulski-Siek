package Klasy;

import DAO.AccountService;
import DAO.OperationService;
import Tables.Account;
import Tables.Operation;
import java.io.DataOutputStream;
import java.io.InputStream;
import java.io.OutputStream;
import java.math.BigDecimal;
import java.net.HttpURLConnection;
import java.net.URL;
import java.sql.Date;
import java.util.List;
import javax.json.Json;
import javax.json.JsonArray;
import javax.json.JsonObject;
import javax.json.JsonObjectBuilder;
import javax.json.JsonReader;
import javax.json.JsonWriter;
import sun.misc.IOUtils;

public class Transaction {

    public boolean isSolvent(Account account, BigDecimal amount) {
        if (account.getBalance().compareTo(amount) == -1) {
            return false;
        } else {
            return true;
        }
    }

    public boolean isInternal(String number) {
        return number.substring(2, 5).equals("102");
    }

    public void makeInternalTransaction(Account account, String number, BigDecimal amount, String title) {
        //OBCIĄŻENIE KONTA
        AccountService as = new AccountService();
        account.setBalance(account.getBalance().subtract(amount));
        as.update(account);
        //ZAPIS OPERACJI
        OperationService os = new OperationService();
        Operation o = new Operation("obciążenie", new Date(new java.util.Date().getTime()), amount, "Zrealizowany", account.getNumber(), number, title);
        os.persist(o);
        //UZNANIE KONTA
        Account account2 = as.findByNumber(number);
        account2.setBalance(account2.getBalance().add(amount));
        as.update(account2);
    }

    public boolean makeExternalTransaction(Account account, String number, BigDecimal amount, String title) {
        boolean success = false;
        //WYSŁANIE ZAPYTANIA DO JEDNOSTKI ROZLICZENIOWEJ
        JsonObjectBuilder objectBuilder = Json.createObjectBuilder();
        objectBuilder.add("senderAccountnumber", "PL" + account.getNumber());
        objectBuilder.add("recipientAccountnumber", "PL" + number);
        objectBuilder.add("paymentTitle", title);
        objectBuilder.add("paymentAmount", 25);
        objectBuilder.add("currency", "PLN");
        JsonObject json = objectBuilder.build();

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

    public void receiveExternalTransaction(String session) {
        try {
            URL url = new URL("https://jr-api-express.herokuapp.com/api/payment/getIncoming/?bankCode=102&session=" + session);
            InputStream is = url.openStream();
            JsonReader rdr = Json.createReader(is);

            JsonObject obj = rdr.readObject();
            JsonArray results = obj.getJsonArray("r");
            for (JsonObject result : results.getValuesAs(JsonObject.class)) {
                Boolean returnToSender = false;
                String status = result.getString("paymentStatus");
                BigDecimal amount = new BigDecimal(Integer.toString((result.getInt("paymentAmount"))));
                String senderAccountNumber = result.getString("senderAccountnumber").substring(2); //nr nadawcy bez PL
                String recipientAccountNumber = result.getString("recipientAccountnumber").substring(2); //nr odbiorcy bez PL

                if (status.compareTo("settled") == 0) {    //czy udany przelew
                    AccountNumber an = new AccountNumber();
                    if (an.isValid("PL" + recipientAccountNumber)) { //czy prawidłowy format nr konta odbiorcy
                        AccountService as = new AccountService();
                        Account account = as.findByNumber(recipientAccountNumber);
                        if (account == null) {  //czy nie znaleziono odbiorcę w banku
                            returnToSender = true;
                        } else {
                            //ZAPIS OPERACJI
                            OperationService os = new OperationService();
                            Operation o = new Operation("uznanie",
                                    new Date(new java.util.Date().getTime()),
                                    amount,
                                    "Zrealizowany",
                                    senderAccountNumber,
                                    recipientAccountNumber,
                                    result.getString("paymentTitle"));
                            os.persist(o);
                            //UZNANIE KONTA
                            account.setBalance(account.getBalance().add(amount));
                            as.update(account);
                        }

                    } else {
                        returnToSender = true;
                    }
                } else {
                    returnToSender = true;
                }

                if (returnToSender) {   //Przelew do nadawcy
                    //WYSŁANIE ZAPYTANIA DO JEDNOSTKI ROZLICZENIOWEJ
                    String json = "{"
                            + "\"senderAccountnumber\": \"PL84102029640000000000000001\","
                            + "\"recipientAccountnumber\": \"PL" + senderAccountNumber + "\","
                            + "\"paymentTitle\": \"Zwrot należności\","
                            + "\"paymentAmount\": \"" + amount.toString() + "\","
                            + "\"currency\": \"PLN\""
                            + "}";

                    HttpURLConnection connection = null;

                    try {
                        //Create connection
                        URL url2 = new URL("https://jr-api-express.herokuapp.com/api/payment/");
                        connection = (HttpURLConnection) url2.openConnection();
                        connection.setRequestMethod("POST");
                        connection.setRequestProperty("Content-Type",
                                "application/json; charset=UTF-8");

                        connection.setUseCaches(false);
                        connection.setDoOutput(true);
                        //Send request
                        DataOutputStream wr = new DataOutputStream(
                                connection.getOutputStream());
                        wr.writeBytes(json);
                        wr.close();
                        connection.getInputStream();
                    } catch (Exception e) {
                        e.printStackTrace();
                    } finally {
                        if (connection != null) {
                            connection.disconnect();
                        }
                    }

                }
            }
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    public void makeExpressTransaction(String senderAccountnumber, String recipientAccountnumber, String paymentTitle, BigDecimal amount) {
        //OBCIĄŻENIE KONTA
        AccountService as = new AccountService();
        Account account = as.findByNumber(senderAccountnumber);
        account.setBalance(account.getBalance().subtract(amount.add(new BigDecimal("3"))));
        as.update(account);
        //UZNANIE KONTA DEJLI EXPRESS
        Account account2 = as.findByNumber("57102029640000000000000002");
        account2.setBalance(account2.getBalance().add(amount.add(new BigDecimal("3"))));
        as.update(account2);
        //ZAPIS OPERACJI
        OperationService os = new OperationService();
        Operation o = new Operation("obciążenie", new Date(new java.util.Date().getTime()), amount, "Zrealizowany", senderAccountnumber, recipientAccountnumber, paymentTitle);
        os.persist(o);
        //WYSŁANIE ZAPYTANIA DO BANKU B
    }

    public void receiveExpressTransaction(String senderAccountnumber, String recipientAccountnumber, String paymentTitle, BigDecimal amount) {
        //OBCIĄŻENIE KONTA
        AccountService as = new AccountService();
        Account account = as.findByNumber("57102029640000000000000002");
        account.setBalance(account.getBalance().subtract(amount));
        as.update(account);
        //ZAPIS OPERACJI
        OperationService os = new OperationService();
        Operation o = new Operation("uznanie", new Date(new java.util.Date().getTime()), amount, "Zrealizowany", senderAccountnumber, recipientAccountnumber, paymentTitle);
        os.persist(o);
        //UZNANIE KONTA
        Account account2 = as.findByNumber(recipientAccountnumber);
        account2.setBalance(account2.getBalance().add(amount));
        as.update(account2);
    }

    public List<Operation> getHistory(Account account) {
        OperationService os = new OperationService();
        List<Operation> list = os.findByNumber(account.getNumber());
        return list;
    }

    public String getSession() {
        String session = null;
        try {
            URL url = new URL("https://jr-api-express.herokuapp.com/api/session");
            InputStream is = url.openStream();
            JsonReader rdr = Json.createReader(is);

            JsonObject obj = rdr.readObject();
            session = obj.getString("currentSessionAvailable");
        } catch (Exception e) {
            e.printStackTrace();
        }

        return session;
    }

    public String getToken() {
        String token = null;

        JsonObjectBuilder objectBuilder = Json.createObjectBuilder();
        objectBuilder.add("username", "b102");
        objectBuilder.add("password", "operator5");
        JsonObject json = objectBuilder.build();

        HttpURLConnection connection = null;

        try {
            //Create connection
            URL url = new URL("http://jr-api-express.herokuapp.com/api/auth/login");
            connection = (HttpURLConnection) url.openConnection();
            connection.setRequestMethod("POST");
            connection.setRequestProperty("Content-Type",
                    "application/json; charset=UTF-8");

            connection.setUseCaches(false);
            connection.setDoOutput(true);
            //Send request
            DataOutputStream wr = new DataOutputStream(
                    connection.getOutputStream());
            wr.writeBytes(json.toString());
            wr.close();
            //Recieve request
            InputStream is = connection.getInputStream();
            JsonReader rdr = Json.createReader(is);
            JsonObject obj = rdr.readObject();
            token = obj.getString("token");
        } catch (Exception e) {
            e.printStackTrace();
        } finally {
            if (connection != null) {
                connection.disconnect();
            }
        }

        return token;
    }
}
