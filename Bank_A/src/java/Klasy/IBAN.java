
package Klasy;

public class IBAN {
    private String IBAN;
    
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
        
        int pom = 98 - (Integer.valueOf(IBAN) % 97);
        
        if(pom <10){
            IBAN = "0" + pom;
        }
        else {
            IBAN = Integer.toString(pom);
        }
        
        return IBAN;
    }
    
    public Boolean isValid(String IBAN){
        IBAN = IBAN.replaceAll("[^a-zA-Z0-9]", "");    //usuwanie niealfanumerycznych znaków
        
        IBAN = IBAN.substring(4) + IBAN.charAt(0) + IBAN.charAt(1) + IBAN.charAt(2) + IBAN.charAt(3);   //przesunięcie 4 pierwszych znaków na koniec
        
        for(int i = 24; i<=26; i+=2){   //zamiana liter na ducyfrowe liczby
            for(int j = 65; j<=90; j++){
                if(IBAN.charAt(i) == j){
                    IBAN = IBAN.substring(0, i) + (j - 55) + IBAN.substring(i+1);
                }
            }
                
        }
        
        if(Integer.valueOf(IBAN) % 97 == 1){
            return true;
        }
        else{
            return false;
        }
    }
}
