package main;

import java.util.Random;

public class RandomPercent {
	
	 public String max;
	 public String min;

	  public RandomPercent(){
		  
		  int value = randBetween(51,99);
		  int value2 = 100 - value;
		  max = Integer.toString(value);
		  min = Integer.toString(value2);
	  } 
	  
	  public static int randBetween(int start, int end) {
	        return start + (int)Math.round(Math.random() * (end - start));
	    }


}
