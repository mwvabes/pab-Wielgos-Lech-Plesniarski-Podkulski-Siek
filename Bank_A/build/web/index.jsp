
<%@page contentType="text/html" pageEncoding="UTF-8"%>
<html>
    <head>
        <title>Bank A</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <div>
            <h1>Bank A</h1>
            <form action="LoginServlet" method="post">
                Login:<input type="text" name="login">
                Hasło:<input type="password" name="pass">
                ${message}
                <input type="submit" value="Zaloguj">
            </form>
        </div>
    </body>
</html>

