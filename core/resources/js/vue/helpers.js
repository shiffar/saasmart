export function getCurrencySymbolWithAmount(amount){
    const currency = window.currencySymbol;

    if(currency.currencyPosition ?? 'left' === 'left'){
        return currency.symbol + amount;
    }

    return amount + currency.symbol;
}
