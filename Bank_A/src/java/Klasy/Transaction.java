package Klasy;

import DAO.AccountService;
import DAO.OperationService;
import Tables.Account;
import Tables.Operation;
import java.io.DataOutputStream;
import java.io.InputStream;
import java.math.BigDecimal;
import java.net.HttpURLConnection;
import java.net.URL;
import java.sql.Date;
import java.util.List;
import javax.json.Json;
import javax.json.JsonArray;
import javax.json.JsonObject;
import javax.json.JsonReader;

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

    public void makeExternalTransaction(Account account, String number, BigDecimal amount, String title) {
        //OBCIĄŻENIE KONTA
        AccountService as = new AccountService();
        account.setBalance(account.getBalance().subtract(amount));
        as.update(account);
        //ZAPIS OPERACJI
        OperationService os = new OperationService();
        Operation o = new Operation("obciążenie", new Date(new java.util.Date().getTime()), amount, "Zlecony", account.getNumber(), number, title);
        os.persist(o);
        //WYSŁANIE ZAPYTANIA DO JEDNOSTKI ROZLICZENIOWEJ
        String json = "{"
                + "\"senderAccountnumber\": \"PL" + account.getNumber() + "\","
                + "\"recipientAccountnumber\": \"PL" + number + "\","
                + "\"paymentTitle\": \"" + title + "\","
                + "\"paymentAmount\": \"" + amount.toString() + "\","
                + "\"currency\": \"PLN\""
                + "}";

        HttpURLConnection connection = null;

        try {
            //Create connection
            URL url = new URL("https://jr-api-express.herokuapp.com/api/payment/");
            connection = (HttpURLConnection) url.openConnection();
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

    public void receiveExternalTransaction() {
        try {
            URL url = new URL("https://jr-api-express.herokuapp.com/api/payment/getIncoming/?bankCode=102&session=20210123_04");
            InputStream is = url.openStream();
            JsonReader rdr = Json.createReader(is);

            JsonObject obj = rdr.readObject();
            JsonArray results = obj.getJsonArray("r");
            for (JsonObject result : results.getValuesAs(JsonObject.class)) {
                Boolean returnToSender = false;
                String status = result.getString("paymentStatus");
                BigDecimal amount = new BigDecimal(result.getString("paymentAmount"));
                String senderAccountNumber = result.getString("senderAccountnumber");
                String recipientAccountNumber = result.getString("recipientAccountnumber");
                
                if (status.compareTo("settled") == 0) {    //czy udany przelew
                    AccountNumber an = new AccountNumber();
                    if (an.isValid(recipientAccountNumber)) { //czy prawidłowy format nr konta odbiorcy
                        AccountService as = new AccountService();
                        Account account = as.findByNumber(recipientAccountNumber);
                        if (account == null) {  //czy nie znaleziono odbiorcę w banku
                            returnToSender = true;
                        } else {
                            //ZAPIS OPERACJI
                            OperationService os = new OperationService();
                            Operation o = new Operation("uznaniee",
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

    public List<Operation> getHistory(Account account) {
        OperationService os = new OperationService();
        List<Operation> list = os.findByNumber(account.getNumber());
        return list;
    }
}
