/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Servlets;

import Klasy.AccountNumber;
import Klasy.Transaction;
import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;
import java.math.BigDecimal;
import javax.json.Json;
import javax.json.JsonObject;
import javax.json.JsonObjectBuilder;
import javax.json.JsonReader;
import javax.json.JsonWriter;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

/**
 *
 * @author UkeiS
 */
@WebServlet(name = "EndPoint", urlPatterns = {"/dejli/create"})
public class EndPoint extends HttpServlet {

    /**
     * Processes requests for both HTTP <code>GET</code> and <code>POST</code>
     * methods.
     *
     * @param request servlet request
     * @param response servlet response
     * @throws ServletException if a servlet-specific error occurs
     * @throws IOException if an I/O error occurs
     */
    protected void processRequest(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {

//        try (PrintWriter out = response.getWriter()) {
//            /* TODO output your page here. You may use following sample code. */
//            out.println("<!DOCTYPE html>");
//            out.println("<html>");
//            out.println("<head>");
//            out.println("<title>Servlet EndPoint</title>");            
//            out.println("</head>");
//            out.println("<body>");
//            out.println("<h1>Servlet EndPoint at " + request.getContextPath() + "</h1>");
//            out.println("</body>");
//            out.println("</html>");
//        }
    }

    // <editor-fold defaultstate="collapsed" desc="HttpServlet methods. Click on the + sign on the left to edit the code.">
    /**
     * Handles the HTTP <code>GET</code> method.
     *
     * @param request servlet request
     * @param response servlet response
     * @throws ServletException if a servlet-specific error occurs
     * @throws IOException if an I/O error occurs
     */
    @Override
    protected void doGet(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        processRequest(request, response);
    }

    /**
     * Handles the HTTP <code>POST</code> method.
     *
     * @param request servlet request
     * @param response servlet response
     * @throws ServletException if a servlet-specific error occurs
     * @throws IOException if an I/O error occurs
     */
    @Override
    protected void doPost(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {

        //Odebranie Jsona
        InputStream is = request.getInputStream();

        JsonReader rdr = Json.createReader(is);

        JsonObject obj = rdr.readObject();

        String senderAccountnumber = obj.getString("senderAccountnumber").replaceAll("[^a-zA-Z0-9]", "").substring(2);
        String snederName = obj.getString("senderName");
        String senderAddress = obj.getString("senderAddress");
        String recipientAccountnumber = obj.getString("recipientAccountnumber").replaceAll("[^a-zA-Z0-9]", "").substring(2);
        String recipientName = obj.getString("recipientName");
        String recipientAddress = obj.getString("recipientAddress");
        String paymentTitle = obj.getString("paymentTitle");
        BigDecimal paymentAmount = new BigDecimal(Integer.toString(obj.getInt("paymentAmount")));
        String currency = obj.getString("currency");
        String message = "Przelew odrzucony";

        //Obsługa tranzakcji
        AccountNumber an = new AccountNumber();
        if (currency.equals("PLN") == true) {
            if (an.isValid("PL" + senderAccountnumber) && an.isValid("PL" + recipientAccountnumber)) {
                Transaction t = new Transaction();
                t.receiveExpressTransaction(senderAccountnumber, snederName, senderAddress, 
                        recipientAccountnumber, recipientName, recipientAddress, 
                        paymentTitle, paymentAmount);
                message = "Przelew przyjęty";
            } else {
                message += " | Błędny nr konta";
            }
        }
        else{
            message += " | Nieobsługiwana waluta";
        }

        //Wysłanie Jsona
        response.setContentType("application/json;charset=UTF-8");
        JsonObjectBuilder loginBuilder = Json.createObjectBuilder();

        loginBuilder.add("message", message);
        loginBuilder.add("senderAccountnumber", senderAccountnumber);
        loginBuilder.add("recipientAccountnumber", recipientAccountnumber);

        JsonObject object = loginBuilder.build();

        OutputStream os = response.getOutputStream();
        JsonWriter jw = Json.createWriter(os);
        jw.writeObject(object);
        jw.close();
    }

    /**
     * Returns a short description of the servlet.
     *
     * @return a String containing servlet description
     */
    @Override
    public String getServletInfo() {
        return "Short description";
    }// </editor-fold>

}
