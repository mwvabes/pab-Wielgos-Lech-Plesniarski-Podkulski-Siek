
<%@page contentType="text/html" pageEncoding="UTF-8"%>
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
            Hasło:<input type="text" name="password"></br>
            Adres:<input type="text" name="address"></br>
            Kontakt:<input type="text" name="contact"></br>
            Oddział</br>
            <input type="radio" name="oddzial" value="02964">Grunwaldzka 1, 21-035 Rzeszów</br>
            <input type="radio" name="oddzial" value="01417">Al. Jerozolimskie 99, 00-012 Warszawa</br>
            <input type="submit" value="Zarejestruj">
        </form>
    </body>
</html>
