package main;

import java.util.Random;

public class RandomLetter {
	
	 public String symbols;

	  public RandomLetter(){
		  final String alphabet = "ID";
		    final int N = alphabet.length();

		    Random r = new Random();

		    for (int i = 0; i < 50; i++) {
		        symbols =  Character.toString(alphabet.charAt(r.nextInt(N)));
		       }
		    symbols = "'"+symbols+"'";
	  } 

}
