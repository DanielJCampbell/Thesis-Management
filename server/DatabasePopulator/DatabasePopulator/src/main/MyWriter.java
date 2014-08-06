package main;

import java.io.PrintWriter;

public class MyWriter {

	public MyWriter(PrintWriter writer) {
		for(int i = 0 ; i <= 50; i++){
		String fname = new RandomString().symbols;
		String lname = new RandomString().symbols;
		boolean halftime = new RandomBoolean().symbols;
		int studentid = 300000000 + i;
		
		RandomPercent rp = new RandomPercent();
		
		int supid1 = 80000000 + i;
		String supPercent1 = rp.max;
		int supid2 = 80000000 + i+ 300;
		String supPercent2 = rp.min;
		String scholar = new RandomString().symbols;
		String notes = new RandomString().symbols;
		String origin = new RandomLetter().symbols;
		
		//Masters
		String startDate = new RandomDate(2014,2014).symbols;
		String course = new RandomString().symbols;
		String spec = new RandomString().symbols;
		String propDeadDate = new RandomDate(2014,2014).symbols;
		String propSubDate = new RandomDate(2014,2014).symbols;
		String propConfDate = new RandomDate(2014,2014).symbols;
		String prop3mthDeadDate = new RandomDate(2014,2014).symbols;
		String prop3mthSubDate = new RandomDate(2014,2014).symbols;
		String prop3mthApprDate = new RandomDate(2014,2014).symbols;
		String prop8mthDeadDate = new RandomDate(2014,2014).symbols;
		String prop8mthSubDate = new RandomDate(2014,2014).symbols;
		String prop8mthApprDate = new RandomDate(2014,2014).symbols;
		String thesisDead = new RandomDate(2014,2014).symbols;
		String thesisSub = new RandomDate(2014,2014).symbols;
		String examinersAppointed = new RandomDate(2014,2014).symbols;
		String examinationComplete = new RandomDate(2014,2014).symbols;
		String revisions = new RandomDate(2014,2014).symbols;
		String deposited = new RandomDate(2014,2014).symbols;
		
		//PhD
		String degree = new RandomString().symbols;
		String propSeminar = new RandomDate(2014,2014).symbols;
		String fgr = new RandomDate(2014,2014).symbols;
		String workHours = Integer.toString(135+i);
		
		//Supervisor
		String supfname = new RandomString().symbols;
		String suplname = new RandomString().symbols;
		String supfname2 = new RandomString().symbols;
		String suplname2 = new RandomString().symbols;
		System.out.println(fgr);
		
		// 6mth report
		String report6mthlyDue = "'2014-5-29'";
		String report6mthlySub = new RandomDate(2014,2014).symbols;
		String report6mthlyAppr = new RandomDate(2014,2014).symbols;
		
		writer.println("INSERT INTO Students Values ("+fname+","+ lname +","+ halftime+ ","+ studentid +","+supid1+","+supPercent1 + ","+supid2+","+supPercent2+","+scholar+","+notes+","+ origin+ ");");
		writer.println("INSERT INTO Supervisors Values ("+ supfname+","+suplname+","+ supid1+");");
		writer.println("INSERT INTO Supervisors Values ("+ supfname2+","+suplname2+","+ supid2+");");
		
		if(i> 25 && i< 30){
		writer.println("INSERT INTO SixMonthlyReports Values ("+studentid+","+ report6mthlyDue+","+"NULL, NULL"+");");
		}
		else{
			if(i>25 &&i< 40){
			writer.println("INSERT INTO SixMonthlyReports Values ("+studentid+","+ report6mthlyDue+","+report6mthlySub+","+report6mthlyAppr +");");
			}
			else if(i> 25){
				writer.println("INSERT INTO SixMonthlyReports Values ("+studentid+","+ report6mthlyDue+","+report6mthlySub+",NULL);");
			}
		}
		
		// Suspensions
		if(i < 2){
			String susID = new RandomString().symbols;
			String susStart = new RandomDate(2014,2014).symbols;
			String susEnd = new RandomDate(2014,2014).symbols;
			writer.println("INSERT INTO Suspensions Values ("+ susID +"," + studentid + ","+ susStart + "," + susEnd+");");
		}
		
		if(i<25){
			writer.println("INSERT INTO MastersStudents Values ("+ studentid +","+startDate+","+course+","+spec+","+propDeadDate+","+propSubDate+","+propConfDate+","+prop3mthDeadDate+","+ prop3mthSubDate+","+prop3mthApprDate+","+ prop8mthDeadDate+","+ prop8mthSubDate+","+prop8mthApprDate+","+ thesisDead+","+thesisSub +","+ examinersAppointed+ "," +examinationComplete+"," + revisions+"," +deposited+");");
		}
		else{
			if(i<40){
			writer.println("INSERT INTO PhDStudents Values ("+ studentid +","+degree+","+startDate+","+propDeadDate+","+propSubDate+","+propSeminar+","+propConfDate+","+fgr+","+ thesisDead+","+thesisSub +","+ examinersAppointed+ "," +examinationComplete+"," + revisions+"," +deposited+","+workHours+");");
			}
			else{
				writer.println("INSERT INTO PhDStudents Values ("+ studentid +","+degree+","+startDate+","+propDeadDate+","+propSubDate+","+propSeminar+","+propConfDate+","+fgr+","+ thesisDead+","+thesisSub +","+ examinersAppointed+ "," +examinationComplete+"," + revisions+"," +deposited+","+"NULL"+");");
				}
		}
		}
		
		
	}
}
