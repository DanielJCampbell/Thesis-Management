package main;

import java.util.Random;

public class RandomString {

	  public String symbols;

	  public RandomString(){
		  char[] chars = "abcdefghijklmnopqrstuvwxyz".toCharArray();
		  StringBuilder sb = new StringBuilder();
		  Random random = new Random();
		  for (int i = 0; i < 20; i++) {
		      char c = chars[random.nextInt(chars.length)];
		      sb.append(c);
		  }
		  String output = sb.toString();
		  symbols = output;
	  }   
}