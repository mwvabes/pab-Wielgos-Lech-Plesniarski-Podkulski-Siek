/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Servlets;

import DAO.AccountService;
import DAO.LoginService;
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
import org.mindrot.jbcrypt.BCrypt;

@WebServlet(name = "RegisterServlet", urlPatterns = {"/RegisterServlet"})
public class RegisterServlet extends HttpServlet {

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
            out.println("<title>Servlet RegisterServlet</title>");            
            out.println("</head>");
            out.println("<body>");
            out.println("<h1>Servlet RegisterServlet at " + request.getContextPath() + "</h1>");
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
        
        String destPage = "admin.jsp";
        
        String name = request.getParameter("name");
        String surname = request.getParameter("surname");
        String login = request.getParameter("login");
        String password = request.getParameter("password");
        String address = request.getParameter("address");
        String contact = request.getParameter("contact");
        String department = request.getParameter("department");

        if("".equals(name) || "".equals(surname) || "".equals(login) || "".equals(password) || "".equals(address) || "".equals(contact)){
            String message = "Uzupełnij wszystkie pola.";
            request.setAttribute("message", message);
        }
        else {
            LoginService ls = new LoginService();
            String hashed = BCrypt.hashpw(password, BCrypt.gensalt());
            Login l = new Login(login, hashed, false);
            if(ls.findByLogin(login).size() > 0){
                String message = "Istniej już użytkownik o padnym loginie.";
                request.setAttribute("message", message);
            }
            else {
                ls.persist(l);

                UserService us = new UserService();
                User user = new User(name, surname, address, contact, String.valueOf(l.getId_login()));
                us.persist(user);

                AccountService as = new AccountService();
                Account a = new Account("123", new BigDecimal(0), user.getId_user());
                as.persist(a);
                String N = String.valueOf(a.getId_account());
                while(N.length() < 16){
                    N = "0" + N;
                }
                AccountNumber an = new AccountNumber();
                String n = an.GenerateAccountNumber(department, N);
                a.setNumber(n);
                as.update(a);
        
                String message = "Zarejstrowano nowego użytkownika.";
                request.setAttribute("message", message);
            }
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
