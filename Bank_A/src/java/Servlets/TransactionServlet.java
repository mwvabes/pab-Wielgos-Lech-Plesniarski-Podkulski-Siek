/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Servlets;

import DAO.AccountService;
import DAO.UserService;
import Klasy.AccountNumber;
import Tables.Account;
import Tables.Login;
import Tables.User;
import java.io.DataOutputStream;
import java.io.IOException;
import java.io.PrintWriter;
import java.math.BigDecimal;
import java.net.HttpURLConnection;
import java.net.URL;
import javax.servlet.RequestDispatcher;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;

/**
 *
 * @author UkeiS
 */
@WebServlet(name = "TransactionServlet", urlPatterns = {"/TransactionServlet"})
public class TransactionServlet extends HttpServlet {

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
        response.setContentType("text/html;charset=UTF-8");
        try (PrintWriter out = response.getWriter()) {
            /* TODO output your page here. You may use following sample code. */
            out.println("<!DOCTYPE html>");
            out.println("<html>");
            out.println("<head>");
            out.println("<title>Servlet TransactionServlet</title>");
            out.println("</head>");
            out.println("<body>");
            out.println("<h1>Servlet TransactionServlet at " + request.getContextPath() + "</h1>");
            out.println("</body>");
            out.println("</html>");
        }
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

        try {
            String number = request.getParameter("number").replaceAll("[^a-zA-Z0-9]", ""); //pobranie i usuwanie niealfanumerycznych znaków
            String address = request.getParameter("address");
            BigDecimal amount = new BigDecimal(request.getParameter("amount"));
            String title = request.getParameter("title");

            HttpSession session = request.getSession();
            Login l = (Login) session.getAttribute("login");

            UserService us = new UserService();
            User u = us.findByIdLogin(Integer.toString(l.getId_login()));

            AccountService as = new AccountService();
            Account a = as.findByIdUser(Integer.toString(u.getId_user()));

            Klasy.Transaction t = new Klasy.Transaction();

            if (!t.isSolvent(a, amount)) {
                String message = "Niewystarczajaca ilość środków na koncie.";
                request.setAttribute("message", message);
            }

            AccountNumber an = new AccountNumber();

            if (!an.isValid("PL" + number)) {
                String message = "Nieprawidłowy numer konta.";
                request.setAttribute("message", message);
            }

            if (t.isInternal(number)) {   //określenie typu przelewu
                t.makeInternalTransaction(a, number, amount, title);
            } else {   //przelew zewnętrzny
                t.makeExternalTransaction(a, number, amount, title);
            }

        } catch (Exception e) {
            String message = "Niepoprawne dane.";
            request.setAttribute("message", message);
            String destPage = "zlecenie_przelewu.jsp";
            RequestDispatcher dispatcher = request.getRequestDispatcher(destPage);
            dispatcher.forward(request, response);
        }

        String destPage = "user.jsp";
        RequestDispatcher dispatcher = request.getRequestDispatcher(destPage);
        dispatcher.forward(request, response);
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
