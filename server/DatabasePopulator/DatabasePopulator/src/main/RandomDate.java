package main;

import java.util.GregorianCalendar;

public class RandomDate{

	public String symbols;

	GregorianCalendar gc = new GregorianCalendar();

    public RandomDate(int startYear, int endYear) {

        int year = randBetween(startYear,endYear);

        gc.set(gc.YEAR, year);

        int dayOfMonth = randBetween(1, gc.getActualMaximum(gc.DAY_OF_MONTH));

        gc.set(gc.DAY_OF_MONTH, dayOfMonth);

        int monthOfYear = randBetween(1, gc.getActualMaximum(gc.MONTH));

        gc.set(gc.MONTH, monthOfYear);
        if (monthOfYear == 2 && dayOfMonth > 28) {
        	dayOfMonth = 28;
        	gc.set(gc.DAY_OF_MONTH, 28);
        }

        symbols = (gc.get(gc.YEAR) + "-" + gc.get(gc.MONTH) + "-" + gc.get(gc.DAY_OF_MONTH));
        symbols = "'"+symbols+"'";

    }

    public static int randBetween(int start, int end) {
        return start + (int)Math.round(Math.random() * (end - start));
    }

    // Move the date by arg-number of months. 
    public void moveMonths(int months){

    	int newMonth =  gc.get(gc.MONTH)+months;
    	gc.set(gc.YEAR, gc.get(gc.YEAR)+((newMonth)/12));
    	gc.set(gc.MONTH, ((newMonth)%12)+1);
/*
    	if(newMonth>48){
    		newMonth = newMonth - 48;
    		gc.set(gc.YEAR,gc.get(gc.YEAR)+4);
    	}
    	else if(newMonth>36){
    		newMonth = newMonth - 36;
    		gc.set(gc.YEAR,gc.get(gc.YEAR)+3);
    	}
    	else if(newMonth>24){
    		newMonth = newMonth - 24;
    		gc.set(gc.YEAR,gc.get(gc.YEAR)+2);
    	}
    	else if(newMonth>12){
    		newMonth = newMonth - 12;
    		gc.set(gc.YEAR,gc.get(gc.YEAR)+1);
    	}
*/
    	if(gc.get(gc.MONTH) < 1){
    		gc.set(gc.MONTH, 1);
    	}
    	
    	symbols = (gc.get(gc.YEAR) + "-" + gc.get(gc.MONTH) + "-" + gc.get(gc.DAY_OF_MONTH));
        symbols = "'"+symbols+"'";
    }
}
