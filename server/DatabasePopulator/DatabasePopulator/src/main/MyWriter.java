package main;

import java.io.PrintWriter;

public class MyWriter {

	public MyWriter(PrintWriter writer) {
		for(int i = 0 ; i <= 70; i++){
			int suspendLocation = 0;
			
			//Masters
		if(i<25){
		suspendLocation = RandomDate.randBetween(1, 4);
		}
			//PhD
		else{
		suspendLocation = RandomDate.randBetween(0, 3);	
		}
				
		String susStart="";
		String susEnd ="";
			
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
		
		// Suspend Location 1 - Before Proposition Masters
		if(suspendLocation == 1 ){
		susStart = prop.symbols;
		prop.moveMonths(RandomDate.randBetween(1, 3));
		susEnd = prop.symbols;
		}

		String propSubDate = prop.symbols;
		prop.moveMonths(RandomDate.randBetween(1,3));
		String propDeadDate = prop.symbols;
		prop.moveMonths(RandomDate.randBetween(1,3));
		String propConfDate = prop.symbols;
		
		// Suspend Location 2 - Before 3mth report Masters
		if(suspendLocation == 2){
		susStart = prop.symbols;
		prop.moveMonths(RandomDate.randBetween(1, 3));
		susEnd = prop.symbols;
		}
		
		prop.moveMonths(3);
		String prop3mthSubDate = prop.symbols;
		prop.moveMonths(RandomDate.randBetween(1,3));
		String prop3mthDeadDate = prop.symbols;
		prop.moveMonths(RandomDate.randBetween(1,3));
		String prop3mthApprDate = prop.symbols;

		// Suspend Location 3 - Before 8mth report Masters
		if(suspendLocation == 3){
		susStart = prop.symbols;
		prop.moveMonths(RandomDate.randBetween(1, 3));
		susEnd = prop.symbols;
		}
		
		prop.moveMonths(5);
		String prop8mthDeadDate = prop.symbols;
		prop.moveMonths(RandomDate.randBetween(1,3));
		String prop8mthSubDate = prop.symbols;
		prop.moveMonths(RandomDate.randBetween(1,3));
		String prop8mthApprDate = prop.symbols;
		
		// Suspend Location 4 - Before thesis Masters
				if(suspendLocation == 4 && i<25){
				susStart = thesisM.symbols;
				prop.moveMonths(RandomDate.randBetween(1, 3));
				susEnd = thesisM.symbols;
				}

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
				
				// Suspend Location 0 - Before thesis PhD
				if(suspendLocation == 0){
				susStart = thesisP.symbols;
				prop.moveMonths(RandomDate.randBetween(1, 3));
				susEnd = thesisP.symbols;
				}

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
		prop.moveMonths(RandomDate.randBetween(1,3));
		String propSeminar = prop.symbols;
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


		writer.println("INSERT INTO Supervisors Values ("+ supfname+","+suplname+","+ supid1+");");
		writer.println("INSERT INTO Supervisors Values ("+ supfname2+","+suplname2+","+ supid2+");");

		writer.println("INSERT INTO Students Values ("+fname+","+ lname +","+ course +","+spec+","+halftime+ ","+ studentid +","+supid1+","+supPercent1 + ","+supid2+","+supPercent2+","+scholar+","+notes+","+ origin+ ");");

		if(i<25){
			writer.println("INSERT INTO MastersStudents Values ("+ studentid +","+startDate+","+propDeadDate+","+propSubDate+","+propConfDate+","+prop3mthDeadDate+","+ prop3mthSubDate+","+prop3mthApprDate+","+ prop8mthDeadDate+","+ prop8mthSubDate+","+prop8mthApprDate+","+ thesisDead+","+thesisSub +","+ examinersAppointed+ "," +examinationComplete+"," + revisions+"," +deposited+");");
			suspend(writer,studentid,susStart,susEnd);
		}
		else{
			if(i<40){
			writer.println("INSERT INTO PhDStudents Values ("+ studentid +","+startDate+","+propDeadDate+","+propSubDate+","+propSeminar+","+propConfDate+","+ thesisPDead+","+thesisPSub +","+ examinersPAppointed+ "," +examinationPComplete+"," + revisionsP+"," +depositedP+","+workHours1+","+workHours2+","+workHours3+");");
			}
			else{
				if(i<45){
				writer.println("INSERT INTO PhDStudents Values ("+ studentid +","+startDate+","+propDeadDate+","+propSubDate+","+propSeminar+","+propConfDate+","+ thesisPDead+","+thesisPSub +","+ examinersPAppointed+ "," +examinationPComplete+"," + revisionsP+"," +depositedP+","+workHours1+","+workHours2+","+"NULL"+");");
				}
				else if(i<50){
				writer.println("INSERT INTO PhDStudents (StudentId,StartDate,ProposalDeadline) Values ("+ studentid +","+startDate+","+propDeadDate+");");
				suspend(writer,studentid,susStart,susEnd);
				}
				else if(i<60){
					writer.println("INSERT INTO PhDStudents (StudentId,StartDate,ProposalDeadline,ProposalSubmission) Values ("+ studentid +","+startDate+","+propDeadDate+","+propSubDate+");");
					suspend(writer,studentid,susStart,susEnd);
					}
				else if(i<62){
					writer.println("INSERT INTO PhDStudents (StudentId,StartDate,ProposalDeadline,ProposalSubmission,ProposalSeminar) Values ("+ studentid +","+startDate+","+propDeadDate+","+propSubDate+","+propSeminar+");");
					suspend(writer,studentid,susStart,susEnd);
					}
				else if(i<64){
					writer.println("INSERT INTO PhDStudents (StudentId,StartDate,ProposalDeadline,ProposalSubmission,ProposalSeminar,ProposalConfirmation,ThesisDeadline,ThesisSubmission) Values ("+ studentid +","+startDate+","+propDeadDate+","+propSubDate+","+propSeminar+","+propConfDate+","+ thesisPDead+","+thesisPSub +");");
					suspend(writer,studentid,susStart,susEnd);
					}
				else if(i<66){
					writer.println("INSERT INTO PhDStudents (StudentId,StartDate,ProposalDeadline,ProposalSubmission,ProposalSeminar,ProposalConfirmation,ThesisDeadline,ThesisSubmission,ExaminersAppointedDate) Values ("+ studentid +","+startDate+","+propDeadDate+","+propSubDate+","+propSeminar+","+propConfDate+","+ thesisPDead+","+thesisPSub + ","+ examinersPAppointed+");");
					suspend(writer,studentid,susStart,susEnd);
					}
				else if(i<68){
					writer.println("INSERT INTO PhDStudents (StudentId,StartDate,ProposalDeadline,ProposalSubmission,ProposalSeminar,ProposalConfirmation,ThesisDeadline,ThesisSubmission,ExaminersAppointedDate,ExaminationCompleted) Values ("+ studentid +","+startDate+","+propDeadDate+","+propSubDate+","+propSeminar+","+propConfDate+","+ thesisPDead+","+thesisPSub + ","+ examinersPAppointed+ "," +examinationPComplete+");");
					suspend(writer,studentid,susStart,susEnd);
					}
				else if(i<=70){
					writer.println("INSERT INTO PhDStudents (StudentId,StartDate,ProposalDeadline,ProposalSubmission,ProposalSeminar,ProposalConfirmation,ThesisDeadline,ThesisSubmission,ExaminersAppointedDate,ExaminationCompleted,RevisionsFinalised) Values ("+ studentid +","+startDate+","+propDeadDate+","+propSubDate+","+propSeminar+","+propConfDate+","+ thesisPDead+","+thesisPSub + ","+ examinersPAppointed+ "," +examinationPComplete+"," + revisionsP+");");
					suspend(writer,studentid,susStart,susEnd);
					}
			}
		}
		}
	}
	public void suspend(PrintWriter writer, int studentid, String susStart, String susEnd){
		writer.println("INSERT INTO Suspensions Values ("+ "NULL" +"," + studentid + ","+ susStart + "," + susEnd+");");
	}
}
