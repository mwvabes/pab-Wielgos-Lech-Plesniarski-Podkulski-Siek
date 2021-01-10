
package Klasy;

import java.math.BigInteger;

public class AccountNumber {
    
    public String GenerateAccountNumber(String department, String N) {
        String IBAN = "PL00 102" + department + N;
        return ControlSum(IBAN) + "102" + department + N;
    }
    
    public String ControlSum(String IBAN){
        IBAN = IBAN.replaceAll("[^a-zA-Z0-9]", "");    //usuwanie niealfanumerycznych znaków
        
        IBAN = IBAN.substring(4) + IBAN.charAt(0) + IBAN.charAt(1) + IBAN.charAt(2) + IBAN.charAt(3);   //przesunięcie 4 pierwszych znaków na koniec
        
        for(int i = 24; i<=26; i+=2){   //zamiana liter na ducyfrowe liczby
            for(int j = 65; j<=90; j++){
                if(IBAN.charAt(i) == j){
                    IBAN = IBAN.substring(0, i) + (j - 55) + IBAN.substring(i+1);
                }
            }
                
        }
        BigInteger a = new BigInteger("98");
        BigInteger b = new BigInteger(IBAN);
        BigInteger c = new BigInteger("97");
        BigInteger d;
        d = a.subtract(b.mod(c));
       // int pom = 98 - (Integer.valueOf(IBAN) % 97);
       int pom = Integer.valueOf(d.toString());
       
        if(pom <10){
            IBAN = "0" + pom;
        }
        else {
            IBAN = Integer.toString(pom);
        }
        
        return IBAN;
    }
    
    public Boolean isValid(String IBAN){
        if(IBAN.length() != 26){    //sprawdzenie długości
            return false;
        }
        
        IBAN = IBAN.replaceAll("[^a-zA-Z0-9]", "");    //usuwanie niealfanumerycznych znaków
        
        IBAN = IBAN.substring(4) + IBAN.charAt(0) + IBAN.charAt(1) + IBAN.charAt(2) + IBAN.charAt(3);   //przesunięcie 4 pierwszych znaków na koniec
        
        for(int i = 24; i<=26; i+=2){   //zamiana liter na ducyfrowe liczby
            for(int j = 65; j<=90; j++){
                if(IBAN.charAt(i) == j){
                    IBAN = IBAN.substring(0, i) + (j - 55) + IBAN.substring(i+1);
                }
            }
                
        }
        
        if(new BigInteger(IBAN).mod(new BigInteger("97")).compareTo(BigInteger.ONE) == 0){
            return true;
        }
        else{
            return false;
        }
    }
}
