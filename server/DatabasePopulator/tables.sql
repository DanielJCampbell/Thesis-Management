CREATE TABLE Supervisors
(
F_Name varchar(50) NOT NULL,
L_Name varchar(50) NOT NULL,
SupervisorID numeric(8,0) NOT NULL,
PRIMARY KEY (SupervisorID)
);

CREATE TABLE Students
(
F_Name varchar(50) NOT NULL,
L_Name varchar(50) NOT NULL,
StartDate date NOT NULL,
Course varchar(50) NOT NULL,
Specialisation varchar(50) NOT NULL,
StudentID numeric(9,0) NOT NULL,
Primary_SupervisorID numeric(8,0) NOT NULL,
Primary_SupervisorPercent numeric(3,0) NOT NULL,
Secondary_SupervisorID numeric(8,0) NOT NULL,
Secondary_SupervisorPercent decimal(3,0) NOT NULL,
Scholarship varchar(50),
Notes varchar(255),
Origin char(1) NOT NULL,
Withdrawn boolean DEFAULT FALSE,
CHECK (Origin='I' OR Origin='D'),
CHECK (Primary_SupervisorPercent > 50 AND Primary_SupervisorPercent < 100),
CHECK (Secondary_SupervisorPercent > 0 AND Secondary_SupervisorPercent < 50),
CHECK (Secondary_SupervisorPercent + Primary_SupervisorPercent = 100),
PRIMARY KEY(StudentID),
FOREIGN KEY (Primary_SupervisorID) REFERENCES Supervisors(SupervisorID),
FOREIGN KEY (Secondary_SupervisorID) REFERENCES Supervisors(SupervisorID)
);

CREATE TABLE MastersStudents
(
StudentID numeric(9,0) NOT NULL,
ProposalSubmission date,
ProposalConfirmation  date,
Report3MonthSubmission date,
Report3MonthApproval date,
Report8MonthSubmission date,
Report8MonthApproval date,
ThesisSubmission date,
ExaminersAppointed  date,
ExaminationCompleted date,
RevisionsFinalised date,
DepositedInLibrary date,
CHECK (ProposalDeadline > StartDate),
CHECK (ProposalConfirmation  > ProposalSubmission OR ProposalConfirmation IS NULL),
CHECK (Report3MonthApproval > Report3MonthSubmission OR Report3MonthApproval IS NULL),
CHECK (Report8MonthApproval > Report8MonthSubmission OR Report8MonthApproval IS NULL),
CHECK (ThesisSubmission > ProposalConfirmation OR ThesisSubmission IS NULL),
CHECK (ExaminersAppointed  > ThesisSubmission OR ExaminersAppointed IS NULL),
CHECK (ExaminationCompleted > ExaminersAppointed OR ExaminationCompleted IS NULL),
CHECK (RevisionsFinalised > ExaminationCompleted OR RevisionsFinalised IS NULL),
CHECK (DepositedInLibrary >= RevisionsFinalised OR DepositedInLibrary IS NULL),
PRIMARY KEY (StudentID),
FOREIGN KEY (StudentID) REFERENCES Students(StudentID)
);

CREATE TABLE PhDStudents
(
StudentID numeric(9,0) NOT NULL,
ProposalSubmission date,
ProposalSeminar date,
ProposalConfirmation date,
ThesisSubmission date,
ExaminersAppointed  date,
ExaminationCompleted date,
RevisionsFinalised date,
DepositedInLibrary date,
WorkHours1 int DEFAULT 0 CHECK (WorkHours1 >= 0),
WorkHours2 int DEFAULT 0 CHECK (WorkHours2 >= 0),
WorkHours3 int DEFAULT 0 CHECK (WorkHours3 >= 0),
CHECK (ProposalDeadline > StartDate OR ProposalDeadline IS NULL),
CHECK (ProposalConfirmation > ProposalSubmission OR ProposalConfirmation IS NULL),
CHECK (ThesisSubmission > ProposalConfirmation OR ThesisSubmission IS NULL),
CHECK (ExaminersAppointed  > ThesisSubmission OR ExaminersAppointed IS NULL),
CHECK (ExaminationCompleted > ExaminersAppointed OR ExaminationCompleted IS NULL),
CHECK (RevisionsFinalised > ExaminationCompleted OR RevisionsFinalised IS NULL),
CHECK (DepositedInLibrary >= RevisionsFinalised OR DepositedInLibrary IS NULL),
CHECK (WorkHours1 <= 150),
CHECK (WorkHours2 <= 150),
CHECK (WorkHours3 <= 150),
PRIMARY KEY (StudentID),
FOREIGN KEY (StudentID) REFERENCES Students(StudentID)
);



CREATE TABLE Suspensions
(
SuspensionID SERIAL,
StudentID numeric(9,0),
SuspensionStartDate date,
SuspensionEndDate date,
CHECK (SuspensionEndDate > SuspensionStartDate),
PRIMARY KEY (SuspensionID),
FOREIGN KEY (StudentID) REFERENCES Students(StudentID)
);

CREATE TABLE EnrolmentTypeChanges
(
StudentID int NOT NULL,
EnrolmentType char NOT NULL,
ChangeDate date NOT NULL,
CHECK (EnrolmentType IN ('H', 'F')),
PRIMARY KEY (StudentID, EnrolmentType, ChangeDate),
FOREIGN KEY (StudentID) REFERENCES Students(StudentID)
);



