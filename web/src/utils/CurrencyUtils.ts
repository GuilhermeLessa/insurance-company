const CurrencyLanguage = {
    "EUR": "eu",
    "GBP": "en-GB",
    "USD": "en-US"
};

export default class CurrencyUtils {

    static format(
        currency: "EUR"|"GBP"|"USD", 
        amount: number
    ): string {
        const formatter = new Intl.NumberFormat(
            CurrencyLanguage[currency], 
            {
                style: 'currency',
                currency
            }
        );
        return formatter.format(amount); 
    }

}