package main;

import java.util.GregorianCalendar;

public class RandomDate{

	public String symbols;

	GregorianCalendar gc = new GregorianCalendar();

    public RandomDate(int startYear, int endYear) {

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

    // Move the date by arg-number of months. DO NOT put in more than 11!!!!!!!!
    public void moveMonths(int months){

    	int newMonth =  gc.get(gc.MONTH)+months;

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

    	symbols = (gc.get(gc.YEAR) + "-" + newMonth + "-" + gc.get(gc.DAY_OF_MONTH));
        symbols = "'"+symbols+"'";
    }
 // Move the date by arg-number of months. DO NOT put in more than 11!!!!!!!!
    public void moveYear(int years){

    	int newYear =  gc.get(gc.YEAR)+years;

    	if(newYear>12){
    		newYear = newYear - 12;
    		gc.set(gc.YEAR,gc.get(gc.YEAR)+1);
    	}

    	symbols = newYear + "-" + (gc.get(gc.YEAR) + "-" + gc.get(gc.DAY_OF_MONTH));
        symbols = "'"+symbols+"'";
    }
}
