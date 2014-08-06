package main;

import java.io.PrintWriter;

public class MyWriter {

	public MyWriter(PrintWriter writer) {
		for(int i = 0 ; i <= 50; i++){
		String fname = new RandomString().symbols;
		String lname = new RandomString().symbols;
		boolean halftime = new RandomBoolean().symbols;
		int studentid = 300000000 + i;
		System.out.println(halftime);
		
		writer.println("INSERT INTO Students Values ("+fname+","+ lname +","+ halftime+ ","+ studentid + ");");
		}
	}
}
