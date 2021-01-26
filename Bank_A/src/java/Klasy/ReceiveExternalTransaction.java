
package Klasy;

import java.util.Calendar;
import java.util.Timer;
import java.util.TimerTask;
import java.util.concurrent.TimeUnit;
import javax.servlet.ServletContextEvent;
import javax.servlet.ServletContextListener;

public class ReceiveExternalTransaction 
           implements ServletContextListener{

  @Override
  public void contextDestroyed(ServletContextEvent arg0) {

  }

  @Override
  public void contextInitialized(ServletContextEvent arg0) {
    Timer timer = new Timer();
        TimerTask task = new TimerTask() {
            public void run() {
                Calendar cal = Calendar.getInstance();
                if (cal.getTime().getDay() != 0 && cal.getTime().getDay() != 6) { //sprawdzenie czy nie weekend
                    Transaction t = new Transaction();
                     t.receiveExternalTransaction(t.getSession());
                }
            }
        };
        
        TimerTask task2 = new TimerTask() {
            public void run() {
                Calendar cal = Calendar.getInstance();
                if (cal.getTime().getDay() != 0 && cal.getTime().getDay() != 6) { //sprawdzenie czy nie weekend
                    Transaction t = new Transaction();
                     t.receiveExternalTransaction(t.getSession());
                }
            }
        };
        
        TimerTask task3 = new TimerTask() {
            public void run() {
                Calendar cal = Calendar.getInstance();
                if (cal.getTime().getDay() != 0 && cal.getTime().getDay() != 6) { //sprawdzenie czy nie weekend
                    Transaction t = new Transaction();
                     t.receiveExternalTransaction(t.getSession());
                }
            }
        };

        Calendar date = Calendar.getInstance();
        date.set(Calendar.HOUR_OF_DAY, 11);
        date.set(Calendar.MINUTE, 55);

        timer.schedule(task, date.getTime(), TimeUnit.MILLISECONDS.convert(1, TimeUnit.DAYS)); // Sesja 1

        date.set(Calendar.HOUR_OF_DAY, 14);
        date.set(Calendar.MINUTE, 55);

        timer.schedule(task2, date.getTime(), TimeUnit.MILLISECONDS.convert(1, TimeUnit.DAYS)); // Sesja 2

        date.set(Calendar.HOUR_OF_DAY, 18);
        date.set(Calendar.MINUTE, 5);

        timer.schedule(task3, date.getTime(), TimeUnit.MILLISECONDS.convert(1, TimeUnit.DAYS)); // Sesja 3
  }
}