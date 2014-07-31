package main;

import java.util.Random;

public class RandomBoolean {
	 public boolean symbols;

	  public RandomBoolean(){
		  Random random = new Random();
		  
		  symbols = random.nextBoolean();
	  }   
}
