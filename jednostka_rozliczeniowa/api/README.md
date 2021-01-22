# Jednostka rozliczeniowa

## Uruchomienie

```
cd jednostka-rozliczeniowa
npm install
npm run start
```

## Dokumentacja zapytań

[http://jr-api-express.herokuapp.com/docs/](http://jr-api-express.herokuapp.com/docs/)

## Obsługiwane banki wprowadzone w konfiguracji

1. PKO BP
    - Numer banku: `102`
    - Oddziały: 
        - `02964`, Grunwaldzka 1, 21-035 Rzeszów
        - `01417`, Al. Jerozolimskie 99, 00-012 Warszawa

2. ING Bank Śląski
    - Numer banku: `105`
    - Oddziały: 
        - `04475`, Grunwaldzka 1, 21-035 Rzeszów
        - `01417`, Al. Jerozolimskie 99, 00-012 Warszawa

## Przykłady

```
PKO BP: PL 40 1020 2964 5040 9093 8192 5554 4792
              ^^^
              numer banku: 102

PKO BP: PL 40 1020 2964 5040 9093 8192 5554 4792
                 ^^^^^^
                 numer oddziału: 02964
```

### Przykład zapytania do walidacji numeru

```http://localhost:3001/api/validatenumber?accountnumber=PL 85 1050 4475 6311 7698 7831 7488 1785```

Parametr accountnumber: wymagany jest numer IBAN tzn z PL na początku. Dopuszczalne są spacje ` ` i/lub pauzy `-`.

#### Parametr decyzyjny z zapytania

```json
{
    "isAccountNumberValid": true
    ...
}
```

`isAccountNumberValid` będzie `true` i status `200` tylko wtedy gdy wszystko się zgadza tzn:
- format numeru
- numer banku
- oddział banku
- suma kontrolna

w przeciwnym wypadku będzie `false` i status `400`

### Poprawne numery




## Jednostka weryfikująca

### Przyjęcie przelewu

1. Sprawdzenie, czy wszystkie wymagane parametry zostały zdefiniowane

    ```senderAccountnumber, recipientAccountnumber, paymentTitle, currency, paymentAmount```

2. Walidacja numerów IBAN nadawcy i odbiorcy. Algorytm walidacji.
    * Sprowadzenie numeru konta do jednolitej postaci (usunięcie spacji lub znaków `-`)
    * Sprawdzenie zgodności kraju `PL`
    * Sprawdzenie długości numeru konta `32`
    * Sprawdzenienie występowania niedozwolonych znaków
    * Obliczenie **sumy kontrolnej banku**
    * Odnalezienie czy dany bank istnieje w konfiguracji (po trzycyfrowym numerze banku)
    * Obliczenie **cyfry kontrolnej**
    * Obliczenie **sumy kontrolnej IBAN**
    * Zwrócenie informacji o poprawności
        * Przykłady poprawnych numerów:
            ```
            Proper number PKO BP Rzeszów: PL 40 1020 2964 5040 9093 8192 5554 4792
            Proper number PKO BP W-wa   : PL 63 1020 1417 3464 3146 7920 4129 4804

            Proper number ING BŚ Rzeszów: PL 85 1050 4475 6311 7698 7831 7488 1785
            Proper number ING BŚ W-wa   : PL 74 1050 2963 6283 9086 2470 9980 6719
            ```
3. Sprawdzenie poprawności waluty `PLN`
4. Sprawdzenie górnej granicy kwoty `1 000 000 PLN`
5. Sprawdzenie dolnej granicy kwoty `1 000 PLN` (zdefiniowana w konfiguracji, przypisana do sesji)
    * Zdefiniowanie statusu `accepted / revision`
    * ~ `revision` ~ Ręczna akceptacja przelewu
6. *jeśli walidacja dyspozycji poprawna* Utworzenie ramki do zapisania w bazie
7. *jeśli walidacja dyspozycji poprawna* Zapisanie do bazy
8. Zwrócenie informacji w zapytaniu

### Rozliczenie sesji

Zgodnie z harmonogramem zapisanym w konfiguracji
1. Zamknięcie przyjmowania przelewów dla danej sesji
2. Weryfikacja przelewów przez pracowników
3. Rozliczenie zaakceptowanych przelewów status: `settled`
4. Rozgłoszenie do odbiorców (dostępność poprzez zapytanie `getIncoming`)
5.  