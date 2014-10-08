package main;

import java.io.PrintWriter;

public class MyWriter {
	
	RandomSupervisor rs = new RandomSupervisor(0);
	RandomSupervisor rs2 = new RandomSupervisor(300);

	public MyWriter(PrintWriter writer) {
		for(int i = 0 ; i <= 70; i++){
			// Randomized location for Suspension
			int suspendLocation = 0;
			// Randomized location for Enrollment Type Change
			int etcLocation = 0;
						
		//Masters
		if(i<25){
		suspendLocation = randBetween(1, 4);
		etcLocation =  randBetween(1, 4);
		}
			//PhD
		else{
		suspendLocation = randBetween(0, 3);
		etcLocation =  randBetween(0, 3);		
		}
				
		String susStart="";
		String susEnd ="";
			
		RandomName name = new RandomName();
		String fname = name.first;
		String lname = name.last;
		String course = new RandomString().symbols;
		String spec = new RandomString().symbols;
		int studentid = 300000000 + i;

		String scholar = new RandomString().symbols;
		String notes = new RandomString().symbols;
		String origin = new RandomLetter().symbols;

		RandomDate prop = new RandomDate(1990,2014);
		String startDate = prop.symbols;
		
		RandomDate thesisM = prop;
		RandomDate thesisP = prop;
		thesisM.moveMonths(12);
		thesisP.moveMonths(randBetween(36,48));
		
		if(i % 4 == 1){
			rs = new RandomSupervisor(i);
			writer.println("INSERT INTO Supervisors Values ("+ rs.supfname+","+rs.suplname+","+ rs.supid1+");");
			writer.println("INSERT INTO Supervisors Values ("+ rs.supfname2+","+rs.suplname2+","+ rs.supid2+");");

		}
		else if (i == 0){
			writer.println("INSERT INTO Supervisors Values ("+ rs.supfname+","+rs.suplname+","+ rs.supid1+");");
			writer.println("INSERT INTO Supervisors Values ("+ rs.supfname2+","+rs.suplname2+","+ rs.supid2+");");
		}
		
		boolean withdrawn = new RandomBoolean().symbols;
		
		writer.println("INSERT INTO Students Values ("+fname+","+ lname +"," + startDate +","+ course +","+spec+","+ studentid +","+rs.supid1+","+rs.supPercent + ","+rs.supid2+","+rs.supPercent2+","+scholar+","+notes+","+ origin+","+ withdrawn +");");
		
		// Start of enrolment - Initial enrolment Type
		String enrolmentType = "";
		if(i < 15 || i > 50){
			enrolmentType = "'H'";
		}
		else{
			enrolmentType = "'F'";
		}
		
		// Initial Change - So they they HAVE an enrolment type.
		writer.println("INSERT INTO EnrolmentTypeChanges VALUES (" + studentid + "," + enrolmentType + "," + "" + ");");
		
		// Suspend Location 1 - Before Proposition Masters
		if(suspendLocation == 1 ){
		susStart = prop.symbols;
		prop.moveMonths(randBetween(1, 3));
		susEnd = prop.symbols;
		}
		
		// ETC Location 1 - Before Proposition Masters
		if(etcLocation == 1 ){
			if(enrolmentType == "'H'"){
				enrolmentType = "'F'";
			}
			else if(enrolmentType == "'F'"){
				enrolmentType = "'H'";
			}
			writer.println("INSERT INTO EnrolmentTypeChanges VALUES (" + studentid + "," + enrolmentType + "," + prop.symbols + ");");
		}

		//Masters
		String propSubDate = prop.symbols;
		prop.moveMonths(randBetween(1,3));
		prop.moveMonths(randBetween(1,3));
		String propConfDate = prop.symbols;
		
		// Suspend Location 2 - Before 3mth report Masters
		if(suspendLocation == 2){
		susStart = prop.symbols;
		prop.moveMonths(randBetween(1, 3));
		susEnd = prop.symbols;
		}
		
		// ETC Location 2 - Before 3mth report Masters
		if(etcLocation == 2 ){
			if(enrolmentType == "'H'"){
				enrolmentType = "'F'";
			}
			else if(enrolmentType == "'F'"){
				enrolmentType = "'H'";
			}
			writer.println("INSERT INTO EnrolmentTypeChanges VALUES (" + studentid + "," + enrolmentType + "," + prop.symbols + ");");
		}
		
		prop.moveMonths(3);
		String prop3mthSubDate = prop.symbols;
		prop.moveMonths(randBetween(1,3));
		prop.moveMonths(randBetween(1,3));
		String prop3mthApprDate = prop.symbols;

		// Suspend Location 3 - Before 8mth report Masters
		if(suspendLocation == 3){
		susStart = prop.symbols;
		prop.moveMonths(randBetween(1, 3));
		susEnd = prop.symbols;
		}
		
		// ETC Location 3 - Before 8mth report Masters
		if(etcLocation == 3 ){
			if(enrolmentType == "'H'"){
				enrolmentType = "'F'";
			}
			else if(enrolmentType == "'F'"){
				enrolmentType = "'H'";
			}
			writer.println("INSERT INTO EnrolmentTypeChanges VALUES (" + studentid + "," + enrolmentType + "," + prop.symbols + ");");
		}
		
		prop.moveMonths(5);
		prop.moveMonths(randBetween(1,3));
		String prop8mthSubDate = prop.symbols;
		prop.moveMonths(randBetween(1,3));
		String prop8mthApprDate = prop.symbols;
		
		// Second Suspension
				String susStart1 = "";
				String susStart2 = "";
				String susEnd1 = "";
				String susEnd2 = "";
				
				if(i<25){
					susStart1 = thesisM.symbols;
					prop.moveMonths(randBetween(1, 3));
					susEnd1 = thesisM.symbols;
					if(i<10){
						
					}
				}
					else{
					susStart2 = thesisP.symbols;
					prop.moveMonths(randBetween(1, 3));
					susEnd2 = thesisP.symbols;
					if(i>50){
						
					}
				}
				
		// Suspend Location 4 - Before thesis Masters
		if(suspendLocation == 4 && i<25){
		susStart = thesisM.symbols;
		prop.moveMonths(randBetween(1, 3));
		susEnd = thesisM.symbols;
		}
		
		// ETC Location 4 - Before thesis Masters
		if(etcLocation == 4 ){
			if(enrolmentType == "'H'"){
				enrolmentType = "'F'";
			}
			else if(enrolmentType == "'F'"){
				enrolmentType = "'H'";
			}
			writer.println("INSERT INTO EnrolmentTypeChanges VALUES (" + studentid + "," + enrolmentType + "," + prop.symbols + ");");
		}

		// thesisM due 1 year from start (masters)
		String thesisSub = thesisM.symbols;
		thesisM.moveMonths(randBetween(1,3));
		thesisM.moveMonths(randBetween(1,3));
		String examinersAppointed = thesisM.symbols;
		thesisM.moveMonths(randBetween(1,3));
		String examinationComplete = thesisM.symbols;
		thesisM.moveMonths(randBetween(1,3));
		String revisions = thesisM.symbols;
		thesisM.moveMonths(randBetween(1,3));
		String deposited = thesisM.symbols;
		
		
		// Suspend Location 0 - Before thesis PhD
		if(suspendLocation == 0 && i > 25){
		susStart = thesisP.symbols;
		prop.moveMonths(randBetween(1, 3));
		susEnd = thesisP.symbols;
		}
		
		// ETC Location 0 - Before thesis PhD 
		if(etcLocation == 0 ){
			if(enrolmentType == "'H'"){
				enrolmentType = "'F'";
			}
			else if(enrolmentType == "'F'"){
				enrolmentType = "'H'";
			}
			writer.println("INSERT INTO EnrolmentTypeChanges VALUES (" + studentid + "," + enrolmentType + "," + prop.symbols + ");");
		}

		// thesisP due 3 years from start (PhD)
		String thesisPSub = thesisP.symbols;
		thesisP.moveMonths(randBetween(1,3));
		thesisP.moveMonths(randBetween(1,3));
		String examinersPAppointed = thesisP.symbols;
		thesisP.moveMonths(randBetween(1,3));
		String examinationPComplete = thesisP.symbols;
		thesisP.moveMonths(randBetween(1,3));
		String revisionsP = thesisP.symbols;
		thesisP.moveMonths(randBetween(1,3));
		String depositedP = thesisP.symbols;

		//PhD
		prop.moveMonths(randBetween(1,3));
		String propSeminar = prop.symbols;
		RandomWorkHours rwh = new RandomWorkHours();
		String workHours1 = rwh.first;
		String workHours2 = rwh.second;
		String workHours3 = rwh.third;
		
		if(i<25){
			if(i<2){			
				// Suspension that start before current date, End after current date - Masters
				writer.println("INSERT INTO MastersStudents Values ("+ studentid +","+""+","+""+","+propSubDate+","+propConfDate+","+""+","+ prop3mthSubDate+","+prop3mthApprDate+","+ ""+","+ prop8mthSubDate+","+prop8mthApprDate+","+ ""+","+thesisSub +","+ examinersAppointed+ "," +examinationComplete+"," + revisions+"," +"NULL"+");");
				suspend(writer,studentid,"'2014-08-10'","'2014-09-10'");
				suspend(writer,studentid,susStart1,susEnd1);
				}
			else if(i<4){
				writer.println("INSERT INTO MastersStudents Values ("+ studentid +","+""+","+""+","+propSubDate+","+propConfDate+","+""+","+ prop3mthSubDate+","+prop3mthApprDate+","+ ""+","+ prop8mthSubDate+","+prop8mthApprDate+","+ ""+","+thesisSub +","+ examinersAppointed+ "," +"NULL,NULL,NULL"+");");
				suspend(writer,studentid,susStart,susEnd);
				}
			else if(i<6){
				writer.println("INSERT INTO MastersStudents Values ("+ studentid +","+""+","+""+","+propSubDate+","+propConfDate+","+""+","+ prop3mthSubDate+","+prop3mthApprDate+","+ ""+","+ prop8mthSubDate+","+prop8mthApprDate+","+"NULL,NULL,NULL,NULL,NULL,NULL"+");");
				suspend(writer,studentid,susStart,susEnd);
				}
			else if(i<8){
				writer.println("INSERT INTO MastersStudents Values ("+ studentid +","+""+","+""+","+propSubDate+","+propConfDate+","+""+","+ prop3mthSubDate+","+prop3mthApprDate+","+ ""+","+ prop8mthSubDate+","+"NULL,NULL,NULL,NULL,NULL,NULL,NULL"+");");
				suspend(writer,studentid,susStart,susEnd);
				}
			else if(i<10){
				writer.println("INSERT INTO MastersStudents Values ("+ studentid +","+""+","+""+","+propSubDate+","+propConfDate+","+""+","+ prop3mthSubDate+",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL"+");");
				suspend(writer,studentid,susStart,susEnd);
				}
			else if(i<12){
				writer.println("INSERT INTO MastersStudents Values ("+ studentid +","+""+","+""+","+propSubDate+",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL"+");");
				suspend(writer,studentid,susStart,susEnd);
				}			
			else if(i<14){
				writer.println("INSERT INTO MastersStudents Values ("+ studentid +","+""+","+""+","+"NULL"+",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL"+");");
				suspend(writer,studentid,susStart,susEnd);
				}
			else if(i<16){
				writer.println("INSERT INTO MastersStudents Values ("+ studentid +","+""+","+""+","+propSubDate+","+propConfDate+","+""+","+"NULL"+",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL"+");");
				suspend(writer,studentid,susStart,susEnd);
				}
			else if(i<18){
				writer.println("INSERT INTO MastersStudents Values ("+ studentid +","+""+","+""+","+propSubDate+","+propConfDate+","+""+","+ prop3mthSubDate+","+prop3mthApprDate+","+ ""+",NULL,"+"NULL,NULL,NULL,NULL,NULL,NULL,NULL"+");");
				suspend(writer,studentid,susStart,susEnd);
				}

			else if(i<20){
				writer.println("INSERT INTO MastersStudents Values ("+ studentid +","+""+","+""+","+propSubDate+","+propConfDate+","+""+","+ prop3mthSubDate+","+prop3mthApprDate+","+ ""+","+ prop8mthSubDate+","+prop8mthApprDate+",NULL,NULL,NULL,NULL,NULL"+");");
				suspend(writer,studentid,susStart,susEnd);
				}
			else if(i<23){
				writer.println("INSERT INTO MastersStudents Values ("+ studentid +","+""+","+""+",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL"+");");
				suspend(writer,studentid,susStart,susEnd);
				}
			else{
				writer.println("INSERT INTO MastersStudents Values ("+ studentid +","+""+","+""+","+propSubDate+","+propConfDate+","+""+","+ prop3mthSubDate+","+prop3mthApprDate+","+ ""+","+ prop8mthSubDate+","+prop8mthApprDate+","+ ""+","+thesisSub +","+ examinersAppointed+ "," +examinationComplete+"," + revisions+"," +deposited+");");
			}
		}
		else{
			if(i<40){
			writer.println("INSERT INTO PhDStudents Values ("+ studentid +","+""+","+""+","+propSubDate+","+propSeminar+","+propConfDate+","+ ""+","+thesisPSub +","+ examinersPAppointed+ "," +examinationPComplete+"," + revisionsP+"," +depositedP+","+workHours1+","+workHours2+","+workHours3+");");
			}
			else{
				if(i<45){
				writer.println("INSERT INTO PhDStudents Values ("+ studentid +","+""+","+""+","+propSubDate+","+propSeminar+","+propConfDate+","+ ""+","+thesisPSub +","+ examinersPAppointed+ "," +examinationPComplete+"," + revisionsP+"," +depositedP+","+workHours1+","+workHours2+","+"NULL"+");");
				}
				else if(i<50){
				writer.println("INSERT INTO PhDStudents (StudentId,,ProposalDeadline) Values ("+ studentid +","+""+","+""+");");
				suspend(writer,studentid,susStart,susEnd);
				}
				else if(i<60){
					writer.println("INSERT INTO PhDStudents (StudentId,,ProposalDeadline,ProposalSubmission) Values ("+ studentid +","+""+","+""+","+propSubDate+");");
					suspend(writer,studentid,susStart,susEnd);
					}
				else if(i<62){
					writer.println("INSERT INTO PhDStudents (StudentId,,ProposalDeadline,ProposalSubmission,ProposalSeminar) Values ("+ studentid +","+""+","+""+","+propSubDate+","+propSeminar+");");
					
					}
				else if(i<64){
					writer.println("INSERT INTO PhDStudents (StudentId,,ProposalDeadline,ProposalSubmission,ProposalSeminar,ProposalConfirmation,ThesisDeadline,ThesisSubmission) Values ("+ studentid +","+""+","+""+","+propSubDate+","+propSeminar+","+propConfDate+","+ ""+","+thesisPSub +");");
					
					}
				else if(i<66){
					writer.println("INSERT INTO PhDStudents (StudentId,,ProposalDeadline,ProposalSubmission,ProposalSeminar,ProposalConfirmation,ThesisDeadline,ThesisSubmission,ExaminersAppointed) Values ("+ studentid +","+""+","+""+","+propSubDate+","+propSeminar+","+propConfDate+","+ ""+","+thesisPSub + ","+ examinersPAppointed+");");
					
					}
				else if(i<68){
					writer.println("INSERT INTO PhDStudents (StudentId,,ProposalDeadline,ProposalSubmission,ProposalSeminar,ProposalConfirmation,ThesisDeadline,ThesisSubmission,ExaminersAppointed,ExaminationCompleted) Values ("+ studentid +","+""+","+""+","+propSubDate+","+propSeminar+","+propConfDate+","+ ""+","+thesisPSub + ","+ examinersPAppointed+ "," +examinationPComplete+");");
					
					}
				else if(i<=70){
					writer.println("INSERT INTO PhDStudents (StudentId,,ProposalDeadline,ProposalSubmission,ProposalSeminar,ProposalConfirmation,ThesisDeadline,ThesisSubmission,ExaminersAppointed,ExaminationCompleted,RevisionsFinalised) Values ("+ studentid +","+""+","+""+","+propSubDate+","+propSeminar+","+propConfDate+","+ ""+","+thesisPSub + ","+ examinersPAppointed+ "," +examinationPComplete+"," + revisionsP+");");
					suspend(writer,studentid,susStart,susEnd);
					suspend(writer,studentid,susStart2,susEnd2);
					}
			}
		}
		
		// Withdrawals at indices: 15 (Masters) and 45 (PhD)
		if(i == 15 || i == 45){
			writer.println("INSERT INTO Withdrawals VALUES ("+ studentid +");");
		}
		
		}
	}
	public void suspend(PrintWriter writer, int studentid, String susStart, String susEnd){
		writer.println("INSERT INTO Suspensions (StudentID,SuspensionStartDate,SuspensionEndDate) Values ("+ studentid + ","+ susStart + "," + susEnd+");");
	}
	
	public static int randBetween(int start, int end) {
        return start + (int)Math.round(Math.random() * (end - start));
    }
}
