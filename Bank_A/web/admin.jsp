
<%@page contentType="text/html" pageEncoding="UTF-8"%>
<%@ page language="java" import="Tables.*" %>
<%
    Login l = (Login) session.getAttribute("login");
    
    if(l == null){
        response.sendRedirect("index.jsp");
        return;
    }
    else{
        if(l.isModerator() == false){
            response.sendRedirect("user.jsp");
            return;
        }
    }
%>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Bank A</title>
    </head>
    <body>
        <h1>Panel moderatora</h1>
        <a href="LogoutServlet">Wyloguj</a>
        
        <form action="RegisterServlet" method="post">
            Imie:<input type="text" name="name"></br>
            Nazwisko:<input type="text" name="surname"></br>
            Login:<input type="text" name="login"></br>
            Hasło:<input type="password" name="password"></br>
            Adres:<input type="text" name="address"></br>
            Kontakt:<input type="text" name="contact"></br>
            Oddział</br>
            <input type="radio" name="department" value="02964" checked>Grunwaldzka 1, 21-035 Rzeszów</br>
            <input type="radio" name="department" value="01417">Al. Jerozolimskie 99, 00-012 Warszawa</br>
            <input type="submit" value="Zarejestruj">
            ${message}
        </form>
    </body>
</html>