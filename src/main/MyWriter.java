package main;

import java.io.PrintWriter;

public class MyWriter {

	public MyWriter(PrintWriter writer) {
		for(int i = 0 ; i <= 50; i++){
		String fname = new RandomString().symbols;
		String lname = new RandomString().symbols;
		boolean halftime = new RandomBoolean().symbols;
		int studentid = 300000000 + i;
		String degree = new RandomString().symbols;
		int supid1 = 80000000 + i;
		int supid2 = 80000000 + i+ 300;
		String scholar = new RandomString().symbols;
		String notes = new RandomString().symbols;
		String origin = new RandomLetter().symbols;
		
		
		System.out.println(halftime);
		
		writer.println("INSERT INTO Students Values ("+fname+","+ lname +","+ halftime+ ","+ studentid +","+degree+","+supid1+","+supid2+","+scholar+","+notes+","+ origin+ ");");
		}
	}
}
