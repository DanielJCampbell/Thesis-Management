package main;

public class RandomSupervisor {
	
	int supid1 = 0;
	int supid2 = 0;
	String supfname = "";
	String suplname = "";
	String supfname2 = "";
	String suplname2 = "";
	String supPercent = "";
	String supPercent2 = "";
	

	public RandomSupervisor(int i) {
		RandomPercent rp = new RandomPercent();

		supid1 = 80000000 + i;
		supid2 = 80000300 + i;
		supPercent = rp.max;
		supPercent2 = rp.min;

		RandomName supervisor = new RandomName();
		RandomName supervisor2 = new RandomName();
		supfname = supervisor.first;
		suplname = supervisor.last;
		supfname2 = supervisor2.first;
		suplname2 = supervisor2.last;
		
	}
}