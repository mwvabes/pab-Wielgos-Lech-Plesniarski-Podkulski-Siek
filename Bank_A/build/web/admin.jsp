
<%@page contentType="text/html" pageEncoding="UTF-8"%>
<%@ page language="java" import="Tables.*" %>
<%
    Login l = (Login) session.getAttribute("login");

    if (l == null) {
        response.sendRedirect("index.jsp");
        return;
    } else {
        if (l.isModerator() == false) {
            response.sendRedirect("user.jsp");
            return;
        }
    }
%>
<!DOCTYPE html>
<html lang="pl">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- <title>Logowanie</title> -->

        <link rel="stylesheet" href="styles/reset.css" />
        <link rel="stylesheet" href="styles/global.css" />
        <link rel="stylesheet" href="styles/zalogowany_motywjasny.css" />

    </head>

    <body>

        <div class="circle"></div>

        <header>
            <div class="headerWrapper">
                <div class="container">
                    <div class="row">
                        <div class="right">
                            <div class="logo">
                                <img src="icons/transfer_pkobp.png" alt="">
                            </div>
                            <div class="messagesCentre">
                                <h3>Panel administratora</h3>
                            </div>
                        </div>
                        <div class="left">
                            <div class="row">
                                <div class="currentlyLoggedInfo">
                                    <p><% out.println(l.getLogin());%></p>
                                </div>
                                <div class="clientLogin">
                                    <a href="LogoutServlet"><img src="./../icons/" alt=""><img src="icons/logout_white.png" alt=""
                                                                                               class="smallIcon">
                                        Wyloguj</a>
                                </div>
                                <a href="#" class="mobileHamburgerMenu"><img src="./../icons/hamburgericon_blue.png" alt=""></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="headerWrapper">
                <div class="container subMenuContainer">
                    <div class="subMenu">
                        <a href="admin.jsp">Rejestracja</a>
                        <a href="klienci.jsp">Zarządzanie kontami</a>
                        <a href="#">Karty płatnicze <img class="submenuIcon" src="icons/expand_blue.png" /></a>
                        <a href="#">Ostrzeżenia <span class="redDotInfo">1</span></a>
                        <a href="#">Moje ubezpieczenia</a>
                    </div>
                </div>
            </div>

        </header>

        <div class="container superContainer">

            <main>

                <div class="newPaymentDispositionWindow">
                    <h3>Rejestracja nowego klienta</h3>
                    <div class="newPaymentDispositionCard">
                        <form action="RegisterServlet" method="post">
                            <div class="row">
                                <label> Imie<input type="text" name="name"> </label>
                                <label> Nazwisko<input type="text" name="surname"> </label>
                            </div>
                            <div class="row">
                                <label> Login<input type="text" name="login"> </label>
                                <label> Hasło<input type="password" name="password"> </label>
                            </div>
                            <div class="row">
                                <label> Adres<input type="text" name="address"> </label>
                                <label> Kontakt<input type="text" name="contact"> </label>
                            </div>
                            <div class="row"><label>Oddział</label></div>
                            <div class="row">
                                <label> Grunwaldzka 1, 21-035 Rzeszów<input type="radio" name="department" value="02964" checked=""> </label>
                                <label> Al. Jerozolimskie 99, 00-012 Warszawat<input type="radio" name="department" value="01417"> </label>
                            </div>
                            <div class="row">
                                <label>${message}</label>
                                <input type="submit" value="Zarejestruj">
                            <div>         
                        </form>
                    </div>
                </div>

            </main>

        </div>

        <footer>
            <div class="container">
                <div class="row">
                    <div class="left">
                        &copy; 2021 Banki Polskie RYBA
                    </div>
                    <div class="right">
                        <div class="links">
                            <a href="#">Bankowość Osobista</a>
                            <a href="#">Bankowość Firmowa</a>
                            <a href="#">Zastrzeż kartę</a>
                            <a href="#">Przerwy techniczne</a>
                            <a href="#">Infolinia: 800 800 008</a>
                            <a href="#"><img src="icons/en.png" alt=""></a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

    </body>

</html>