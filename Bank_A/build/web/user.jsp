<%-- 
    Document   : user
    Created on : 2021-01-09, 11:00:15
    Author     : UkeiS
--%>

<%@page contentType="text/html" pageEncoding="UTF-8"%>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>JSP Page</title>
    </head>
    <body>
        <a href="LogoutServlet">Wyloguj</a>
        <h1>Przelew</h1>
        <form action="TransactionServlet" method="post">
            Numer rachunku:<input type="text" name="number"></br>
            Nazwa i adres:<input type="text" name="address"></br>
            Kwota:<input type="text" name="amount"></br>
            Tytuł:<input type="text" name="title"></br>
            <input type="submit" value="Wyślij">
            ${message}
            
            <h2>Historia operacji</h2>

            <%@ page language="java" import="Tables.*" %>
            <%@ page language="java" import="DAO.*" %>
            <%@ page language="java" import="Klasy.*" %>
            <%@ page language="java" import="java.math.BigDecimal" %>
            <%@ page language="java" import="java.util.List" %>
            <%
                
                Login l = (Login) session.getAttribute("login");
               // out.println(l);
                
                UserService us = new UserService();
                User u = us.findByIdLogin(Integer.toString(l.getId_login()));
                
                AccountService as = new AccountService();
                Account a = as.findByIdUser(Integer.toString(u.getId_user()));
                
                Transaction t = new Transaction();
                
                
                List<Operation> list = t.getHistory(a);
                for(int i =0; i<list.size(); i++){
                    if(list.get(i).getSender_number().compareTo(a.getNumber()) == 0){
                        out.println("-" + list.get(i).getAmount().toString() + "</br>");
                    }
                    else{
                        out.println(list.get(i).getAmount().toString() + "</br>");
                    }
                }
                
                %>
        </form>
        
    </body>
</html>
