
<%@page contentType="text/html" pageEncoding="UTF-8"%>
<%@ page language="java" import="Tables.*" %>
<%@ page language="java" import="DAO.*" %>
<%@ page language="java" import="Klasy.*" %>
<%@ page language="java" import="java.math.BigDecimal" %>
<%@ page language="java" import="java.util.List" %>
<%@ page language="java" import="java.text.SimpleDateFormat" %>
<%
    if (session.getAttribute("login") == null) {
        response.sendRedirect("index.jsp");
        return;
    }

    Login l = (Login) session.getAttribute("login");

    UserService us = new UserService();
    User u = us.findByIdLogin(Integer.toString(l.getId_login()));

    AccountService as = new AccountService();
    Account a = as.findByIdUser(Integer.toString(u.getId_user()));

%>
<!DOCTYPE html>
<html lang="pl">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Bank A</title>

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
                                <div class="messagesCentreIcon">
                                    <img src="icons/phone_white.png" />
                                    <span class="redDotInfo">4</span>
                                </div>
                                <div class="messagesProperties">
                                    <h2>Centrum wiadomości</h2>
                                    <a href="#">Czytaj wszystko</a>
                                </div>
                            </div>
                            <div class="headerQuickInfo">
                                <p>ostatnia sesja logowania przez przeglądarkę: <strong>10.10.2020 14:23</strong></p>
                                <p>rachunki bankowe powiązane z kontem: <strong>1:23</strong></p>
                                <p>skojarzona aplikacja RYBA Neon: <strong>nie</strong> <a href="#">Połącz teraz</a></p>
                            </div>
                        </div>
                        <div class="left">
                            <div class="row">
                                <div class="currentlyLoggedInfo">
                                    <p><% out.println(u.getName() + " " + u.getLastName());%></p>
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
                        <a href="user.jsp"><img class="submenuIcon" src="icons/house_blue.png" /> Strona
                            główna</a>
                        <a href="#">Moje konta <img class="submenuIcon" src="icons/expand_blue.png" /></a>
                        <a href="mojeDane.jsp">Moje dane</a>
                        <a href="#">Ostrzeżenia <span class="redDotInfo">1</span></a>
                        <a href="#">Moje ubezpieczenia</a>
                    </div>
                </div>
            </div>

        </header>

        <div class="container superContainer">

            <main>

                <div class="newPaymentDispositionWindow">
                    <h3>Moje dane</h3>
                    <div class="newPaymentDispositionCard">

                        <form action="UpdateUser" method="post">
                            <input type="hidden" name="id" value="<%=u.getId_user()%>">
                            <div class="row">
                                <label> Imie<input type="text" name="name" value="<%=u.getName()%>"> </label>
                                <label> Nazwisko<input type="text" name="surname" value="<%=u.getLastName()%>"> </label>
                            </div>
                            <div class="row">
                                <label> Adres<input type="text" name="address" value="<%=u.getAddress()%>"> </label>
                                <label> Kontakt<input type="text" name="contact" value="<%=u.getContact()%>"> </label>
                            </div>
                            <div class="row">
                                <label>${message}</label>
                                <input type="submit" value="Zmień">
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