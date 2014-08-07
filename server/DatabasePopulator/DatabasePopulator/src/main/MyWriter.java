package main;

import java.io.PrintWriter;

public class MyWriter {

	public MyWriter(PrintWriter writer) {
		for(int i = 0 ; i <= 50; i++){
		RandomName name = new RandomName();
		String fname = name.first;
		String lname = name.last;
		String course = new RandomString().symbols;
		String spec = new RandomString().symbols;
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
		RandomDate prop = new RandomDate(2014,2014);

		String startDate = prop.symbols;
		RandomDate thesisM = prop;
		RandomDate thesisP = prop;
		thesisM.moveMonths(12);
		thesisP.moveMonths(RandomDate.randBetween(36,48));


		String propSubDate = prop.symbols;
		prop.moveMonths(RandomDate.randBetween(1,3));
		String propDeadDate = prop.symbols;
		prop.moveMonths(RandomDate.randBetween(1,3));
		String propConfDate = prop.symbols;

		prop.moveMonths(3);
		String prop3mthSubDate = prop.symbols;
		prop.moveMonths(RandomDate.randBetween(1,3));
		String prop3mthDeadDate = prop.symbols;
		prop.moveMonths(RandomDate.randBetween(1,3));
		String prop3mthApprDate = prop.symbols;

		prop.moveMonths(5);
		String prop8mthDeadDate = prop.symbols;
		prop.moveMonths(RandomDate.randBetween(1,3));
		String prop8mthSubDate = prop.symbols;
		prop.moveMonths(RandomDate.randBetween(1,3));
		String prop8mthApprDate = prop.symbols;

				// thesisM due 1 year from start (masters)
				String thesisSub = thesisM.symbols;
				thesisM.moveMonths(RandomDate.randBetween(1,3));
				String thesisDead = thesisM.symbols;
				thesisM.moveMonths(RandomDate.randBetween(1,3));
				String examinersAppointed = thesisM.symbols;
				thesisM.moveMonths(RandomDate.randBetween(1,3));
				String examinationComplete = thesisM.symbols;
				thesisM.moveMonths(RandomDate.randBetween(1,3));
				String revisions = thesisM.symbols;
				thesisM.moveMonths(RandomDate.randBetween(1,3));
				String deposited = thesisM.symbols;

				// thesisP due 3 years from start (PhD)
				String thesisPSub = thesisP.symbols;
				thesisP.moveMonths(RandomDate.randBetween(1,3));
				String thesisPDead = thesisP.symbols;
				thesisP.moveMonths(RandomDate.randBetween(1,3));
				String examinersPAppointed = thesisP.symbols;
				thesisP.moveMonths(RandomDate.randBetween(1,3));
				String examinationPComplete = thesisP.symbols;
				thesisP.moveMonths(RandomDate.randBetween(1,3));
				String revisionsP = thesisP.symbols;
				thesisP.moveMonths(RandomDate.randBetween(1,3));
				String depositedP = thesisP.symbols;

		//PhD
		String propSeminar = new RandomDate(2014,2014).symbols;
		String fgr = new RandomDate(2014,2014).symbols;
		RandomWorkHours rwh = new RandomWorkHours();
		String workHours1 = rwh.first;
		String workHours2 = rwh.second;
		String workHours3 = rwh.third;

		//Supervisor
		RandomName supervisor1 = new RandomName();
		RandomName supervisor2 = new RandomName();
		String supfname = supervisor1.first;
		String suplname = supervisor1.last;
		String supfname2 = supervisor2.first;
		String suplname2 = supervisor2.last;
		System.out.println(fgr);


		writer.println("INSERT INTO Supervisors Values ("+ supfname+","+suplname+","+ supid1+");");
		writer.println("INSERT INTO Supervisors Values ("+ supfname2+","+suplname2+","+ supid2+");");

		writer.println("INSERT INTO Students Values ("+fname+","+ lname +","+ course +","+spec+","+halftime+ ","+ studentid +","+supid1+","+supPercent1 + ","+supid2+","+supPercent2+","+scholar+","+notes+","+ origin+ ");");

		if(i<25){
			writer.println("INSERT INTO MastersStudents Values ("+ studentid +","+startDate+","+propDeadDate+","+propSubDate+","+propConfDate+","+prop3mthDeadDate+","+ prop3mthSubDate+","+prop3mthApprDate+","+ prop8mthDeadDate+","+ prop8mthSubDate+","+prop8mthApprDate+","+ thesisDead+","+thesisSub +","+ examinersAppointed+ "," +examinationComplete+"," + revisions+"," +deposited+");");
		}
		else{
			if(i<40){
			writer.println("INSERT INTO PhDStudents Values ("+ studentid +","+startDate+","+propDeadDate+","+propSubDate+","+propSeminar+","+propConfDate+","+ thesisPDead+","+thesisPSub +","+ examinersPAppointed+ "," +examinationPComplete+"," + revisionsP+"," +depositedP+","+workHours1+","+workHours2+","+workHours3+");");
			}
			if(i<40){
				writer.println("INSERT INTO PhDStudents Values ("+ studentid +","+startDate+","+propDeadDate+","+propSubDate+","+propSeminar+","+propConfDate+","+ thesisPDead+","+thesisPSub +","+ examinersPAppointed+ "," +examinationPComplete+"," + revisionsP+"," +depositedP+","+workHours1+","+workHours2+","+workHours3+");");
			}
			else{
				if(i<45){
				writer.println("INSERT INTO PhDStudents Values ("+ studentid +","+startDate+","+propDeadDate+","+propSubDate+","+propSeminar+","+propConfDate+","+ thesisPDead+","+thesisPSub +","+ examinersPAppointed+ "," +examinationPComplete+"," + revisionsP+"," +depositedP+","+workHours1+","+workHours2+","+"NULL"+");");
				}
				else{
				writer.println("INSERT INTO PhDStudents Values ("+ studentid +","+startDate+","+propDeadDate+","+propSubDate+","+propSeminar+","+propConfDate+","+ thesisPDead+","+thesisPSub +","+ examinersPAppointed+ "," +examinationPComplete+"," + revisionsP+"," +depositedP+","+"NULL,NULL,NULL"+");");
				}
			}
		}
		// Suspensions
			if(i < 2){
					String susID = new RandomString().symbols;
					String susStart = new RandomDate(2014,2014).symbols;
					String susEnd = new RandomDate(2014,2014).symbols;
					writer.println("INSERT INTO Suspensions Values ("+ susID +"," + studentid + ","+ susStart + "," + susEnd+");");
			}
		}
	}
}
