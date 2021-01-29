
<%@page contentType="text/html" pageEncoding="UTF-8"%>
<!DOCTYPE html>
<html lang="pl">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- <title>Logowanie</title> -->

        <link rel="stylesheet" href="styles/reset.css" />
        <link rel="stylesheet" href="styles/global.css" />

    </head>

    <body id="test">

        <div class="circle"></div>

        <header>
            <div class="container">
                <div class="row">
                    <div class="right">
                        <div class="logo">
                            <img src="icons/ryba_logo.png" alt="">
                        </div>
                    </div>
                    <div class="left">
                        <div class="row">
                            <div class="links">
                                <a href="./logowanie.html" class="active">Strona główna</a>
                                <a href="./oferty_promocje.html">Oferty i promocje</a>
                                <a href="#">Kalkulator sesji ELIXIR</a>
                                <a href="./kantor.html">Kantor</a>
                                <a href="./kontakt.html">Kontakt</a>
                            </div>
                            <div class="clientLogin">
                                <a href="./logowanie.html"><img src="./../icons/" alt=""><img src="icons/padlock_white.png" alt=""
                                                                                              class="smallIcon">
                                    Logowanie Klienta</a>
                            </div>
                            <a href="#" class="mobileHamburgerMenu"><img src="icons/hamburgericon_blue.png" alt=""></a>
                        </div>
                    </div>
                </div>
            </div>
        </header>


        <main>
            <div class="container">
                <div class="card">

                    <div class="grid gridRight">
                        <img src="icons/circlegrid_9_4.svg" class="circleImg" />
                    </div>

                    <div class="cardTitle row">
                        <div class="cardTitleH1">
                            <h1>RYBA Banki Polskie</h1>
                        </div>
                        <div class="cardTitleH2">
                            <h2>Logowanie Klienta</h2>
                        </div>
                    </div>
                    <div class="loginTypeChoose row">
                        <a href="#" class="active">
                            <h3>Klient Indywidualny</h3>
                        </a>
                        <a href="#">
                            <h3>Klient Firmowy</h3>
                        </a>
                    </div>
                    <form action="LoginServlet" method="post" class="loginInputs">
                        <div class="row">
                            <input type="text" placeholder="Login" name="login">
                        </div>
                        <div class="row">
                            <input type="password" placeholder="Hasło" name="pass">
                        </div>
                        <div class="row">
                            <input type="submit" value="Zaloguj">
                        </div>
                        <div class="row">
                            ${message}
                        </div>
                        <div class="row">
                            <div class="helpInfo">
                                <p>Nie możesz się zalogować? <a href="./logowanie3.html">Skorzystaj z pomocy w logowaniu</a>.</p>
                            </div>
                        </div>
                    </form>

                    <div class="cardMessages">
                        <article>
                            <h4>Drogi Kliencie!</h4>
                            <p>Chroń swoje konto przed nieuprawnionym dostępem osób trzecich. Uważaj na wyłudzenia danych. Zapoznaj się
                                z naszym <a href="#">poradnikiem dotyczącym bezpieczeństwa</a>.</p>
                        </article>
                    </div>

                </div>
            </div>
        </main>

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
                            <a href="#"><img src="./../icons/en.png" alt=""></a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

    </body>

</html>
