export default class DateUtils {

    static formatDateTime(date: Date): string {
        return date.toLocaleString();
    }

    static addDays(date: Date, days: number): Date {
        date.setDate(date.getDate() + days);
        return date;
    }

}