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
import java.io.IOException;
import java.io.PrintWriter;
import java.math.BigDecimal;
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
        request.setCharacterEncoding("UTF-8");
        
        String message = null;
        String destPage = "user.jsp";
        
        try {
            String number = request.getParameter("number").replaceAll("[^a-zA-Z0-9]", ""); //pobranie i usuwanie niealfanumerycznych znaków
            String address = request.getParameter("address");
            String name = request.getParameter("name");
            BigDecimal amount = new BigDecimal(request.getParameter("amount"));
            String title = request.getParameter("title");
            String type = request.getParameter("type");

            HttpSession session = request.getSession();
            Login l = (Login) session.getAttribute("login");

            UserService us = new UserService();
            User u = us.findByIdLogin(Integer.toString(l.getId_login()));

            AccountService as = new AccountService();
            Account a = as.findByIdUser(Integer.toString(u.getId_user()));

            Klasy.Transaction t = new Klasy.Transaction();

            if (type.equals("standard")) {
                if (!t.isSolvent(a, amount)) {
                    message = "Niewystarczajaca ilość środków na koncie.";
                    request.setAttribute("message", message);
                }
            }
            else{
                if (!t.isSolvent(a, amount.add(new BigDecimal("3")))) {
                    message = "Niewystarczajaca ilość środków na koncie.";
                    request.setAttribute("message", message);
                }
            }

            AccountNumber an = new AccountNumber();

            if (!an.isValid("PL" + number)) {
                message = "Nieprawidłowy numer konta.";
                request.setAttribute("message", message);
            }

            if (t.isInternal(number)) {   //określenie typu przelewu
                t.makeInternalTransaction(a, u, number, name, address, amount, title);
            } else {   //przelew zewnętrzny
                if (type.equals("standard")) {
                    if(t.makeExternalTransaction(a, u, number, name, address, amount, title) == false){
                        message = "Wystąpił błąd, spróbuj jeszcze raz później.";
                        request.setAttribute("message", message);
                        destPage = "zlecenie_przelewu.jsp";
                    }
                } else {
                    t.makeExpressTransaction(a.getNumber(), u.getName() + " " + u.getLastName(), u.getAddress(),
                            number, name, address, title, amount);
                }
            }

        } catch (Exception e) {
            message = "Niepoprawne dane.";
            request.setAttribute("message", message);
            destPage = "zlecenie_przelewu.jsp";
            RequestDispatcher dispatcher = request.getRequestDispatcher(destPage);
            dispatcher.forward(request, response);
        }

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
