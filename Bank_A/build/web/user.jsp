
<%@page contentType="text/html" pageEncoding="UTF-8"%>
<%@ page language="java" import="Tables.*" %>
<%@ page language="java" import="DAO.*" %>
<%@ page language="java" import="Klasy.*" %>
<%@ page language="java" import="java.math.BigDecimal" %>
<%@ page language="java" import="java.util.List" %>
<%@ page language="java" import="java.text.SimpleDateFormat" %>
<%
    if(session.getAttribute("login") == null){
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
                <p><% out.println(u.getName() + " " + u.getLastName()); %></p>
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

      <div class="mainSummary">
        <div class="col2 summaryFirstCol">
          <h1 class="accountName">Konto</h1>
          <h2 class="accountNumber"><% out.println(a.getNumber()); %></h2>
          <div class="copyButtons">
            <button>kopiuj numer konta</button>
            <button>pobierz PDF z danymi do przelewu</button>
          </div>
          <div class="balanceInfo">
            <h2 class="mainBalance"><span>saldo</span> <% out.println(a.getBalance() + " PLN"); %></h2>
          </div>
          <div class="mainButtons">
            <a href="zlecenie_przelewu.jsp" class="mainActionButton">
              <img src="icons/new_transaction_white.png" /><span>Nowy przelew</span>
              <div class="selectionBox"><img src="icons/expand_white.png" /></div>
            </a>
            <a href="#" class="historyButton"><img src="icons/history_blue.png" />Historia</a>
          </div>
        </div>
        <div class="col2 summarySecondCol">
          <h2>Podsumowanie</h2>
          <div class="tableLikeContainer">
            <p class="tableLike"><span>blokady</span><span class="val">44,57 PLN</span></p>
            <p class="tableLike"><span>przelewy w trakcie realizacji</span><span class="val">0</span></p>
            <p class="tableLike"><span>operacje internetowe w trakcie realizacji</span><span class="val">1</span></p>
            <p class="tableLike"><span>operacje płatnicze w trakcie realizacji</span><span class="val">2</span></p>
          </div>
          <div class="tableLikeContainer">
            <p class="tableLike"><span>płatności kartą dzisiaj</span><span class="val">5</span></p>
            <p class="tableLike"><span>w tym odrzuconych</span><span class="val">0</span></p>
          </div>
        </div>
        <div class="col1 summaryThirdCol">
          <h2>
            Moje wyciągi
          </h2>
          <div class="tableLikeContainer">
            <div class="tableLike"><span class="badgeNew">NOWY</span><span>wrzesień 2020</span><a href="#">Pobierz
                PDF</a></div>
            <div class="tableLike"><span>sierpień 2020</span><a href="#">Pobierz PDF</a></div>
            <div class="tableLike"><span>lipiec 2020</span><a href="#">Pobierz PDF</a></div>
            <div class="tableLike"><span>czerwiec 2020</span><a href="#">Pobierz PDF</a></div>
            <div class="tableLike"><button class="generateInactive">Generuj niestandardowy</button><button
                class="generateActive">Zobacz więcej</button></div>
          </div>
          <p>Istnieje powiązane konto Junior</p>
          <a href="#" class="juniorColor">Zarządzaj kontem dziecka</a>
        </div>
      </div>

      <div class="mainPropWindow">
        <div class="mainPropHeader">
          <h2>Historia operacji</h2>
          <h2></h2>
        </div>

        <div class="historyWrapper">
            
            <%
                Transaction t = new Transaction();    
                List<Operation> list = t.getHistory(a);
                
                for(int i =0; i<list.size(); i++){
                    if(list.get(i).getSender_number().compareTo(a.getNumber()) == 0){
                        %>
                        <div class="historyEntity">
                            <div class="historyEntityContainer">
                              <div class="historyEntityProps historyTypeRed">
                                <div class="historyImageSection">
                                  <div class="mainImage">
                                    <img src="icons/transfers.png" />
                                  </div>
                                  <div class="operationTypeImage">
                                    <img src="icons/outgoing_transfer.png" />
                                  </div>
                                </div>
                                <div class="beneficiary">
                                    <p><%=list.get(i).getRecipent_name() %></p>
                                    <p><%=list.get(i).getRecipent_address()%></p>
                                </div>
                                <div class="paymentInfo">
                                  <p><% out.println(new SimpleDateFormat("yyyy-MM-dd").format(list.get(i).getDate())); %></p>
                                  <p>Numer konta: <% out.println(list.get(i).getRecipent_number()); %></p>
                                  <p>Tytuł: <% out.println(list.get(i).getTitle()); %></p>
                                </div>
                                <div class="operationInfo">
                                  <h4>Przelew wychodzący</h4>
                                  <h3 class="operationMinus"><% out.println("-" + list.get(i).getAmount().toString() + " PLN"); %></h3>
                                </div>
                                <div class="historyEntityCollapseIcon">
                                  <img src="icons/expand_blue.png" />
                                </div>
                              </div>
                            </div>
                        </div>
                        <%
                    }
                    else{                 
                        %>
                        <div class="historyEntity">
                            <div class="historyEntityContainer">
                              <div class="historyEntityProps historyTypeGreen">
                                <div class="historyImageSection">
                                  <div class="mainImage">
                                    <img src="icons/transfers.png" />
                                  </div>
                                  <div class="operationTypeImage">
                                    <img src="icons/incoming_transfer.png" />
                                  </div>
                                </div>
                                <div class="beneficiary">
                                  <p><%=list.get(i).getSender_name()%></p>
                                  <p><%=list.get(i).getSender_address()%></p>
                                </div>
                                <div class="paymentInfo">
                                  <p><% out.println(new SimpleDateFormat("yyyy-MM-dd").format(list.get(i).getDate())); %></p>
                                  <p>Numer konta: <% out.println(list.get(i).getSender_number()); %></p>
                                  <p>Tytuł: <% out.println(list.get(i).getTitle()); %></p>
                                </div>
                                <div class="operationInfo">
                                  <h4>Przelew przychodzący</h4>
                                  <h3 class="operationPlus"><% out.println(list.get(i).getAmount().toString() + " PLN"); %></h3>
                                </div>
                                <div class="historyEntityCollapseIcon">
                                  <img src="icons/expand_blue.png" />
                                </div>
                              </div>
                            </div>
                        </div>
                        <%
                    }
                }
            %>

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