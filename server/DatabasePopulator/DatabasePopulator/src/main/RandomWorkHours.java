package main;

public class RandomWorkHours {

	 public String first;
	 public String second;
	 public String third;

	  public RandomWorkHours(){

		  int value = randBetween(0,450);
		  int value2 = randBetween(0,450-value);
		  int value3 = 450 - (value+value2);
		  first = Integer.toString(value);
		  second = Integer.toString(value2);
		  third = Integer.toString(value3);
	  }

	  public static int randBetween(int start, int end) {
	        return start + (int)Math.round(Math.random() * (end - start));
	    }

}
