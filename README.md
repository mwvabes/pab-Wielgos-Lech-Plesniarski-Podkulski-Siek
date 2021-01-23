# pab-Wielgos-Lech-Plesniarski-Podkulski-Siek

## Projekt

Uczelniany projekt zaliczeniowy z przedmiotu **Projektowanie aplikacji biznesowych (PAB)**. 
Rok akademicki 2020/2021, Uniwersytet Rzeszowski

## Członkowie zespołu

* Marcin Wielgos `hello.wielgos@gmail.com` **- osoba do kontaktu**
* Karol Lech
* Przemysław Pleśniarski
* Krzysztof Podkulski
* Janusz Siek

***

# Jednostka rozliczeniowa

## Uruchomienie

```
cd jednostka-rozliczeniowa
npm install
npm run start
```

## Obsługiwane banki

1. PKO BP
    - Numer banku: `102`
    - Oddziały: 
        - `02964`, Grunwaldzka 1, 21-035 Rzeszów
        - `01417`, Al. Jerozolimskie 99, 00-012 Warszawa

2. ING Bank Śląski
    - Numer banku: `105`
    - Oddziały: 
        - `04475`, Grunwaldzka 1, 21-035 Rzeszów
        - `01416`, Al. Jerozolimskie 99, 00-012 Warszawa

## Przykłady

```
PKO BP: PL 52 1020 2964 0589 2425 9345 9630
              ^^^
              numer banku: 102

PKO BP: PL 52 1020 2964 0589 2425 9345 9630
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

```
Proper number PKO BP Rzeszów: PL 52 1020 2964 0589 2425 9345 9630
Proper number PKO BP W-wa   : PL 34 1020 1417 3109 9087 2047 4799

Proper number ING BŚ Rzeszów: PL 27 1050 4475 9393 0635 9401 7658
Proper number ING BŚ Rzeszów: PL 87 1050 4475 4135 2700 6690 2937
Proper number ING BŚ W-wa   : PL 35 1050 1416 4430 8094 1693 8388
Proper number ING BŚ W-wa   : PL 69 1050 1416 3479 2267 8029 0421
```

