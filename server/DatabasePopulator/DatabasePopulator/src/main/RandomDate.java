package main;

import java.util.GregorianCalendar;

public class RandomDate{
	
	public String symbols;
	
    public RandomDate(int startYear, int endYear) {

        GregorianCalendar gc = new GregorianCalendar();

        int year = randBetween(startYear,endYear);

        gc.set(gc.YEAR, year);

        int dayOfYear = randBetween(1, gc.getActualMaximum(gc.DAY_OF_YEAR));

        gc.set(gc.DAY_OF_YEAR, dayOfYear);
        
        int monthOfYear = randBetween(1, gc.getActualMaximum(gc.MONTH));

        gc.set(gc.MONTH, monthOfYear);

        symbols = (gc.get(gc.YEAR) + "-" + gc.get(gc.MONTH) + "-" + gc.get(gc.DAY_OF_MONTH));
        symbols = "'"+symbols+"'";

    }

    public static int randBetween(int start, int end) {
        return start + (int)Math.round(Math.random() * (end - start));
    }
}
