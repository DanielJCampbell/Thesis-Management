package main;

public class RandomWorkHours {

	 public String first;
	 public String second;
	 public String third;

	  public RandomWorkHours(){
		  
		  int value = 0;
		  int value2 = 0;
		  int value3 = 0;

		  boolean rand = new RandomBoolean().symbols;
		  if(rand){
		  value = 150;
		  rand = new RandomBoolean().symbols;
			  if(rand){
			  value2 = 150;
				  if(rand){
					  value3 = 150;
					  }
			  }
		  }
		  
		  first = Integer.toString(value);
		  second = Integer.toString(value2);
		  third = Integer.toString(value3);
	  }

	  public static int randBetween(int start, int end) {
	        return start + (int)Math.round(Math.random() * (end - start));
	    }

}
