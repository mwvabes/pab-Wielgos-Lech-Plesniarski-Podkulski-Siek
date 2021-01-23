const fs = require('fs')
const banks = JSON.parse(fs.readFileSync('./conf/banks_conf.json'))

exports.validateNumber = (accountnumber) => {

  accountnumber = accountnumber.replace(/[\s-]/g, '')

  if (accountnumber.substr(0, 2) != "PL") {
    return ({
      isAccountNumberValid: false,
      comment: "Nieobsługiwany kraj bądź niepoprawny format numeru rachunku. Poprawny przykład: PL 00 1111 2222 3333 4444 5555 6666.",
      status: 400
    })
  }
  
  if (accountnumber.length != 28) {
    return ({
      isAccountNumberValid: false,
      comment: "Zły format numeru rachunku. Poprawny przykład: PL 00 1111 2222 3333 4444 5555 6666.",
      status: 400
    })
  }

  if (isNaN(accountnumber.substr(2, 28))) {
    return ({
      isAccountNumberValid: false,
      comment: "Część zasadnicza numeru rachunku zawiera niepoprawne znaki. Poprawny przykład: PL 00 1111 2222 3333 4444 5555 6666.",
      status: 400
    })
  }
  
    const bankNumber = accountnumber.substring(4, 12)
    const bankNumberWeights = [3, 9, 7, 1, 3, 9, 7]

    const bankControlSum = bankNumberWeights.reduce(function (previousValue, currentValue, index, array) {
      return previousValue + (currentValue * bankNumber[index]);
    }, 0);

    const bank = banks.find(b => b.bankID === accountnumber.substr(4, 3))

    if (!bank) {
      return ({
        isAccountNumberValid: false,
        comment: "Brak banku o podanym ID.",
        status: 400
      })
    }

    const bankControlDigit = bankControlSum % 10 === 0 ? 0 : 10 - (bankControlSum % 10)

    if (bankControlDigit != bankNumber[7]) {
      return ({
        isAccountNumberValid: false,
        comment: "Niepoprawna cyfra kontrolna banku.",
        bankControlDigit,
        status: 400
      })
    }

    const bankWithUnit = bank.bankUnits.find(u => u.unitID === accountnumber.substr(7, 5))

    if (!bankWithUnit) {
      return ({
        isAccountNumberValid: false,
        comment: "Brak poprawnego oddziału banku.",
        "bankID": bank.bankID,
        "bankName": bank.bankName,
        "oddzial": accountnumber.substr(7, 5),
        status: 400
      })
    }

    const dict = {
      "P": "25",
      "L": "21"
    }

    let iban = (accountnumber.substr(4, 28) + accountnumber.substr(0, 4)).split("")
    console.log("NEW", iban)
    iban[24] = dict[iban[24]]
    iban[25] = dict[iban[25]]
    iban = iban.join("")
    iban = BigInt(iban)

    ibanControlSum = iban % BigInt(97)

    if (ibanControlSum != BigInt(1)) {
      return ({
        isAccountNumberValid: false,
        comment: "Niezgodna suma kontrolna numeru IBAN.",
        iban: String(iban),
        ibanControlSum: String(ibanControlSum),
        status: 400
      })
    }


    return({
      isAccountNumberValid: true,
      comment: "Walidacja pomyślna. Numer jest poprawny.",
      accountnumber,
      bankNumber,
      bankControlSum,
      bankControlDigit,
      bankWithUnit,
      ibanControlSum: String(ibanControlSum),
      status: 200
    })
}