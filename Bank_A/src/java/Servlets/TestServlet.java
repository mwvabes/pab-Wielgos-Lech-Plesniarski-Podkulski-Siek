package Servlets;

import Klasy.Transaction;
import java.io.IOException;
import java.io.PrintWriter;
import java.text.SimpleDateFormat;
import java.util.Calendar;
import java.util.Timer;
import java.util.TimerTask;
import java.util.concurrent.TimeUnit;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

@WebServlet(name = "TestServlet", urlPatterns = {"/TestServlet"})
public class TestServlet extends HttpServlet {

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
            out.println("<title>Servlet TestServlet</title>");
            out.println("</head>");
            out.println("<body>");
            out.println("<h1>Servlet TestServlet at " + request.getContextPath() + "</h1>");
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
        
        Timer timer = new Timer();
        TimerTask task = new TimerTask() {
            public void run() {
                
                Calendar cal = Calendar.getInstance();
                if(cal.getTime().getDay() != 0 && cal.getTime().getDay() != 6){ //sprawdzenie czy nie weekend
                    Transaction t = new Transaction();
                    t.receiveExternalTransaction(t.getSession());
                }
                
                
            }
        };
        
        Calendar date = Calendar.getInstance();
        date.set(Calendar.HOUR_OF_DAY, 11);
        date.set(Calendar.MINUTE, 55);

        timer.schedule(task, date.getTime(), TimeUnit.MILLISECONDS.convert(1, TimeUnit.DAYS) * 7); // Sesja 1
        
        date.set(Calendar.HOUR_OF_DAY, 14);
        date.set(Calendar.MINUTE, 55);

        timer.schedule(task, date.getTime(), TimeUnit.MILLISECONDS.convert(1, TimeUnit.DAYS) * 7); // Sesja 2
        
        date.set(Calendar.HOUR_OF_DAY, 18);
        date.set(Calendar.MINUTE, 5);

        timer.schedule(task, date.getTime(), TimeUnit.MILLISECONDS.convert(1, TimeUnit.DAYS) * 7); // Sesja 3

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
        processRequest(request, response);
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
